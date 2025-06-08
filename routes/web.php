<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\UserSettingController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\CounselorController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FirebaseController; // Add this import
use Illuminate\Support\Facades\Broadcast;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/aboutdev' , [HomeController::class, 'aboutdev'])->name('aboutdev');

Route::middleware(['web'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth'])->group(function () {
    // Change this line
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    // Remove or comment out this line since we now have the main dashboard route
  Route::get('/student/dashboard', [HomeController::class, 'dashboard'])->name('student.dashboard');

    Route::get('/construction', function () {
        return view('under_construction.construct');
    })->name('construction');

    Route::prefix('counseling')->name('counseling.')->middleware(['auth'])->group(function ()  {
        Route::get('/reports/export', [CounselingController::class, 'exportReports'])->name('reports.export');
        Route::get('/reports', [CounselingController::class, 'reports'])->name('reports');
        Route::get('/profile', [CounselingController::class,'profile'])->name('profile');
        Route::get('/request', [CounselingController::class, 'request'])->name('request');
        Route::post('/request', [CounselingController::class, 'storeRequest'])->name('request.store');
        Route::get('/my-requests', [CounselingController::class, 'myRequests'])->name('my-requests');
        Route::get('/setting', [CounselingController::class, 'setting'])->name('setting');
        Route::get('/history', [CounselingController::class, 'history'])->name('history');
        Route::get('/request/{id}', [CounselingController::class, 'show'])->name('request.show');
        Route::delete('/request/{id}/cancel', [CounselingController::class, 'cancel'])->name('request.cancel');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    });

    Route::prefix('teacher')->name('teacher.')->middleware(['auth', CheckRole::class . ':guru'])->group(function(){
        Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
        Route::get('/request/export', [TeacherController::class, 'exportRequests'])->name('request.export');
        Route::get('/request', [TeacherController::class, 'request'])->name('request');
        Route::post('/request/{id}/approve', [TeacherController::class, 'approveRequest'])->name('request.approve');
        Route::post('/request/{id}/reject', [TeacherController::class, 'rejectRequest'])->name('request.reject');
        Route::post('/request/{id}/complete', [TeacherController::class, 'completeRequest'])->name('request.complete');
    });

    Route::prefix('admin')->name('admin.')->middleware(['auth', CheckRole::class . ':admin'])->group(function () {
        // Dashboard route
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Counselor management routes
        Route::get('/counselor/get-users', [CounselorController::class, 'getUsers'])->name('counselor.getUsers');
        Route::post('/counselor/convert/{id}', [CounselorController::class, 'convertToCounselor'])->name('counselor.convert');
        Route::post('/counselor/{id}/restore', [CounselorController::class, 'restore'])->name('counselor.restore');
        Route::resource('counselor', CounselorController::class);

        // Student management routes
        Route::get('/student', [SiswaController::class, 'index'])->name('student'); // Changed from 'student' to 'student.index'
        Route::get('/student/{id}', [SiswaController::class, 'show'])->name('student.show');
        Route::delete('/student/{id}', [SiswaController::class, 'destroy'])->name('student.destroy');
        Route::get('/check-table', [SiswaController::class, 'checkTable'])->name('check-table');
        Route::post('/student/{id}/restore', [SiswaController::class, 'restore'])->name('student.restore');
        
        Route::get('/administrator', [AdminController::class, 'administrator'])->name('administrator');
        Route::get('/class', [AdminController::class, 'class'])->name('class');
    });

    Route::get('/settings', [UserSettingController::class, 'index'])->name('profile.settings');
    Route::put('/settings/account', [UserSettingController::class, 'updateAccount'])->name('settings.account');
    Route::put('/settings/security', [UserSettingController::class, 'updateSecurity'])->name('settings.security');
    Route::post('/settings/avatar', [UserSettingController::class, 'updateAvatar'])->name('settings.avatar');
    Route::delete('/settings/delete-account', [UserSettingController::class, 'deleteAccount'])->name('settings.delete-account');
    Route::put('/settings/appearance', [UserSettingController::class, 'updateAppearance'])->name('settings.appearance');
    Route::get('/settings/login-history', [UserSettingController::class, 'getLoginHistory'])->name('settings.login-history');
    Route::put('/settings/counselor', [UserSettingController::class, 'updateCounselor'])->name('settings.counselor');

    // Messages routes
    Route::middleware(['auth'])->group(function () {
        Route::prefix('messages')->group(function () {
            Route::get('/', [MessageController::class, 'index'])->name('counseling.messages');
            Route::get('/contacts', [MessageController::class, 'contacts'])->name('messages.contacts');
            Route::get('/conversation/{conversation}', [MessageController::class, 'show'])
             ->name('messages.conversation.show')
             ->middleware('can:view,conversation'); // Add authorization middleware
            Route::post('/conversation/start', [MessageController::class, 'startConversation'])->name('messages.conversation.start');
            Route::post('/{conversation}/send', [MessageController::class, 'send'])->name('messages.send');
            Route::get('/check-new', [MessageController::class, 'checkNew'])->name('messages.check-new');
            Route::post('/conversation/{conversation}/mark-read', [MessageController::class, 'markAsRead'])->name('messages.mark-read');
            Route::get('/contacts/available', [MessageController::class, 'availableContacts'])
             ->name('messages.contacts.available');
        });

        // Add this route temporarily for debugging
        Route::get('/debug-counselors', function() {
            $counselors = \App\Models\Counselor::all();
            return response()->json($counselors);
        });

        // Firebase route - Add this line
        Route::get('/firebase/token', [FirebaseController::class, 'getToken'])->name('firebase.token');
    });

    Route::get('/debug/users', function() {
        $user = Auth::user();
        
        $allUsers = \App\Models\User::select('id', 'nama', 'role', 'username')
                                    ->get();
        
        $availableUsers = \App\Models\User::where('id', '!=', $user->id)
                                        ->select('id', 'nama', 'role', 'username')
                                        ->get();
        
        return response()->json([
            'current_user' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'role' => $user->role
            ],
            'all_users' => $allUsers,
            'available_users' => $availableUsers,
            'table_name' => (new \App\Models\User())->getTable(),
            'database_connection' => config('database.default')
        ]);
    })->middleware('auth');

    // Other counseling routes
    Route::get('/counseling/request', [CounselingController::class, 'request'])->name('counseling.request');
    Route::get('/counseling/my-requests', [CounselingController::class, 'myRequests'])->name('counseling.my-requests');
    Route::get('/counseling/history', [CounselingController::class, 'history'])->name('counseling.history');
    Route::get('/counseling/reports', [CounselingController::class, 'reports'])->name('counseling.reports');
});

// Broadcast routes
Broadcast::routes(['middleware' => ['web', 'auth']]);