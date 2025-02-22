<?php
namespace App\Service;

use App\Models\Car;
use App\Models\Auction;
use App\Traits\HasImage;
use App\Models\Insurance;
use App\Traits\HttpResponse;

use Illuminate\Support\Facades\Storage;
use App\Exceptions\InsuranceNotFoundException;


class CarService
{
    use HasImage , HttpResponse;

    public function __construct(public Car $car){}


    public function index()
    {
        return Car::where('user_id', auth()->id())->paginate();
    }
    public function filterCars(array $filters)
    {
        return Car::query()->where('status', 'approved')->filter($filters)->paginate(10); 
    }

    public function getCarStatusPending()
    {
        return Car::where('user_id', auth()->id())->where('status', 'pending')->paginate();
    }

    public function getCarStatusApproved()
    {
        return Car::where('user_id', auth()->id())->where('status', 'approved')->paginate();
    }

    public function getCarStatusRejected()
    {
        return Car::where('user_id', auth()->id())->where('status', 'rejected')->paginate();
    }

    public function store(array $data): Car
    {
        $user = auth()->user();

        if (!$user || $user->service !== 'vendor') {
            throw new InsuranceNotFoundException(__('The user is not associated with a vendor account.', [], request()->header('Accept-language')));
        }

        $minBalance = [
            'my' => 5000,
            'dealer' => 3000,
        ][$user->category] ?? null;

        if (is_null($minBalance)) {
            throw new InsuranceNotFoundException(__('Invalid category', [], request()->header('Accept-language')));
        }

        $insurance = Insurance::where('user_id', $user->id)->first();

        if (!$insurance) {
            throw new InsuranceNotFoundException(__('No insurance found for the user.', [], request()->header('Accept-language')), 404);

        }

        if ($insurance->balance < $minBalance) {
            throw new InsuranceNotFoundException(__('You need to have an insurance balance of :minBalance or more to add a car.', [
                'minBalance' => $minBalance
            ], request()->header('Accept-language')));
        }

        if ($insurance->payment_status !== 'paid') {
            throw new InsuranceNotFoundException(__('Your insurance payment status must be paid to add a car.', [], request()->header('Accept-language')));
        }

        $data['user_id'] = $user->id;
        $data['image_license'] = $data['image_license'] ?? null ? $this->saveImage($data['image_license'], 'car/image_license') : null;
        $data['video'] = $data['video'] ?? null ? $this->saveImage($data['video'], 'car/video') : null;
        $data['report'] = $data['report'] ?? null ? $this->saveImage($data['report'], 'car/report') : null;

        $newCar = $this->car->create($data);

        if (isset($data['images'])) {
            foreach ($data['images'] as $image) {
                $newCar->carImages()->create([
                    'image' => $this->saveImage($image, 'car/images'),
                ]);
            }
        }

        return $newCar;
    }


    public function show($id)
    {
        return $this->car->findOrFail($id);
    }


public function update($id, array $data): Car
{
    $user = auth()->user();

    if (!$user || $user->service !== 'vendor') {
        throw new InsuranceNotFoundException(__('The user is not associated with a vendor account.', [], request()->header('Accept-language')));
    }

    $minBalance = [
        'my' => 5000,
        'dealer' => 3000,
    ][$user->category] ?? null;

    if (is_null($minBalance)) {
        throw new InsuranceNotFoundException(__('Invalid category', [], request()->header('Accept-language')));
    }

    $insurance = Insurance::where('user_id', $user->id)->first();

    if (!$insurance) {
        throw new InsuranceNotFoundException(__('No insurance found for the user.', [], request()->header('Accept-language')));
    }

    if ($insurance->balance < $minBalance) {
        throw new InsuranceNotFoundException(__('You need to have an insurance balance of :minBalance or more to update the car.', [
            'minBalance' => $minBalance
        ], request()->header('Accept-language')));
    }

    if ($insurance->payment_status !== 'paid') {
        throw new InsuranceNotFoundException(__('Your insurance payment status must be paid to update the car.', [], request()->header('Accept-language')));
    }

    $car = $this->car->findOrFail($id);

    if ($car->user_id !== $user->id) {
        throw new InsuranceNotFoundException(__('Car not found or you do not have permission to update it.', [], request()->header('Accept-language')));
    }

    $data['user_id'] = $user->id;

    foreach (['image_license', 'video', 'report'] as $field) {
        if (isset($data[$field])) {
            $this->deleteOldImage($car->$field);
            $data[$field] = $this->saveImage($data[$field], "car/$field");
        }
    }

    if (isset($data['status']) && $data['status'] === 'approved') {
        Auction::firstOrCreate([
            'car_id' => $car->id,
            'user_id' => $user->id,
        ], [
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'start_price' => $car->price,
        ]);
    }

    $car->update($data);

    if (!empty($data['images']) && is_array($data['images'])) {
        $car->carImages()->each(fn($image) => $this->deleteOldImage($image->image) && $image->delete());

        foreach ($data['images'] as $image) {
            $car->carImages()->create([
                'image' => $this->saveImage($image, 'car/images'),
            ]);
        }
    }

    return $car;
}


private function deleteOldImage($path)
{
    if ($path && Storage::exists($path)) {
        Storage::delete($path);
    }
}

    public function destroy($id)
    {
        $car = $this->car->findOrFail($id);
        $car->delete();
        return $car;
    }

}
