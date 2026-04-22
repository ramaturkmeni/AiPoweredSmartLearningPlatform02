@extends('layouts.teacher')

@section('page-content')
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('teacher.lectures.index', $lecture->course_id) }}" class="text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined">arrow_forward</span>
            </a>
            <h2 class="text-2xl font-bold text-white font-plus-jakarta">تعديل المحاضرة</h2>
        </div>
        <p class="text-on-surface-variant text-sm text-right">تحديث بيانات المحاضرة والمرفقات</p>
    </div>

    <div class="bg-surface-container rounded-2xl p-8 max-w-3xl">
        <form action="{{ route('teacher.lectures.update', $lecture) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-on-surface-variant text-sm font-medium mb-2 text-right">عنوان المحاضرة</label>
                    <input type="text" name="title" value="{{ old('title', $lecture->title) }}"
                        class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-on-surface text-sm text-right focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                        required />
                </div>

                <div>
                    <label class="block text-on-surface-variant text-sm font-medium mb-2 text-right">المحتوى النصي</label>
                    <textarea name="content_text" rows="6"
                        class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-on-surface text-sm text-right focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-none">{{ old('content_text', $lecture->content_text) }}</textarea>
                </div>

                <div>
                    <label class="block text-on-surface-variant text-sm font-medium mb-2 text-right">ملف المرفق</label>
                    @if($lecture->file_path)
                        <div class="flex items-center gap-2 mb-3 p-3 bg-surface-container-low rounded-xl">
                            <span class="material-symbols-outlined text-primary text-lg">description</span>
                            <a href="{{ Storage::url($lecture->file_path) }}" target="_blank" class="text-primary text-sm hover:underline">الملف الحالي</a>
                        </div>
                    @endif
                    <input type="file" name="file"
                        class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-on-surface text-sm file:bg-primary file:text-on-primary-fixed file:border-0 file:rounded-lg file:px-4 file:py-2 file:ml-4 file:cursor-pointer" />
                </div>

                <div>
                    <label class="block text-on-surface-variant text-sm font-medium mb-2 text-right">رابط الفيديو</label>
                    <input type="url" name="video_url" value="{{ old('video_url', $lecture->video_url) }}"
                        class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-on-surface text-sm text-right focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                        dir="ltr" />
                </div>

                <div>
                    <label class="block text-on-surface-variant text-sm font-medium mb-2 text-right">ترتيب المحاضرة</label>
                    <input type="number" name="order_index" value="{{ old('order_index', $lecture->order_index) }}" min="0"
                        class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-on-surface text-sm text-right focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                        required />
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit"
                        class="bg-primary text-on-primary-fixed font-bold py-3 px-8 rounded-xl hover:bg-primary-fixed-dim transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">save</span>
                        حفظ التعديلات
                    </button>
                    <a href="{{ route('teacher.lectures.index', $lecture->course_id) }}"
                        class="text-on-surface-variant hover:text-on-surface font-medium py-3 px-6 rounded-xl border border-outline-variant transition-all">
                        إلغاء
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection