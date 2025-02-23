<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Helpers\OTPHelper;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\InsuranceNotFoundException;




class PasswordService
{

    public function forgetPassword($data)
    {
        $user = User::where('email', $data['email'])->first();
        if ($user) {
            $user->update(['code' => mt_rand(1000, 9999), 'expire_at' => Carbon::now()->addMinute(), 'email_verified_at' => null]);

            OTPHelper::sendOtp($user, $user->code);
          return $user;
        }
        throw new InsuranceNotFoundException(__('Email not registered', [], request()->header('Accept-language')), 400);
    }

    public function resetPassword($data)
    {
        $user = User::where('email', $data['email'])->first();
        if ($user->code == $data['otp']) {
            $user->update(['password' => Hash::make($data['password']) , 'code' => null ,'expire_at' => null ,'email_verified_at' => Carbon::now()]);
            return $user;
        }

        throw new InsuranceNotFoundException(__('These credentials do not match our records.', [], Request()->header('Accept-language')), 400);
    }


    public function changePassword($data)
    {
        $user = auth('sanctum')->user();
        $user->update(['password' => Hash::make($data['password'])]);
        return $user;
    }




}
