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

Route::get('/dashboard', [HomeController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');

Route::prefix('counseling')->name('counseling.')->middleware(['auth', CheckRole::class . ':user'])->group(function ()  {
    Route::get('/messages', [CounselingController::class, 'message'])->name('messages');
    Route::get('/reports', [CounselingController::class, 'reports'])->name('reports');
    Route::get('/profile', [CounselingController::class,'profile'])->name('profile');
    Route::get('/request', [CounselingController::class, 'request'])->name('request');
    Route::post('/request', [CounselingController::class, 'storeRequest'])->name('request.store');
    Route::get('/my-requests', [CounselingController::class, 'myRequests'])->name('my-requests');
    Route::get('/chat', [CounselingController::class, 'chat'])->name('chat');
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
    Route::get('/request', [TeacherController::class, 'request'])->name('request');
    Route::post('/teacher/request/{id}/approve', [TeacherController::class, 'approveRequest'])->name('teacher.request.approve');
    Route::post('/teacher/request/{id}/reject', [TeacherController::class, 'rejectRequest'])->name('teacher.request.reject');
    Route::post('/teacher/request/{id}/complete', [TeacherController::class, 'completeRequest'])->name('teacher.request.complete');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/student', [AdminController::class, 'student'])->name('student');
    Route::get('/counselor', [AdminController::class,'counselor'])->name('counselor');
    Route::get('/administrator', [AdminController::class,'administrator'])->name('administrator');
    Route::get('/class', [AdminController::class,'class'])->name('class');
    
});

Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [UserSettingController::class, 'index'])->name('profile.settings');
    Route::put('/settings/account', [UserSettingController::class, 'updateAccount'])->name('settings.account');
    Route::put('/settings/security', [UserSettingController::class, 'updateSecurity'])->name('settings.security');
    Route::post('/settings/avatar', [UserSettingController::class, 'updateAvatar'])->name('settings.avatar');
    Route::delete('/settings/delete-account', [UserSettingController::class, 'deleteAccount'])->name('settings.delete-account');
    Route::put('/settings/appearance', [UserSettingController::class, 'updateAppearance'])->name('settings.appearance');
    Route::get('/settings/login-history', [UserSettingController::class, 'getLoginHistory'])->name('settings.login-history');
});
