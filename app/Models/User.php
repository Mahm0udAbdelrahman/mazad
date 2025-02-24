<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    // use HasFactory, Notifiable;
    use HasApiTokens, HasFactory, Notifiable , HasRoles , SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable =
    [
        'name',
        'address',
        'phone',
        'national_number',
        'image',
        'service',
        'category',
        'email',
        'password',
        'code',
        'verify',
        'auction',
        'active',
        'expire_at',
        'fcm_token',
        'terms_and_conditions',
        'email_verified_at',





    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function insurance()
    {
        return $this->hasOne(Insurance::class);
    }

    public function commitAuctions()
    {
        return $this->hasMany(CommitAuction::class);
    }

    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }

    public function getIsVendorAttribute()
    {
        return $this->service === 'vendor';
    }

    public function getIsMerchantAttribute()
    {
        return $this->service === 'merchant';
    }

    public function getIsDealerAttribute()
    {
        return $this->category === 'dealer';
    }

    public function getIsMyAttribute()
    {
        return $this->category === 'my';
    }


}
