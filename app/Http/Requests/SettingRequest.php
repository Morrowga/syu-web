<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        if(request()->setting_type == 'general')
        {
            return [
                "splash_slogan" => ['required'],
                "app_bg_color" => ['required'],
                "app_text_color" => ['required'],
                "app_button_color" => ['required'],
                "categories" => ['required'],
                "expire_day" => ['required'],
                "app_logo_img" => ['nullable']
            ];
        } else if(request()->setting_type == 'banner')
        {
            return [
                "images" => ['nullable'],
                "remove_images" => ['nullable']
            ];
        }

    }
}
