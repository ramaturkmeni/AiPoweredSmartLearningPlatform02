@extends('layouts.student')

@section('title', '{{ $course->title }} - Smart Learn')

@section('page-content')
    <div class="mb-10 text-right">
        <div class="flex items-center gap-2 text-on-surface-variant text-sm mb-4">
            <a href="{{ route('student.courses.index') }}" class="hover:text-primary transition-colors">المواد الدراسية</a>
            <span class="material-symbols-outlined text-xs">chevron_left</span>
            <span class="text-on-surface">{{ $course->title }}</span>
        </div>

        <div class="bg-surface-container rounded-2xl p-8 mb-8 border border-outline-variant/10">
            <div class="flex flex-row-reverse items-start gap-6">
                <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-primary text-3xl" style="font-variation-settings: 'FILL' 1;">book_5</span>
                </div>
                <div class="flex-1 text-right">
                    <h2 class="text-2xl font-extrabold text-white mb-2 font-plus-jakarta">{{ $course->title }}</h2>
                    <p class="text-on-surface-variant text-sm leading-relaxed">{{ $course->description }}</p>
                    <div class="flex flex-row-reverse gap-6 mt-4">
                        <div class="flex items-center gap-1 text-on-surface-variant">
                            <span class="material-symbols-outlined text-sm">play_circle</span>
                            <span class="text-xs font-medium">{{ $course->lectures_count ?? $lectures->total() }} محاضرة</span>
                        </div>
                        <div class="flex items-center gap-1 text-on-surface-variant">
                            <span class="material-symbols-outlined text-sm">person</span>
                            <span class="text-xs font-medium">{{ $course->teacher->first_name ?? '' }} {{ $course->teacher->last_name ?? '' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-6 flex justify-between items-center flex-row-reverse">
        <h3 class="text-xl font-bold text-white font-plus-jakarta">المحاضرات</h3>
    </div>

    <div class="space-y-4">
        @forelse ($lectures as $lecture)
            <a href="{{ route('student.lectures.show', $lecture->id) }}" class="block bg-surface-container-low rounded-2xl p-6 border border-transparent hover:border-indigo-500/20 transition-all duration-300 group">
                <div class="flex flex-row-reverse items-center justify-between">
                    <div class="flex flex-row-reverse items-center gap-4">
                        <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center group-hover:bg-secondary/20 transition-colors">
                            <span class="material-symbols-outlined text-secondary">movie</span>
                        </div>
                        <div class="text-right">
                            <h4 class="text-base font-bold text-white group-hover:text-primary transition-colors">{{ $lecture->title }}</h4>
                            <p class="text-on-surface-variant text-xs mt-1">{{ $lecture->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        @if ($lecture->quiz && $lecture->quiz->isPublished())
                            <span class="bg-tertiary/10 text-tertiary-fixed-dim text-[10px] font-bold px-3 py-1 rounded-full flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">quiz</span>
                                اختبار متاح
                            </span>
                        @endif
                        <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors">arrow_back</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="bg-surface-container p-8 rounded-2xl text-center border border-dashed border-outline-variant/30">
                <span class="material-symbols-outlined text-6xl text-slate-600 mb-4">video_library</span>
                <h3 class="text-xl font-bold text-white mb-2">لا توجد محاضرات بعد</h3>
                <p class="text-on-surface-variant">لم يتم إضافة محاضرات لهذه المادة بعد.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $lectures->withQueryString()->links() }}
    </div>
@endsection