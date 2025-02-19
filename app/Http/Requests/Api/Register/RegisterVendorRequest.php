<?php

namespace App\Http\Requests\Api\Register;

use Illuminate\Foundation\Http\FormRequest;

class RegisterVendorRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone'=> 'required|string|unique:users,phone',
            'national_number' => 'required|string|unique:users,national_number',
            'image' => 'nullable|image',
            'category' => 'required|in:dealer,my',
            'password' => 'required|string|min:8|confirmed',

        ];
    }
}
