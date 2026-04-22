<!DOCTYPE html>
<html class="dark" dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>لوحة تحكم الأستاذ - Smart Learn</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-background": "#e2e2e5",
                        "tertiary-container": "#d560e6",
                        "tertiary-fixed-dim": "#f9abff",
                        "on-tertiary": "#570066",
                        "surface-container-high": "#282a2c",
                        "on-primary": "#00228a",
                        "on-tertiary-container": "#4c0059",
                        "on-tertiary-fixed": "#35003f",
                        "on-surface-variant": "#c4c5d7",
                        "secondary": "#ffb778",
                        "primary-fixed": "#dde1ff",
                        "on-secondary-fixed-variant": "#6c3a00",
                        "error-container": "#93000a",
                        "on-primary-fixed-variant": "#0034c0",
                        "on-surface": "#e2e2e5",
                        "on-secondary": "#4c2700",
                        "on-error-container": "#ffdad6",
                        "outline-variant": "#444654",
                        "surface-variant": "#333537",
                        "on-primary-fixed": "#001257",
                        "inverse-surface": "#e2e2e5",
                        "outline": "#8e90a0",
                        "secondary-container": "#fd9000",
                        "surface-container-highest": "#333537",
                        "surface-bright": "#37393b",
                        "surface-container-low": "#1a1c1e",
                        "on-tertiary-fixed-variant": "#7b008f",
                        "surface-tint": "#b9c3ff",
                        "primary-fixed-dim": "#b9c3ff",
                        "inverse-primary": "#2d50d9",
                        "surface": "#121416",
                        "secondary-fixed-dim": "#ffb778",
                        "on-secondary-fixed": "#2e1500",
                        "secondary-fixed": "#ffdcc1",
                        "inverse-on-surface": "#2f3133",
                        "background": "#121416",
                        "surface-container-lowest": "#0c0e10",
                        "on-error": "#690005",
                        "on-secondary-container": "#613400",
                        "on-primary-container": "#001d79",
                        "primary-container": "#6e88ff",
                        "surface-dim": "#121416",
                        "primary": "#b9c3ff",
                        "surface-container": "#1e2022",
                        "tertiary": "#f9abff",
                        "error": "#ffb4ab",
                        "tertiary-fixed": "#ffd6fe",
                        "success": "#10b981"
                    },
                    fontFamily: {
                        "headline": ["Plus Jakarta Sans"],
                        "body": ["Inter"],
                        "label": ["Inter"],
                        "plus-jakarta": ["Plus Jakarta Sans"]
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #121416; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #121416; }
        ::-webkit-scrollbar-thumb { background: #333537; border-radius: 10px; }
    </style>
</head>
<body class="bg-background text-on-surface antialiased overflow-x-hidden">

    <!-- Sidebar Navigation Shell -->
    <aside class="fixed right-0 h-full w-72 bg-slate-900 flex flex-col border-l border-slate-800/50 z-50 transition-all ease-in-out duration-200">
        <!-- Brand Header -->
        <div class="px-6 py-8">
            <div class="flex flex-row-reverse items-center gap-3 mb-8">
                <div class="w-10 h-10 bg-indigo-500/20 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-indigo-300" style="font-variation-settings: 'FILL' 1;">school</span>
                </div>
                <div>
                    <h1 class="text-xl font-black text-indigo-300 font-plus-jakarta">Smart Learn</h1>
                    <p class="text-[10px] text-slate-400 font-medium tracking-widest opacity-70">بوابة المعرفة الرقمية</p>
                </div>
            </div>

            <!-- User Profile (Dynamic) -->
            <div class="flex flex-row-reverse items-center gap-4 mb-10 p-2 bg-slate-800/30 rounded-xl">
                <!-- صورة افتراضية (يمكنك ربطها بـ avatar مستقبلاً) -->
                <div class="w-12 h-12 rounded-full border-2 border-indigo-500/30 bg-indigo-900 flex items-center justify-center text-white font-bold">
                    {{ mb_substr($teacher->first_name, 0, 1) }}
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-white">د. {{ $teacher->first_name }} {{ $teacher->last_name }}</p>
                    <p class="text-[10px] text-indigo-300 font-label uppercase">أستاذ مشارك</p>
                </div>
            </div>

            <!-- Navigation Items -->
            <nav class="space-y-1">
                <a class="flex flex-row-reverse items-center gap-4 bg-indigo-500/10 text-indigo-200 border-r-4 border-indigo-400 px-4 py-3 ml-2 rounded-l-xl transition-all" href="{{ route('dashboard') }}">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                    <span class="font-medium text-sm">لوحة القيادة</span>
                </a>
                <a class="flex flex-row-reverse items-center gap-4 text-slate-400 px-4 py-3 hover:text-slate-200 hover:bg-slate-800/50 transition-colors" href="#">
                    <span class="material-symbols-outlined">book_5</span>
                    <span class="font-medium text-sm">المواد الدراسية</span>
                </a>
                <a class="flex flex-row-reverse items-center gap-4 text-slate-400 px-4 py-3 hover:text-slate-200 hover:bg-slate-800/50 transition-colors" href="#">
                    <span class="material-symbols-outlined">video_library</span>
                    <span class="font-medium text-sm">المحاضرات</span>
                </a>
                <a class="flex flex-row-reverse items-center gap-4 text-slate-400 px-4 py-3 hover:text-slate-200 hover:bg-slate-800/50 transition-colors" href="#">
                    <span class="material-symbols-outlined">quiz</span>
                    <span class="font-medium text-sm">الاختبارات</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="mt-auto px-6 py-6 border-t border-slate-800/30">
            <button class="w-full bg-gradient-to-br from-primary to-primary-container text-on-primary-container font-bold py-3 rounded-xl flex items-center justify-center gap-2 mb-4 hover:opacity-90 transition-all scale-95 active:scale-90">
                <span class="material-symbols-outlined text-sm">smart_toy</span>
                <span class="text-xs">بدء جلسة ذكاء اصطناعي</span>
            </button>
            <div class="space-y-1">
                <a class="flex flex-row-reverse items-center gap-4 text-slate-400 px-4 py-2 hover:text-slate-200 transition-colors" href="{{ route('profile') }}">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="font-medium text-xs">الإعدادات</span>
                </a>

                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">@csrf</form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex flex-row-reverse items-center gap-4 text-error px-4 py-2 hover:opacity-80 transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="font-medium text-xs">تسجيل الخروج</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="mr-72 min-h-screen p-8 transition-all duration-300">

        <!-- Top App Bar -->
        <header class="flex flex-row-reverse justify-between items-center w-full px-6 py-4 bg-slate-900/60 backdrop-blur-xl rounded-2xl shadow-2xl shadow-indigo-500/10 mb-8 sticky top-4 z-40">
            <div class="flex items-center gap-6">
                <div class="relative">
                    <span class="material-symbols-outlined text-indigo-200 cursor-pointer">notifications</span>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full border border-slate-900"></span>
                </div>
                <div class="h-8 w-px bg-slate-700/50"></div>
                <div class="flex items-center gap-3">
                    <span class="text-indigo-200 font-bold text-sm font-plus-jakarta">مرحباً، د. {{ $teacher->first_name }}</span>
                </div>
            </div>
            <div class="relative w-96">
                <input class="w-full bg-slate-800/50 border-none rounded-full px-6 py-2 text-sm text-indigo-100 placeholder:text-slate-500 focus:ring-1 focus:ring-indigo-400 focus:bg-slate-800 transition-all text-right" placeholder="البحث في المواد والطلاب..." type="text" dir="rtl"/>
                <span class="material-symbols-outlined absolute left-4 top-2 text-slate-500 text-xl">search</span>
            </div>
        </header>

        <!-- Greeting & Intro -->
        <div class="mb-10 text-right">
            <h2 class="text-3xl font-extrabold text-white mb-2 font-plus-jakarta tracking-tight">لوحة تحكم الأستاذ</h2>
            <p class="text-on-surface-variant text-sm">نظرة عامة على نشاطك التعليمي وأداء طلابك اليوم.</p>
        </div>

        <!-- Bento Stats Grid (Dynamic Data) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <!-- Stat 1: Courses -->
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

            <!-- Stat 2: Lectures -->
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

            <!-- Stat 3: Quizzes -->
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

            <!-- Stat 4: Students -->
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

        <!-- Latest Courses Section (Dynamic Foreach) -->
        <div class="mb-6 flex justify-between items-center flex-row-reverse">
            <h3 class="text-xl font-bold text-white font-plus-jakarta">المواد الدراسية الأخيرة</h3>
            <a href="#" class="text-primary text-sm font-bold flex items-center gap-1 hover:underline">
                عرض الكل <span class="material-symbols-outlined text-sm">arrow_back</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @php
                // مصفوفة صور افتراضية في حال لم تكن المادة تحتوي على صورة
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
                        <a href="#" class="block text-center w-full bg-slate-800 text-on-surface font-bold py-3 rounded-xl hover:bg-primary hover:text-on-primary transition-all duration-300">
                            إدارة المادة
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-surface-container p-8 rounded-2xl text-center border border-dashed border-outline-variant/30">
                    <span class="material-symbols-outlined text-6xl text-slate-600 mb-4">school</span>
                    <h3 class="text-xl font-bold text-white mb-2">لا توجد مواد دراسية بعد</h3>
                    <p class="text-on-surface-variant mb-6">ابدأ بإنشاء مادتك الأولى الآن لتتمكن من إضافة المحاضرات والطلاب.</p>
                    <button class="bg-primary text-on-primary-fixed px-6 py-2 rounded-xl font-bold inline-flex items-center gap-2">
                        <span class="material-symbols-outlined">add</span> إضافة مادة جديدة
                    </button>
                </div>
            @endforelse
        </div>

        <!-- Secondary Section: Recent Activity & AI Insights -->
        <div class="mt-12 grid grid-cols-1 xl:grid-cols-2 gap-8">

            <!-- Activity (Placeholder for future dynamic data) -->
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

            <!-- AI Insight Card -->
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
    </main>

    <!-- Contextual FAB for quick actions -->
    <a href="#" class="fixed bottom-8 left-8 w-14 h-14 bg-indigo-500 text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-50">
        <span class="material-symbols-outlined text-3xl">add</span>
    </a>

</body>
</html>
