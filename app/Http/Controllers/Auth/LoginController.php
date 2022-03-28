<?php

namespace App\Http\Controllers\Auth;

use App\Encript;
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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials['password'] = Encript::enkripsi($request->password);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'Admin') {
                return redirect()->intended('/anm/dashboard');
            } else {
                return redirect()->intended('/dashboard');
            }
        }

        return back()->with('loginError', 'These credentials do not match our records!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
