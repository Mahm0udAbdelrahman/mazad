<?php

namespace App\Http\Requests\Dashboard\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title_en.required' => __('Title (English) field is required.', [], request()->header('Accept-Language')),
            'title_en.string' => __('Title (English) must be a valid string.', [], request()->header('Accept-Language')),
            'title_en.max' => __('Title (English) must not exceed 255 characters.', [], request()->header('Accept-Language')),
            'title_ar.required' => __('Title (Arabic) field is required.', [], request()->header('Accept-Language')),
            'title_ar.string' => __('Title (Arabic) must be a valid string.', [], request()->header('Accept-Language')),
            'title_ar.max' => __('Title (Arabic) must not exceed 255 characters.', [], request()->header('Accept-Language')),
            'description_en.required' => __('Description (English) field is required.', [], request()->header('Accept-Language')),
            'description_en.string' => __('Description (English) must be a valid string.', [], request()->header('Accept-Language')),
            'description_ar.required' => __('Description (Arabic) field is required.', [], request()->header('Accept-Language')),
            'description_ar.string' => __('Description (Arabic) must be a valid string.', [], request()->header('Accept-Language')),
            'image.required' => __('Image field is required.', [], request()->header('Accept-Language')),
            'image.mimes' => __('Image must be a file of type: jpeg, png, jpg, gif, svg.', [], request()->header('Accept-Language')),
            'image.max' => __('Image must not exceed 2MB in size.', [], request()->header('Accept-Language'))
        ];
    }
}