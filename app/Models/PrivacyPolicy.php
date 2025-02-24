<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    protected $fillable =
    [
        'message_ar',
        'message_ru',
        'message_en',
    ];
}
