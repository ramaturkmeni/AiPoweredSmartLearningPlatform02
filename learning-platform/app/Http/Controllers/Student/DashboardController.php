<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        $stats = [
            'courses'   => $student->courses()->count(),
            'attempts'  => $student->quizAttempts()->where('status', 'submitted')->count(),
            'average'   => round($student->quizAttempts()->where('status', 'submitted')->avg('score') ?? 0, 1),
            'lectures'  => $student->courses()->with('lectures')->get()->flatMap(fn($c) => $c->lectures)->count(),
        ];

        $enrolledCourses = $student->courses()
                                   ->withCount('lectures')
                                   ->latest('course_enrollments.enrolled_at')
                                   ->take(4)
                                   ->get();

        return view('student.dashboard', compact('student', 'stats', 'enrolledCourses'));
    }
}
