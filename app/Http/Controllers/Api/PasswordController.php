<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Services\PasswordService;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoginResource;
use App\Http\Requests\Api\Login\ChangePassword;
use App\Http\Requests\Api\Register\SendCodeRequest;
use App\Http\Requests\Api\Login\ResetPasswordRequest;

class PasswordController extends Controller
{
    use HttpResponse;
    public function __construct(public PasswordService $passwordService){}

        public function forgetPassword(SendCodeRequest $sendCodeRequest)
        {
           $user = $this->passwordService->forgetPassword($sendCodeRequest->validated());
            $response = ['user' => LoginResource::make($user), 'otp' => $user->code];
            return $this->okResponse($response, __('Code sent successfully', [], Request()->header('Accept-language')));

        }

        public function resetPassword(ResetPasswordRequest $resetPasswordRequest)
        {
            $user = $this->passwordService->resetPassword($resetPasswordRequest->validated());
            return $this->okResponse(LoginResource::make($user), __('The password has been reset successfully', [], Request()->header('Accept-language')));
        }


        public function changePassword(ChangePassword $changePassword)
        {
            $user = $this->passwordService->changePassword($changePassword->validated());
            return $this->okResponse(LoginResource::make($user), __('The password has been changed successfully', [], Request()->header('Accept-language')));

        }




}
