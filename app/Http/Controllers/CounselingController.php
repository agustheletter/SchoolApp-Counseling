<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CounselingController extends Controller
{
    public function message(): View{
        return view("counseling.messages");
    }
    public function reports(): View{
        return view("counseling.reports");
    }
    public function schedule(): View{
        return view("counseling.schedule");
    }
    public function profile(): View{
        return view("counseling.profile");
    }
    public function settings(): View{
        return view("counseling.setting");
    }
    public function request(): View {
        return view("counseling.request");
    }   

    public function myRequests(): View {
        return view("counseling.my-request");
    }
    public function chat(): View {
        return view("counseling.chat");
    }
    public function history(): View{
        return view("counseling.history");
    }
}
