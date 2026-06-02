@extends('layouts.teacher')

@section('page-content')
    <div class="mb-8 flex justify-between items-center flex-row-reverse">
        <div class="text-right">
            <h2 class="text-2xl font-extrabold text-white font-plus-jakarta mb-1">محاضرات {{ $course->title }}</h2>
            <p class="text-on-surface-variant text-sm">إدارة المحاضرات الخاصة بهذه المادة الدراسية</p>
        </div>
        <a href="{{ route('teacher.lectures.create') }}" class="bg-primary text-on-primary-fixed px-6 py-2.5 rounded-xl font-bold inline-flex items-center gap-2 hover:opacity-90 transition-all">
            <span class="material-symbols-outlined text-lg">add</span>
            إضافة محاضرة
        </a>
    </div>

    <div class="bg-surface-container rounded-2xl overflow-hidden border border-outline-variant/10">
        <table class="w-full text-right">
            <thead>
                <tr class="bg-surface-container-high text-on-surface-variant text-xs font-medium">
                    <th class="px-6 py-4">الترتيب</th>
                    <th class="px-6 py-4">العنوان</th>
                    <th class="px-6 py-4">الملف</th>
                    <th class="px-6 py-4">الفيديو</th>
                    <th class="px-6 py-4">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                @forelse ($lectures as $lecture)
                    <tr class="hover:bg-surface-container-low transition-colors">
                        <td class="px-6 py-4 text-on-surface-variant font-medium">{{ $lecture->order_index }}</td>
                        <td class="px-6 py-4 text-white font-bold">{{ $lecture->title }}</td>
                        <td class="px-6 py-4">
                            @if($lecture->file_url)
                                <a href="{{ Storage::url($lecture->file_url) }}" class="text-primary hover:underline inline-flex items-center gap-1 text-sm">
                                    <span class="material-symbols-outlined text-sm">description</span>
                                    ملف
                                </a>
                            @else
                                <span class="text-on-surface-variant text-sm">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($lecture->video_url)
                                <a href="{{ $lecture->video_url }}" target="_blank" class="text-secondary hover:underline inline-flex items-center gap-1 text-sm">
                                    <span class="material-symbols-outlined text-sm">play_circle</span>
                                    فيديو
                                </a>
                            @else
                                <span class="text-on-surface-variant text-sm">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2 flex-row-reverse">
                                <a href="{{ route('teacher.lectures.edit', $lecture) }}" class="text-primary hover:bg-primary/10 p-2 rounded-lg transition-all" title="تعديل">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <form method="POST" action="{{ route('teacher.lectures.destroy', $lecture) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-error hover:bg-error/10 p-2 rounded-lg transition-all" title="حذف" onclick="return confirm('هل أنت متأكد من حذف هذه المحاضرة؟')">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <span class="material-symbols-outlined text-5xl text-slate-600 mb-3 block">video_library</span>
                            <p class="text-on-surface-variant">لا توجد محاضرات بعد</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('teacher.courses.index') }}" class="text-on-surface-variant hover:text-white text-sm inline-flex items-center gap-1 transition-colors">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            العودة إلى المواد الدراسية
        </a>
    </div>
@endsection