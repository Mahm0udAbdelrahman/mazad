<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\HasImage;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\LoginResource;
use App\Http\Requests\Api\Login\LoginRequest;
use App\Http\Requests\Api\Login\ChangePassword;
use App\Http\Requests\Api\Login\ProfileRequest;
use App\Http\Requests\Api\Login\ResetPasswordRequest;

class LoginController extends Controller
{
    use HttpResponse , HasImage;
    public function login(LoginRequest $loginRequest)
    {
        $user = User::where('name', $loginRequest->name)->first();
        if ($user && Hash::check($loginRequest->password, $user->password)) {

            $user->update(['fcm_token' => $loginRequest->fcm_token]);
            $token = $user->createToken("API TOKEN")->plainTextToken;
            $response = ['user' => LoginResource::make($user), 'token' => $token];

            return $this->okResponse($response , __('Login successfully', [], Request()->header('Accept-language')));
        }
        return $this->errorResponse(__('These credentials do not match our records.', [], Request()->header('Accept-language')));
    }


    public function resetPassword(ResetPasswordRequest $resetPasswordRequest)
    {
        $user = User::where('phone', $resetPasswordRequest->phone)->first();
        if ($user) {
            $user->update(['password' => Hash::make($resetPasswordRequest->password)]);
            return $this->okResponse(LoginResource::make($user), __('The password has been reset successfully', [], Request()->header('Accept-language')));
        }

        return $this->errorResponse(__('These credentials do not match our records.', [], Request()->header('Accept-language')));
    }

    public function changePassword(ChangePassword $changePassword)
    {
        $user = auth('sanctum')->user();
        $user->update(['password' => Hash::make($changePassword->password)]);
        return $this->okResponse(LoginResource::make($user), __('The password has been changed successfully', [], Request()->header('Accept-language')));
    }

    public function profile()
    {
        $user = auth('sanctum')->user();
        if ($user->service == 'vendor') {
            return $this->okResponse(LoginResource::make($user), __('Vendor profile', [], Request()->header('Accept-language')));
        } else {
            return $this->okResponse(LoginResource::make($user), __('Merchant profile', [], Request()->header('Accept-language')));

        }
    }

    public function updateProfile(ProfileRequest $profileRequest)
    {
        $data = $profileRequest->validated();
        $user = auth('sanctum')->user();
        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($profileRequest->file('image'), 'category');
       }
        $user->update($data);
        return $this->okResponse(LoginResource::make($user), __('The user profile has been updated successfully', [], Request()->header('Accept-language')));
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }
        return $this->okResponse(LoginResource::make($request->user()), __('logout', [], Request()->header('Accept-language')));
    }
}
