@extends('layouts.student')

@section('title', 'جلسة الذكاء الاصطناعي - الطالب')

@section('page-content')
<div class="flex flex-col gap-12 max-w-5xl mx-auto">
    <!-- Header Section -->
    <header class="flex flex-col gap-4 text-right relative z-10">
        <div class="flex items-center justify-end gap-3 mb-2">
            <span class="bg-primary-container/20 text-primary-fixed-dim px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest flex items-center gap-2 border border-primary-container/30 shadow-[0_0_15px_rgba(110,136,255,0.2)]">
                <span class="material-symbols-outlined text-[16px] animate-pulse">psychology</span>
                محرك DeepSeek-V4 النشط
            </span>
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-l from-primary to-primary-container leading-tight">
            المساعد الأكاديمي الذكي
        </h1>
        <p class="text-lg text-on-surface-variant font-medium leading-[1.8] max-w-2xl mr-auto">
            ارتقِ بتجربتك الدراسية. حدد المحاضرة ودع الذكاء الاصطناعي يستخرج لك الخلاصة المركزة بأي مستوى من التفصيل تحتاجه.
        </p>
    </header>

    <!-- Summarization Control Panel Section -->
    <section class="grid grid-cols-1 gap-8 relative z-10">
        <div class="group relative flex flex-col text-right bg-surface-container-low/80 backdrop-blur-xl rounded-[2rem] p-8 md:p-10 border border-outline-variant/20 shadow-2xl overflow-visible">

            <!-- Ambient Glow -->
            <div class="absolute -top-32 -left-32 w-72 h-72 bg-primary/20 rounded-full blur-[80px] pointer-events-none transition-all duration-700 group-hover:bg-primary/30"></div>
            <div class="absolute -bottom-32 -right-32 w-72 h-72 bg-tertiary/10 rounded-full blur-[80px] pointer-events-none transition-all duration-700 group-hover:bg-tertiary/20"></div>

            <div class="flex justify-between items-start mb-10 relative z-10 flex-row-reverse">
                <div class="w-16 h-16 rounded-2xl bg-surface-container flex items-center justify-center border border-primary/20 shadow-[0_0_30px_rgba(185,195,255,0.1)] group-hover:scale-110 transition-transform duration-500">
                    <span class="material-symbols-outlined text-primary text-[32px]" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                </div>
                <div class="text-right flex-1 mr-6">
                    <h3 class="text-2xl font-bold text-white mb-2">إعدادات التلخيص التلقائي</h3>
                    <p class="text-sm text-on-surface-variant leading-[1.6]">
                        اختر المحاضرة وحدد عمق التلخيص المطلوب ليقوم النظام بتوليد ملاحظات مخصصة لك.
                    </p>
                </div>
            </div>

            <!-- Form for Summarization -->
            <form id="summarize-form" method="POST" action="" class="relative z-10 flex flex-col gap-8">
                @csrf

                <!-- إختيار المحاضرة -->
                <div class="bg-surface-container/50 p-6 rounded-2xl border border-outline-variant/10">
                    <label class="block text-sm font-bold text-primary-fixed-dim mb-4 text-right flex items-center gap-2 flex-row-reverse">
                        <span class="material-symbols-outlined text-sm">library_books</span> المحاضرة المستهدفة
                    </label>
                    <div class="relative">
                        <select onchange="updateFormAction(this.value)" class="w-full bg-surface border border-outline-variant/30 rounded-xl px-5 py-4 text-right text-white focus:ring-2 focus:ring-primary focus:border-primary appearance-none transition-all cursor-pointer" dir="rtl">
                            <option value="" disabled selected>-- انقر لاختيار المحاضرة --</option>
                            @forelse($lectures as $lecture)
                                <option value="{{ $lecture->id }}">{{ $lecture->title }} (مادة: {{ $lecture->course->title ?? 'غير محدد' }})</option>
                            @empty
                                <option value="" disabled>لا توجد محاضرات متاحة حالياً</option>
                            @endforelse
                        </select>
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                    </div>
                </div>

                <!-- مستوى التلخيص -->
                <div class="bg-surface-container/50 p-6 rounded-2xl border border-outline-variant/10">
                    <label class="block text-sm font-bold text-primary-fixed-dim mb-4 text-right flex items-center gap-2 flex-row-reverse">
                        <span class="material-symbols-outlined text-sm">tune</span> مستوى وعمق التلخيص
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4" dir="rtl">
                        <!-- موجز -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="level" value="brief" class="peer sr-only">
                            <div class="p-4 rounded-xl border border-outline-variant/30 bg-surface text-center hover:bg-surface-bright peer-checked:border-primary peer-checked:bg-primary/10 transition-all">
                                <span class="material-symbols-outlined text-on-surface-variant peer-checked:text-primary block mb-2 text-3xl">short_text</span>
                                <h4 class="font-bold text-white mb-1">موجز سريع</h4>
                                <p class="text-xs text-on-surface-variant">أهم النقاط (3-5 نقاط)</p>
                            </div>
                            <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 transition-opacity">
                                <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            </div>
                        </label>

                        <!-- متوازن -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="level" value="medium" class="peer sr-only" checked>
                            <div class="p-4 rounded-xl border border-outline-variant/30 bg-surface text-center hover:bg-surface-bright peer-checked:border-primary peer-checked:bg-primary/10 transition-all">
                                <span class="material-symbols-outlined text-on-surface-variant peer-checked:text-primary block mb-2 text-3xl">subject</span>
                                <h4 class="font-bold text-white mb-1">متوازن</h4>
                                <p class="text-xs text-on-surface-variant">شرح شامل للنقاط الأساسية</p>
                            </div>
                            <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 transition-opacity">
                                <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            </div>
                        </label>

                        <!-- مفصل -->
                        <label class="relative cursor-pointer">
                            <input type="radio" name="level" value="detailed" class="peer sr-only">
                            <div class="p-4 rounded-xl border border-outline-variant/30 bg-surface text-center hover:bg-surface-bright peer-checked:border-primary peer-checked:bg-primary/10 transition-all">
                                <span class="material-symbols-outlined text-on-surface-variant peer-checked:text-primary block mb-2 text-3xl">notes</span>
                                <h4 class="font-bold text-white mb-1">مفصل</h4>
                                <p class="text-xs text-on-surface-variant">شرح عميق مع الأمثلة</p>
                            </div>
                            <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 transition-opacity">
                                <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- زر التنفيذ -->
                <button type="submit" id="submit-btn" disabled class="w-full mt-4 bg-gradient-to-l from-primary to-primary-container text-on-primary-container py-4 rounded-xl font-black text-lg hover:opacity-90 transition-all flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed disabled:from-surface-container disabled:to-surface-container disabled:text-on-surface-variant shadow-lg group">
                    <span class="material-symbols-outlined text-2xl group-hover:animate-spin disabled:group-hover:animate-none">memory</span>
                    توليد الملخص الذكي الآن
                </button>

            </form>
        </div>
    </section>
</div>

<script>
    function updateFormAction(lectureId) {
        const form = document.getElementById('summarize-form');
        const btn = document.getElementById('submit-btn');
        if(lectureId) {
            // توجيه الفورم إلى مسار التلخيص للطالب
            form.action = `/student/lectures/${lectureId}/summarize`;
            btn.removeAttribute('disabled');
        }
    }

    // تأثير بصري عند إرسال الفورم (Loading state)
    document.getElementById('summarize-form').addEventListener('submit', function() {
        const btn = document.getElementById('submit-btn');
        btn.innerHTML = '<span class="material-symbols-outlined text-2xl animate-spin">progress_activity</span> جاري التحليل والتلخيص...';
        btn.classList.add('opacity-75', 'cursor-wait');
    });
</script>
@endsection
