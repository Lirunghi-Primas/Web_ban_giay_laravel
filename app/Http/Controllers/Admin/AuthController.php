<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Admin\LoginRequest;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $attempt = Auth::guard('admin')->attempt([
            'username' => $data['username'], 
            'password' => $data['password']
        ]);

        if ($attempt) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        } 

        return back()->withErrors(['username' => trans('auth.failed')]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
