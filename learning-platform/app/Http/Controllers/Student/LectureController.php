<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Services\AIService;
use Illuminate\Http\Request; // تم إضافة استدعاء Request هنا
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

    // تم إضافة Request $request لتلقي بيانات مستوى التلخيص
    public function summarize(Request $request, Lecture $lecture)
    {
        $student = Auth::user()->student;

        // التحقق من صلاحيات الطالب
        abort_if(
            !$student->isEnrolledIn($lecture->course_id),
            403, 'يجب التسجيل في المادة أولاً.'
        );

        // التحقق من وجود نص للمحاضرة
        abort_if(!$lecture->content_text, 422, 'لا يوجد نص لهذه المحاضرة.');

        // 1. استقبال مستوى التلخيص من الفورم (الافتراضي: medium)
        $level = $request->input('level', 'medium');

        // 2. إرسال النص ومستوى التلخيص للذكاء الاصطناعي
        $summaryResult = $this->ai->summarize($lecture->content_text, $level);

        // 3. التحقق مما إذا كان~ الذكاء الاصطناعي قد أرجع النتيجة على شكل JSON (كما حدث سابقاً)
        $decoded = json_decode($summaryResult, true);
        if (json_last_error() === JSON_ERROR_NONE && isset($decoded['summary'])) {
            $summaryText = $decoded['summary'];
        } else {
            // إذا كان النص عادياً وليس JSON
            $summaryText = $summaryResult;
        }

        // 4. تحويل مستوى التلخيص لاسم عربي لعرضه في الواجهة بوضوح
        $levelName = match($level) {
            'brief'    => 'موجز سريع',
            'detailed' => 'مفصل وعميق',
            default    => 'متوازن',
        };

        // 5. توجيه الطالب إلى صفحة العرض الخاصة بالملخص
        return view('student.summary', compact('lecture', 'summaryText', 'levelName'));
    }
}




