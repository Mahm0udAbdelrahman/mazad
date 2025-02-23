<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Services\LogoutService;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoginResource;

class LogoutController extends Controller
{
    use HttpResponse;

    public function __construct(public LogoutService $logoutService)
    {
    }

    public function logout()
    {
        $user = $this->logoutService->logout();
        return $this->okResponse(LoginResource::make($user), __('logout', [], Request()->header('Accept-language')));
    }


}
