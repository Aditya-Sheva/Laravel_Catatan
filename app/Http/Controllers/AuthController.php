<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.users');
            }

            return redirect()->route('notes.index');
        }

        return back()->with('error', 'Email atau password salah!');
    }


    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        $role = User::count() === 0 ? 'admin' : 'user';

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil!');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
