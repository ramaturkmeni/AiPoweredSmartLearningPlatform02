@extends('layouts.teacher')

@section('page-content')
    <div class="mb-8 text-right">
        <h2 class="text-2xl font-bold text-white font-plus-jakarta">إدارة الاختبارات والنتائج</h2>
        <p class="text-on-surface-variant text-sm mt-1">هنا تجد جميع الاختبارات التي قمت بإنشائها وإحصائيات الطلاب.</p>
    </div>

    <div class="grid grid-cols-1 gap-4">
        @forelse($quizzes as $quiz)
            <div class="bg-surface-container-low p-6 rounded-2xl border border-outline-variant/10 flex flex-row-reverse justify-between items-center hover:bg-surface-container transition-all">
                <div class="text-right">
                    <h3 class="text-lg font-bold text-white">{{ $quiz->title }}</h3>
                    <p class="text-on-surface-variant text-xs">{{ $quiz->lecture->course->title }} - {{ $quiz->lecture->title }}</p>
                </div>

                <div class="flex flex-row-reverse items-center gap-6">
                    <div class="text-center px-4 border-l border-outline-variant/20">
                        <p class="text-xl font-black text-primary font-plus-jakarta">{{ $quiz->attempts_count }}</p>
                        <p class="text-[10px] text-on-surface-variant">عدد المشاركين</p>
                    </div>

                    <a href="{{ route('teacher.quizzes.results', $quiz) }}" class="bg-primary/10 text-primary px-6 py-2 rounded-xl text-sm font-bold hover:bg-primary hover:text-on-primary-fixed transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">analytics</span>
                        عرض النتائج
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-surface-container p-12 rounded-2xl text-center border border-dashed border-outline-variant/30">
                <span class="material-symbols-outlined text-5xl text-slate-600 mb-4">quiz</span>
                <p class="text-on-surface-variant">لا توجد اختبارات منشورة حالياً.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $quizzes->links() }}
    </div>
@endsection
