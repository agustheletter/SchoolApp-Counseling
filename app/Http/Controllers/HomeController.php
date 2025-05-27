<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        $user = auth()->user();

        if ($user->role === 'guru') {
            return redirect()->route('teacher.dashboard');
        }else if($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('dashboard');
    }
    public function contact()
    {
        return view('contact');
    }
    public function about()
    {
        return view('about');   
    }
    public function services()
    {
        return view('services');
    }
    public function aboutdev()
    {
        return view('aboutdev');
    }
}