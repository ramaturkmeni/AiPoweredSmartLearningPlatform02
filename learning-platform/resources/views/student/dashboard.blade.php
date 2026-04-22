@extends('layouts.student')
@section('page-content')
    <div class="mb-10 text-right">
        <h2 class="text-3xl font-extrabold text-white mb-2 font-plus-jakarta tracking-tight">لوحة تحكم الطالب</h2>
        <p class="text-on-surface-variant text-sm">نظرة عامة على نشاطك التعليمي وأدائك اليوم.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-surface-container-low p-6 rounded-2xl flex flex-col gap-4 relative overflow-hidden group hover:bg-surface-container transition-all duration-300">
            <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-8xl text-primary">book</span>
            </div>
            <div class="flex justify-between items-start flex-row-reverse">
                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">menu_book</span>
                </div>
            </div>
            <div class="text-right">
                <p class="text-on-surface-variant text-xs font-medium mb-1">المواد المسجلة</p>
                <p class="text-3xl font-black text-white font-plus-jakarta">{{ $stats['courses'] }}</p>
            </div>
        </div>

        <div class="bg-surface-container-low p-6 rounded-2xl flex flex-col gap-4 relative overflow-hidden group hover:bg-surface-container transition-all duration-300">
            <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-8xl text-secondary">quiz</span>
            </div>
            <div class="flex justify-between items-start flex-row-reverse">
                <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-secondary">assignment</span>
                </div>
            </div>
            <div class="text-right">
                <p class="text-on-surface-variant text-xs font-medium mb-1">محاولات الاختبار</p>
                <p class="text-3xl font-black text-white font-plus-jakarta">{{ $stats['attempts'] }}</p>
            </div>
        </div>

        <div class="bg-surface-container-low p-6 rounded-2xl flex flex-col gap-4 relative overflow-hidden group hover:bg-surface-container transition-all duration-300">
            <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-8xl text-success">grade</span>
            </div>
            <div class="flex justify-between items-start flex-row-reverse">
                <div class="w-12 h-12 bg-success/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-success">trending_up</span>
                </div>
            </div>
            <div class="text-right">
                <p class="text-on-surface-variant text-xs font-medium mb-1">متوسط الدرجات</p>
                <p class="text-3xl font-black text-white font-plus-jakarta">{{ $stats['average'] }}%</p>
            </div>
        </div>

        <div class="bg-surface-container-low p-6 rounded-2xl flex flex-col gap-4 relative overflow-hidden group hover:bg-surface-container transition-all duration-300">
            <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-8xl text-tertiary">video_camera_back</span>
            </div>
            <div class="flex justify-between items-start flex-row-reverse">
                <div class="w-12 h-12 bg-tertiary/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-tertiary">movie</span>
                </div>
            </div>
            <div class="text-right">
                <p class="text-on-surface-variant text-xs font-medium mb-1">المحاضرات</p>
                <p class="text-3xl font-black text-white font-plus-jakarta">{{ $stats['lectures'] }}</p>
            </div>
        </div>
    </div>

    <div class="mb-6 flex justify-between items-center flex-row-reverse">
        <h3 class="text-xl font-bold text-white font-plus-jakarta">المواد المسجلة</h3>
        <a href="{{ route('student.courses.index') }}" class="text-primary text-sm font-bold flex items-center gap-1 hover:underline">
            عرض الكل <span class="material-symbols-outlined text-sm">arrow_back</span>
        </a>
    </div>

    @php
        $defaultImages = [
            'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=800&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=800&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1555949963-ff9fe0c870eb?q=80&w=800&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?q=80&w=800&auto=format&fit=crop'
        ];
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-8">
        @forelse ($enrolledCourses as $index => $course)
            <div class="bg-surface-container rounded-2xl overflow-hidden group border border-transparent hover:border-indigo-500/20 transition-all duration-500">
                <div class="h-40 relative">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                         src="{{ $course->img_url ?? $defaultImages[$index % count($defaultImages)] }}" alt="{{ $course->title }}"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-surface-container to-transparent opacity-80"></div>
                    <span class="absolute top-4 right-4 bg-success/20 text-success text-[10px] font-bold px-3 py-1 rounded-full backdrop-blur-md">
                        مسجّل
                    </span>
                </div>
                <div class="p-6 text-right">
                    <h4 class="text-lg font-bold text-white leading-tight truncate mb-4">{{ $course->title }}</h4>
                    <div class="flex flex-row-reverse gap-4 mb-6">
                        <div class="flex items-center gap-1 text-on-surface-variant">
                            <span class="material-symbols-outlined text-sm">play_circle</span>
                            <span class="text-xs font-medium">{{ $course->lectures_count }} محاضرة</span>
                        </div>
                    </div>
                    <a href="{{ route('student.courses.show', $course->id) }}" class="block text-center w-full bg-slate-800 text-on-surface font-bold py-3 rounded-xl hover:bg-primary hover:text-on-primary transition-all duration-300">
                        عرض المحاضرات
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-4 bg-surface-container p-8 rounded-2xl text-center border border-dashed border-outline-variant/30">
                <span class="material-symbols-outlined text-6xl text-slate-600 mb-4">school</span>
                <h3 class="text-xl font-bold text-white mb-2">لا توجد مواد مسجلة بعد</h3>
                <p class="text-on-surface-variant mb-6">ابدأ بتسجيل موادك الأولى لتتمكن من متابعة المحاضرات والاختبارات.</p>
                <a href="{{ route('student.courses.index') }}" class="bg-primary text-on-primary-fixed px-6 py-2 rounded-xl font-bold inline-flex items-center gap-2">
                    <span class="material-symbols-outlined">add</span> تصفح المواد
                </a>
            </div>
        @endforelse
    </div>
@endsection