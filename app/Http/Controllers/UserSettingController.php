<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Validation\Rule;

class UserSettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('counseling.setting', compact('user'));
    }

    public function updateAccount(Request $request)
    {
        $validationRules = [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:tbl_users,username,' . Auth::id(),
            'email' => 'required|string|email|max:255|unique:tbl_users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:15',
            'bio' => 'nullable|string|max:1000',
        ];

        // Add NIP validation for guru role
        if (Auth::user()->role === 'guru') {
            $validationRules['nip'] = 'required|string|size:18|regex:/^[0-9]+$/|unique:tbl_users,nip,' . Auth::id();
        }

        $request->validate($validationRules);

        $user = Auth::user();
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->bio = $request->bio;

        // Update NIP if user is guru
        if ($user->role === 'guru') {
            $user->nip = $request->nip;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateSecurity(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'different:current_password',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'
            ],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini tidak sesuai'])
                ->withInput();
        }

        try {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return back()->with('success', 'Password berhasil diubah');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Terjadi kesalahan saat mengubah password'])
                ->withInput();
        }
    }

    public function updateAppearance(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark'
        ]);

        $user = Auth::user();
        $user->theme = $request->theme;
        $user->save();

        return back()->with('success_appereance', 'Tema berhasil diubah.');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|in:HAPUS AKUN SAYA'
        ]);

        try {
            $user = Auth::user();
            
            // Revoke all tokens if using sanctum/passport
            if (method_exists($user, 'tokens')) {
                $user->tokens()->delete();
            }
            
            // Delete avatar if exists
            if ($user->avatar && !str_starts_with($user->avatar, 'default-')) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }
            
            // Delete the user
            $user->delete();
            
            Auth::logout();
            
            return redirect()
                ->route('login')
                ->with('success', 'Akun Anda telah berhasil dihapus.');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus akun']);
        }
    }
    
    public function updateAvatar(Request $request)
    {
        if (!$request->hasFile('avatar')) {
            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
        }

        try {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $user = Auth::user();
            $file = $request->file('avatar');
            
            // Delete old avatar if exists and is not default
            if ($user->avatar && !str_starts_with($user->avatar, 'default-')) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }
            
            // Generate filename
            $filename = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store file
            $path = $file->storeAs('avatars', $filename, 'public');
            
            if (!$path) {
                throw new \Exception('Failed to store file');
            }

            // Update database
            $user->avatar = $filename;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Avatar updated successfully',
                'avatar_url' => $user->avatar_url
            ]);

        } catch (\Exception $e) {
            \Log::error('Avatar upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload avatar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get the user's login history.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLoginHistory()
    {
        $user = Auth::user();
        $agent = new \Jenssegers\Agent\Agent();
        
        // Get location from IP
        $position = Location::get($user->last_login_ip ?? request()->ip());
        $location = $position ? "{$position->cityName}, {$position->countryName}" : 'Unknown Location';
        
        // Get device and browser info
        $browser = $agent->browser();
        $deviceType = $this->getDeviceType($agent);
        $device = "{$browser} di {$deviceType}";
        
        $loginData = [[
            'device' => $device,
            'location' => $location,
            'ip_address' => $user->last_login_ip ?? request()->ip(),
            'login_at' => $user->last_login_at ?? now(),
            'status' => 'current'
        ]];

        return response()->json($loginData);
    }

    private function getDeviceType($agent)
    {
        if ($agent->isPhone()) {
            return 'Smartphone';
        } elseif ($agent->isTablet()) {
            return 'Tablet';
        } elseif ($agent->isDesktop()) {
            return $agent->platform() ?: 'Desktop';
        }
        return 'Unknown Device';
    }
}