<?php
namespace App\Service;

use App\Models\User;
use App\Traits\HasImage;

class RegisterService
{
    use HasImage;
    public function __construct(public User $user){}

    public function registerMerchant($data){
        $data['service'] = 'merchant';
        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'user');
       }
        return $this->user->create($data);
    }
    public function registerVendor($data){
        $data['service'] = 'vendor';
        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'user');
       }
        return $this->user->create($data);
    }
}
