<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\quizzes;
use App\Models\student_quiz_attempts;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    // ── Start Quiz ───────────────────────────────
    public function start(quizzes $quiz)
    {
        $student = Auth::user()->student;

        abort_if(!$quiz->isPublished(), 403, 'هذا الاختبار غير متاح.');
        abort_if(
            !$student->isEnrolledIn($quiz->lecture->course_id),
            403, 'يجب التسجيل في المادة أولاً.'
        );

        // إنشاء محاولة جديدة
        $attempt = student_quiz_attempts::create([
            'student_id' => $student->id,
            'quiz_id'    => $quiz->id,
            'status'     => 'in_progress',
        ]);

        $quiz->load('questions.options');

        return view('student.quizzes.take', compact('quiz', 'attempt'));
    }

    // ── Submit Quiz ──────────────────────────────
    public function submit(Request $request, student_quiz_attempts $attempt)
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
                student_quiz_attempts::createAndCheck(
                    attemptId:        $attempt->id,
                    questionId:       $ans['question_id'],
                    selectedOptionId: $ans['option_id']
                );
            }

            // حساب الدرجة وتغيير الحالة
            $attempt->submit();
        });

        return redirect()->route('student.quizzes.result', $attempt->id);
    }

    // ── View Result ──────────────────────────────
    public function result(student_quiz_attempts $attempt)
    {
        abort_if($attempt->student_id !== Auth::user()->student->id, 403);

        $attempt->load('answers.question.options', 'answers.selectedOption', 'quiz');

        return view('student.quizzes.result', compact('attempt'));
    }

    // ── My Attempts ──────────────────────────────
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
