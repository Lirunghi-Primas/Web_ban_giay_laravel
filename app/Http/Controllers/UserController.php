<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateProfileRequest;
use App\Http\Requests\UserChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request) 
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return back()->with('message', 'Đăng ký tài khoản thành công.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (auth()->attempt($credentials, $request->remember)) {
            return redirect()->route('home');
        } else {
            return back()->withInput()->withErrors('Thông tin đăng nhập không chính xác.');
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function updateProfile(UserUpdateProfileRequest $request)
    {
        $data = $request->validated();

        auth()->user()->update($data);

        return back()->with('profile_message', 'Cập nhật hồ sơ thành công.');
    }

    public function changePassword(UserChangePasswordRequest $request)
    {
        $data = $request->validated();

        auth()->user()->update(['password' => bcrypt($data['password'])]);

        return back()->with('password_message', 'Đổi mật khẩu thành công.');

    }

    public function sendForgotPasswordRequest(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Địa chỉ Email không tồn tại.']);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['message' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }
}
