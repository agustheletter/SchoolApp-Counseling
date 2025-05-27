<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounselingRequest; // Correct model
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $pendingRequests = CounselingRequest::where('status', 'Pending')->count();
        $todaySessions = CounselingRequest::whereDate('tanggal_permintaan', now())->where('status', 'Approved')->count();
        $activeStudents = CounselingRequest::distinct('idsiswa')->count();
        $monthlySessions = CounselingRequest::whereMonth('tanggal_permintaan', now()->month)->count();
        $latestRequests = CounselingRequest::with('student')->latest()->take(5)->get();

        // Fetch today's schedule (only approved requests for today)
        $todaySchedule = CounselingRequest::with('student')
            ->whereDate('tanggal_permintaan', now())
            ->where('status', 'Approved')
            ->get();

        return view('teacher.dashboard', compact(
            'pendingRequests',
            'todaySessions',
            'activeStudents',
            'monthlySessions',
            'latestRequests',
            'todaySchedule'
        ));
    }

    public function request()
    {
        $requests = CounselingRequest::with(['student', 'counselor'])->paginate(10);
        
        return view('teacher.request', compact('requests'));
    }

    public function approveRequest($id)
    {
        $request = CounselingRequest::findOrFail($id);
        $request->status = 'Approved';
        $request->save();

        return redirect()->back()->with('success', 'Permintaan konseling berhasil diterima.');
    }

    public function rejectRequest($id)
    {
        $request = CounselingRequest::findOrFail($id);
        $request->status = 'Rejected';
        $request->save();

        return redirect()->back()->with('success', 'Permintaan konseling berhasil ditolak.');
    }

    public function completeRequest($id)
    {
        $request = CounselingRequest::findOrFail($id);
        $request->status = 'Completed';
        $request->save();

        return redirect()->back()->with('success', 'Permintaan konseling berhasil diselesaikan.');
    }
}
