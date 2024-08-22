<?php

namespace App\Http\Requests\Api;

use App\Models\ShippingCity;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Rules\NameValidation;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Rules\ExtraAddressValidation;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function outOfAreaCityId()
    {
        return ShippingCity::where('name_en', 'Out Of Area or Gate')->first()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = Auth::user();

        $rules = [
            "name" => ['required', new NameValidation],
            "email" => ['nullable'],
            'shipping_city_id' => ['required', 'exists:shipping_cities,id'],
            "shipping_address" => ['required'],
            "msisdn" => ['required', Rule::unique('users', 'msisdn')->ignore($user->id)],
            "gender" => ['required', 'in:male,female,other'],
            "is_above_eighteen" => ['nullable'],
        ];

        if ($this->shipping_city_id == $this->outOfAreaCityId()) {
            $rules['extra_address'] = ['required'];
        } else {
            $rules['extra_address'] = ['nullable'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'extra_address.required' => 'လိပ်စာသည် ဂိတ်ချ သို့မဟုတ် စာဝေနယ်ပြင်ပဖြစ်ပါက အပေါ်နေရာတွင်အချက်အလတ်ထည့်သွင်းပေးရပါမည်။',
        ];
    }

}
