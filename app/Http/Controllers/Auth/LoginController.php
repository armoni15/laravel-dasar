<?php

namespace App\Http\Controllers\Auth;

use App\CaesarCipher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            if (Auth::user()->role == 'Admin') {
                return redirect()->intended('/anm/dashboard');
            } else {
                return redirect()->intended('/dashboard');
            }
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'password' => 'required',
        ]);

        $loginType = filter_var($request->user, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials[$loginType] = $request->user;

        $credentials['password'] = CaesarCipher::enkripsi($request->password);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'Admin') {
                return redirect()->intended('/anm/dashboard');
            } else {
                return redirect()->intended('/dashboard');
            }
        }

        return back()->withInput()->with('loginError', 'Login failed!');
        // return back()->with('loginError', 'Login failed!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
