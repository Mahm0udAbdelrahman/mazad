<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use App\Models\Auction;
use Carbon\Carbon;

class UpdateAuctionSchedule extends Command
{
    protected $signature = 'auction:update-schedule';
    protected $description = 'Update auctions every week and soft delete after 4 weeks.';

    public function handle()
    {
       try{
        $now = now();

        $auctions = Auction::where('status','pending')->where('end_date', '>=', $now)->get();

        foreach ($auctions as $auction) {
            $weeksPassed = Carbon::parse($auction->start_date)->diffInWeeks($now);


            if ($weeksPassed > 0 && $weeksPassed <= 4) {
                $auction->update(['created_at' => $now]);
                $this->info("Updated created_at for Auction ID: {$auction->id}");
            }

            if (Carbon::parse($auction->end_date)->lte($now)) {
                $auction->update(['deleted_at' => $now]);
                $this->info("Soft deleted Auction ID: {$auction->id}");
            }
        }

        $this->info('Auction schedule update completed.');
       }catch(Exception $e){
            return $e->getMessage();
       }
    }
}
