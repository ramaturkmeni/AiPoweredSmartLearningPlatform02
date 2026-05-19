@extends('layouts.teacher')

@section('page-content')
    <div class="mb-8 flex justify-between items-center flex-row-reverse">
        <div>
            <h2 class="text-2xl font-bold text-white font-plus-jakarta">نتائج الاختبار</h2>
            <p class="text-on-surface-variant text-sm mt-1">{{ $quiz->title }}</p>
        </div>
        <a href="{{ route('teacher.quizzes.review', $quiz) }}" class="text-primary text-sm font-bold flex items-center gap-1 hover:underline">
            <span class="material-symbols-outlined text-sm">arrow_back</span> العودة للمراجعة
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-surface-container-low p-6 rounded-2xl text-right">
            <div class="flex items-center gap-3 mb-3 flex-row-reverse">
                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">groups</span>
                </div>
                <p class="text-on-surface-variant text-xs font-medium">إجمالي المحاولات</p>
            </div>
            <p class="text-3xl font-black text-white font-plus-jakarta">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-surface-container-low p-6 rounded-2xl text-right">
            <div class="flex items-center gap-3 mb-3 flex-row-reverse">
                <div class="w-10 h-10 bg-success/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-success">task_alt</span>
                </div>
                <p class="text-on-surface-variant text-xs font-medium">تم التسليم</p>
            </div>
            <p class="text-3xl font-black text-white font-plus-jakarta">{{ $stats['submitted'] }}</p>
        </div>
        <div class="bg-surface-container-low p-6 rounded-2xl text-right">
            <div class="flex items-center gap-3 mb-3 flex-row-reverse">
                <div class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-secondary">percent</span>
                </div>
                <p class="text-on-surface-variant text-xs font-medium">متوسط الدرجة</p>
            </div>
            <p class="text-3xl font-black text-white font-plus-jakarta">{{ $stats['average_score'] }}%</p>
        </div>
    </div>

    <div class="bg-surface-container rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-outline-variant/20 flex items-center gap-3 flex-row-reverse">
            <span class="material-symbols-outlined text-primary">format_list_numbered</span>
            <h3 class="text-lg font-bold text-white font-plus-jakarta">سجل المحاولات</h3>
        </div>

        @forelse($attempts as $attempt)
            <div class="px-6 py-4 border-b border-outline-variant/10 flex items-center justify-between flex-row-reverse hover:bg-surface-container-high transition-colors">
                <div class="flex items-center gap-4 flex-row-reverse">
                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary font-bold">
                        {{ mb_substr($attempt->student->user->first_name ?? '؟', 0, 1) }}
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-white">{{ $attempt->student->user->first_name ?? '' }} {{ $attempt->student->user->last_name ?? '' }}</p>
                        {{-- <p class="text-xs text-on-surface-variant">{{ $attempt->created_at->format('Y/m/d H:i') }}</p> --}}
                        <p class="text-xs text-on-surface-variant">
    {{ $attempt->taken_at ? $attempt->taken_at->format('Y/m/d H:i') : 'تاريخ غير معروف' }}
</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 flex-row-reverse">
                    @if($attempt->score !== null)
                        <div class="{{ $attempt->score >= 60 ? 'bg-success/10 text-success' : 'bg-error/10 text-error' }} px-3 py-1 rounded-full text-xs font-bold">
                            {{ $attempt->score }}%
                        </div>
                    @else
                        <span class="bg-outline/10 text-on-surface-variant px-3 py-1 rounded-full text-xs font-bold">لم يُكمل</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-12 text-center">
                <span class="material-symbols-outlined text-6xl text-slate-600 mb-4">inbox</span>
                <p class="text-on-surface-variant">لا توجد محاولات بعد</p>
            </div>
        @endforelse
    </div>
@endsection
