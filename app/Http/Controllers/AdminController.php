<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard');
    }

    public function student(): View
    {
       return view('admin.student.v_student');
    }

    public function counselor(): View
    {
        return view('admin.counselor.v_counselor');
    }
    
    public function administrator(): View
    {
        return view('admin.administrator.v_administrator');
    }
        
    public function class(): View
    {
        return view('admin.class.v_class');
    }
}

