<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SendNotification extends Model
{
    protected $fillable =
    [
        'title_ar',
        'body_ar',
        'title_ru',
        'body_ru',
        'title_en',
        'body_en',
    ];
}
