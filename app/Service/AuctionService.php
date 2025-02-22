<?php

namespace App\Service;

use App\Models\User;
use App\Models\Auction;
use App\Models\CommitCar;
use App\Models\Insurance;
use App\Models\CommitAuction;
use Illuminate\Support\Facades\DB;
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

    $auction->update([
        'status' => $data['status'],
        'winner_id' => $highestCommit->user_id,
        'winner_price' => $highestCommit->price,
        'winner_date' => now(),
    ]);

    return $auction;
}





}
