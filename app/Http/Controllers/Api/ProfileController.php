<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Services\ProfileService;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoginResource;
use App\Http\Requests\Api\Login\ProfileRequest;

class ProfileController extends Controller
{
    use HttpResponse;
    public function __construct(public ProfileService $profileService)
    {
    }
    public function profile()
    {
        $user =$this->profileService->profile();
        if ($user->service == 'vendor') {
            return $this->okResponse(LoginResource::make($user), __('Vendor profile', [], Request()->header('Accept-language')));
        } else {
            return $this->okResponse(LoginResource::make($user), __('Merchant profile', [], Request()->header('Accept-language')));

        }

    }

    public function updateProfile(ProfileRequest $profileRequest)
    {
        $user = $this->profileService->updateProfile($profileRequest->validated());
        return $this->okResponse(LoginResource::make($user), __('The user profile has been updated successfully', [], Request()->header('Accept-language')));
    }


}
