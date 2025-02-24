<?php

namespace App\Http\Requests\Dashboard\Provider;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProviderRequest extends FormRequest
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
        'email' => "nullable|email",
        'phone' => "required|numeric",
        'password' => 'nullable|string|min:8',
        'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:102400'

    ];
}
}
