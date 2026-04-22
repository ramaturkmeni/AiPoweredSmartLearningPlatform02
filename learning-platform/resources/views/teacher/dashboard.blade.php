@extends('layouts.teacher')

@section('title', 'لوحة تحكم الأستاذ - Smart Learn')

@section('page-content')
    <div class="mb-10 text-right">
        <h2 class="text-3xl font-extrabold text-white mb-2 font-plus-jakarta tracking-tight">لوحة تحكم الأستاذ</h2>
        <p class="text-on-surface-variant text-sm">نظرة عامة على نشاطك التعليمي وأداء طلابك اليوم.</p>
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
                <p class="text-on-surface-variant text-xs font-medium mb-1">المواد الدراسية</p>
                <p class="text-3xl font-black text-white font-plus-jakarta">{{ $stats['courses'] }}</p>
            </div>
        </div>

        <div class="bg-surface-container-low p-6 rounded-2xl flex flex-col gap-4 relative overflow-hidden group hover:bg-surface-container transition-all duration-300">
            <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-8xl text-secondary">video_camera_back</span>
            </div>
            <div class="flex justify-between items-start flex-row-reverse">
                <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-secondary">movie</span>
                </div>
            </div>
            <div class="text-right">
                <p class="text-on-surface-variant text-xs font-medium mb-1">إجمالي المحاضرات</p>
                <p class="text-3xl font-black text-white font-plus-jakarta">{{ $stats['lectures'] }}</p>
            </div>
        </div>

        <div class="bg-surface-container-low p-6 rounded-2xl flex flex-col gap-4 relative overflow-hidden group hover:bg-surface-container transition-all duration-300">
            <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-8xl text-tertiary">quiz</span>
            </div>
            <div class="flex justify-between items-start flex-row-reverse">
                <div class="w-12 h-12 bg-tertiary/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-tertiary">assignment</span>
                </div>
            </div>
            <div class="text-right">
                <p class="text-on-surface-variant text-xs font-medium mb-1">الاختبارات</p>
                <p class="text-3xl font-black text-white font-plus-jakarta">{{ $stats['quizzes'] }}</p>
            </div>
        </div>

        <div class="bg-surface-container-low p-6 rounded-2xl flex flex-col gap-4 relative overflow-hidden group hover:bg-surface-container transition-all duration-300">
            <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-8xl text-indigo-300">group</span>
            </div>
            <div class="flex justify-between items-start flex-row-reverse">
                <div class="w-12 h-12 bg-indigo-500/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-indigo-300">diversity_3</span>
                </div>
            </div>
            <div class="text-right">
                <p class="text-on-surface-variant text-xs font-medium mb-1">الطلاب المسجلين</p>
                <p class="text-3xl font-black text-white font-plus-jakarta">{{ $stats['students'] }}</p>
            </div>
        </div>
    </div>

    <div class="mb-6 flex justify-between items-center flex-row-reverse">
        <h3 class="text-xl font-bold text-white font-plus-jakarta">المواد الدراسية الأخيرة</h3>
        <a href="{{ route('teacher.courses.index') }}" class="text-primary text-sm font-bold flex items-center gap-1 hover:underline">
            عرض الكل <span class="material-symbols-outlined text-sm">arrow_back</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @php
            $defaultImages = [
                'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1555949963-ff9fe0c870eb?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?q=80&w=800&auto=format&fit=crop'
            ];
        @endphp

        @forelse ($recentCourses as $index => $course)
            <div class="bg-surface-container rounded-2xl overflow-hidden group border border-transparent hover:border-indigo-500/20 transition-all duration-500">
                <div class="h-40 relative">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                         src="{{ $course->img_url ?? $defaultImages[$index % count($defaultImages)] }}" alt="Course Cover"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-surface-container to-transparent opacity-80"></div>
                    <span class="absolute top-4 right-4 bg-tertiary/20 text-tertiary-fixed-dim text-[10px] font-bold px-3 py-1 rounded-full backdrop-blur-md">
                        {{ $course->created_at->diffForHumans() }}
                    </span>
                </div>
                <div class="p-6 text-right">
                    <div class="flex justify-between items-start mb-4 flex-row-reverse">
                        <h4 class="text-lg font-bold text-white leading-tight truncate w-3/4">{{ $course->title }}</h4>
                        <span class="bg-success/10 text-success text-[10px] font-bold px-2 py-0.5 rounded">نشط</span>
                    </div>
                    <div class="flex flex-row-reverse gap-4 mb-6">
                        <div class="flex items-center gap-1 text-on-surface-variant">
                            <span class="material-symbols-outlined text-sm">play_circle</span>
                            <span class="text-xs font-medium">{{ $course->lectures_count }} محاضرة</span>
                        </div>
                        <div class="flex items-center gap-1 text-on-surface-variant">
                            <span class="material-symbols-outlined text-sm">groups</span>
                            <span class="text-xs font-medium">{{ $course->students_count }} طالب</span>
                        </div>
                    </div>
                    <a href="{{ route('teacher.courses.edit', $course->id) }}" class="block text-center w-full bg-slate-800 text-on-surface font-bold py-3 rounded-xl hover:bg-primary hover:text-on-primary transition-all duration-300">
                        إدارة المادة
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-surface-container p-8 rounded-2xl text-center border border-dashed border-outline-variant/30">
                <span class="material-symbols-outlined text-6xl text-slate-600 mb-4">school</span>
                <h3 class="text-xl font-bold text-white mb-2">لا توجد مواد دراسية بعد</h3>
                <p class="text-on-surface-variant mb-6">ابدأ بإنشاء مادتك الأولى الآن لتتمكن من إضافة المحاضرات والطلاب.</p>
                <a href="{{ route('teacher.courses.create') }}" class="bg-primary text-on-primary-fixed px-6 py-2 rounded-xl font-bold inline-flex items-center gap-2">
                    <span class="material-symbols-outlined">add</span> إضافة مادة جديدة
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-12 grid grid-cols-1 xl:grid-cols-2 gap-8">
        <div class="bg-surface-container-low rounded-2xl p-8">
            <h3 class="text-lg font-bold text-white mb-6 text-right font-plus-jakarta">النشاط الأخير</h3>
            <div class="space-y-6">
                <div class="flex flex-row-reverse items-center gap-4">
                    <div class="w-10 h-10 bg-success/10 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-success text-lg">check_circle</span>
                    </div>
                    <div class="text-right flex-1">
                        <p class="text-sm text-white font-medium">تم تصحيح 45 اختباراً في مادة هندسة البرمجيات</p>
                        <p class="text-[10px] text-on-surface-variant">منذ ساعتين</p>
                    </div>
                </div>
                <div class="flex flex-row-reverse items-center gap-4">
                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-lg">upload_file</span>
                    </div>
                    <div class="text-right flex-1">
                        <p class="text-sm text-white font-medium">تم رفع محاضرة جديدة: "إدارة الذاكرة في C++"</p>
                        <p class="text-[10px] text-on-surface-variant">منذ 5 ساعات</p>
                    </div>
                </div>
                <div class="flex flex-row-reverse items-center gap-4">
                    <div class="w-10 h-10 bg-tertiary/10 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-tertiary text-lg" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                    </div>
                    <div class="text-right flex-1">
                        <p class="text-sm text-white font-medium">قام مساعد الذكاء الاصطناعي بتوليد 10 أسئلة جديدة</p>
                        <p class="text-[10px] text-on-surface-variant">أمس في 04:30 م</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-surface-container to-surface-container-highest rounded-2xl p-8 relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-32 h-32 bg-tertiary/20 blur-3xl -translate-x-1/2 -translate-y-1/2 rounded-full"></div>
            <div class="relative z-10">
                <div class="flex flex-row-reverse items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-tertiary text-2xl" style="font-variation-settings: 'FILL' 1;">psychology</span>
                    <h3 class="text-lg font-bold text-white font-plus-jakarta">تحليلات الذكاء الاصطناعي</h3>
                </div>
                <p class="text-on-surface-variant text-sm leading-relaxed mb-6 text-right">
                    لاحظنا انخفاضاً بنسبة 12% في تفاعل الطلاب مع أحدث المحاضرات. نقترح إضافة اختبار قصير تفاعلي (Quiz) في منتصف المحاضرة القادمة لزيادة التركيز.
                </p>
                <div class="flex flex-row-reverse gap-3">
                    <button class="bg-tertiary/10 text-tertiary-fixed-dim px-4 py-2 rounded-lg text-xs font-bold hover:bg-tertiary hover:text-on-tertiary transition-all">توليد اختبار تلقائي</button>
                    <button class="bg-transparent border border-outline-variant text-on-surface-variant px-4 py-2 rounded-lg text-xs font-bold hover:bg-surface-variant transition-all">تجاهل الآن</button>
                </div>
            </div>
            <div class="absolute bottom-4 left-4 opacity-20">
                <span class="material-symbols-outlined text-6xl text-tertiary">insights</span>
            </div>
        </div>
    </div>
@endsection