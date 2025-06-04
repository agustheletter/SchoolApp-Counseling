<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounselingRequest;
use App\Models\Counseling;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $teacherId = auth()->id();
        
        // Only count requests assigned to current teacher
        $pendingRequests = CounselingRequest::where('idguru', $teacherId)
            ->where('status', 'Pending')
            ->count();
            
        $todaySessions = CounselingRequest::where('idguru', $teacherId)
            ->whereDate('tanggal_permintaan', now())
            ->where('status', 'Approved')
            ->count();
            
        $activeStudents = CounselingRequest::where('idguru', $teacherId)
            ->distinct('idsiswa')
            ->count();
            
        $monthlySessions = CounselingRequest::where('idguru', $teacherId)
            ->whereMonth('tanggal_permintaan', now()->month)
            ->whereYear('tanggal_permintaan', now()->year)
            ->where('status', 'Completed')
            ->count();

        // Add today's schedule query
        $todaySchedule = CounselingRequest::where('idguru', $teacherId)
            ->whereDate('tanggal_permintaan', now())
            ->where('status', 'Approved')
            ->with(['student'])
            ->orderBy('tanggal_permintaan')
            ->get();

        // Get latest requests
        $latestRequests = CounselingRequest::where('idguru', $teacherId)
            ->with(['student'])
            ->latest()
            ->take(5)
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
        $teacherId = auth()->id();
        
        $requests = CounselingRequest::with(['student'])
            ->where('idguru', $teacherId)
            ->when(request('status'), function($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('teacher.request', compact('requests'));
    }

    // Protect action methods
    public function approveRequest($id)
    {
        $request = CounselingRequest::where('idguru', auth()->id())
            ->findOrFail($id);
        $request->status = 'Approved';
        $request->save();

        return redirect()->back()->with('success', 'Permintaan konseling berhasil diterima.');
    }

    public function rejectRequest($id)
    {
        $request = CounselingRequest::where('idguru', auth()->id())
            ->findOrFail($id);
        $request->status = 'Rejected';
        $request->save();

        return redirect()->back()->with('success', 'Permintaan konseling berhasil ditolak.');
    }

    public function completeRequest(Request $request, $id)
    {
        $counselingRequest = CounselingRequest::where('idguru', auth()->id())
            ->findOrFail($id);
        
        try {
            \DB::beginTransaction();

            // Validate the request
            $validated = $request->validate([
                'hasil_konseling' => 'required|string'
            ]);

            // Update counseling request status
            $counselingRequest->status = 'Completed';
            $counselingRequest->save();

            // Find the counseling session using the correct relationship
            // The Counseling table uses idkonseling to reference the CounselingRequest id
            $counseling = Counseling::where('idkonseling', $counselingRequest->id)->first();
            
            if ($counseling) {
                // Update existing counseling session
                $counseling->status = 'Completed';
                $counseling->hasil_konseling = $validated['hasil_konseling'];
                $counseling->save();
            } else {
                // Create new counseling session if it doesn't exist
                $counseling = new Counseling();
                $counseling->idsiswa = $counselingRequest->idsiswa;
                $counseling->idguru = $counselingRequest->idguru;
                $counseling->tanggal_konseling = $counselingRequest->tanggal_permintaan;
                $counseling->status = 'Completed';
                $counseling->hasil_konseling = $validated['hasil_konseling'];
                $counseling->save();
                
                // Now update the idkonseling to reference the request
                $counseling->idkonseling = $counselingRequest->id;
                $counseling->save();
            }

            \DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Permintaan konseling berhasil diselesaikan.',
                'success' => true,
                'message' => 'Permintaan konseling berhasil diselesaikan',
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('CompleteRequest Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'success' => false,
                'message' => 'Gagal menyelesaikan permintaan konseling'
            ], 500);
        }
    }

    public function exportRequests()
    {
        $teacherId = auth()->id();
        
        $requests = CounselingRequest::with(['student'])
            ->where('idguru', $teacherId)
            ->orderBy('created_at', 'desc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set title
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'LAPORAN SESI KONSELING');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ]
        ]);

        // Set headers
        $headers = ['No', 'Tanggal Permintaan', 'Nama Siswa', 'Kategori', 'Deskripsi', 'Status'];
        $row = 3;
        foreach (array_values($headers) as $i => $header) {
            $sheet->setCellValue(chr(65 + $i) . $row, $header);
        }

        // Style headers
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4B5563']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ];
        $sheet->getStyle('A3:F3')->applyFromArray($headerStyle);
        
        // Populate data
        $row = 4;
        foreach ($requests as $index => $request) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $request->tanggal_permintaan->format('d/m/Y H:i'));
            $sheet->setCellValue('C' . $row, $request->student->nama);
            $sheet->setCellValue('D' . $row, $request->kategori);
            $sheet->setCellValue('E' . $row, $request->deskripsi);
            $sheet->setCellValue('F' . $row, $request->status);
            
            // Style status cell based on value
            $statusColors = [
                'Pending' => 'FFA500',   // Orange
                'Approved' => '28A745',   // Green
                'Rejected' => 'DC3545',   // Red
                'Completed' => '17A2B8'   // Blue
            ];
            
            if (isset($statusColors[$request->status])) {
                $sheet->getStyle('F' . $row)->applyFromArray([
                    'font' => ['color' => ['rgb' => $statusColors[$request->status]]]
                ]);
            }
            
            $row++;
        }

        // Style data rows
        $dataRange = 'A4:F' . ($row - 1);
        $sheet->getStyle($dataRange)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);
        
        // Auto-size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set row height
        $sheet->getRowDimension(1)->setRowHeight(30);  // Title row
        $sheet->getRowDimension(3)->setRowHeight(20);  // Header row
        
        // Wrap text in description column
        $sheet->getStyle('E4:E' . ($row - 1))->getAlignment()->setWrapText(true);

        // Create Excel file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan_Konseling_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        
        $tempFile = tempnam(sys_get_temp_dir(), 'excel');
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend();
    }
}