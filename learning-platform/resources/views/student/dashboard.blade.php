@extends('layouts.student')

@section('page-content')
    <!-- عنوان الترحيب وأعلى لوحة التحكم -->
    <div class="mb-10 text-right">
        <h2 class="text-3xl font-black text-white mb-2 font-plus-jakarta tracking-tight">لوحة تحكم الطالب</h2>
        <p class="text-on-surface-variant text-sm sm:text-base">نظرة عامة على نشاطك التعليمي الاستثنائي وأدائك الأكاديمي اليوم.</p>
    </div>

    <!-- شبكة الإحصائيات الفاخرة التفاعلية -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">

        <!-- بطاقة: المواد المسجلة -->
        <div class="bg-slate-900/40 border border-white/5 p-6 rounded-2xl flex flex-col gap-4 relative overflow-hidden group hover:border-primary/25 hover:shadow-lg hover:shadow-primary/5 transition-all duration-300">
            <!-- توهج خلفي ناعم -->
            <div class="absolute -right-6 -bottom-6 opacity-5 group-hover:opacity-15 group-hover:scale-110 transition-all duration-500 text-primary">
                <span class="material-symbols-outlined text-9xl">book</span>
            </div>

            <div class="flex justify-between items-center flex-row-reverse relative z-10">
                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary transition-transform duration-300 group-hover:scale-105">
                    <span class="material-symbols-outlined">menu_book</span>
                </div>
                <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
            </div>

            <div class="text-right relative z-10">
                <p class="text-on-surface-variant text-xs font-bold tracking-wide mb-1">المواد المسجلة</p>
                <p class="text-3xl font-black text-white font-plus-jakarta tracking-tight">{{ $stats['courses'] }}</p>
            </div>
        </div>

        <!-- بطاقة: محاولات الاختبار -->
        <div class="bg-slate-900/40 border border-white/5 p-6 rounded-2xl flex flex-col gap-4 relative overflow-hidden group hover:border-secondary/25 hover:shadow-lg hover:shadow-secondary/5 transition-all duration-300">
            <!-- توهج خلفي ناعم -->
            <div class="absolute -right-6 -bottom-6 opacity-5 group-hover:opacity-15 group-hover:scale-110 transition-all duration-500 text-secondary">
                <span class="material-symbols-outlined text-9xl">quiz</span>
            </div>

            <div class="flex justify-between items-center flex-row-reverse relative z-10">
                <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center text-secondary transition-transform duration-300 group-hover:scale-105">
                    <span class="material-symbols-outlined">assignment</span>
                </div>
                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
            </div>

            <div class="text-right relative z-10">
                <p class="text-on-surface-variant text-xs font-bold tracking-wide mb-1">محاولات الاختبار</p>
                <p class="text-3xl font-black text-white font-plus-jakarta tracking-tight">{{ $stats['attempts'] }}</p>
            </div>
        </div>

        <!-- بطاقة: متوسط الدرجات -->
        <div class="bg-slate-900/40 border border-white/5 p-6 rounded-2xl flex flex-col gap-4 relative overflow-hidden group hover:border-success/25 hover:shadow-lg hover:shadow-success/5 transition-all duration-300">
            <!-- توهج خلفي ناعم -->
            <div class="absolute -right-6 -bottom-6 opacity-5 group-hover:opacity-15 group-hover:scale-110 transition-all duration-500 text-success">
                <span class="material-symbols-outlined text-9xl">grade</span>
            </div>

            <div class="flex justify-between items-center flex-row-reverse relative z-10">
                <div class="w-12 h-12 bg-success/10 rounded-xl flex items-center justify-center text-success transition-transform duration-300 group-hover:scale-105">
                    <span class="material-symbols-outlined">trending_up</span>
                </div>
                <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
            </div>

            <div class="text-right relative z-10">
                <p class="text-on-surface-variant text-xs font-bold tracking-wide mb-1">متوسط الدرجات</p>
                <p class="text-3xl font-black text-white font-plus-jakarta tracking-tight">{{ $stats['average'] }}%</p>
            </div>
        </div>

        <!-- بطاقة: المحاضرات المتاحة -->
        <div class="bg-slate-900/40 border border-white/5 p-6 rounded-2xl flex flex-col gap-4 relative overflow-hidden group hover:border-tertiary/25 hover:shadow-lg hover:shadow-tertiary/5 transition-all duration-300">
            <!-- توهج خلفي ناعم -->
            <div class="absolute -right-6 -bottom-6 opacity-5 group-hover:opacity-15 group-hover:scale-110 transition-all duration-500 text-tertiary">
                <span class="material-symbols-outlined text-9xl">video_camera_back</span>
            </div>

            <div class="flex justify-between items-center flex-row-reverse relative z-10">
                <div class="w-12 h-12 bg-tertiary/10 rounded-xl flex items-center justify-center text-tertiary transition-transform duration-300 group-hover:scale-105">
                    <span class="material-symbols-outlined">movie</span>
                </div>
                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
            </div>

            <div class="text-right relative z-10">
                <p class="text-on-surface-variant text-xs font-bold tracking-wide mb-1">المحاضرات</p>
                <p class="text-3xl font-black text-white font-plus-jakarta tracking-tight">{{ $stats['lectures'] }}</p>
            </div>
        </div>
    </div>

    <!-- ترويسة قسم المواد المسجلة -->
    <div class="mb-8 flex justify-between items-center flex-row-reverse">
        <h3 class="text-lg font-bold text-white tracking-tight">المواد المسجلة حالياً</h3>
        <a href="{{ route('student.courses.index') }}" class="group text-primary text-xs sm:text-sm font-bold flex items-center gap-1.5 transition-colors duration-300 hover:text-indigo-400">
            <span>عرض الكل</span>
            <span class="material-symbols-outlined text-sm transition-transform duration-300 group-hover:-translate-x-1">arrow_back</span>
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

    <!-- شبكة عرض كروت المواد المسجلة -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8">
        @forelse ($enrolledCourses as $index => $course)
            <div class="bg-slate-900/35 rounded-2xl overflow-hidden group border border-white/5 transition-all duration-500 hover:border-primary/25 hover:shadow-xl hover:shadow-primary/5 flex flex-col justify-between">

                <div>
                    <!-- صورة غلاف الكورس مع ميزة التكبير الناعم عند التمرير -->
                    <div class="h-44 relative overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                             src="{{ $course->img_url ?? $defaultImages[$index % count($defaultImages)] }}" alt="{{ $course->title }}"/>
                        <!-- تدرج لوني لحفظ جودة النصوص بأسفل الصورة -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-transparent to-black/10"></div>
                        <span class="absolute top-4 right-4 bg-success/20 text-success border border-success/20 text-[10px] font-bold px-3 py-1 rounded-full backdrop-blur-md">
                            مسجّل
                        </span>
                    </div>

                    <!-- تفاصيل ومحتوى كارت المادة -->
                    <div class="p-6 text-right">
                        <h4 class="text-base font-bold text-white leading-snug truncate mb-3 transition-colors duration-300 group-hover:text-primary-fixed-dim" title="{{ $course->title }}">{{ $course->title }}</h4>
                        <div class="flex flex-row-reverse items-center gap-1.5 text-on-surface-variant">
                            <span class="material-symbols-outlined text-sm text-primary">play_circle</span>
                            <span class="text-xs font-semibold">{{ $course->lectures_count }} محاضرة تفاعلية</span>
                        </div>
                    </div>
                </div>

                <!-- زر الإجراء في نهاية الكارت بالتساوي -->
                <div class="p-6 pt-0 text-right">
                    <a href="{{ route('student.courses.show', $course->id) }}" class="block text-center w-full bg-white/5 border border-white/10 text-white hover:bg-primary hover:border-primary hover:shadow-lg hover:shadow-primary/20 font-bold py-3 rounded-xl transition-all duration-300 text-sm">
                        عرض المحاضرات
                    </a>
                </div>

            </div>
        @empty
            <!-- الكارت البديل لحالة خلو البيانات (Empty State) بالتصميم المتناسق الجديد -->
            <div class="col-span-1 sm:col-span-2 xl:col-span-4 bg-slate-900/20 border border-dashed border-white/10 p-12 rounded-2xl text-center flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center text-slate-500 mb-5 shadow-inner">
                    <span class="material-symbols-outlined text-4xl">school</span>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">لا توجد مواد مسجلة بعد</h3>
                <p class="text-on-surface-variant text-sm max-w-sm mb-6 leading-relaxed">ابدأ بتسجيل موادك الدراسية الأولى لمتابعة المحاضرات وإجراء الاختبارات التقييمية الذكية.</p>
                <a href="{{ route('student.courses.index') }}" class="bg-primary hover:bg-indigo-500 text-white px-6 py-3 rounded-xl font-bold inline-flex items-center gap-2 transition-all duration-300 hover:shadow-lg hover:shadow-primary/20">
                    <span class="material-symbols-outlined text-sm">add</span> <span>تصفح المواد المتاحة</span>
                </a>
            </div>
        @endforelse
    </div>
@endsection
