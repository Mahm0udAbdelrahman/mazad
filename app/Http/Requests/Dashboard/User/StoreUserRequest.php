<?php

namespace App\Http\Requests\Dashboard\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'email' => ['nullable','email',Rule::unique('users')->whereNull('deleted_at')],
            'phone' => ['required','numeric',Rule::unique('users')->whereNull('deleted_at')],
            'password' => 'required|string|min:8',
            'service' => 'required|in:vendor,merchant',
            'national_number' => [
                $this->service === 'vendor' ? 'required' : 'nullable',
                'string',
                "unique:users,national_number,{$this->id},id,deleted_at,NULL"
            ],
            'category' => 'required|in:dealer,my',
            'role_id' => 'required|numeric|exists:roles,id',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:102400'

        ];
    }
}
