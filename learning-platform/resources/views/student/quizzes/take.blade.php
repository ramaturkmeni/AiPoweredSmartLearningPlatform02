@extends('layouts.student')
@section('title', 'أداء الاختبار - Smart Learn')

@section('page-content')
    <div class="mb-10 text-right">
        <h2 class="text-3xl font-extrabold text-white mb-2 font-plus-jakarta tracking-tight">{{ $quiz->title }}</h2>
        <p class="text-on-surface-variant text-sm">أجب على جميع الأسئلة ثم اضغط تسليم.</p>
    </div>

    <div class="bg-surface-container-low rounded-2xl p-6 mb-8 flex flex-row-reverse items-center justify-between sticky top-20 z-30 backdrop-blur-xl">
        <div class="flex flex-row-reverse items-center gap-4">
            <span class="material-symbols-outlined text-tertiary text-2xl" style="font-variation-settings: 'FILL' 1;">timer</span>
            <div class="text-right">
                <p class="text-[10px] text-on-surface-variant">الوقت المتبقي</p>
                <p id="quiz-timer" class="text-2xl font-black text-white font-plus-jakarta">{{ $quiz->duration }}:00</p>
            </div>
        </div>
        <div class="flex flex-row-reverse items-center gap-3">
            <span class="material-symbols-outlined text-on-surface-variant">quiz</span>
            <span class="text-on-surface-variant text-sm">{{ $quiz->questions->count() }} سؤال</span>
        </div>
    </div>

    <form method="POST" action="{{ route('student.quizzes.submit', $attempt->id) }}" id="quiz-form">
        @csrf
        <div class="space-y-6">
            @foreach($quiz->questions as $qIndex => $question)
                <div class="bg-surface-container rounded-2xl p-6 border border-transparent hover:border-outline-variant/20 transition-all" data-question="{{ $question->id }}">
                    <div class="flex flex-row-reverse items-start gap-4 mb-6">
                        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                            <span class="text-primary font-black text-sm">{{ $qIndex + 1 }}</span>
                        </div>
                        <div class="flex-1 text-right">
                            <p class="text-white font-bold text-sm leading-relaxed">{{ $question->text }}</p>
                        </div>
                    </div>

                    <div class="space-y-3 mr-14">
                        @foreach($question->options as $oIndex => $option)
                            <label class="flex flex-row-reverse items-center gap-4 p-4 rounded-xl bg-surface-container-low border border-transparent hover:border-primary/20 cursor-pointer transition-all has-[:checked]:border-primary/40 has-[:checked]:bg-primary/5">
                                <input type="radio" name="answers[{{ $qIndex }}][option_id]" value="{{ $option->id }}" class="w-5 h-5 text-primary border-outline-variant focus:ring-primary bg-surface-container shrink-0" required/>
                                <span class="text-on-surface-variant text-sm">{{ $option->text }}</span>
                            </label>
                        @endforeach
                    </div>

                    <input type="hidden" name="answers[{{ $qIndex }}][question_id]" value="{{ $question->id }}"/>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex flex-row-reverse gap-4">
            <button type="submit" class="bg-gradient-to-br from-primary to-primary-container text-on-primary-container font-bold py-4 px-8 rounded-xl flex items-center gap-2 hover:opacity-90 transition-all">
                <span class="material-symbols-outlined">send</span>
                تسليم الاختبار
            </button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    (function() {
        const duration = {{ $quiz->duration }};
        let seconds = duration * 60;
        const timerEl = document.getElementById('quiz-timer');

        const interval = setInterval(() => {
            seconds--;
            if (seconds <= 0) {
                clearInterval(interval);
                document.getElementById('quiz-form').submit();
                return;
            }
            const m = Math.floor(seconds / 60);
            const s = seconds % 60;
            timerEl.textContent = `${m}:${s.toString().padStart(2, '0')}`;
            if (seconds <= 60) {
                timerEl.classList.add('text-error');
                timerEl.classList.remove('text-white');
            }
        }, 1000);
    })();
</script>
@endpush