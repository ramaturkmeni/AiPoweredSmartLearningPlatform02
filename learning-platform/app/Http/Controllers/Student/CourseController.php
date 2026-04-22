<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // ── All Available Courses ────────────────────
    public function index(Request $request)
    {
        $student = Auth::user()->student;

        $courses = Course::with('teacher')
                         ->withCount('lectures', 'students')
                         ->when($request->search, fn($q) =>
                             $q->where('title', 'like', "%{$request->search}%")
                         )
                         ->paginate(12);

        $enrolledIds = $student->enrollments()->pluck('course_id')->toArray();

        return view('student.courses.index', compact('courses', 'enrolledIds'));
    }

    // ── Enroll in Course ─────────────────────────
    public function enroll(Course $course)
    {
        $student = Auth::user()->student;

        abort_if($student->isEnrolledIn($course->id), 422, 'أنت مسجّل في هذه المادة بالفعل.');

        CourseEnrollment::create([
            'student_id' => $student->id,
            'course_id'  => $course->id,
            'status'     => 'active',
        ]);

        return back()->with('success', "تم تسجيلك في مادة {$course->title} بنجاح ✓");
    }

    // ── Drop Course ──────────────────────────────
    public function drop(Course $course)
    {
        $student = Auth::user()->student;

        $enrollment = CourseEnrollment::where('student_id', $student->id)
                                      ->where('course_id', $course->id)
                                      ->firstOrFail();

        $enrollment->update(['status' => 'dropped']);

        return back()->with('success', 'تم إلغاء تسجيلك من المادة.');
    }

    // ── Show Course Lectures ─────────────────────
    public function show(Course $course)
    {
        $student = Auth::user()->student;

        abort_if(!$student->isEnrolledIn($course->id), 403, 'يجب التسجيل في المادة أولاً.');

        $lectures = $course->lectures()->paginate(10);

        return view('student.courses.show', compact('course', 'lectures'));
    }
}
