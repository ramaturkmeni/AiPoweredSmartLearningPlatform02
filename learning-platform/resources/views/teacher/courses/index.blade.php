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
                            <button type="submit" class="w-full bg-error-container text-on-error-container py-2 rounded-xl text-sm font-bold hover:opacity-80 transition-all" onclick="return confirm('هل أنت متأكد من حذف هذه المادة؟')">
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
@endsection