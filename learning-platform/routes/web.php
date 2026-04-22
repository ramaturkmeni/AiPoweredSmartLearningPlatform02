<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
// قمنا بإزالة استدعاء DashboardController من هنا لمنع التضارب

// ========== صفحات عامة ==========
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('home');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// ========== صفحات محمية (تتطلب تسجيل دخول) ==========
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // 1. مسار التوجيه الذكي (Traffic Cop)
    // عندما يطلب النظام الذهاب إلى dashboard، هذا المسار سيفحص نوع المستخدم ويوجهه للوحة الصحيحة
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        }
        return redirect()->route('student.dashboard');
    })->name('dashboard');

    // ==========================================
    // 2. مسارات الأستاذ (Teacher Routes)
    // ==========================================
    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');

        // يمكنك إضافة مسارات المواد والاختبارات الخاصة بالأستاذ هنا لاحقاً
    });

    // ==========================================
    // 3. مسارات الطالب (Student Routes)
    // ==========================================
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');

        // يمكنك إضافة مسارات التلخيص والمهام الخاصة بالطالب هنا لاحقاً
    });

});
