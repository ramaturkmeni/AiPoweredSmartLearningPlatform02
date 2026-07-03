@extends('layouts.teacher')

@section('page-content')
    <div class="mb-8 flex justify-between items-center flex-row-reverse">
        <div class="text-right">
            <h2 class="text-2xl font-extrabold text-white font-plus-jakarta tracking-tight">المواد الدراسية</h2>
            <p class="text-on-surface-variant text-sm mt-1">إدارة جميع المواد الدراسية الخاصة بك</p>
        </div>
        <a href="{{ route('teacher.courses.create') }}" class="bg-primary text-on-primary-fixed px-6 py-3 rounded-xl font-bold inline-flex items-center gap-2 hover:opacity-90 transition-all">
            <span class="material-symbols-outlined">add</span>
            إضافة مادة جديدة
        </a>
    </div>

    @if($courses->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <div class="bg-surface-container rounded-2xl p-6 border border-transparent hover:border-primary/20 transition-all duration-300">
                    <div class="flex justify-between items-start flex-row-reverse mb-4">
                        <div class="text-right flex-1">
                            <h3 class="text-lg font-bold text-white mb-1">{{ $course->title }}</h3>
                            <p class="text-on-surface-variant text-sm line-clamp-2">{{ $course->description }}</p>
                        </div>
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mr-4 shrink-0">
                            <span class="material-symbols-outlined text-primary">menu_book</span>
                        </div>
                    </div>

                    <div class="flex flex-row-reverse gap-4 mb-6 py-4 border-t border-b border-outline-variant/20">
                        <div class="flex items-center gap-1 text-on-surface-variant">
                            <span class="material-symbols-outlined text-sm">play_circle</span>
                            <span class="text-xs font-medium">{{ $course->lectures_count ?? 0 }} محاضرة</span>
                        </div>
                        <div class="flex items-center gap-1 text-on-surface-variant">
                            <span class="material-symbols-outlined text-sm">groups</span>
                            <span class="text-xs font-medium">{{ $course->students_count ?? 0 }} طالب</span>
                        </div>
                    </div>

                    <div class="flex flex-row-reverse gap-3">
                        <a href="{{ route('teacher.lectures.index', $course) }}" class="flex-1 text-center bg-surface-variant text-on-surface py-2 rounded-xl text-sm font-bold hover:bg-primary hover:text-on-primary-fixed transition-all">
                            المحاضرات
                        </a>
                        <a href="{{ route('teacher.courses.edit', $course) }}" class="flex-1 text-center bg-surface-variant text-on-surface py-2 rounded-xl text-sm font-bold hover:bg-secondary hover:text-on-secondary transition-all">
                            تعديل
                        </a>
                            <form method="POST" action="{{ route('teacher.courses.destroy', $course) }}" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDeleteCourse(this)" class="w-full bg-error-container text-on-error-container py-2 rounded-xl text-sm font-bold hover:opacity-80 transition-all">
                                حذف
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $courses->links() }}
        </div>
    @else
        <div class="bg-surface-container p-12 rounded-2xl text-center border border-dashed border-outline-variant/30">
            <span class="material-symbols-outlined text-6xl text-slate-600 mb-4 block">school</span>
            <h3 class="text-xl font-bold text-white mb-2">لا توجد مواد دراسية بعد</h3>
            <p class="text-on-surface-variant mb-6">ابدأ بإنشاء مادتك الأولى الآن.</p>
            <a href="{{ route('teacher.courses.create') }}" class="bg-primary text-on-primary-fixed px-6 py-3 rounded-xl font-bold inline-flex items-center gap-2">
                <span class="material-symbols-outlined">add</span> إضافة مادة جديدة
            </a>
        </div>
    @endif

    <!-- نافذة التأكيد المنسدلة من الأعلى المخصصة لحذف المادة من قبل الأستاذ -->
<div id="confirm-delete-course-modal" class="fixed inset-0 z-[100] hidden flex items-start justify-center pt-24 bg-black/60 backdrop-blur-sm transition-all duration-300">
    <div class="bg-surface-container-high border border-outline-variant/30 p-6 rounded-2xl max-w-sm w-full mx-4 shadow-2xl text-right animate-fade-in">
        <div class="flex items-center gap-3 flex-row-reverse mb-4">
            <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">warning</span>
            <h4 class="text-white font-bold text-lg">تأكيد حذف المادة نهائياً</h4>
        </div>
        <p class="text-on-surface-variant text-sm mb-6 leading-relaxed">هل أنت متأكد من رغبتك في حذف هذه المادة الدراسية؟ <br> تنبيه: سيتم حذف جميع المحاضرات والاختبارات التابعة لهذه المادة نهائياً.</p>
        <div class="flex gap-3 justify-end flex-row-reverse">
            <button id="modal-course-delete-submit-btn" class="bg-error text-white font-black px-5 py-2.5 rounded-xl text-sm hover:opacity-90 transition-all">نعم، حذف نهائي</button>
            <button type="button" onclick="closeDeleteCourseModal()" class="bg-surface-container-low text-on-surface-variant border border-outline-variant/30 px-5 py-2.5 rounded-xl text-sm hover:bg-surface-variant transition-all">تراجع</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let activeCourseDeleteForm = null;

    function confirmDeleteCourse(button) {
        activeCourseDeleteForm = button.closest('form');
        const modal = document.getElementById('confirm-delete-course-modal');
        modal.classList.remove('hidden');
    }

    function closeDeleteCourseModal() {
        const modal = document.getElementById('confirm-delete-course-modal');
        modal.classList.add('hidden');
        activeCourseDeleteForm = null;
    }

    document.getElementById('modal-course-delete-submit-btn').addEventListener('click', function() {
        if (activeCourseDeleteForm) {
            activeCourseDeleteForm.submit();
        }
    });
</script>
@endpush
