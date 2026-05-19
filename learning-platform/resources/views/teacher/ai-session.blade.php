@extends('layouts.teacher')

@section('title', 'جلسة الذكاء الاصطناعي - الأستاذ')

@section('page-content')
<div class="flex flex-col gap-12 max-w-5xl mx-auto">
    <!-- Header Section -->
    <header class="flex flex-col gap-4 text-right">
        <div class="flex items-center justify-end gap-3 mb-2">
            <span class="bg-tertiary-container/20 text-tertiary-fixed-dim px-3 py-1 rounded-full text-[12px] font-bold uppercase tracking-widest flex items-center gap-2 border border-tertiary-container/30">
                <span class="material-symbols-outlined text-[14px]">psychology</span>
                الذكاء الاصطناعي النشط
            </span>
        </div>
        <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-l from-primary to-primary-container leading-tight">
            بدء جلسة الذكاء الاصطناعي
        </h1>
        <p class="text-base text-on-surface-variant font-medium leading-[1.6] max-w-2xl mr-auto">
            قم بتوليد اختبارات ذكية تلقائياً من نصوص المحاضرات، يمكنك التعديل على الأسئلة لاحقاً ونشرها للطلاب بنقرة زر.
        </p>
    </header>

    <!-- Generator Section -->
    <section class="grid grid-cols-1 gap-6">
        <div class="group relative flex flex-col text-right bg-surface-container-low rounded-[1.5rem] p-8 overflow-hidden border border-outline-variant/10">
            <div class="absolute -top-24 -left-24 w-48 h-48 bg-tertiary/20 rounded-full blur-[60px]"></div>

            <div class="flex justify-between items-start mb-8 relative z-10 flex-row-reverse">
                <div class="w-14 h-14 rounded-2xl bg-surface-container-highest flex items-center justify-center border border-outline-variant/20 shadow-lg">
                    <span class="material-symbols-outlined text-tertiary-fixed-dim text-[28px]" style="font-variation-settings: 'FILL' 1;">quiz</span>
                </div>
            </div>

            <div class="relative z-10 mb-8">
                <h3 class="text-2xl font-bold text-on-surface mb-3">توليد اختبار تلقائي</h3>
                <p class="text-sm text-on-surface-variant leading-[1.6]">
                    سيقوم الذكاء الاصطناعي بتحليل نص المحاضرة وتحويلها إلى أسئلة اختيار من متعدد، وصح/خطأ بدقة عالية.
                </p>
            </div>

            <!-- Form for Quiz Generation -->
            <div class="relative z-10 bg-surface-container p-6 rounded-xl border border-outline-variant/20">
                <label class="block text-sm font-bold text-on-surface mb-3 text-right">اختر المحاضرة المستهدفة:</label>
                <div class="flex gap-4">
                    <button onclick="generateQuiz()" class="bg-tertiary text-on-tertiary px-6 py-3 rounded-xl font-bold hover:opacity-90 transition-opacity flex items-center gap-2 w-48 justify-center">
                        <span class="material-symbols-outlined text-sm">magic_button</span> توليد الآن
                    </button>
                    <select id="lecture_id" class="flex-1 bg-background border border-outline-variant/30 rounded-xl px-4 py-3 text-right text-on-surface focus:ring-tertiary focus:border-tertiary" dir="rtl">
                        <option value="" disabled selected>-- اختر المحاضرة --</option>
                        @foreach($lectures as $lecture)
                            <option value="{{ $lecture->id }}">{{ $lecture->title }} ({{ $lecture->course->title }})</option>
                        @endforeach
                    </select>
                </div>
                <p id="error-msg" class="text-error text-xs mt-2 hidden text-right">يرجى اختيار محاضرة أولاً.</p>
            </div>
        </div>
    </section>
</div>

<script>
    function generateQuiz() {
        const lectureId = document.getElementById('lecture_id').value;
        if(!lectureId) {
            document.getElementById('error-msg').classList.remove('hidden');
            return;
        }
        // التوجيه إلى مسار توليد الاختبار للأستاذ
        window.location.href = `/teacher/quizzes/generate/${lectureId}`;
    }
</script>
@endsection
