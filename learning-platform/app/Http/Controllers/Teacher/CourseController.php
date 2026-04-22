<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // ── Index ────────────────────────────────────
    public function index()
    {
        $teacher = Auth::user()->teacher;

        $courses = $teacher->courses()
                           ->withCount('lectures', 'students')
                           ->latest()
                           ->paginate(10);

        return view('teacher.courses.index', compact('courses'));
    }

    // ── Create ───────────────────────────────────
    public function create()
    {
        return view('teacher.courses.create');
    }

    // ── Store ────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Auth::user()->teacher->courses()->create([
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('teacher.courses.index')
                         ->with('success', 'تم إنشاء المادة بنجاح ✓');
    }

    // ── Edit ─────────────────────────────────────
    public function edit(Course $course)
    {
        $this->authorizeTeacher($course);

        return view('teacher.courses.edit', compact('course'));
    }

    // ── Update ───────────────────────────────────
    public function update(Request $request, Course $course)
    {
        $this->authorizeTeacher($course);

        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $course->update($request->only('title', 'description'));

        return redirect()->route('teacher.courses.index')
                         ->with('success', 'تم تحديث المادة بنجاح ✓');
    }

    // ── Destroy ──────────────────────────────────
    public function destroy(Course $course)
    {
        $this->authorizeTeacher($course);

        $course->delete();

        return redirect()->route('teacher.courses.index')
                         ->with('success', 'تم حذف المادة بنجاح');
    }

    // ── Private: التحقق من ملكية الأستاذ ─────────
    private function authorizeTeacher(Course $course): void
    {
        $teacherId = Auth::user()->teacher->id;

        abort_if($course->teacher_id !== $teacherId, 403, 'غير مصرح لك.');
    }
}
