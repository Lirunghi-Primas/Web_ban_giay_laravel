<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return session('cart') ? (bool) count(session('cart')) : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fullname' => 'required|string',
            'phone_number' => 'required|size:10|regex:/^[0-9]+$/',
            'email' => 'required|email',
            'address' => 'required'
        ];
    }
}
