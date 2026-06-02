@extends('layouts.student')
@section('title', 'المحاضرة - Smart Learn')

@section('page-content')
    <div class="mb-10 text-right">
        <div class="flex items-center gap-2 text-on-surface-variant text-sm mb-2">
            <a href="{{ route('student.courses.show', $lecture->course_id) }}" class="hover:text-primary transition-colors">{{ $lecture->course->title }}</a>
            <span class="material-symbols-outlined text-sm">chevron_left</span>
            <span>المحاضرة</span>
        </div>
        <h2 class="text-3xl font-extrabold text-white mb-2 font-plus-jakarta tracking-tight">{{ $lecture->title }}</h2>
    </div>

    <div class="flex gap-8">
        <div class="flex-1 min-w-0">
            <div class="bg-surface-container rounded-2xl p-8 mb-6">
                @if($lecture->content_text)
                    <div class="text-on-surface-variant leading-relaxed whitespace-pre-wrap text-right mb-6">{{ $lecture->content_text }}</div>
                @endif

                @if($lecture->file_url)
                    <div class="flex flex-row-reverse items-center gap-3 p-4 bg-surface-container-low rounded-xl mb-4">
                        <span class="material-symbols-outlined text-primary text-2xl">description</span>
                        <a href="{{ Storage::url($lecture->file_url) }}" target="_blank" class="text-primary font-bold text-sm hover:underline">تحميل الملف المرفق</a>
                    </div>
                @endif

                @if($lecture->video_url)
                    <div class="flex flex-row-reverse items-center gap-3 p-4 bg-surface-container-low rounded-xl mb-4">
                        <span class="material-symbols-outlined text-secondary text-2xl">play_circle</span>
                        <a href="{{ $lecture->video_url }}" target="_blank" class="text-secondary font-bold text-sm hover:underline">مشاهدة الفيديو</a>
                    </div>
                @endif

                <div class="flex flex-row-reverse gap-3 mt-6">
                    @if($quiz)
                        <a href="{{ route('student.quizzes.take', $quiz->id) }}" class="bg-gradient-to-br from-tertiary to-tertiary-container text-on-tertiary font-bold px-6 py-3 rounded-xl flex items-center gap-2 hover:opacity-90 transition-all">
                            <span class="material-symbols-outlined">quiz</span>
                            أداء الاختبار
                        </a>
                    @endif

                    <button id="ai-summarize-btn" data-lecture-id="{{ $lecture->id }}" class="bg-gradient-to-br from-primary to-primary-container text-on-primary-container font-bold px-6 py-3 rounded-xl flex items-center gap-2 hover:opacity-90 transition-all">
                        <span class="material-symbols-outlined">auto_awesome</span>
                        تلخيص بالذكاء الاصطناعي
                    </button>
                </div>
            </div>

            <div id="ai-summary" class="hidden bg-gradient-to-br from-surface-container to-surface-container-highest rounded-2xl p-8 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-32 h-32 bg-tertiary/20 blur-3xl -translate-x-1/2 -translate-y-1/2 rounded-full"></div>
                <div class="relative z-10">
                    <div class="flex flex-row-reverse items-center gap-3 mb-4">
                        <span class="material-symbols-outlined text-tertiary text-2xl" style="font-variation-settings: 'FILL' 1;">psychology</span>
                        <h3 class="text-lg font-bold text-white font-plus-jakarta">ملخص الذكاء الاصطناعي</h3>
                    </div>
                    <p id="ai-summary-text" class="text-on-surface-variant text-sm leading-relaxed text-right"></p>
                </div>
            </div>
        </div>

        <div class="w-80 shrink-0">
            <div class="bg-surface-container-low rounded-2xl p-6 sticky top-28">
                <h3 class="text-lg font-bold text-white mb-4 text-right font-plus-jakarta">محاضرات المادة</h3>
                <div class="space-y-2">
                    @foreach($courseLectures as $lec)
                        <a href="{{ route('student.lectures.show', $lec->id) }}" class="flex flex-row-reverse items-center gap-3 p-3 rounded-xl {{ $lec->id === $lecture->id ? 'bg-primary/10 text-primary border border-primary/20' : 'bg-surface-container text-on-surface-variant hover:bg-surface-container-high' }} transition-all">
                            {{-- <span class="material-symbols-outlined text-lg {{ $lec->id === $lecture->id ? 'text-primary' }}">play_circle</span> --}}
                            <span class="material-symbols-outlined text-lg {{ $lec->id === $lecture->id ? 'text-primary' : '' }}">play_circle</span>
                            <span class="text-sm font-medium truncate">{{ $lec->title }}</span>
                            @if($lec->quiz && $lec->quiz->isPublished())
                                <span class="material-symbols-outlined text-tertiary text-sm mr-auto">quiz</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('ai-summarize-btn')?.addEventListener('click', async function() {
        const lectureId = this.dataset.lectureId;
        const summaryEl = document.getElementById('ai-summary');
        const summaryText = document.getElementById('ai-summary-text');
        const btn = this;

        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined animate-spin">progress_activity</span> جارٍ التلخيص...';

        try {
            const res = await fetch('{{ route('student.lectures.summarize', 0) }}'.replace('0', lectureId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                }
            });
            const data = await res.json();
            if (data.summary) {
                summaryText.textContent = data.summary;
                summaryEl.classList.remove('hidden');
            }
        } catch (e) {
            summaryText.textContent = 'حدث خطأ أثناء التلخيص. يرجى المحاولة لاحقاً.';
            summaryEl.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<span class="material-symbols-outlined">auto_awesome</span> تلخيص بالذكاء الاصطناعي';
        }
    });
</script>
@endpush
