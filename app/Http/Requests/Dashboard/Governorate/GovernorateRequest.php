<?php

namespace App\Http\Requests\Dashboard\Governorate;

use Illuminate\Foundation\Http\FormRequest;

class GovernorateRequest extends FormRequest
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
            'governorate_name_ar' => 'required|string|max:255',
            'governorate_name_en' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ];
    }
}
