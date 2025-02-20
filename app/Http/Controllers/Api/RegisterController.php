<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\OTPHelper;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Service\RegisterService;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterVendorResource;
use App\Http\Requests\Api\Register\CodeRequest;
use App\Http\Resources\RegisterMerchantResource;
use App\Http\Requests\Api\Register\SendCodeRequest;
use App\Http\Requests\Api\Register\RegisterVendorRequest;
use App\Http\Requests\Api\Register\RegisterMerchantRequest;

class RegisterController extends Controller
{
    use HttpResponse;
    public function __construct(public RegisterService $registerService){}

    public function register(RegisterVendorRequest $request)
    {
        $data = $this->registerService->register($request->validated());

        return $this->okResponse(new RegisterVendorResource($data));
    }

    // public function registerMerchant(RegisterMerchantRequest $request)
    // {
    //     $data = $this->registerService->registerMerchant($request->validated());

    //     return $this->okResponse(new RegisterMerchantResource($data));
    // }

    public function verify(CodeRequest $codeRequest)
    {
        $user = User::where('email', $codeRequest->email)->first();
        if ($user) {
            if ($user->verify != 1) {
                if ($user->code == $codeRequest->otp) {
                    $token = $user->createToken("API TOKEN")->plainTextToken;
                    $user->update(['code' => NULL, 'verify' => 1]);
                    $response = ['user' => LoginResource::make($user), 'token' => $token];

                    return $this->okResponse($response, __('User account verified successfully', [], Request()->header('Accept-language')));


                }
                return $this->errorResponse(__('Wrong OTP code', [], Request()->header('Accept-language')));
            }
            return $this->errorResponse(__('The user account has already been verified', [], Request()->header('Accept-language')));
        }
        return $this->errorResponse(__('Email not registered', [], Request()->header('Accept-language')));
    }

    public function otp(SendCodeRequest $sendCodeRequest)
    {
        $user = User::where('email', $sendCodeRequest->email)->first();
        if ($user) {
            $otp = mt_rand(1000, 9999);
            OTPHelper::sendOtp($user, $otp);
            $response = ['user' => LoginResource::make($user), 'otp' => $otp];
            return $this->okResponse($response, __('Code sent successfully', [], Request()->header('Accept-language')));
        }
        return $this->errorResponse(__('Email not registered', [], Request()->header('Accept-language')));
    }
}
