<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Traits\HasImage;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Services\LoginService;
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

    public function __construct(public LoginService $loginService){}


    public function login(LoginRequest $loginRequest)
    {

        [$user, $token] = $this->loginService->login($loginRequest->validated());

        $response = [
            'user'  => LoginResource::make($user),
            'token' => $token,
        ];
        return $this->okResponse($response, __('Login successfully', [], request()->header('Accept-language')));
    }
}
