<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;

        $stats = [
            'courses'   => $teacher->courses()->count(),
            'lectures'  => $teacher->courses()->withCount('lectures')->get()->sum('lectures_count'),
            'quizzes'   => $teacher->courses()
                                   ->with('lectures.quiz')
                                   ->get()
                                   ->flatMap(fn($c) => $c->lectures)
                                   ->filter(fn($l) => $l->quiz)
                                   ->count(),
            'students'  => $teacher->courses()
                                   ->withCount('students')
                                   ->get()
                                   ->sum('students_count'),
        ];

        $recentCourses = $teacher->courses()
                                 ->withCount('lectures', 'students')
                                 ->latest()
                                 ->take(4)
                                 ->get();

        return view('teacher.dashboard', compact('teacher', 'stats', 'recentCourses'));
    }
}
