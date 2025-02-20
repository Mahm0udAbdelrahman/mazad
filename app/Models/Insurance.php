<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $fillable =
    [
        'user_id',
        'balance',
        'payment_method',
        'payment_id',
        'payment_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
