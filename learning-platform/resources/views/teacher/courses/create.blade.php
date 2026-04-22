@extends('layouts.teacher')

@section('page-content')
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('teacher.courses.index') }}" class="text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h2 class="text-2xl font-extrabold text-white font-plus-jakarta">إضافة مادة جديدة</h2>
        </div>
        <p class="text-on-surface-variant text-sm">أنشئ مادة دراسية جديدة لطلابك.</p>
    </div>

    <div class="bg-surface-container rounded-2xl p-8 max-w-2xl">
        <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label for="title" class="block text-on-surface-variant text-sm font-medium mb-2 text-right">عنوان المادة</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                    class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-on-surface text-sm text-right placeholder:text-on-surface-variant/50 focus:ring-1 focus:ring-primary focus:border-primary transition-all"
                    placeholder="مثال: هندسة البرمجيات" required/>
                @error('title')
                    <p class="text-error text-xs mt-1 text-right">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-on-surface-variant text-sm font-medium mb-2 text-right">وصف المادة</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-on-surface text-sm text-right placeholder:text-on-surface-variant/50 focus:ring-1 focus:ring-primary focus:border-primary transition-all resize-none"
                    placeholder="اكتب وصفاً مختصراً للمادة...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-error text-xs mt-1 text-right">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-row-reverse gap-3">
                <button type="submit"
                    class="bg-primary text-on-primary-fixed px-8 py-3 rounded-xl font-bold text-sm hover:opacity-90 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">save</span>
                    حفظ المادة
                </button>
                <a href="{{ route('teacher.courses.index') }}"
                    class="bg-surface-container-low border border-outline-variant text-on-surface-variant px-6 py-3 rounded-xl font-bold text-sm hover:bg-surface-container transition-all">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
@endsection