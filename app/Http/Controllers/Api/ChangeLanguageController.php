<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponse;
use App\Http\Controllers\Controller;
use App\Services\ChangeLanguageService;
use App\Http\Resources\ChangeLanguageResource;
use App\Http\Requests\Api\ChangeLanguage\ChangeLanguageRequest;

class ChangeLanguageController extends Controller
{
    use   HttpResponse;
    public function __construct(public ChangeLanguageService $changeLanguageService){}


    public function update(ChangeLanguageRequest $request){
        $change_language = $this->changeLanguageService->update($request->validated());
        return $this->okResponse(new ChangeLanguageResource($change_language), __('The language has been update successfully', [], request()->header('Accept-language')));

    }
}
