<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\StudentQuizAttempt;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
   public function start(Quiz $quiz)
    {
        $student = Auth::user()->student;

        // 1. التحقق من حالة النشر والمادة
        if (!$quiz->isPublished()) {
            return back()->with('error', 'هذا الاختبار غير متاح حالياً.');
        }

        if (!$student->isEnrolledIn($quiz->lecture->course_id)) {
            return back()->with('error', 'يجب التسجيل في المادة أولاً.');
        }

        // ── 2. التعديل الجديد: التحقق من الحدود الزمنية للاختبار (مهم جداً) ──
        $now = now();

        // أ) التحقق مما إذا كان وقت البدء لم يحن بعد
        if ($quiz->start_time && $now->lt(\Carbon\Carbon::parse($quiz->start_time))) {
            $formattedStart = \Carbon\Carbon::parse($quiz->start_time)->format('Y/m/d H:i');
            return back()->with('error', 'هذا الاختبار لم يبدأ بعد .. سيبدأ في: ' . $formattedStart);
        }

        // ب) التحقق مما إذا كان وقت الانتهاء قد مضى وتجاوز الموعد
        if ($quiz->end_time && $now->gt(\Carbon\Carbon::parse($quiz->end_time))) {
            return back()->with('error', 'عذراً، انتهى الوقت المخصص لتقديم هذا الاختبار.');
        }

        // 3. التحقق من المحاولات السابقة والمسلمة
        $hasSubmitted = \App\Models\StudentQuizAttempt::where('student_id', $student->id)
            ->where('quiz_id', $quiz->id)
            ->where('status', 'submitted')
            ->exists();

        if ($hasSubmitted) {
            return back()->with('error', 'لقد قمت بتأدية هذا الاختبار مسبقاً ولا يمكنك إعادته.');
        }

        // 4. جلب أو إنشاء المحاولة (قيد التقدم)
        $attempt = \App\Models\StudentQuizAttempt::firstOrCreate([
            'student_id' => $student->id,
            'quiz_id'    => $quiz->id,
            'status'     => 'in_progress',
        ]);

        $quiz->load('questions.options');

        return view('student.quizzes.take', compact('quiz', 'attempt'));
    }

    public function submit(Request $request, StudentQuizAttempt $attempt)
    {
        abort_if($attempt->student_id !== Auth::user()->student->id, 403);
        abort_if($attempt->isSubmitted(), 422, 'تم تسليم هذا الاختبار مسبقاً.');

        $request->validate([
            'answers'                  => ['required', 'array'],
            'answers.*.question_id'    => ['required', 'exists:questions,id'],
            'answers.*.option_id'      => ['required', 'exists:question_options,id'],
        ]);

        DB::transaction(function () use ($request, $attempt) {
            foreach ($request->answers as $ans) {
                StudentAnswer::createAndCheck(
                    attemptId:        $attempt->id,
                    questionId:       $ans['question_id'],
                    selectedOptionId: $ans['option_id']
                );
            }

            $attempt->submit();
        });

        return redirect()->route('student.quizzes.result', $attempt->id);
    }

    public function result(StudentQuizAttempt $attempt)
    {
        abort_if($attempt->student_id !== Auth::user()->student->id, 403);

        $attempt->load('answers.question.options', 'answers.selectedOption', 'quiz');

        return view('student.quizzes.result', compact('attempt'));
    }

    public function myAttempts()
    {
        $student = Auth::user()->student;

        $attempts = $student->quizAttempts()
                            ->with('quiz.lecture.course')
                            ->where('status', 'submitted')
                            ->latest('taken_at')
                            ->paginate(10);

        return view('student.quizzes.attempts', compact('attempts'));
    }
}
