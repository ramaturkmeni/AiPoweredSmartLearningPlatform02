@extends('layouts.teacher')

@section('page-content')
    <div class="mb-8 text-right">
        <div class="flex items-center justify-between flex-row-reverse mb-4">
            <h2 class="text-2xl font-extrabold text-white font-plus-jakarta">إضافة محاضرة جديدة</h2>
            <a href="{{ route('teacher.courses.index') }}" class="text-on-surface-variant hover:text-white flex items-center gap-2 text-sm transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
                العودة للمواد
            </a>
        </div>
        <p class="text-on-surface-variant text-sm">أضف محاضرة جديدة مع إمكانية توليد اختبار تلقائي بالذكاء الاصطناعي.</p>
    </div>

    <div class="bg-surface-container rounded-2xl p-8 max-w-3xl">
        <form action="{{ route('teacher.lectures.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="text-right">
                <label for="course_id" class="block text-sm font-bold text-on-surface mb-2">المادة الدراسية</label>
                <select name="course_id" id="course_id" class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-on-surface text-sm text-right focus:ring-2 focus:ring-primary focus:border-primary transition-all" required>
                    <option value="">اختر المادة</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                    @endforeach
                </select>
                @error('course_id')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-right">
                <label for="title" class="block text-sm font-bold text-on-surface mb-2">عنوان المحاضرة</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-on-surface text-sm text-right focus:ring-2 focus:ring-primary focus:border-primary transition-all" placeholder="مثال: مقدمة في هندسة البرمجيات" required/>
                @error('title')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-right">
                <label for="content_text" class="block text-sm font-bold text-on-surface mb-2">نص المحاضرة</label>
                <textarea name="content_text" id="content_text" rows="8" class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-on-surface text-sm text-right focus:ring-2 focus:ring-primary focus:border-primary transition-all resize-y" placeholder="اكتب محتوى المحاضرة هنا...">{{ old('content_text') }}</textarea>
                @error('content_text')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-right">
                <label for="file" class="block text-sm font-bold text-on-surface mb-2">ملف المحاضرة (PDF، PPTX...)</label>
                <div class="flex items-center gap-4 flex-row-reverse">
                    <label class="cursor-pointer bg-surface-container-low border-2 border-dashed border-outline-variant rounded-xl px-6 py-4 hover:border-primary transition-all flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">upload_file</span>
                        <span class="text-on-surface-variant text-sm">اختر ملفاً</span>
                        <input type="file" name="file" id="file" class="hidden" accept=".pdf,.pptx,.ppt,.doc,.docx"/>
                    </label>
                    <span id="file-name" class="text-on-surface-variant text-xs"></span>
                </div>
                @error('file')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-right">
                <label for="video_url" class="block text-sm font-bold text-on-surface mb-2">رابط الفيديو</label>
                <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}" class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-on-surface text-sm text-right focus:ring-2 focus:ring-primary focus:border-primary transition-all" placeholder="https://www.youtube.com/watch?v=..."/>
                @error('video_url')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-right">
                <label for="image" class="block text-sm font-bold text-on-surface mb-2">صورة المحاضرة</label>
                <div class="flex items-center gap-4 flex-row-reverse">
                    <label class="cursor-pointer bg-surface-container-low border-2 border-dashed border-outline-variant rounded-xl px-6 py-4 hover:border-primary transition-all flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">image</span>
                        <span class="text-on-surface-variant text-sm">اختر صورة</span>
                        <input type="file" name="image" id="image" class="hidden" accept="image/*"/>
                    </label>
                    <span id="image-name" class="text-on-surface-variant text-xs"></span>
                </div>
                @error('image')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-right">
                <label for="order_index" class="block text-sm font-bold text-on-surface mb-2">ترتيب المحاضرة</label>
                <input type="number" name="order_index" id="order_index" value="{{ old('order_index', 1) }}" min="1" class="w-full bg-surface-container-low border border-outline-variant rounded-xl px-4 py-3 text-on-surface text-sm text-right focus:ring-2 focus:ring-primary focus:border-primary transition-all" required/>
                @error('order_index')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 flex-row-reverse bg-tertiary/5 border border-tertiary/20 rounded-xl p-4">
                <input type="checkbox" name="generate_quiz" id="generate_quiz" value="1" {{ old('generate_quiz') ? 'checked' : '' }} class="w-5 h-5 rounded bg-surface-container-low border-outline-variant text-primary focus:ring-primary cursor-pointer"/>
                <div class="text-right">
                    <label for="generate_quiz" class="text-sm font-bold text-on-surface cursor-pointer flex items-center gap-2">
                        <span class="material-symbols-outlined text-tertiary" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                        توليد اختبار تلقائي بالذكاء الاصطناعي
                    </label>
                    <p class="text-on-surface-variant text-xs mt-1">سيتم إنشاء اختبار بناءً على محتوى المحاضرة تلقائياً</p>
                </div>
            </div>

            <div class="flex items-center gap-4 flex-row-reverse pt-4">
                <button type="submit" class="bg-primary text-on-primary-fixed font-bold py-3 px-8 rounded-xl hover:opacity-90 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    حفظ المحاضرة
                </button>
                <a href="{{ route('teacher.courses.index') }}" class="bg-surface-container-low text-on-surface-variant font-bold py-3 px-6 rounded-xl hover:bg-surface-container transition-all">إلغاء</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('file').addEventListener('change', function(e) {
        document.getElementById('file-name').textContent = e.target.files[0]?.name || '';
    });
    document.getElementById('image').addEventListener('change', function(e) {
        document.getElementById('image-name').textContent = e.target.files[0]?.name || '';
    });
</script>
@endpush