<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auction extends Model
{
    use SoftDeletes;
    protected $fillable =
    [
        'user_id',
        'car_id',
        'start_price',
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

    public function commitAuctions()
    {
        return $this->hasMany(CommitAuction::class);
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id','id');
    }



    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, fn($query, $search) => $query->where(fn($query) => $query->where('start_price', 'like', '%' . $search . '%')
            ->orWhere('start_date', 'like', '%' . $search . '%')
            ->orWhere('end_date', 'like', '%' . $search . '%')
            ->orWhere('winner_price', 'like', '%' . $search . '%')
            ->orWhere('winner_date', 'like', '%' . $search . '%')
            ->orWhere('status', 'like', '%' . $search . '%')
        ));
    }



    public function scopeSort($query, array $sorts)
    {
        $sorts = $sorts['sort'] ?? 'id';
        $order = $sorts['order'] ?? 'asc';

        $query->when($sorts, fn($query, $sorts) => $query->orderBy($sorts, $order));
    }

    public function scopeStatus($query, $status)
    {
        $query->when($status, fn($query, $status) => $query->where('status', $status));
    }


}
