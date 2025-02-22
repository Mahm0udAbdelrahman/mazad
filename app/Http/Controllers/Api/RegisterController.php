<?php
namespace App\Http\Controllers\Api;

use App\Helpers\OTPHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Register\CodeRequest;
use App\Http\Requests\Api\Register\RegisterVendorRequest;
use App\Http\Requests\Api\Register\SendCodeRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use App\Service\RegisterService;
use App\Traits\HttpResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use HttpResponse;
    public function __construct(public RegisterService $registerService)
    {}

    public function register(RegisterVendorRequest $request)
    {
        $data = $this->registerService->register($request->validated());

        $resource = [
            'user' => new RegisterResource($data),
            'otp'  => $data['code'],
        ];
        return $this->okResponse($resource, __('User registered successfully', [], Request()->header('Accept-language')));
    }

    public function verify(CodeRequest $codeRequest)
    {
        [$user, $token] = $this->registerService->verify($codeRequest->validated());

        $response = [
            'user'  => LoginResource::make($user),
            'token' => $token,
        ];
        return $this->okResponse($response, __('User account verified successfully', [], request()->header('Accept-language')));
    }

   
}
