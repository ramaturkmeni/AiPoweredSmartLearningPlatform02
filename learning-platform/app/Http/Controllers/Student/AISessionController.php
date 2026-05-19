<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AISessionController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        // جلب المحاضرات الخاصة بالمواد التي سجل بها الطالب لتلخيصها
        $lectures = $student->courses()
                            ->with('lectures')
                            ->get()
                            ->flatMap(fn($c) => $c->lectures);

        return view('student.ai-session', compact('lectures'));
    }
}
