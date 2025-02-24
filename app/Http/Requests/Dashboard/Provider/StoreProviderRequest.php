<?php

namespace App\Http\Requests\Dashboard\Provider;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreProviderRequest extends FormRequest
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
            'email' => ['nullable','email',Rule::unique('users')->whereNull('deleted_at')],
            'phone' => ['required','numeric',Rule::unique('users')->whereNull('deleted_at')],
            'password' => 'required|string|min:8',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:102400'
        ];
    }
}
