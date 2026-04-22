@extends('layouts.student')

@section('title', 'محاولات الاختبار - Smart Learn')

@section('page-content')
    <div class="mb-10 text-right">
        <h2 class="text-3xl font-extrabold text-white mb-2 font-plus-jakarta tracking-tight">محاولات الاختبار</h2>
        <p class="text-on-surface-variant text-sm">جميع اختباراتك السابقة ونتائجها.</p>
    </div>

    @forelse ($attempts as $attempt)
        <div class="bg-surface-container-low rounded-2xl p-6 mb-4 hover:bg-surface-container transition-all duration-300">
            <div class="flex flex-row-reverse justify-between items-center">
                <div class="text-right">
                    <h4 class="text-lg font-bold text-white">{{ $attempt->quiz->title }}</h4>
                    <p class="text-on-surface-variant text-sm">{{ $attempt->quiz->lecture->course->title }} - {{ $attempt->quiz->lecture->title }}</p>
                    <p class="text-on-surface-variant text-xs mt-1">{{ $attempt->taken_at?->format('Y/m/d H:i') ?? '-' }}</p>
                </div>
                <div class="flex flex-row-reverse items-center gap-4">
                    <div class="text-center">
                        <p class="text-3xl font-black {{ $attempt->score >= 60 ? 'text-success' : 'text-error' }} font-plus-jakarta">{{ $attempt->score }}%</p>
                        <p class="text-on-surface-variant text-xs">الدرجة</p>
                    </div>
                    <a href="{{ route('student.quizzes.result', $attempt->id) }}" class="bg-primary/10 text-primary px-4 py-2 rounded-xl text-sm font-bold hover:bg-primary hover:text-on-primary transition-all">
                        عرض التفاصيل
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-surface-container p-8 rounded-2xl text-center border border-dashed border-outline-variant/30">
            <span class="material-symbols-outlined text-6xl text-slate-600 mb-4">quiz</span>
            <h3 class="text-xl font-bold text-white mb-2">لا توجد محاولات بعد</h3>
            <p class="text-on-surface-variant mb-6">سجّل في مادة ثم أدّ اختباراً لترى نتائجك هنا.</p>
            <a href="{{ route('student.courses.index') }}" class="bg-primary text-on-primary-fixed px-6 py-2 rounded-xl font-bold inline-flex items-center gap-2">
                <span class="material-symbols-outlined">add</span> تصفح المواد
            </a>
        </div>
    @endforelse

    <div class="mt-6">
        {{ $attempts->links() }}
    </div>
@endsection