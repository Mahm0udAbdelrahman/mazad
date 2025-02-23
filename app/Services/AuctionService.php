<?php

namespace App\Services;

use App\Models\User;
use App\Models\Auction;
use App\Models\CommitCar;
use App\Models\Insurance;
use App\Models\CommitAuction;
use Illuminate\Support\Facades\DB;
use App\Helpers\SendNotificationHelper;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DBFireBaseNotification;
use App\Exceptions\InsuranceNotFoundException;

class AuctionService
{
    public function getAll()
    {
        return Auction::with(['user', 'car'])->latest()->paginate();
    }

    public function getById($id)
    {
        return Auction::with(['user', 'car'])->findOrFail($id);
    }

    public function getMyAuctions()
    {
        return CommitAuction::where('user_id', auth()->id())->with(['user', 'auction'])->latest()->paginate();
    }



    public function commitAuction($id, array $data)
{
    $user = auth()->user();

    $auction = Auction::findOrFail($id);

    if ($user->service !== 'merchant' && $auction->user_id !== $user->id) {
        throw new InsuranceNotFoundException(__('You must be a merchant or the owner of this auction to commit.', [], request()->header('Accept-language')));
    }

    $minBalance = [
        'my' => 300,
        'dealer' => 500,
    ][$user->category] ?? null;

    if (is_null($minBalance)) {
        throw new InsuranceNotFoundException(__('Invalid category.', [], request()->header('Accept-language')));
    }

    $insurance = Insurance::where('user_id', $user->id)->first();

    if (!$insurance) {
        throw new InsuranceNotFoundException(__('No insurance record found for the user.', [], request()->header('Accept-language')), 404);
    }

    if ($insurance->balance < $minBalance) {
        throw new InsuranceNotFoundException(__('Your insurance balance must be at least :minBalance.', [
            'minBalance' => $minBalance
        ], request()->header('Accept-language')));
    }

    if ($insurance->payment_status !== 'paid') {
        throw new InsuranceNotFoundException(__('Your insurance payment status must be paid to add a car.', [], request()->header('Accept-language')));
    }

    $commit = CommitAuction::create([
        'user_id'    => $user->id,
        'auction_id' => $auction->id,
        'price'      => $data['price'],
        'commit'     => $data['commit'] ?? null,
    ]);

    $data = [
        "title_ar" => "مزايدة جديدة على سيارتك",
        "body_ar" => "مرحباً، لقد تمت مزايدة جديدة على سيارتك. يمكنك متابعة تفاصيل المزايدة واتخاذ القرار المناسب.",
        "title_en" => "New Bid on Your Car",
        "body_en" => "Hello, a new bid has been placed on your car. You can check the auction details and take the appropriate action.",
        "title_ru" => "Новая ставка на ваш автомобиль",
        "body_ru" => "Здравствуйте, на ваш автомобиль была сделана новая ставка. Вы можете ознакомиться с деталями аукциона и принять соответствующее решение.",
        'image' => null
    ];
    // $newNotification = new SendNotificationHelper();
    $user = User::findOrFail($auction->car->user->id);
    Notification::send(
        $user,
       new DBFireBaseNotification($data['title_ar'],$data['body_ar'],$data['title_en'],$data['body_en'],$data['title_ru'],$data['body_ru'])
   );
    // $newNotification->sendNotification($data , [$auction->car->user->fcm_token]);


    return $commit;
}



public function UpdateStatusAuction($id, $data)
{
    $auction = Auction::findOrFail($id);



    if ($auction->car->user_id !== auth()->id()) {
        throw new InsuranceNotFoundException(__('You must be the owner of this car to update the auction status.', [], request()->header('Accept-language')));
    }
    if ($auction->car->sold === 1) {
        throw new InsuranceNotFoundException(__('The car has already been sold.', [], request()->header('Accept-language')));
    }

    if ($auction->status === 'won') {
        throw new InsuranceNotFoundException(__('Already won.', [], request()->header('Accept-language')));
    }

    $highestCommit = CommitAuction::where('auction_id', $auction->id)
        ->orderBy('price', 'desc')
        ->first();

    if (!$highestCommit) {
        throw new InsuranceNotFoundException(__('No commits found for this auction.', [], request()->header('Accept-language')));
    }

    if ($data['status'] === 'won') {
        $winnerUser = User::find($highestCommit->user_id);

        if ($winnerUser && $winnerUser->service === 'merchant' && $winnerUser->category === 'my') {
            $insurance = Insurance::where('user_id', $winnerUser->id)
                ->where('payment_status', 'paid')
                ->first();

            if (!$insurance) {
                throw new InsuranceNotFoundException(__('Insurance payment status must be paid.', [], request()->header('Accept-language')));
            }

            if ($insurance->balance < 500) {
                throw new InsuranceNotFoundException(__('Balance is less than 500.', [], request()->header('Accept-language')));
            }

            $insurance->decrement('balance', 500);

            $auction->car->update(['sold' => 1]);
        }
    }
    $commit = CommitAuction::find($data['commit_id']);

    $auction->update([
        'status' => $data['status'],
        'winner_id' => $commit->user_id,
        'winner_price' => $highestCommit->price,
        'winner_date' => now(),
    ]);

    $data = [
        "title_ar" => "مبروك! لقد فزت بالمزاد",
        "body_ar" => "تهانينا! لقد فزت بالمزاد على السيارة. يرجى متابعة الخطوات لإكمال عملية الشراء.",
        "title_en" => "Congratulations! You Won the Auction",
        "body_en" => "Congratulations! You have won the auction for the car. Please proceed with the steps to complete the purchase.",
        "title_ru" => "Поздравляем! Вы выиграли аукцион",
        "body_ru" => "Поздравляем! Вы выиграли аукцион на автомобиль. Пожалуйста, выполните шаги для завершения покупки.",
        'image' => null
    ];
    // $newNotification = new SendNotificationHelper();
    $user = User::findOrFail($commit->user->id);
    Notification::send(
        $user,
       new DBFireBaseNotification($data['title_ar'],$data['body_ar'],$data['title_en'],$data['body_en'],$data['title_ru'],$data['body_ru'])
   );
    // $newNotification->sendNotification($data , [$commit->user->fcm_token]);




    return $auction;
}





}
