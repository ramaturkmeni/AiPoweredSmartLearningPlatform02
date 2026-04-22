@extends('layouts.teacher')

@section('page-content')
    <div class="mb-8 flex justify-between items-center flex-row-reverse">
        <div class="text-right">
            <h2 class="text-2xl font-extrabold text-white font-plus-jakarta">تعديل المادة</h2>
            <p class="text-on-surface-variant text-sm mt-1">تحديث بيانات المادة الدراسية</p>
        </div>
        <a href="{{ route('teacher.courses.index') }}" class="flex items-center gap-2 text-on-surface-variant hover:text-white transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
            <span class="text-sm font-medium">العودة للمواد</span>
        </a>
    </div>

    <div class="bg-surface-container rounded-2xl p-8 max-w-2xl">
        <form action="{{ route('teacher.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6 text-right">
                <label for="title" class="block text-sm font-medium text-on-surface-variant mb-2">عنوان المادة</label>
                <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}"
                    class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-on-surface text-sm focus:ring-1 focus:ring-primary focus:border-primary transition-all text-right"
                    placeholder="أدخل عنوان المادة" required />
                @error('title')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8 text-right">
                <label for="description" class="block text-sm font-medium text-on-surface-variant mb-2">الوصف</label>
                <textarea name="description" id="description" rows="5"
                    class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-on-surface text-sm focus:ring-1 focus:ring-primary focus:border-primary transition-all text-right resize-none"
                    placeholder="أدخل وصف المادة">{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-row-reverse gap-4">
                <button type="submit" class="bg-primary text-on-primary-fixed px-8 py-3 rounded-xl font-bold text-sm hover:opacity-90 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">save</span>
                    حفظ التعديلات
                </button>
                <a href="{{ route('teacher.courses.index') }}" class="bg-surface-variant text-on-surface-variant px-8 py-3 rounded-xl font-bold text-sm hover:bg-surface-container-high transition-all">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
@endsection