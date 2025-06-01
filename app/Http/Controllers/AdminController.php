<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Jurusan;
use App\Models\Agama;


class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard');
    }

    public function student(): View
    {
       $jurusans = Jurusan::orderBy('namajurusan')->get(['idjurusan', 'namajurusan']);
       $agamas = Agama::orderBy('agama')->get(['idagama', 'agama']);
       $tahunMasukOptions = range(date('Y') - 10, date('Y') + 1); 
       return view('admin.student.v_student', compact('jurusans', 'agamas', 'tahunMasukOptions'));
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

