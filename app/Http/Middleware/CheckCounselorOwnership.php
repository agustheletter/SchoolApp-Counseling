<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\CounselingRequest;

class CheckCounselorOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $counselingRequestId = $request->route('id');
        $teacherId = auth()->id();

        $counselingRequest = CounselingRequest::where('id', $counselingRequestId)
            ->where('idguru', $teacherId)
            ->first();

        if (!$counselingRequest) {
            return response()->json([
                'message' => 'Anda tidak memiliki akses untuk mengelola sesi konseling ini'
            ], 403);
        }

        return $next($request);
    }
}
