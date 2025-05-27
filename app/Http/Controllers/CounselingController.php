<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounselingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Models\User;

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
        $counselors = User::where('role', 'guru')->get();
        return view('counseling.request', compact('counselors'));
    }   

    public function storeRequest(Request $request)
    {
        try {
            // Add debug logging for user ID
            Log::info('Current user ID:', ['id' => Auth::id()]);
            
            // Verify user exists
            $user = User::find(Auth::id());
            if (!$user) {
                Log::error('User not found:', ['id' => Auth::id()]);
                return back()->withInput()->with('error', 'User tidak ditemukan.');
            }

            $validated = $request->validate([
                'counselor_id' => 'required|exists:tbl_users,id',
                'kategori' => 'required|in:Pribadi,Akademik,Karir,Lainnya',
                'tanggal_permintaan' => 'required|date|after:today',
                'deskripsi' => 'required|string|max:1000',
                'terms' => 'required|accepted'
            ]);

            $counselingRequest = new CounselingRequest();
            $counselingRequest->idsiswa = $user->id; // Use verified user ID
            $counselingRequest->idguru = $validated['counselor_id'];
            $counselingRequest->kategori = $validated['kategori'];
            $counselingRequest->tanggal_permintaan = $validated['tanggal_permintaan'];
            $counselingRequest->deskripsi = $validated['deskripsi'];
            $counselingRequest->status = 'Pending';
            
            // Add debug logging
            Log::info('Attempting to save counseling request:', $counselingRequest->toArray());

            if (!$counselingRequest->save()) {
                Log::error('Failed to save counseling request');
                return back()->withInput()->with('error', 'Gagal membuat permintaan konseling. Silakan coba lagi.');
            }

            Log::info('Counseling request saved successfully with ID: ' . $counselingRequest->id);
            
            return redirect()->route('counseling.my-requests')
                ->with('success', 'Permintaan konseling berhasil dikirim.');
        } catch (\Exception $e) {
            Log::error('Counseling Request Error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function myRequests(): View {
        $requests = CounselingRequest::where('idsiswa', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('counseling.my-requests', compact('requests'));
    }
    public function chat(): View {
        return view("counseling.chat");
    }
    public function history(): View{
        return view("counseling.history");
    }
    public function show($id)
    {
        $request = CounselingRequest::findOrFail($id);
        return view('counseling.request-detail', compact('request'));
    }

    public function cancel($id)
    {
        $request = CounselingRequest::findOrFail($id);
        
        if ($request->status !== 'Pending') {
            return back()->with('error', 'Hanya permintaan yang masih menunggu yang dapat dibatalkan.');
        }
        
        $request->delete();
        return redirect()->route('counseling.my-requests')
            ->with('success', 'Permintaan konseling berhasil dibatalkan.');
    }

    public function dashboard()
    {
        $pendingRequests = CounselingRequest::where('status', 'Pending')->count();
        $todaySessions = CounselingRequest::whereDate('tanggal_permintaan', now())->count();
        $activeStudents = CounselingRequest::distinct('idsiswa')->count();
        $monthlySessions = CounselingRequest::whereMonth('tanggal_permintaan', now()->month)->count();
        $latestRequests = CounselingRequest::with('student')->latest()->take(5)->get();

        return view('teacher.dashboard', compact(
            'pendingRequests',
            'todaySessions',
            'activeStudents',
            'monthlySessions',
            'latestRequests'
        ));
    }
}
