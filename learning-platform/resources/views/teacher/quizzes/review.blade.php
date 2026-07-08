@extends('layouts.teacher')

@section('page-content')
<div class="mb-8">
    <div class="flex items-center gap-3 mb-2 flex-row-reverse">
        <span class="material-symbols-outlined text-tertiary text-3xl">quiz</span>
        <h2 class="text-2xl font-extrabold text-white font-plus-jakarta">مراجعة الاختبار</h2>
    </div>
    <p class="text-on-surface-variant text-sm text-right">راجع الأسئلة والإعدادات قبل نشر الاختبار للطلاب</p>
</div>

@if(session('success'))
<div class="mb-6 bg-success/10 border border-success/30 text-success px-4 py-3 rounded-xl text-right text-sm">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-error/10 border border-error/30 text-error px-4 py-3 rounded-xl text-right text-sm">
    {{ session('error') }}
</div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <div class="xl:col-span-2 space-y-6">
        <div class="bg-surface-container rounded-2xl p-6">
            <div class="flex items-center justify-between mb-6 flex-row-reverse">
                <h3 class="text-lg font-bold text-white font-plus-jakarta">الأسئلة ({{ $quiz->questions->count() }})</h3>
                <span class="bg-tertiary/10 text-tertiary-fixed-dim text-xs font-bold px-3 py-1 rounded-full">مسودة</span>
            </div>

            @forelse($quiz->questions->sortBy('order_index') as $index => $question)
            <div class="bg-surface-container-low rounded-xl p-5 mb-4 border border-outline-variant/20">
                <div class="flex items-start justify-between mb-3 flex-row-reverse">
                    <div class="flex-1 text-right">
                        <span class="text-on-surface-variant text-xs font-bold">السؤال {{ $index + 1 }}</span>
                        <p class="text-white font-medium mt-1">{{ $question->question_text }}</p>
                    </div>
                    <form method="POST" action="{{ route('teacher.quizzes.deleteQuestion', $question->id) }}" class="mr-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-error hover:bg-error/10 p-1.5 rounded-lg transition-all" onclick="return confirm('هل أنت متأكد من حذف هذا السؤال؟')">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                    </form>
                </div>
                <div class="space-y-2">
                    @foreach($question->options as $option)
                    <div class="flex items-center gap-3 flex-row-reverse {{ $option->is_correct ? 'bg-success/10 border border-success/30' : 'bg-surface-container border border-outline-variant/10' }} rounded-lg px-4 py-2.5">
                        <div class="w-5 h-5 rounded-full border-2 {{ $option->is_correct ? 'border-success bg-success' : 'border-outline-variant' }} flex items-center justify-center flex-shrink-0">
                            @if($option->is_correct)
                            <span class="material-symbols-outlined text-on-surface text-xs" style="font-variation-settings: 'FILL' 1;">check</span>
                            @endif
                        </div>
                        <span class="text-sm {{ $option->is_correct ? 'text-success font-bold' : 'text-on-surface-variant' }}">{{ $option->option_text }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @empty
            <div class="bg-surface-container-low rounded-xl p-8 text-center">
                <span class="material-symbols-outlined text-5xl text-slate-600 mb-3">help_outline</span>
                <p class="text-on-surface-variant">لا توجد أسئلة بعد. أضف أسئلة يدوياً أو استخدم الذكاء الاصطناعي لتوليدها.</p>
            </div>
            @endforelse
        </div>

        <div class="bg-surface-container rounded-2xl p-6">
            <div class="flex items-center gap-3 mb-6 flex-row-reverse">
                <span class="material-symbols-outlined text-primary">add_circle</span>
                <h3 class="text-lg font-bold text-white font-plus-jakarta">إضافة سؤال جديد</h3>
            </div>
            <form method="POST" action="{{ route('teacher.quizzes.addQuestion', $quiz) }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-on-surface-variant text-sm font-medium mb-2 text-right">نص السؤال</label>
                        <input type="text" name="question_text" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary focus:border-transparent text-right" placeholder="أدخل نص السؤال...">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-on-surface-variant text-sm font-medium mb-2 text-right">الخيار الأول (الإجابة الصحيحة)</label>
                            <input type="text" name="options[0][text]" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary focus:border-transparent text-right" placeholder="الخيار 1">
                            <input type="hidden" name="options[0][is_correct]" value="1">
                        </div>
                        <div>
                            <label class="block text-on-surface-variant text-sm font-medium mb-2 text-right">الخيار الثاني</label>
                            <input type="text" name="options[1][text]" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary focus:border-transparent text-right" placeholder="الخيار 2">
                            <input type="hidden" name="options[1][is_correct]" value="0">
                        </div>
                        <div>
                            <label class="block text-on-surface-variant text-sm font-medium mb-2 text-right">الخيار الثالث</label>
                            <input type="text" name="options[2][text]" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary focus:border-transparent text-right" placeholder="الخيار 3">
                            <input type="hidden" name="options[2][is_correct]" value="0">
                        </div>
                        <div>
                            <label class="block text-on-surface-variant text-sm font-medium mb-2 text-right">الخيار الرابع</label>
                            <input type="text" name="options[3][text]" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary focus:border-transparent text-right" placeholder="الخيار 4">
                            <input type="hidden" name="options[3][is_correct]" value="0">
                        </div>
                    </div>
                    <p class="text-on-surface-variant text-xs text-right">الخيار الأول هو الإجابة الصحيحة افتراضياً. يمكنك تعديل ذلك من خلال النقر على زر النشر بعد الإضافة.</p>
                    <button type="submit" class="bg-primary text-on-primary-fixed px-6 py-3 rounded-xl font-bold text-sm hover:opacity-90 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">add</span>
                        إضافة السؤال
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-surface-container rounded-2xl p-6">
            <div class="flex items-center gap-3 mb-6 flex-row-reverse">
                <span class="material-symbols-outlined text-secondary">settings</span>
                <h3 class="text-lg font-bold text-white font-plus-jakarta">إعدادات الاختبار</h3>
            </div>
            <form method="POST" action="{{ route('teacher.quizzes.update', $quiz) }}">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-on-surface-variant text-sm font-medium mb-2 text-right">عنوان الاختبار</label>
                        <input type="text" name="title" value="{{ $quiz->title }}" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary focus:border-transparent text-right">
                    </div>
                    <div>
                        <label class="block text-on-surface-variant text-sm font-medium mb-2 text-right">مدة الاختبار (بالدقائق)</label>
                        <input type="number" name="duration" value="{{ $quiz->duration }}" min="1" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary focus:border-transparent text-right">
                    </div>
                    <div>
                        <label class="block text-on-surface-variant text-sm font-medium mb-2 text-right">وقت البدء</label>
                        <input type="datetime-local" name="start_time" value="{{ $quiz->start_time ? $quiz->start_time->format('Y-m-d\TH:i') : '' }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary focus:border-transparent text-right">
                    </div>
                    <div>
                        <label class="block text-on-surface-variant text-sm font-medium mb-2 text-right">وقت الانتهاء</label>
                        <input type="datetime-local" name="end_time" value="{{ $quiz->end_time ? $quiz->end_time->format('Y-m-d\TH:i') : '' }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-on-surface text-sm focus:ring-2 focus:ring-primary focus:border-transparent text-right">
                    </div>
                    <button type="submit" class="w-full bg-surface-container-low text-on-surface px-6 py-3 rounded-xl font-bold text-sm hover:bg-surface-container-high transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">save</span>
                        حفظ الإعدادات
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-surface-container rounded-2xl p-6">
            <div class="flex items-center gap-3 mb-4 flex-row-reverse">
                <span class="material-symbols-outlined text-success">rocket_launch</span>
                <h3 class="text-lg font-bold text-white font-plus-jakarta">نشر الاختبار</h3>
            </div>
            <p class="text-on-surface-variant text-sm mb-6 text-right">بعد النشر سيتمكن الطلاب من أداء الاختبار. تأكد من مراجعة جميع الأسئلة والإعدادات.</p>
            <form method="POST" action="{{ route('teacher.quizzes.publish', $quiz) }}">
             @csrf
         <!-- قمنا بتغيير نوع الزر إلى button واستدعاء دالة التأكيد المخصصة للنشر -->
              <button type="button" onclick="confirmPublish(this)" class="w-full bg-success text-white px-6 py-3 rounded-xl font-bold text-sm hover:opacity-90 transition-all flex items-center justify-center gap-2">
              <span class="material-symbols-outlined text-lg">publish</span>
               نشر الاختبار
            </button>
            </form>
        </div>

        <form method="POST" action="{{ route('teacher.quizzes.destroy', $quiz) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full bg-error/10 text-error px-6 py-3 rounded-xl font-bold text-sm hover:bg-error hover:text-on-error transition-all flex items-center justify-center gap-2" onclick="return confirm('هل أنت متأكد من حذف الاختبار بالكامل؟')">
                <span class="material-symbols-outlined text-lg">delete_forever</span>
                حذف الاختبار
            </button>
        </form>
    </div>
</div>
<!-- نافذة التأكيد المنسدلة من الأعلى المخصصة لنشر الاختبار من قبل الأستاذ -->
<div id="confirm-publish-modal" class="fixed inset-0 z-[100] hidden flex items-start justify-center pt-24 bg-black/60 backdrop-blur-sm transition-all duration-300">
    <div class="bg-surface-container-high border border-outline-variant/30 p-6 rounded-2xl max-w-sm w-full mx-4 shadow-2xl text-right animate-fade-in">
        <div class="flex items-center gap-3 flex-row-reverse mb-4">
            <span class="material-symbols-outlined text-success" style="font-variation-settings: 'FILL' 1;">rocket_launch</span>
            <h4 class="text-white font-bold text-lg">تأكيد نشر الاختبار</h4>
        </div>
        <p class="text-on-surface-variant text-sm mb-6 leading-relaxed">هل أنت متأكد من رغبتك في نشر هذا الاختبار للطلاب؟ <br> <span class="text-success font-bold">تنبيه:</span> بمجرد النشر، سيتم إتاحته للطلاب فوراً ولن تتمكن من تعديل أو حذف الأسئلة.</p>
        <div class="flex gap-3 justify-end flex-row-reverse">
            <button id="modal-publish-submit-btn" class="bg-success text-white font-black px-5 py-2.5 rounded-xl text-sm hover:opacity-90 transition-all">نعم، نشر الآن</button>
            <button type="button" onclick="closePublishModal()" class="bg-surface-container-low text-on-surface-variant border border-outline-variant/30 px-5 py-2.5 rounded-xl text-sm hover:bg-surface-variant transition-all">تراجع</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let activePublishForm = null;

    // فتح نافذة تأكيد النشر للأستاذ وحفظ الفورم المعني
    function confirmPublish(button) {
        activePublishForm = button.closest('form');
        const modal = document.getElementById('confirm-publish-modal');
        modal.classList.remove('hidden');
    }

    // إغلاق نافذة تأكيد النشر
    function closePublishModal() {
        const modal = document.getElementById('confirm-publish-modal');
        modal.classList.add('hidden');
        activePublishForm = null;
    }

    // تنفيذ النشر الفعلي بعد موافقة الأستاذ
    document.getElementById('modal-publish-submit-btn').addEventListener('click', function() {
        if (activePublishForm) {
            activePublishForm.submit();
        }
    });
</script>
@endpush
