<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth;
use Illuminate\Support\Facades\Auth as LaravelAuth;
use Illuminate\Support\Facades\Log;

class FirebaseController extends Controller
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function getToken()
    {
        try {
            $user = LaravelAuth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'error' => 'User not authenticated'
                ], 401);
            }

            $customToken = $this->auth->createCustomToken((string)$user->id, [
                'email' => $user->email,
                'name' => $user->nama,
                'role' => $user->role
            ]);

            return response()->json([
                'success' => true,
                'token' => $customToken->toString(),
                'user' => [
                    'id' => $user->id,
                    'name' => $user->nama,
                    'email' => $user->email
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Firebase token error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to generate token: ' . $e->getMessage()
            ], 500);
        }
    }
}