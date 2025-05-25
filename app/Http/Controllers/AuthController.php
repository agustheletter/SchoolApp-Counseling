<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
    
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'email' => 'required|string|email|max:255|unique:tbl_users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Generate username from name
        $username = strtolower(str_replace(' ', '', $request->name)) . rand(100, 999);

        // Set default avatar based on gender
        $avatar = $request->gender === 'male' ? 'default-male.png' : 'default-female.png';

        User::create([
            'nama' => $request->name,
            'gender' => $request->gender,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $avatar,
            'role' => 'user',
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun Anda telah berhasil dibuat. Silakan login.');  
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    
    protected function authenticated(Request $request, $user)
    {
        $user->recordLogin($request);
    }
}