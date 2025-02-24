<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceCenter extends Model
{
    protected $fillable =
    [
        'name_en',
        'name_ar',
        'name_ru',
        'address_en',
        'address_ar',
        'address_ru',
        'phone',
    ];
}
