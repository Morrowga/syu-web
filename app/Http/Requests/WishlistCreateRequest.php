<?php

namespace App\Http\Requests;

use App\Models\Wishlist;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class WishlistCreateRequest extends FormRequest
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
            "product_id" => [
                'required'
            ]
        ];
    }


    public function messages()
    {
        return [
            'product_id.unique' => 'The selected product is already in your wishlist.'
        ];
    }
}
