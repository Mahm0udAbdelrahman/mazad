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

    public function auction()
    {
        return $this->hasOne(Auction::class);
    }

    public function CommitAuctions()
    {
        return $this->hasMany(CommitAuction::class);
    }

    public function scopeFilter($query, array $filters)
    {
        // $query->when($filters['search'] ?? null, fn($query, $search) => $query->where(fn($query) => $query->where('name', 'like', '%' . $search . '%')
        //     ->orWhere('model', 'like', '%' . $search . '%')
        //     // ->orWhere('year', 'like', '%' . $search . '%')
        //     ->orWhere('color', 'like', '%' . $search . '%')
        //     ->orWhere('price', 'like', '%' . $search . '%')
        //     ->orWhere('description', 'like', '%' . $search . '%')
        //     ->orWhere('kilometer', 'like', '%' . $search . '%')
        //     ->orWhere('deposit', 'like', '%' . $search . '%')
        //     ->orWhere('license_year', 'like', '%' . $search . '%')
        //     ->orWhere('status', 'like', '%' . $search . '%')
        //     ->orWhere('sold', 'like', '%' . $search . '%')
        //     ->orWhere('created_at', 'like', '%' . $search . '%')
        //     ->orWhere('updated_at', 'like', '%' . $search . '%')));

        $query->when($filters['name'] ?? null, fn($query, $name) => $query->where('name', $name));
        $query->when($filters['model'] ?? null, fn($query, $model) => $query->where('model', $model));
        $query->when($filters['color'] ?? null, fn($query, $color) => $query->where('color', $color));
        $query->when($filters['price'] ?? null, fn($query, $price) => $query->where('price', $price));
        $query->when($filters['description'] ?? null, fn($query, $description) => $query->where('description', $description));
        $query->when($filters['kilometer'] ?? null, fn($query, $kilometer) => $query->where('kilometer', $kilometer));
        $query->when($filters['deposit'] ?? null, fn($query, $deposit) => $query->where('deposit', $deposit));
        $query->when($filters['license_year'] ?? null, fn($query, $license_year) => $query->where('license_year', $license_year));
        $query->when($filters['car_type_id'] ?? null, fn($query, $car_type_id) => $query->where('car_type_id', $car_type_id));
        $query->when($filters['status'] ?? null, fn($query, $status) => $query->where('status', $status));
        $query->when($filters['sold'] ?? null, fn($query, $sold) => $query->where('sold', $sold));
        $query->when(($filters['price_min'] ?? null) && ($filters['price_max'] ?? null), function ($query) use ($filters) {
            $query->whereBetween('price', [$filters['price_min'], $filters['price_max']]);
        });

        $query->when($filters['price_min'] ?? null, fn($query, $price_min) =>
            $query->where('price', '>=', $price_min)
        );

        $query->when($filters['price_max'] ?? null, fn($query, $price_max) =>
            $query->where('price', '<=', $price_max)
        );
    }

    // public function scopeSort($query, array $sorts)
    // {
    //     $query->when($sorts['name'] ?? null, fn($query, $name) => $query->orderBy('name', $name));
    //     $query->when($sorts['model'] ?? null, fn($query, $model) => $query->orderBy('model', $model));
    //     $query->when($sorts['year'] ?? null, fn($query, $year) => $query->orderBy('year', $year));
    //     $query->when($sorts['color'] ?? null, fn($query, $color) => $query->orderBy('color', $color));
    //     $query->when($sorts['price'] ?? null, fn($query, $price) => $query->orderBy('price', $price));
    //     $query->when($sorts['description'] ?? null, fn($query, $description) => $query->orderBy('description', $description));
    //     $query->when($sorts['kilometer'] ?? null, fn($query, $kilometer) => $query->orderBy('kilometer', $kilometer));
    //     $query->when($sorts['deposit'] ?? null, fn($query, $deposit) => $query->orderBy('deposit', $deposit));
    //     $query->when($sorts['license_year'] ?? null, fn($query, $license_year) => $query->orderBy('license_year', $license_year));
    //     $query->when($sorts['status'] ?? null, fn($query, $status) => $query->orderBy('status', $status));
    //     $query->when($sorts['sold'] ?? null, fn($query, $sold) => $query->orderBy('sold', $sold));
    //     $query->when($sorts['created_at'] ?? null, fn($query, $created_at) => $query->orderBy('created_at', $created_at));
    //     $query->when($sorts['updated_at'] ?? null, fn($query, $updated_at) => $query->orderBy('updated_at', $updated_at));
    // }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('model', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('color', 'like', '%' . $search . '%')
            ->orWhere('price', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->orWhere('kilometer', 'like', '%' . $search . '%')
            ->orWhere('deposit', 'like', '%' . $search . '%')
            ->orWhere('license_year', 'like', '%' . $search . '%')
            ->orWhere('status', 'like', '%' . $search . '%')
            ->orWhere('sold', 'like', '%' . $search . '%')
            ->orWhere('created_at', 'like', '%' . $search . '%')
            ->orWhere('updated_at', 'like', '%' . $search . '%');
    }

    public function scopeCarTypeId($query, $car_type_id)
    {
        return $query->where('car_type_id', $car_type_id);
    }

    // public function scopeStatus($query, $status)
    // {
    //     return $query->where('status', $status);
    // }

    public function scopeSold($query, $sold)
    {
        return $query->where('sold', $sold);
    }







}
