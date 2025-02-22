<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommitAuction extends Model
{
    protected $fillable =
    [
        'user_id',
        'auction_id',
        'price',
        'commit',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
