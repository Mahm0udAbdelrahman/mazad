<?php

namespace App\Http\Requests\Api\Car;

use Illuminate\Foundation\Http\FormRequest;

class CarUpdateRequest extends FormRequest
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
            'name'=> 'sometimes|string|max:255',
            'car_type_id' => 'sometimes|exists:car_types,id',
            'model'=> 'sometimes|string|max:255',
            'color'=> 'sometimes|string|max:255',
            'kilometer'=> 'sometimes|string|max:255',
            'price'=> 'sometimes|string|max:255',
            'license_year' => 'sometimes|string|max:255',
            'description'=> 'sometimes|string|max:1000',
            'video' => 'sometimes|mimes:mp4,avi,mov,wmv|max:1048576', // 1 جيجابايت
            'image_license'=> 'sometimes|mimes:jpeg,png,jpg,pdf|max:2048',
            'images'=> 'sometimes|array',
            'images.*'=> 'sometimes|image',
            'report' => 'sometimes|mimes:jpeg,png,jpg,pdf|max:2048',
            'status' => 'sometimes|in:pending,approved,rejected',

        ];
    }
}
