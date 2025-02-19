<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use App\Mail\OTPEmail;
use Illuminate\Support\Facades\Mail;

class OTPHelper
{
    public static function sendOtp($user,$otp)
    {
        Mail::to($user->email)->send(new OTPEmail($otp));
        $user->update(['code' => $otp]);
    }
}
