<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\lectures;
use App\Models\quizzes;
use App\Models\questions;
use App\Models\question_Options;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function __construct(protected AIService $ai) {}

    // ── Generate Quiz via AI ─────────────────────
    public function generate(lectures $lecture)
    {
        $this->authorizeTeacher($lecture);

        abort_if(!$lecture->content_text, 422, 'المحاضرة لا تحتوي على نص للتحليل.');
        abort_if($lecture->hasQuiz(), 422, 'هذه المحاضرة لديها اختبار بالفعل.');

        // استدعاء الذكاء الاصطناعي
        $generated = $this->ai->generateQuiz($lecture->content_text);

        DB::transaction(function () use ($lecture, $generated) {
            // إنشاء الاختبار
            $quiz = quizzes::create([
                'lecture_id'     => $lecture->id,
                'title'          => 'اختبار: ' . $lecture->title,
                'is_ai_generated' => true,
                'status'         => 'draft',
            ]);

            // حفظ الأسئلة والخيارات
            foreach ($generated['questions'] as $q) {
                $question = questions::create([
                    'quiz_id'       => $quiz->id,
                    'question_text' => $q['question'],
                ]);

                foreach ($q['options'] as $opt) {
                    question_Options::create([
                        'question_id' => $question->id,
                        'option_text' => $opt['text'],
                        'is_correct'  => $opt['is_correct'],
                    ]);
                }
            }
        });

        return redirect()->route('teacher.quizzes.review', $lecture->quiz->id)
                         ->with('success', 'تم توليد الاختبار بنجاح 🤖');
    }

    // ── Review Quiz (Draft) ──────────────────────
    public function review(quizzes $quiz)
    {
        $this->authorizeQuiz($quiz);

        $quiz->load('questions.options');

        return view('teacher.quizzes.review', compact('quiz'));
    }

    // ── Update Quiz Settings ─────────────────────
    public function update(Request $request, quizzes $quiz)
    {
        $this->authorizeQuiz($quiz);

        $request->validate([
            'title'      => ['required', 'string', 'max:255'],
            'duration'   => ['nullable', 'integer', 'min:1'],
            'start_time' => ['nullable', 'date'],
            'end_time'   => ['nullable', 'date', 'after:start_time'],
        ]);

        $quiz->update($request->only('title', 'duration', 'start_time', 'end_time'));

        return back()->with('success', 'تم تحديث إعدادات الاختبار ✓');
    }

    // ── Publish Quiz ─────────────────────────────
    public function publish(quizzes$quiz)
    {
        $this->authorizeQuiz($quiz);

        abort_if($quiz->questions()->count() === 0, 422, 'لا يمكن نشر اختبار بدون أسئلة.');

        $quiz->publish();

        return back()->with('success', 'تم نشر الاختبار بنجاح 🚀');
    }

    // ── Destroy Quiz ─────────────────────────────
    public function destroy(quizzes $quiz)
    {
        $this->authorizeQuiz($quiz);

        $quiz->delete();

        return redirect()->route('teacher.dashboard')
                         ->with('success', 'تم حذف الاختبار');
    }

    // ── Add Question ─────────────────────────────
    public function addQuestion(Request $request, quizzes $quiz)
    {
        $this->authorizeQuiz($quiz);

        $request->validate([
            'question_text'        => ['required', 'string'],
            'options'              => ['required', 'array', 'min:2'],
            'options.*.text'       => ['required', 'string'],
            'options.*.is_correct' => ['required', 'boolean'],
        ]);

        DB::transaction(function () use ($request, $quiz) {
            $question = questions::create([
                'quiz_id'       => $quiz->id,
                'question_text' => $request->question_text,]);

            foreach ($request->options as $opt) {
                question_Options::create([
                    'question_id' => $question->id,
                    'option_text' => $opt['text'],
                    'is_correct'  => $opt['is_correct'],
                ]);
            }
        });

        return back()->with('success', 'تم إضافة السؤال ✓');
    }

    // ── Delete Question ──────────────────────────
    public function deleteQuestion(questions $question)
    {
        $this->authorizeQuiz($question->quiz);

        $question->delete();

        return back()->with('success', 'تم حذف السؤال');
    }

    // ── View Results ─────────────────────────────
    public function results(quizzes$quiz)
    {
        $this->authorizeQuiz($quiz);

        $attempts = $quiz->attempts()
                         ->with('student')
                         ->where('status', 'submitted')
                         ->orderByDesc('score')
                         ->paginate(20);

        $stats = [
            'total'    => $quiz->attempts()->count(),
            'submitted'=> $quiz->attempts()->where('status', 'submitted')->count(),
            'average'  => $quiz->average_score,
        ];

        return view('teacher.quizzes.results', compact('quiz', 'attempts', 'stats'));
    }

    // ── Private ──────────────────────────────────
    private function authorizeTeacher(lectures $lecture): void
    {
        abort_if(
            $lecture->course->teacher_id !== Auth::user()->teacher->id,
            403
        );
    }

    private function authorizeQuiz(quizzes $quiz): void
    {
        $this->authorizeTeacher($quiz->lecture);
    }
}
