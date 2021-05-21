<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = auth()->user()->id;
        
        return [
            'fullname' => 'required|string',
            'phone_number' => "required|size:10|regex:/^[0-9]+$/|unique:users,phone_number,{$id}",
            'address' => 'required'
        ];
    }
}
