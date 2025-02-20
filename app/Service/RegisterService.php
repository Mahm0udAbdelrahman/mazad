<?php
namespace App\Service;

use App\Models\User;
use App\Traits\HasImage;
use App\Helpers\OTPHelper;

class RegisterService
{
    use HasImage;
    public function __construct(public User $user){}

    public function register($data){

        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'user');
       }

      $data['code'] = rand(1000, 9999);

       OTPHelper::sendOtp($data['email'], $data['code']);

        return $this->user->create($data);
    }
}
