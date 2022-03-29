<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\CaesarCipher;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2|max:100',
                'username' => 'required|min:5|max:20|unique:users',
                'email' => 'required|min:2|max:100|email|unique:users',
                'password' => 'required|min:5|max:40|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '400',
                    'errors' => $validator->errors()
                ]);
            } else {
                $data = $request->all();
                $password = CaesarCipher::enkripsi($request->password);
                $data['password'] = Hash::make($password);
                $data['role'] = 'User';

                User::create($data);

                return response()->json([
                    'status' => '200',
                    'message' => 'Registration successfully'
                ]);
            }
        }
    }

    public function checkUsername(Request $request)
    {
        if ($request->ajax()) {
            $hasil = User::where('username', $request->username)->first();
            if ($hasil) {
                return response()->json([
                    'status' => '400',
                    'errors' => 'Username already taken'
                ]);
            } else {
                return response()->json([
                    'status' => '200',
                    'message' => 'Username already'
                ]);
            }
        }
    }
}
