<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $fillable =
    [
        'user_id',
        'car_id',
        'start_price',
        'start_date',
        'end_date',
        'winner_id',
        'winner_price',
        'winner_date',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
