<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AISessionController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        // جلب المحاضرات الخاصة بالأستاذ لتوليد الاختبارات منها
        $lectures = $teacher->courses()
                            ->with('lectures')
                            ->get()
                            ->flatMap(fn($c) => $c->lectures->each(fn($l) => $l->setRelation('course', $c)));

        return view('teacher.ai-session', compact('lectures'));
    }
}
