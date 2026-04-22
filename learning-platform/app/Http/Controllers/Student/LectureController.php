<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Services\AIService;
use Illuminate\Support\Facades\Auth;

class LectureController extends Controller
{
    public function __construct(protected AIService $ai) {}

    public function show(Lecture $lecture)
    {
        $student = Auth::user()->student;

        abort_if(
            !$student->isEnrolledIn($lecture->course_id),
            403, 'يجب التسجيل في المادة أولاً.'
        );

        $courseLectures = $lecture->course->lectures;
        $quiz           = $lecture->quiz?->isPublished() ? $lecture->quiz : null;

        return view('student.lectures.show', compact('lecture', 'courseLectures', 'quiz'));
    }

    public function summarize(Lecture $lecture)
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