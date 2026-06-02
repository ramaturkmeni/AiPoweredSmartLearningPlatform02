<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function summarize(Request $request, Lecture $lecture)
    {
        $student = Auth::user()->student;

        abort_if(
            !$student->isEnrolledIn($lecture->course_id),
            403, 'يجب التسجيل في المادة أولاً.'
        );

        $level = $request->input('level', 'medium');
        $pdfPath = null;

        if ($lecture->file_url && Storage::disk('public')->exists($lecture->file_url)) {
            $pdfPath = Storage::disk('public')->path($lecture->file_url);
        }

        $hasContent = $lecture->content_text || $pdfPath;
        abort_if(!$hasContent, 422, 'لا يوجد محتوى لهذه المحاضرة (لا نص ولا ملف).');

        $summaryResult = $this->ai->summarize(
            $lecture->content_text ?? '',
            $level,
            $pdfPath
        );


        $decoded = json_decode($summaryResult, true);
        if (json_last_error() === JSON_ERROR_NONE && isset($decoded['summary'])) {
            $summaryText = $decoded['summary'];
        } else {
            $summaryText = $summaryResult;
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['summary' => $summaryText]);
        }

        $levelName = match($level) {
            'brief'    => 'موجز سريع',
            'detailed' => 'مفصل وعميق',
            default    => 'متوازن',
        };

        return view('student.summary', compact('lecture', 'summaryText', 'levelName'));
    }
}
