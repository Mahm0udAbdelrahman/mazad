<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'user_id',
        'car_type_id',
        'name',
        'type',
        'model',
        'year',
        'color',
        'price',
        'description',
        'image',
        'status',
        'kilometer',
        'video',
        'deposit',
        'license_year',
        'image_license',
        'sold',
        'report'
    ];
    public function user()
    {
            return $this->belongsTo(User::class);
    }
    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }
    public function carImages()
    {
        return $this->hasMany(CarImage::class);
    }





}
