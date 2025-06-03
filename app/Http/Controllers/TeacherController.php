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
            ->count();

        // Get only current teacher's latest requests
        $latestRequests = CounselingRequest::with(['student'])
            ->where('idguru', $teacherId)
            ->latest()
            ->take(5)
            ->get();

        // Get only current teacher's today schedule
        $todaySchedule = CounselingRequest::with(['student'])
            ->where('idguru', $teacherId)
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
        $requests = CounselingRequest::with(['student', 'counselor'])->get();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set column headers
        $sheet->setTitle('Permintaan Konseling');
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Siswa');
        $sheet->setCellValue('C1', 'Kategori');
        $sheet->setCellValue('D1', 'Status');
        $sheet->setCellValue('E1', 'Tanggal Permintaan');
        $sheet->setCellValue('F1', 'Deskripsi');

        // Style the header row
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4B0082'], // Indigo color
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        
        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Add data
        $row = 2;
        foreach ($requests as $request) {
            $sheet->setCellValue('A' . $row, $row - 1);
            $sheet->setCellValue('B' . $row, $request->student->nama ?? 'N/A');
            $sheet->setCellValue('C' . $row, $request->kategori);
            $sheet->setCellValue('D' . $row, $request->priorityLabel);
            $sheet->setCellValue('E' . $row, $request->tanggal_permintaan);
            $sheet->setCellValue('F' . $row, $request->deskripsi);

            // Style data rows
            $dataStyle = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ];
            
            // Add zebra striping
            if ($row % 2 == 0) {
                $dataStyle['fill'] = [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F8F9FA'],
                ];
            }

            $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($dataStyle);
            $sheet->getRowDimension($row)->setRowHeight(25);
            
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set specific column alignments
        $sheet->getStyle('A2:A' . ($row-1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D2:E' . ($row-1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Create response with headers
        $response = response()->stream(
            function() use ($spreadsheet) {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="permintaan_konseling_'.date('Y-m-d').'.xlsx"',
            ]
        );
        
        return $response;
    }
}