<!DOCTYPE html>
<html class="dark scroll-smooth" dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Smart Learn - إنشاء حساب جديد</title>

    <!-- جلب خط Tajawal للغة العربية و Plus Jakarta Sans للأرقام واللاتينية -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>

    <!-- Tailwind CSS CDN مع تفعيل الإضافات المطلوبة -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                            950: '#0f0f1b',
                        },
                        darkbg: '#07080d',
                        surface: '#0d0f19',
                        surfaceCard: '#131626',
                        borderLight: '#1e233d',
                    },
                    fontFamily: {
                        sans: ['Tajawal', 'system-ui', 'sans-serif'],
                        latin: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                },
            },
        }
    </script>

    <style>
        body {
            font-family: 'Tajawal', system-ui, -apple-system, sans-serif;
            background-color: #07080d;
            color: #f1f5f9;
            -webkit-font-smoothing: antialiased;
        }
        .font-latin { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #07080d; }
        ::-webkit-scrollbar-thumb { background: #1e233d; border-radius: 10px; }
    </style>
</head>
<body class="bg-darkbg text-slate-100 selection:bg-brand-500 selection:text-white antialiased overflow-x-hidden min-h-screen flex items-center justify-center p-4">

    <!-- الخلفيات التجميلية المتدرجة للعلامة التجارية -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none opacity-35">
        <div class="absolute -top-[10%] start-[60%] w-[500px] h-[500px] rounded-full bg-brand-600/15 blur-[120px]"></div>
        <div class="absolute -bottom-[10%] end-[60%] w-[400px] h-[400px] rounded-full bg-indigo-500/10 blur-[120px]"></div>
    </div>

    <!-- الحاوية الرئيسية المتطابقة مع شبكة تصميم المنصة -->
    <main class="relative w-full max-w-5xl grid grid-cols-1 lg:grid-cols-12 gap-0 bg-surface/40 backdrop-blur-md rounded-3xl overflow-hidden shadow-2xl shadow-black/80 border border-borderLight/80 my-8">

        <!-- الجانب البصري والعلامة التجارية (يعرض في الشاشات الكبيرة) -->
        <div class="hidden lg:flex lg:col-span-5 relative flex-col justify-between p-12 bg-surfaceCard/40 border-l border-borderLight/40 overflow-hidden">

            <!-- الشعار العلوي -->
            <div class="relative z-10">
                <a href="{{ route('home') }}" class="flex items-center gap-3 mb-12 hover:opacity-80 transition-all duration-300">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-indigo-400 flex items-center justify-center shadow-lg shadow-brand-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold font-latin tracking-tight bg-clip-text text-transparent bg-gradient-to-l from-slate-100 to-indigo-300">
                        Smart Learn
                    </span>
                </a>

                <h2 class="text-4xl font-extrabold leading-tight mb-6 text-slate-100">
                    ابدأ رحلتك التعليمية <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-l from-brand-400 to-indigo-300">في المنصة الأذكى</span>
                </h2>
                <p class="text-slate-400 text-base leading-relaxed max-w-sm">
                    انضم إلى آلاف الطلاب والأساتذة في بيئة تعليمية متطورة تعتمد على الذكاء الاصطناعي لتطوير مهاراتك.
                </p>
            </div>

            <!-- ميزة تفاعلية في الأسفل -->
            <div class="relative z-10">
                <div class="flex flex-col gap-6">
                    <div class="flex items-center gap-4 bg-surfaceCard/65 p-4 rounded-2xl border border-borderLight/80 shadow-md">
                        <div class="w-12 h-12 rounded-xl bg-brand-500/10 border border-brand-500/20 flex items-center justify-center text-brand-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-200">تعلم تفاعلي ذكي</p>
                            <p class="text-xs text-slate-400">تحليلات دقيقة مدعومة بالذكاء الاصطناعي لمستوى تقدمك</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- صورة تجميلية خلفية مدمجة مع نظام الألوان الداكن -->
            <div class="absolute inset-0 opacity-[0.15] pointer-events-none mix-blend-luminosity">
                <img class="w-full h-full object-cover grayscale" alt="Library" src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=800&auto=format&fit=crop"/>
                <div class="absolute inset-0 bg-gradient-to-t from-darkbg via-transparent to-transparent"></div>
            </div>
        </div>

        <!-- جانب الحقول والنموذج (Form Side) -->
        <div class="lg:col-span-7 p-8 lg:p-16 flex flex-col justify-center">

            <!-- شعار الهواتف (يعرض في الشاشات الصغيرة فقط) -->
            <div class="lg:hidden flex items-center gap-3 mb-8">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand-600 to-indigo-400 flex items-center justify-center shadow-lg shadow-brand-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span class="text-lg font-bold font-latin bg-clip-text text-transparent bg-gradient-to-l from-slate-100 to-indigo-300">Smart Learn</span>
            </div>

            <!-- عنوان الصفحة -->
            <header class="mb-8">
                <h3 class="text-2xl font-bold text-slate-100 mb-2">إنشاء حساب جديد</h3>
                <p class="text-slate-400 text-sm">قم بملء البيانات التالية لتتمكن من الوصول إلى المنصة</p>
            </header>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- الحقل الخفي لتحديد نوع المستخدم (مهم جداً للمنطق) -->
                <input type="hidden" name="role" id="role_input" value="{{ old('role', 'student') }}">

                <!-- مفتاح تحديد دور المستخدم (طالب / أستاذ) -->
                <div class="flex p-1 bg-surfaceCard/80 backdrop-blur border border-borderLight rounded-2xl w-full max-w-xs relative transition-all duration-300">
                    <button id="btn_student" onclick="setRole('student')" class="flex-1 py-2.5 text-sm font-bold rounded-xl transition-all duration-300 z-10" type="button">
                        طالب
                    </button>
                    <button id="btn_teacher" onclick="setRole('teacher')" class="flex-1 py-2.5 text-sm font-medium rounded-xl transition-all duration-300 z-10" type="button">
                        أستاذ
                    </button>
                </div>

                <!-- شبكة الحقول الأساسية -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">

                    <!-- الاسم الأول -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-400 mr-1">الاسم الأول</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-500 group-focus-within:text-brand-400 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <input name="first_name" value="{{ old('first_name') }}" class="w-full bg-surfaceCard/60 border border-borderLight/80 focus:border-brand-500/50 focus:ring-1 focus:ring-brand-500/50 rounded-2xl py-3 pr-12 pl-4 text-slate-200 placeholder-slate-600 transition-all duration-300" placeholder="أدخل اسمك الأول" type="text" required/>
                        </div>
                        @error('first_name') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- الاسم الأخير -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-400 mr-1">الاسم الأخير</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-500 group-focus-within:text-brand-400 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2" />
                                </svg>
                            </span>
                            <input name="last_name" value="{{ old('last_name') }}" class="w-full bg-surfaceCard/60 border border-borderLight/80 focus:border-brand-500/50 focus:ring-1 focus:ring-brand-500/50 rounded-2xl py-3 pr-12 pl-4 text-slate-200 placeholder-slate-600 transition-all duration-300" placeholder="أدخل اسم العائلة" type="text" required/>
                        </div>
                        @error('last_name') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- اسم المستخدم -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-400 mr-1">اسم المستخدم</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-500 group-focus-within:text-brand-400 transition-colors duration-200">
                                <span class="font-latin font-semibold text-sm">@</span>
                            </span>
                            <input name="username" value="{{ old('username') }}" class="w-full bg-surfaceCard/60 border border-borderLight/80 focus:border-brand-500/50 focus:ring-1 focus:ring-brand-500/50 rounded-2xl py-3 pr-12 pl-4 text-slate-200 text-right transition-all duration-300 font-latin" dir="ltr" placeholder="user123" type="text" required/>
                        </div>
                        @error('username') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- البريد الإلكتروني -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-400 mr-1">البريد الإلكتروني</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-500 group-focus-within:text-brand-400 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input name="email" value="{{ old('email') }}" class="w-full bg-surfaceCard/60 border border-borderLight/80 focus:border-brand-500/50 focus:ring-1 focus:ring-brand-500/50 rounded-2xl py-3 pr-12 pl-4 text-slate-200 text-right transition-all duration-300 font-latin" dir="ltr" placeholder="example@mail.com" type="email" required/>
                        </div>
                        @error('email') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- رقم الهاتف -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-400 mr-1">رقم الهاتف</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-500 group-focus-within:text-brand-400 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </span>
                            <input name="phone" value="{{ old('phone') }}" class="w-full bg-surfaceCard/60 border border-borderLight/80 focus:border-brand-500/50 focus:ring-1 focus:ring-brand-500/50 rounded-2xl py-3 pr-12 pl-4 text-slate-200 text-right transition-all duration-300 font-latin" dir="ltr" placeholder="09XXXXXXXX" type="tel" required/>
                        </div>
                        @error('phone') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- المدينة ومكان الإقامة -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-400 mr-1">المدينة (مكان الإقامة)</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-500 group-focus-within:text-brand-400 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>
                            <input name="location" value="{{ old('location') }}" class="w-full bg-surfaceCard/60 border border-borderLight/80 focus:border-brand-500/50 focus:ring-1 focus:ring-brand-500/50 rounded-2xl py-3 pr-12 pl-4 text-slate-200 placeholder-slate-600 transition-all duration-300" placeholder="مثال: حماة" type="text" required/>
                        </div>
                        @error('location') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- تحديد الجنس -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-400 mr-1">الجنس</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-500 group-focus-within:text-brand-400 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>
                            <select name="gender" class="w-full bg-surfaceCard/60 border border-borderLight/80 focus:border-brand-500/50 focus:ring-1 focus:ring-brand-500/50 rounded-2xl py-3 pr-12 pl-8 text-slate-200 appearance-none transition-all duration-300 cursor-pointer" required>
                                <option disabled selected class="bg-surface" value="">اختر الجنس</option>
                                <option value="male" class="bg-surface" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                                <option value="female" class="bg-surface" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                            </select>
                            <span class="absolute inset-y-0 left-4 flex items-center text-slate-500 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </div>
                        @error('gender') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- التخصص الدراسي (يظهر ديناميكياً للطلاب فقط) -->
                    <div id="major_container" class="space-y-1.5 transition-all duration-300 {{ old('role', 'student') == 'teacher' ? 'hidden' : '' }}">
                        <label class="text-xs font-bold text-slate-400 mr-1">التخصص الدراسي</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-500 group-focus-within:text-brand-400 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </span>
                            <input name="major" id="major_input" value="{{ old('major') }}" class="w-full bg-surfaceCard/60 border border-borderLight/80 focus:border-brand-500/50 focus:ring-1 focus:ring-brand-500/50 rounded-2xl py-3 pr-12 pl-4 text-slate-200 placeholder-slate-600 transition-all duration-300" placeholder="مثال: هندسة البرمجيات" type="text"/>
                        </div>
                        @error('major') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- كلمة المرور مع إمكانية التبديل والإظهار المباشر -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-400 mr-1">كلمة المرور</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-500 group-focus-within:text-brand-400 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            <input name="password" id="password" class="w-full bg-surfaceCard/60 border border-borderLight/80 focus:border-brand-500/50 focus:ring-1 focus:ring-brand-500/50 rounded-2xl py-3 pr-12 pl-12 text-slate-200 text-right transition-all duration-300 font-latin" dir="ltr" placeholder="••••••••" type="password" required/>
                            <span onclick="togglePassword()" class="absolute inset-y-0 left-4 flex items-center text-slate-500 hover:text-brand-400 cursor-pointer transition-colors duration-200">
                                <svg id="toggle-icon-svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <!-- أيقونة العين المفتوحة افتراضياً -->
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </span>
                        </div>
                        @error('password') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- تأكيد كلمة المرور -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-400 mr-1">تأكيد كلمة المرور</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-500 group-focus-within:text-brand-400 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.952 11.952 0 01-7.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </span>
                            <input name="password_confirmation" id="password_confirmation" class="w-full bg-surfaceCard/60 border border-borderLight/80 focus:border-brand-500/50 focus:ring-1 focus:ring-brand-500/50 rounded-2xl py-3 pr-12 pl-4 text-slate-200 text-right transition-all duration-300 font-latin" dir="ltr" placeholder="••••••••" type="password" required/>
                        </div>
                    </div>
                </div>

                <!-- زر الإرسال والروابط المساعدة -->
                <div class="pt-4 flex flex-col gap-6">
                    <button class="w-full py-4 bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-500 hover:to-indigo-500 text-white font-bold text-base rounded-2xl shadow-xl shadow-brand-600/20 hover:shadow-brand-600/35 hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-3 group" type="submit">
                        إنشاء الحساب
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </button>

                    <div class="flex items-center justify-center gap-2">
                        <span class="text-slate-400 text-sm">لديك حساب بالفعل؟</span>
                        <a class="text-brand-400 font-bold text-sm hover:text-brand-300 hover:underline decoration-2 underline-offset-4 transition-all duration-200" href="{{ route('login') }}">
                            تسجيل الدخول
                        </a>
                    </div>
                </div>
            </form>

            <!-- فوتر البطاقة -->
            <footer class="mt-auto pt-8 flex items-center justify-between border-t border-borderLight/40">
                <p class="text-[10px] text-slate-500 font-medium tracking-widest uppercase font-latin">Smart Learn © {{ date('Y') }}</p>
                <div class="flex gap-4">
                    <a class="text-[10px] text-slate-500 hover:text-slate-300 transition-colors duration-200" href="#">شروط الاستخدام</a>
                    <a class="text-[10px] text-slate-500 hover:text-slate-300 transition-colors duration-200" href="#">سياسة الخصوصية</a>
                </div>
            </footer>
        </div>
    </main>

    <!-- النصوص البرمجية للـ JavaScript الديناميكي الخاص بالواجهة -->
    <script>
        // إظهار وإخفاء كلمة المرور باستخدام الـ SVG
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const iconSvg = document.getElementById('toggle-icon-svg');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // تغيير رمز الـ SVG ليكون عين مغلقة
                iconSvg.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                `;
            } else {
                passwordInput.type = 'password';
                // إعادة رمز الـ SVG للعين المفتوحة
                iconSvg.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }

        // تبديل حالة الحساب (طالب / أستاذ) وتعديل الكلاسات ديناميكياً لتطابق ألوان العلامة التجارية الجديدة
        function setRole(role) {
            const roleInput = document.getElementById('role_input');
            const btnStudent = document.getElementById('btn_student');
            const btnTeacher = document.getElementById('btn_teacher');
            const majorContainer = document.getElementById('major_container');
            const majorInput = document.getElementById('major_input');

            // تحديث قيمة حقل الإدخال الخفي لـ Laravel
            roleInput.value = role;

            // كلاسات الأزرار النشطة والغير نشطة المحدّثة للوحة الألوان الجديدة
            const activeClasses = 'font-bold bg-gradient-to-r from-brand-600 to-indigo-600 text-white shadow-lg shadow-brand-600/20'.split(' ');
            const inactiveClasses = 'font-medium text-slate-400 hover:text-slate-200 bg-transparent shadow-none'.split(' ');

            if (role === 'student') {
                btnStudent.classList.add(...activeClasses);
                btnStudent.classList.remove(...inactiveClasses);
                btnTeacher.classList.add(...inactiveClasses);
                btnTeacher.classList.remove(...activeClasses);

                // إظهار التخصص وإعداد كحقل مطلوب
                majorContainer.classList.remove('hidden');
                majorInput.required = true;
            } else {
                btnTeacher.classList.add(...activeClasses);
                btnTeacher.classList.remove(...inactiveClasses);
                btnStudent.classList.add(...inactiveClasses);
                btnStudent.classList.remove(...activeClasses);

                // إخفاء حقل التخصص وتفريغه
                majorContainer.classList.add('hidden');
                majorInput.required = false;
                majorInput.value = '';
            }
        }

        // تشغيل التهيئة المبدئية عند اكتمال تحميل عناصر الصفحة لتأمين القيم السابقة (old)
        document.addEventListener("DOMContentLoaded", function() {
            setRole(document.getElementById('role_input').value);
        });
    </script>
</body>
</html>
