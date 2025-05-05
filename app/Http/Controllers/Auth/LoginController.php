<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'uname' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('name', $request->uname)
            ->where('password', $request->password)
            ->first();

        if ($user) {
            Auth::login($user); // <== Ini yang penting
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Username atau Password salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
