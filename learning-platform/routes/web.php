<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Teacher\CourseController as TeacherCourseController;
use App\Http\Controllers\Teacher\LectureController as TeacherLectureController;
use App\Http\Controllers\Teacher\QuizController as TeacherQuizController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\LectureController as StudentLectureController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;

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

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        }
        return redirect()->route('student.dashboard');
    })->name('dashboard');

    Route::prefix('teacher')->name('teacher.')->middleware('role:teacher')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('courses', TeacherCourseController::class);

        Route::get('/courses/{course}/lectures', [TeacherLectureController::class, 'index'])->name('lectures.index');
        Route::get('/lectures/create', [TeacherLectureController::class, 'create'])->name('lectures.create');
        Route::post('/lectures', [TeacherLectureController::class, 'store'])->name('lectures.store');
        Route::get('/lectures/{lecture}/edit', [TeacherLectureController::class, 'edit'])->name('lectures.edit');
        Route::put('/lectures/{lecture}', [TeacherLectureController::class, 'update'])->name('lectures.update');
        Route::delete('/lectures/{lecture}', [TeacherLectureController::class, 'destroy'])->name('lectures.destroy');

        Route::get('/quizzes/generate/{lecture}', [TeacherQuizController::class, 'generate'])->name('quizzes.generate');
        Route::get('/quizzes/{quiz}/review', [TeacherQuizController::class, 'review'])->name('quizzes.review');
        Route::put('/quizzes/{quiz}', [TeacherQuizController::class, 'update'])->name('quizzes.update');
        Route::post('/quizzes/{quiz}/publish', [TeacherQuizController::class, 'publish'])->name('quizzes.publish');
        Route::delete('/quizzes/{quiz}', [TeacherQuizController::class, 'destroy'])->name('quizzes.destroy');
        Route::post('/quizzes/{quiz}/questions', [TeacherQuizController::class, 'addQuestion'])->name('quizzes.addQuestion');
        Route::delete('/questions/{question}', [TeacherQuizController::class, 'deleteQuestion'])->name('quizzes.deleteQuestion');
        Route::get('/quizzes/{quiz}/results', [TeacherQuizController::class, 'results'])->name('quizzes.results');
    });

    Route::prefix('student')->name('student.')->middleware('role:student')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/courses', [StudentCourseController::class, 'index'])->name('courses.index');
        Route::post('/courses/{course}/enroll', [StudentCourseController::class, 'enroll'])->name('courses.enroll');
        Route::post('/courses/{course}/drop', [StudentCourseController::class, 'drop'])->name('courses.drop');
        Route::get('/courses/{course}', [StudentCourseController::class, 'show'])->name('courses.show');
        Route::get('/lectures/{lecture}', [StudentLectureController::class, 'show'])->name('lectures.show');
        Route::post('/lectures/{lecture}/summarize', [StudentLectureController::class, 'summarize'])->name('lectures.summarize');
        Route::get('/quizzes/{quiz}/take', [StudentQuizController::class, 'start'])->name('quizzes.take');
        Route::post('/quizzes/{attempt}/submit', [StudentQuizController::class, 'submit'])->name('quizzes.submit');
        Route::get('/quizzes/{attempt}/result', [StudentQuizController::class, 'result'])->name('quizzes.result');
        Route::get('/quizzes/attempts', [StudentQuizController::class, 'myAttempts'])->name('quizzes.attempts');
    });
});