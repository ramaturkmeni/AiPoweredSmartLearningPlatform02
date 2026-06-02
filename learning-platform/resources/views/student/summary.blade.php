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

            <div id="summary-content" class="md-content text-on-surface leading-relaxed"></div>
        </div>

        <!-- أدوات سفلية -->
        <div class="relative z-10 mt-12 pt-6 border-t border-outline-variant/20 flex items-center justify-end gap-4">
            <button id="copy-btn" class="text-on-surface-variant hover:text-white flex items-center gap-2 text-sm transition-colors">
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

@push('styles')
<style>
    .md-content { direction: rtl; text-align: right; }
    .md-content h1, .md-content h2, .md-content h3, .md-content h4 { color: #e2e2e5; font-weight: 800; margin-top: 1.5em; margin-bottom: 0.5em; }
    .md-content h1 { font-size: 1.5rem; }
    .md-content h2 { font-size: 1.25rem; border-bottom: 1px solid rgba(68,70,84,0.4); padding-bottom: 0.4em; }
    .md-content h3 { font-size: 1.1rem; color: #b9c3ff; }
    .md-content p { margin-bottom: 0.8em; color: #c4c5d7; line-height: 1.9; }
    .md-content ul, .md-content ol { margin-bottom: 1em; padding-right: 1.5em; color: #c4c5d7; }
    .md-content li { margin-bottom: 0.4em; line-height: 1.8; }
    .md-content li::marker { color: #b9c3ff; }
    .md-content strong { color: #e2e2e5; font-weight: 700; }
    .md-content em { color: #f9abff; font-style: italic; }
    .md-content code { background: rgba(185,195,255,0.1); color: #b9c3ff; padding: 0.15em 0.4em; border-radius: 0.375rem; font-size: 0.875em; }
    .md-content pre { background: #0c0e10; border: 1px solid rgba(68,70,84,0.4); border-radius: 0.75rem; padding: 1em; margin-bottom: 1em; overflow-x: auto; direction: ltr; text-align: left; }
    .md-content pre code { background: none; padding: 0; color: #c4c5d7; }
    .md-content blockquote { border-right: 4px solid #6e88ff; padding-right: 1em; margin-right: 0; margin-bottom: 1em; color: #8e90a0; }
    .md-content table { width: 100%; border-collapse: collapse; margin-bottom: 1em; }
    .md-content th, .md-content td { border: 1px solid rgba(68,70,84,0.4); padding: 0.5em 0.75em; text-align: right; }
    .md-content th { background: rgba(185,195,255,0.05); color: #e2e2e5; font-weight: 700; }
    .md-content hr { border-color: rgba(68,70,84,0.4); margin: 1.5em 0; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    const raw = @json($summaryText);
    document.getElementById('summary-content').innerHTML = marked.parse(raw);
    document.getElementById('copy-btn').addEventListener('click', function() {
        navigator.clipboard.writeText(raw).then(() => alert('تم نسخ الملخص!'));
    });
</script>
@endpush
