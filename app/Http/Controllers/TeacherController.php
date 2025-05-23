<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function dashboard(){
        return view('teacher.dashboard');
    }

    public function request(){
        return view('teacher.request');
    }   
}
