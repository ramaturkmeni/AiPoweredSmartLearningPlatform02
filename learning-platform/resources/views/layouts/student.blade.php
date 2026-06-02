<!DOCTYPE html>
<html class="dark" dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'لوحة الطالب - Smart Learn')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&family=Noto+Kufi+Arabic:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
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
                        "plus-jakarta": ["Plus Jakarta Sans"],
                        "kufi": ["Noto Kufi Arabic"]
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', 'Noto Kufi Arabic', sans-serif; background-color: #121416; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #121416; }
        ::-webkit-scrollbar-thumb { background: #333537; border-radius: 10px; }
    </style>
    @stack('styles')
</head>
<body class="bg-background text-on-surface antialiased overflow-x-hidden">

    @if(session('success'))
        <div id="toast-success" class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] bg-success/90 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3 backdrop-blur-sm transition-all duration-500">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
        <script>setTimeout(() => { const t = document.getElementById('toast-success'); if(t) t.style.opacity = '0'; setTimeout(() => { if(t) t.remove(); }, 500); }, 3000);</script>
    @endif

    @if(session('error'))
        <div id="toast-error" class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] bg-error/90 text-on-error px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3 backdrop-blur-sm transition-all duration-500">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">error</span>
            <span class="text-sm font-bold">{{ session('error') }}</span>
        </div>
        <script>setTimeout(() => { const t = document.getElementById('toast-error'); if(t) t.style.opacity = '0'; setTimeout(() => { if(t) t.remove(); }, 500); }, 3000);</script>
    @endif

    <aside class="fixed right-0 h-full w-72 bg-slate-900 flex flex-col border-l border-slate-800/50 z-50 transition-all ease-in-out duration-200">
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

            <div class="flex flex-row-reverse items-center gap-4 mb-10 p-2 bg-slate-800/30 rounded-xl">
                <div class="w-12 h-12 rounded-full border-2 border-indigo-500/30 bg-indigo-900 flex items-center justify-center text-white font-bold">
                    {{ mb_substr(auth()->user()->student->first_name ?? '', 0, 1) }}
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-white">{{ auth()->user()->student->full_name ?? '' }}</p>
                    <p class="text-[10px] text-indigo-300 font-label uppercase">طالب</p>
                </div>
            </div>

            <nav class="space-y-1">
                <a class="flex flex-row-reverse items-center gap-4 {{ request()->routeIs('student.dashboard') ? 'bg-indigo-500/10 text-indigo-200 border-r-4 border-indigo-400 ml-2 rounded-l-xl' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/50' }} px-4 py-3 transition-all" href="{{ route('student.dashboard') }}">
                    <span class="material-symbols-outlined" style="{{ request()->routeIs('student.dashboard') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">dashboard</span>
                    <span class="font-medium text-sm">لوحة القيادة</span>
                </a>
                <a class="flex flex-row-reverse items-center gap-4 {{ request()->routeIs('student.courses.*') ? 'bg-indigo-500/10 text-indigo-200 border-r-4 border-indigo-400 ml-2 rounded-l-xl' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/50' }} px-4 py-3 transition-all" href="{{ route('student.courses.index') }}">
                    <span class="material-symbols-outlined" style="{{ request()->routeIs('student.courses.*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">book_5</span>
                    <span class="font-medium text-sm">المواد الدراسية</span>
                </a>
                <a class="flex flex-row-reverse items-center gap-4 {{ request()->routeIs('student.quizzes.*') ? 'bg-indigo-500/10 text-indigo-200 border-r-4 border-indigo-400 ml-2 rounded-l-xl' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/50' }} px-4 py-3 transition-all" href="{{ route('student.quizzes.attempts') }}">
                    <span class="material-symbols-outlined" style="{{ request()->routeIs('student.quizzes.*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">quiz</span>
                    <span class="font-medium text-sm">الاختبارات</span>
                </a>
            </nav>
        </div>

        <div class="mt-auto px-6 py-6 border-t border-slate-800/30">
            <a href="{{ route('student.ai.index') }}" class="w-full bg-gradient-to-br from-primary to-primary-container text-on-primary-container font-bold py-3 rounded-xl flex items-center justify-center gap-2 mb-4 hover:opacity-90 transition-all scale-95 active:scale-90">
    <span class="material-symbols-outlined text-sm">smart_toy</span>
    <span class="text-xs">بدء جلسة ذكاء اصطناعي</span>
</a>
            <div class="space-y-1">
                <a class="flex flex-row-reverse items-center gap-4 text-slate-400 px-4 py-2 hover:text-slate-200 transition-colors" href="{{ route('profile') }}">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="font-medium text-xs">الإعدادات</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">@csrf</form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex flex-row-reverse items-center gap-4 text-error px-4 py-2 hover:opacity-80 transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="font-medium text-xs">تسجيل الخروج</span>
                </a>
            </div>
        </div>
    </aside>

    <main class="mr-72 min-h-screen p-8 transition-all duration-300">
        <header class="flex flex-row-reverse justify-between items-center w-full px-6 py-4 bg-slate-900/60 backdrop-blur-xl rounded-2xl shadow-2xl shadow-indigo-500/10 mb-8 sticky top-4 z-40">
            <div class="flex items-center gap-6">
                <div class="relative">
                    <span class="material-symbols-outlined text-indigo-200 cursor-pointer">notifications</span>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full border border-slate-900"></span>
                </div>
                <div class="h-8 w-px bg-slate-700/50"></div>
                <div class="flex items-center gap-3">
                    <span class="text-indigo-200 font-bold text-sm font-plus-jakarta">مرحباً، {{ auth()->user()->student->first_name ?? auth()->user()->username }}</span>
                </div>
            </div>
            <div class="relative w-96">
                <input class="w-full bg-slate-800/50 border-none rounded-full px-6 py-2 text-sm text-indigo-100 placeholder:text-slate-500 focus:ring-1 focus:ring-indigo-400 focus:bg-slate-800 transition-all text-right" placeholder="البحث في المواد..." type="text" dir="rtl"/>
                <span class="material-symbols-outlined absolute left-4 top-2 text-slate-500 text-xl">search</span>
            </div>
        </header>

        @section('page-content')
        @show
    </main>

    @stack('scripts')
</body>
</html>
