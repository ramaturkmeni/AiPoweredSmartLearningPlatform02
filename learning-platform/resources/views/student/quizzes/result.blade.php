@extends('layouts.student')
@section('title', 'نتيجة الاختبار - Smart Learn')

@section('page-content')
    <div class="mb-10 text-right">
        <h2 class="text-3xl font-extrabold text-white mb-2 font-plus-jakarta tracking-tight">نتيجة الاختبار</h2>
        <p class="text-on-surface-variant text-sm">{{ $attempt->quiz->title }}</p>
    </div>

    <div class="bg-surface-container-low p-8 rounded-2xl mb-8 text-center">
        <div class="w-32 h-32 mx-auto rounded-full flex items-center justify-center mb-6 {{ $attempt->score >= 60 ? 'bg-success/10 border-4 border-success' : 'bg-error/10 border-4 border-error' }}">
            <span class="text-5xl font-black font-plus-jakarta {{ $attempt->score >= 60 ? 'text-success' : 'text-error' }}">{{ $attempt->score }}</span>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">{{ $attempt->score >= 60 ? 'تهانينا! لقد نجحت' : 'لم تحصل على درجة النج' }}</h3>
        <p class="text-on-surface-variant text-sm">تم تسليم الاختبار بتاريخ {{ $attempt->taken_at->format('Y/m/d H:i') }}</p>
    </div>

    <div class="mb-6 flex justify-between items-center flex-row-reverse">
        <h3 class="text-xl font-bold text-white font-plus-jakarta">مراجعة الإجابات</h3>
    </div>

    <div class="space-y-6">
        @foreach($attempt->answers as $index => $answer)
            @php
                $question = $answer->question;
                $isCorrect = $answer->is_correct;
                $correctOption = $question->options->firstWhere('is_correct', true);
            @endphp
            <div class="bg-surface-container rounded-2xl p-6 border {{ $isCorrect ? 'border-success/30' : 'border-error/30' }}">
                <div class="flex flex-row-reverse items-start gap-4 mb-4">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 {{ $isCorrect ? 'bg-success/10' : 'bg-error/10' }}">
                        <span class="material-symbols-outlined {{ $isCorrect ? 'text-success' : 'text-error' }}" style="font-variation-settings: 'FILL' 1;">
                            {{ $isCorrect ? 'check_circle' : 'cancel' }}
                        </span>
                    </div>
                    <div class="flex-1 text-right">
                        <p class="text-white font-bold mb-1">السؤال {{ $index + 1 }}</p>
                        <p class="text-on-surface-variant text-sm mb-4">{{ $question->text }}</p>

                        <div class="space-y-2">
                            @foreach($question->options as $option)
                                @php
                                    $isSelected = $answer->selected_option_id === $option->id;
                                    $isCorrectOption = $option->is_correct;
                                @endphp
                                <div class="flex flex-row-reverse items-center gap-3 p-3 rounded-xl {{ $isSelected && $isCorrectOption ? 'bg-success/10 border border-success/30' : ($isSelected ? 'bg-error/10 border border-error/30' : ($isCorrectOption ? 'bg-success/5 border border-success/20' : 'bg-surface-variant/50 border border-transparent')) }}">
                                    <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center shrink-0 {{ $isSelected && $isCorrectOption ? 'border-success' : ($isSelected ? 'border-error' : ($isCorrectOption ? 'border-success' : 'border-outline-variant')) }}">
                                        @if($isSelected)
                                            <div class="w-3 h-3 rounded-full {{ $isCorrectOption ? 'bg-success' : 'bg-error' }}"></div>
                                        @elseif($isCorrectOption)
                                            <div class="w-3 h-3 rounded-full bg-success"></div>
                                        @endif
                                    </div>
                                    <span class="text-sm {{ $isSelected && $isCorrectOption ? 'text-success font-bold' : ($isSelected ? 'text-error font-bold' : ($isCorrectOption ? 'text-success' : 'text-on-surface-variant')) }}">{{ $option->text }}</span>
                                    @if($isSelected && !$isCorrectOption)
                                        <span class="material-symbols-outlined text-error text-sm mr-auto" style="font-variation-settings: 'FILL' 1;">close</span>
                                    @elseif($isCorrectOption && !$isSelected)
                                        <span class="material-symbols-outlined text-success text-sm mr-auto" style="font-variation-settings: 'FILL' 1;">check</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 flex flex-row-reverse gap-4">
        <a href="{{ route('student.dashboard') }}" class="bg-primary text-on-primary-fixed px-6 py-3 rounded-xl font-bold inline-flex items-center gap-2 hover:opacity-90 transition-all">
            <span class="material-symbols-outlined">dashboard</span>
            العودة للوحة القيادة
        </a>
    </div>
@endsection