<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;


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

Route::prefix('counseling')->name('counseling.')->group(function () {
    Route::get('/messages', [CounselingController::class, 'message'])->name('messages');
    Route::get('/reports', [CounselingController::class, 'reports'])->name('reports');
    Route::get('/schedule', [CounselingController::class, 'schedule'])->name('schedule');
    Route::get('/profile', [CounselingController::class,'profile'])->name('profile');
    Route::get('/request', [CounselingController::class, 'request'])->name('request');
    Route::get('/my-requests', [CounselingController::class, 'myRequests'])->name('my-requests');
    Route::get('/chat', [CounselingController::class, 'chat'])->name('chat');
    Route::get('/setting', [CounselingController::class, 'setting'])->name('setting');
    Route::get('/history', [CounselingController::class, 'history'])->name('history');
});

Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
});

Route::prefix('teacher')->name('teacher.')->group(function(){
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('/request', [TeacherController::class, 'request'])->name('request');
});