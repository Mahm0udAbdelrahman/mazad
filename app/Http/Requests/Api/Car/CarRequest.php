<?php

namespace App\Http\Requests\Api\Car;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class CarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        return [
            'name'=> 'required|string|max:255',
            'car_type_id' => 'required|exists:car_types,id',
            'model'=> 'required|string|max:255',
            'color'=> 'required|string|max:255',
            'kilometer'=> 'required|string|max:255',
            'price'=> 'required|string|max:255',
            'license_year' => 'required|string|max:255',
            'description'=> 'required|string|max:1000',
            'video' => 'required|mimes:mp4,avi,mov,wmv|max:1048576', // 1 جيجابايت
            'image_license'=> 'required|mimes:jpeg,png,jpg,pdf|max:2048',
            'images'=> 'required|array',
            'images.*'=> 'required|image',
            'report' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => __('Validation failed', [], request()->header('Accept-language')),
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

}
