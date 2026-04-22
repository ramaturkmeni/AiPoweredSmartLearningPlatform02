<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\lectures;
use App\Services\AIService;
use Illuminate\Support\Facades\Auth;

class LectureController extends Controller
{
    public function __construct(protected AIService $ai) {}

    // ── View Lecture ─────────────────────────────
    public function show(lectures $lecture)
    {
        $student = Auth::user()->student;

        abort_if(
            !$student->isEnrolledIn($lecture->course_id),
            403, 'يجب التسجيل في المادة أولاً.'
        );

        $courseLectures = $lecture->course->lectures;
        $quiz           = $lecture->quiz?->where('status', 'published')->first();

        return view('student.lectures.show', compact('lecture', 'courseLectures', 'quiz'));
    }

    // ── AI Summarize ─────────────────────────────
    public function summarize(lectures $lecture)
    {
        $student = Auth::user()->student;

        abort_if(
            !$student->isEnrolledIn($lecture->course_id),
            403
        );

        abort_if(!$lecture->content_text, 422, 'لا يوجد نص لهذه المحاضرة.');

        $summary = $this->ai->summarize($lecture->content_text);

        return response()->json(['summary' => $summary]);
    }
}
