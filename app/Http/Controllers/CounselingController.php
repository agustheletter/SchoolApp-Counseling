<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounselingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Counseling;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CounselingController extends Controller
{
    public function message(): View{
        return view("counseling.messages");
    }
    public function reports(Request $request)
    {
        $query = CounselingRequest::with(['counselor', 'counselingSession'])
            ->where('idsiswa', Auth::id());

        // Apply filters
        if ($request->kategori && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $counselingSessions = $query->orderBy('created_at', 'desc')->get();

        return view('counseling.reports', compact('counselingSessions'));
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
            Log::info('Current user ID:', ['id' => Auth::id()]);
            
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

            // Start database transaction
            \DB::beginTransaction();
            try {
                // Create counseling request
                $counselingRequest = new CounselingRequest();
                $counselingRequest->idsiswa = $user->id;
                $counselingRequest->idguru = $validated['counselor_id'];
                $counselingRequest->kategori = $validated['kategori'];
                $counselingRequest->tanggal_permintaan = $validated['tanggal_permintaan'];
                $counselingRequest->deskripsi = $validated['deskripsi'];
                $counselingRequest->status = 'Pending';
                $counselingRequest->save();

                // Create corresponding counseling session
                $counseling = new Counseling();
                $counseling->idkonseling = $counselingRequest->id;
                $counseling->idsiswa = $user->id;
                $counseling->idguru = $validated['counselor_id'];
                $counseling->tanggal_konseling = $validated['tanggal_permintaan'];
                $counseling->status = 'Pending';
                $counseling->save();

                \DB::commit();
                
                return redirect()->route('counseling.my-requests')
                    ->with('success', 'Permintaan konseling berhasil dikirim.');

            } catch (\Exception $e) {
                \DB::rollback();
                Log::error('Transaction Error: ' . $e->getMessage());
                throw $e;
            }

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
        $counselingSessions = CounselingRequest::with(['counselor', 'counselingSession'])
            ->where('idsiswa', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $totalSessions = $counselingSessions->count();
        $completedSessions = $counselingSessions->where('status', 'Completed')->count();
        $pendingSessions = $counselingSessions->where('status', 'Pending')->count();
        $canceledSessions = $counselingSessions->where('status', 'Rejected')->count();

        return view('counseling.history', compact(
            'counselingSessions',
            'totalSessions',
            'completedSessions',
            'pendingSessions',
            'canceledSessions'
        ));
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

        // Add today's schedule - this was missing!
        $todaySchedule = CounselingRequest::whereDate('tanggal_permintaan', now())
            ->where('status', 'Approved')
            ->with(['student'])
            ->orderBy('tanggal_permintaan')
            ->get();

        return view('teacher.dashboard', compact(
            'pendingRequests',
            'todaySessions',
            'activeStudents',
            'monthlySessions',
            'latestRequests',
            'todaySchedule'  // Added this line
        ));
    }

    public function exportReports()
    {
        $counselingSessions = CounselingRequest::with(['counselor', 'counselingSession'])
            ->where('idsiswa', Auth::id())
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Kategori');
        $sheet->setCellValue('D1', 'Status');
        $sheet->setCellValue('E1', 'Konselor');
        $sheet->setCellValue('F1', 'Hasil Konseling');

        // Style header
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4B0082'],
            ],
            'font' => [
                'color' => ['rgb' => 'FFFFFF'],
            ],
        ];
        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

        // Add data
        $row = 2;
        foreach ($counselingSessions as $session) {
            $sheet->setCellValue('A' . $row, $row - 1);
            $sheet->setCellValue('B' . $row, \Carbon\Carbon::parse($session->tanggal_permintaan)->format('d/m/Y'));
            $sheet->setCellValue('C' . $row, $session->kategori);
            $sheet->setCellValue('D' . $row, $session->status);
            $sheet->setCellValue('E' . $row, $session->counselor->nama ?? 'N/A');
            $sheet->setCellValue('F' . $row, $session->counselingSession->hasil_konseling ?? '-');
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create response
        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan_konseling_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}