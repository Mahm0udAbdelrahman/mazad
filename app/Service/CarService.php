<?php
namespace App\Service;

use App\Models\Car;
use App\Models\User;
use App\Models\Auction;
use App\Models\CarImage;
use App\Traits\HasImage;
use App\Models\Insurance;
use App\Helpers\OTPHelper;
use App\Traits\HttpResponse;
use App\Http\Resources\CarResource;
use Symfony\Component\HttpFoundation\Response;

class CarService
{
    use HasImage , HttpResponse;

    public function __construct(public Car $car){}


    public function index()
    {
        $cars = Car::where('user_id', auth()->id())->paginate();

        return $this->paginatedResponse($cars, CarResource::class);
    }

    public function store($data)
    {
        $user = auth()->user();

        if (!$user || $user->service !== 'vendor') {
            return $this->errorResponse(
                null,
                Response::HTTP_BAD_REQUEST,
                __('The user is not associated with a vendor account.', [], request()->header('Accept-language'))
            );
        }

        $minBalance = [
            'my' => 5000,
            'dealer' => 3000,
        ][$user->category] ?? null;

        if (is_null($minBalance)) {
            return $this->errorResponse(
                null,
                Response::HTTP_BAD_REQUEST,
                __('Invalid category', [], request()->header('Accept-language'))
            );
        }

        $insurance = Insurance::where('user_id', $user->id)->first();

        if (!$insurance) {
            return $this->errorResponse(
                null,
                Response::HTTP_BAD_REQUEST,
                __('No insurance found for the user.', [], request()->header('Accept-language'))
            );
        }

        if ($insurance->balance < $minBalance) {
            return $this->errorResponse(
                null,
                Response::HTTP_BAD_REQUEST,
                __('You need to have an insurance balance of :minBalance or more to add a car.', [
                    'minBalance' => $minBalance
                ], request()->header('Accept-language'))
            );
        }


        if ($insurance->payment_status !== 'paid') {
            return $this->errorResponse(
                null,
                Response::HTTP_BAD_REQUEST,
                __('Your insurance payment status must be paid to add a car.', [], request()->header('Accept-language'))
            );
        }

        $data['user_id'] = $user->id;
        if ($data['image_license']) {
            $data['image_license'] = $this->saveImage($data['image_license'], 'car/image_license');
        }
        if ($data['video']) {
            $data['video'] = $this->saveImage($data['video'], 'car/image_license');
        }
        if ($data['report']) {
            $data['report'] = $this->saveImage($data['report'], 'car/image_license');
        }

        $newCar = $this->car->create($data);
        foreach ($data['images'] as $image) {
            $newCar->carImages()->create([
                'image' => $this->saveImage($image, 'car/images'),
            ]);
        }

       return $this->okResponse(new CarResource($newCar), __('The car has been added successfully', [], request()->header('Accept-language')));
    }


    public function show($id)
    {
        $car  = $this->car->findOrFail($id);
        return $this->okResponse(new CarResource($car), __('The car has been  successfully', [], request()->header('Accept-language')));
    }
    public function update($id, $data)
{
    $user = auth()->user();

    if (!$user || $user->service !== 'vendor') {
        return $this->errorResponse(
            null,
            Response::HTTP_BAD_REQUEST,
            __('The user is not associated with a vendor account.', [], request()->header('Accept-language'))
        );
    }

    $minBalance = [
        'my' => 5000,
        'dealer' => 3000,
    ][$user->category] ?? null;

    if (is_null($minBalance)) {
        return $this->errorResponse(
            null,
            Response::HTTP_BAD_REQUEST,
            __('Invalid category', [], request()->header('Accept-language'))
        );
    }

    $insurance = Insurance::where('user_id', $user->id)->first();

    if (!$insurance) {
        return $this->errorResponse(
            null,
            Response::HTTP_BAD_REQUEST,
            __('No insurance found for the user.', [], request()->header('Accept-language'))
        );
    }

    if ($insurance->balance < $minBalance) {
        return $this->errorResponse(
            null,
            Response::HTTP_BAD_REQUEST,
            __('You need to have an insurance balance of :minBalance or more to update the car.', [
                'minBalance' => $minBalance
            ], request()->header('Accept-language'))
        );
    }

    if ($insurance->payment_status !== 'paid') {
        return $this->errorResponse(
            null,
            Response::HTTP_BAD_REQUEST,
            __('Your insurance payment status must be paid to update the car.', [], request()->header('Accept-language'))
        );
    }

    $car = $this->car->findOrFail($id);

    if (!$car || $car->user_id !== $user->id) {
        return $this->errorResponse(
            null,
            Response::HTTP_NOT_FOUND,
            __('Car not found or you do not have permission to update it.', [], request()->header('Accept-language'))
        );
    }

    $data['user_id'] = $user->id;

    if (isset($data['image_license'])) {
        $this->deleteOldImage($car->image_license);
        $data['image_license'] = $this->saveImage($data['image_license'], 'car/image_license');
    }

    if (isset($data['video'])) {
        $this->deleteOldImage($car->video);
        $data['video'] = $this->saveImage($data['video'], 'car/image_license');
    }

    if (isset($data['report'])) {
        $this->deleteOldImage($car->report);
        $data['report'] = $this->saveImage($data['report'], 'car/image_license');
    }

    if($data['status'] == 'approved'){
        Auction::create([
            'car_id' => $car->id,
            'user_id'=> $user->id,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'start_price' => $car->price,
        ]);
    }

    $car->update($data);

    if (isset($data['images']) && is_array($data['images'])) {
        foreach ($car->carImages as $existingImage) {
            $this->deleteOldImage($existingImage->image);
            $existingImage->delete();
        }

        foreach ($data['images'] as $image) {
            $car->carImages()->create([
                'image' => $this->saveImage($image, 'car/images'),
            ]);
        }
    }

    return $this->okResponse(new CarResource($car), __('The car has been updated successfully', [], request()->header('Accept-language')));
}

private function deleteOldImage($path)
{
    if ($path && \Storage::exists($path)) {
        \Storage::delete($path);
    }
}

    public function destroy($id)
    {
        $car = $this->car->findOrFail($id);
        $car->delete();
        return $this->okResponse(new CarResource($car), __('The car has been deleted successfully', [], request()->header('Accept-language')));
    }

}
