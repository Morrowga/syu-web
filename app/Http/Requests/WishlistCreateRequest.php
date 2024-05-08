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
                'required',
                'exists:products,id',
                Rule::unique('wishlists')->where(function ($query) use ($user) {
                return $query->where('user_id', $user->id)
                             ->where('product_id', request()->product_id);
            })]
        ];
    }


    public function messages()
    {
        return [
            'product_id.unique' => 'The selected product is already in your wishlist.'
        ];
    }
}
