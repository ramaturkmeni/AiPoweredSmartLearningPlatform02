<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\courses;
use App\Models\lectures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LectureController extends Controller
{
    // ── Index ────────────────────────────────────
    public function index(courses $course)
    {
        $this->authorizeTeacher($course);

        $lectures = $course->lectures()->paginate(10);

        return view('teacher.lectures.index', compact('course', 'lectures'));
    }

    // ── Create ───────────────────────────────────
    public function create()
    {
        $courses = Auth::user()->teacher->courses()->get();

        return view('teacher.lectures.create', compact('courses'));
    }

    // ── Store ────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'course_id'    => ['required', 'exists:courses,id'],
            'title'        => ['required', 'string', 'max:255'],
            'content_text' => ['nullable', 'string'],
            'file'         => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:20480'],
            'video_url'    => ['nullable', 'url'],
            'image'        => ['nullable', 'image', 'max:2048'],
            'order_index'  => ['nullable', 'integer', 'min:0'],
        ]);

        $data = [
            'course_id'    => $request->course_id,
            'title'        => $request->title,
            'content_text' => $request->content_text,
            'video_url'    => $request->video_url,
            'order_index'  => $request->order_index ?? 0,
        ];

        // رفع ملف المحاضرة
        if ($request->hasFile('file')) {
            $data['file_url'] = $request->file('file')->store('lectures/files', 'public');
        }

        // رفع صورة الغلاف
        if ($request->hasFile('image')) {
            $data['img_url'] = $request->file('image')->store('lectures/images', 'public');
        }

        $lecture = lectures::create($data);

        // إذا طلب الأستاذ توليد اختبار مباشرة
        if ($request->boolean('generate_quiz')) {
            return redirect()->route('teacher.quizzes.generate', $lecture->id);
        }

        return redirect()->route('teacher.lectures.index', $request->course_id)
                         ->with('success', 'تم رفع المحاضرة بنجاح ✓');
    }

    // ── Edit ─────────────────────────────────────
    public function edit(lectures $lecture)
    {
        $this->authorizeTeacher($lecture->course);
        $courses = Auth::user()->teacher->courses()->get();

        return view('teacher.lectures.edit', compact('lecture', 'courses'));
    }

    // ── Update ───────────────────────────────────
    public function update(Request $request, lectures $lecture)
    {
        $this->authorizeTeacher($lecture->course);

        $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'content_text' => ['nullable', 'string'],
            'file'         => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:20480'],
            'video_url'    => ['nullable', 'url'],
            'order_index'  => ['nullable', 'integer', 'min:0'],
        ]);

        $data = $request->only('title', 'content_text', 'video_url', 'order_index');

        if ($request->hasFile('file')) {
            // حذف الملف القديم
            if ($lecture->file_url) {
                Storage::disk('public')->delete($lecture->file_url);
            }
            $data['file_url'] = $request->file('file')->store('lectures/files', 'public');
        }

        $lecture->update($data);

        return redirect()->route('teacher.lectures.index', $lecture->course_id)
                         ->with('success', 'تم تحديث المحاضرة بنجاح ✓');
    }

    // ── Destroy ──────────────────────────────────
    public function destroy(lectures $lecture)
    {
        $this->authorizeTeacher($lecture->course);

        if ($lecture->file_url) {
            Storage::disk('public')->delete($lecture->file_url);
        }$lecture->delete();

        return back()->with('success', 'تم حذف المحاضرة بنجاح');
    }

    // ── Private ──────────────────────────────────
    private function authorizeTeacher(courses $course): void
    {
        abort_if(
            $course->teacher_id !== Auth::user()->teacher->id,
            403, 'غير مصرح لك.'
        );
    }
}
