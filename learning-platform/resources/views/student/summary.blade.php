@extends('layouts.student')

@section('title', 'نتيجة التلخيص الذكي')

@section('page-content')
<div class="max-w-4xl mx-auto flex flex-col gap-8">

    <!-- Header -->
    <div class="flex items-center justify-between flex-row-reverse mb-4">
        <div class="text-right">
            <div class="flex items-center justify-end gap-2 mb-2 text-primary-fixed-dim">
                <span class="text-sm font-bold uppercase tracking-widest">نتيجة التحليل</span>
                <span class="material-symbols-outlined text-sm">auto_awesome</span>
            </div>
            <h1 class="text-3xl font-black text-white mb-2">{{ $lecture->title }}</h1>
            <p class="text-on-surface-variant text-sm">
                مستوى التلخيص المطبق: <span class="text-primary font-bold">{{ $levelName }}</span>
            </p>
        </div>

        <!-- زر العودة -->
        <a href="{{ route('student.ai.index') }}" class="bg-surface-container hover:bg-surface-container-highest text-on-surface border border-outline-variant/30 px-4 py-2 rounded-xl flex items-center gap-2 transition-all">
            <span class="text-sm font-bold">العودة للوحة الذكاء</span>
            <span class="material-symbols-outlined text-sm">arrow_forward</span>
        </a>
    </div>

    <!-- Summary Card -->
    <div class="relative bg-surface-container-low border border-primary/20 rounded-[2rem] p-8 md:p-12 shadow-2xl overflow-hidden">

        <!-- الزخرفة الخلفية -->
        <div class="absolute -top-32 -left-32 w-72 h-72 bg-primary/10 rounded-full blur-[80px] pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-72 h-72 bg-tertiary/10 rounded-full blur-[80px] pointer-events-none"></div>

        <!-- محتوى التلخيص -->
        <div class="relative z-10 text-right">
            <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center border border-primary/20 mb-8 ml-auto">
                <span class="material-symbols-outlined text-primary text-[28px]" style="font-variation-settings: 'FILL' 1;">summarize</span>
            </div>

            <div class="prose prose-invert prose-lg max-w-none text-on-surface leading-relaxed marker:text-primary">
                {{-- استخدام nl2br لتحويل النزول للسطر \n إلى <br> مع e() للحماية من ثغرات XSS --}}
                {!! nl2br(e($summaryText)) !!}
            </div>
        </div>

        <!-- أدوات سفلية (اختيارية للطباعة أو النسخ) -->
        <div class="relative z-10 mt-12 pt-6 border-t border-outline-variant/20 flex items-center justify-end gap-4">
            <button onclick="navigator.clipboard.writeText(`{{ $summaryText }}`); alert('تم نسخ الملخص!');" class="text-on-surface-variant hover:text-white flex items-center gap-2 text-sm transition-colors">
                <span class="font-bold">نسخ النص</span>
                <span class="material-symbols-outlined text-sm">content_copy</span>
            </button>
            <button onclick="window.print()" class="text-on-surface-variant hover:text-white flex items-center gap-2 text-sm transition-colors">
                <span class="font-bold">طباعة الملخص</span>
                <span class="material-symbols-outlined text-sm">print</span>
            </button>
        </div>
    </div>
</div>
@endsection
