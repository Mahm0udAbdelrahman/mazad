<?php

namespace App\Http\Requests\Dashboard\SendNotification;

use Illuminate\Foundation\Http\FormRequest;

class SendNotificationRequest extends FormRequest
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
           'title_ar' => 'required|string|max:255',
           'title_en'=> 'required|string|max:255',
           'title_ru'=> 'required|string|max:255',
           'body_en'=> 'required|string|max:255',
           'body_ar'=> 'required|string|max:255',
           'body_ru'=> 'required|string|max:255',
        ];
    }
}
