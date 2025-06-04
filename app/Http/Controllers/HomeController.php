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
        if (auth()->user()->role !== 'user') {
            return redirect()->route(auth()->user()->role === 'guru' ? 'teacher.dashboard' : 'admin.dashboard');
        }

        // Changed to return the existing dashboard view
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