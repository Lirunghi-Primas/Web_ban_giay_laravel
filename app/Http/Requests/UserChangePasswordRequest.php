<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserChangePasswordRequest extends FormRequest
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
        return [
            'old_password' => 'required|password',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'old_password.password' => 'Mật khẩu cũ không chính xác.'
        ];
    }

    public function attributes()
    {
        return [
            'old_password' => 'mật khẩu cũ',
            'password' => 'mật khẩu mới',
            'password_confirmation' => 'mật khẩu mới nhập lại'
        ];
    }
}
