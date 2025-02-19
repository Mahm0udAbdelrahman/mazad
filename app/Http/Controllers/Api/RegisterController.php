<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Service\RegisterService;
use App\Http\Controllers\Controller;
use App\Http\Resources\RegisterVendorResource;
use App\Http\Resources\RegisterMerchantResource;
use App\Http\Requests\Api\Register\RegisterVendorRequest;
use App\Http\Requests\Api\Register\RegisterMerchantRequest;

class RegisterController extends Controller
{
    use HttpResponse;
    public function __construct(public RegisterService $registerService){}

    public function registerVendor(RegisterVendorRequest $request){
        $data = $this->registerService->registerVendor($request->validated());

        return $this->okResponse(new RegisterVendorResource($data));
    }

    public function registerMerchant(RegisterMerchantRequest $request)
    {
        $data = $this->registerService->registerMerchant($request->validated());

        return $this->okResponse(new RegisterMerchantResource($data));
    }
}
