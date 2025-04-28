<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;

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
            ->where('password', $request->password) // tanpa hash, untuk testing
            ->first();

        if ($user) {
            Session::put('loginId', $user->id);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Username atau Password salah');
    }

    public function logout()
    {
        Session::forget('loginId');
        return redirect()->route('home');
    }
}
