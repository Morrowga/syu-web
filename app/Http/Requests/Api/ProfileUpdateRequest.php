<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Rules\NameValidation;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
        $user = Auth::user();

        return [
            "name" => ['required', new NameValidation],
            "email" => ['nullable'],
            "shipping_city_id" => ['required'],
            "shipping_address" => ['required'],
            "msisdn" => ['required', Rule::unique('users', 'msisdn')->ignore($user->id)],
            "gender" => ['required', 'in:male,female,other'],
            "is_above_eighteen" => ['required'],
        ];
    }
}
