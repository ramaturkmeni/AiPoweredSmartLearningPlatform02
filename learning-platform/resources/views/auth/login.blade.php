<!DOCTYPE html>
<html class="dark" dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>تسجيل الدخول - Smart Learn</title>

    <!-- خطوط جوجل المتميزة -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&family=Noto+Kufi+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                        "on-secondary-fixed font-medium": "#2e1500",
                        "secondary-fixed": "#ffdcc1",
                        "inverse-on-surface": "#2f3133",
                        "background": "#0b0f19", /* متوافق مع الصفحة الرئيسية */
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
                        "headline": ["Plus Jakarta Sans", "Noto Kufi Arabic"],
                        "body": ["Inter", "Noto Kufi Arabic"],
                        "label": ["Inter", "Noto Kufi Arabic"]
                    }
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Inter', 'Noto Kufi Arabic', sans-serif;
            background-color: #0b0f19;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .login-gradient-glow {
            background: radial-gradient(circle at 50% 50%, rgba(185, 195, 255, 0.04) 0%, transparent 70%);
        }
        .glass-card {
            background: rgba(17, 24, 39, 0.45);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }
    </style>
</head>
<body class="bg-[#0b0f19] text-on-background min-h-screen flex flex-col justify-center items-center p-4 relative overflow-hidden">

    <!-- الخلفيات الهندسية المضيئة -->
    <div class="absolute inset-0 login-gradient-glow pointer-events-none"></div>
    <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-primary-container/5 blur-[130px] rounded-full"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-tertiary-container/3 blur-[120px] rounded-full"></div>

    <!-- حاوية تسجيل الدخول الرئيسية -->
    <main class="w-full max-w-[440px] z-10">

        <!-- الشعار والهوية البصرية -->
        <a href="{{ route('home') }}" class="flex flex-col items-center mb-8 text-center group transition-all duration-300">
            <div class="mb-4 bg-gradient-to-tr from-primary-container to-primary/80 p-3.5 rounded-2xl shadow-xl shadow-primary/20 transition-transform duration-500 group-hover:scale-105">
                <span class="material-symbols-outlined text-3xl text-white">school</span>
            </div>
            <h1 class="text-3xl font-black font-headline tracking-tight text-white transition-colors group-hover:text-primary-fixed-dim">Smart Learn</h1>
            <p class="text-on-surface-variant mt-2 text-sm tracking-wide">بوابة المعرفة الذكية للمستقبل</p>
        </a>

        <!-- كارت تسجيل الدخول المطور (Glass Card) -->
        <div class="glass-card rounded-2xl p-8 md:p-10 shadow-2xl relative overflow-hidden transition-all duration-300 hover:border-primary/20">
            <!-- خط إضاءة زخرفي بالأعلى -->
            <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-primary/40 to-transparent"></div>

            <div class="flex flex-col gap-6">
                <!-- نموذج تسجيل الدخول الخاص بـ Laravel -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- حقل اسم المستخدم -->
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-on-surface-variant/85 uppercase tracking-widest block mr-1" for="username">اسم المستخدم</label>
                        <div class="relative group rounded-xl border border-white/5 bg-slate-950/40 transition-all duration-300 focus-within:border-primary/50 focus-within:ring-4 focus-within:ring-primary/10">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-on-surface-variant/70 group-focus-within:text-primary transition-colors">person</span>
                            </div>
                            <input name="username" value="{{ old('username') }}" class="w-full bg-transparent border-none text-on-surface py-3.5 pr-12 pl-4 rounded-xl focus:ring-0 placeholder:text-outline/40 text-sm transition-all" id="username" placeholder="أدخل اسم المستخدم" type="text" required autofocus/>
                        </div>
                        @error('username')
                            <p class="text-error text-xs font-semibold mt-1 mr-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- حقل كلمة المرور -->
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-on-surface-variant/85 uppercase tracking-widest block mr-1" for="password">كلمة المرور</label>
                        <div class="relative group rounded-xl border border-white/5 bg-slate-950/40 transition-all duration-300 focus-within:border-primary/50 focus-within:ring-4 focus-within:ring-primary/10">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-on-surface-variant/70 group-focus-within:text-primary transition-colors">lock</span>
                            </div>
                            <input name="password" class="w-full bg-transparent border-none text-on-surface py-3.5 pr-12 pl-12 rounded-xl focus:ring-0 placeholder:text-outline/40 text-sm transition-all" id="password" placeholder="••••••••" type="password" required/>

                            <!-- زر إظهار وإخفاء كلمة المرور التفاعلي -->
                            <button onclick="togglePassword()" class="absolute inset-y-0 left-0 pl-4 flex items-center text-on-surface-variant/70 hover:text-white transition-colors" type="button">
                                <span id="toggle-icon" class="material-symbols-outlined text-[19px]">visibility</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-error text-xs font-semibold mt-1 mr-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- خيارات التذكر واستعادة الحساب -->
                    <div class="flex items-center justify-between pt-1">
                        <div class="flex items-center gap-2.5">
                            <input name="remember" class="w-4 h-4 bg-slate-950 border-white/10 rounded text-primary focus:ring-primary/30 focus:ring-offset-background transition-all" id="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}/>
                            <label class="text-xs font-semibold text-on-surface-variant/95 cursor-pointer select-none" for="remember">تذكرني</label>
                        </div>
                        <a class="text-xs font-bold text-primary hover:text-primary-fixed-dim transition-colors" href="#">نسيت كلمة المرور؟</a>
                    </div>

                    <!-- زر تسجيل الدخول الأساسي المطور -->
                    <button class="w-full bg-gradient-to-r from-primary to-primary-container text-white font-bold py-3.5 rounded-xl shadow-lg shadow-primary/15 hover:shadow-primary/25 hover:-translate-y-0.5 active:scale-95 transition-all duration-300 flex items-center justify-center gap-2 group mt-6" type="submit">
                        <span class="material-symbols-outlined text-[20px] transition-transform duration-300 group-hover:translate-x-1">login</span>
                        تسجيل الدخول
                    </button>
                </form>

                <!-- فاصل خيارات التسجيل الأخرى -->
                <div class="relative py-2">
                    <div class="absolute inset-0 flex items-center"><span class="w-full border-t border-white/5"></span></div>
                    <div class="relative flex justify-center text-xs uppercase"><span class="bg-[#12141c]/90 px-4 text-on-surface-variant/60 font-semibold tracking-widest">أو</span></div>
                </div>

                <!-- رابط إنشاء حساب جديد -->
                <div class="text-center">
                    <p class="text-on-surface-variant/80 text-xs sm:text-sm">
                        ليس لديك حساب؟
                        <a class="text-secondary font-extrabold hover:underline underline-offset-4 transition-all" href="{{ route('register') }}">سجّل الآن</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- التذييل والمعلومات السفلى للأنظمة -->
        <footer class="mt-8 flex flex-col items-center gap-4">
            <div class="flex items-center gap-6">
                <a class="text-xs text-on-surface-variant/50 hover:text-white transition-colors" href="#">سياسة الخصوصية</a>
                <a class="text-xs text-on-surface-variant/50 hover:text-white transition-colors" href="#">شروط الخدمة</a>
                <a class="text-xs text-on-surface-variant/50 hover:text-white transition-colors" href="#">الدعم الفني</a>
            </div>

            <div class="flex items-center gap-2.5 bg-slate-900/60 px-4 py-2 rounded-full border border-white/5 shadow-inner">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-success opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-success"></span>
                </span>
                <span class="text-[10px] text-on-surface-variant/90 font-bold tracking-wide">جميع الأنظمة تعمل بشكل مثالي</span>
            </div>
        </footer>
    </main>

    <!-- البطاقة الجانبية المبتكرة للشاشات الكبيرة (Desktop Side Card) -->
    <div class="hidden lg:block fixed left-12 top-1/2 -translate-y-1/2 max-w-sm z-20">
        <div class="glass-card p-8 rounded-2xl border border-white/10 space-y-5 shadow-2xl relative overflow-hidden transition-all duration-300 hover:border-primary/25">
            <div class="absolute -top-10 -left-10 w-32 h-32 bg-tertiary-container/5 rounded-full blur-2xl"></div>

            <span class="material-symbols-outlined text-tertiary-fixed-dim text-4xl" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
            <h2 class="text-2xl font-bold font-headline text-white leading-snug">رحلة تعلم استثنائية معززة بالذكاء الاصطناعي</h2>
            <p class="text-on-surface-variant text-xs sm:text-sm leading-relaxed font-normal">
                انضم إلى آلاف الطلاب الذين يستخدمون منصة Smart Learn لتسريع التحصيل المعرفي وبناء الاختبارات والملخصات التفاعلية الفورية في ثوانٍ.
            </p>
            <div class="flex -space-x-2.5 space-x-reverse pt-2">
                <img class="w-9 h-9 object-cover rounded-full border-2 border-[#121416]" alt="Student" src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?q=80&w=150&auto=format&fit=crop"/>
                <img class="w-9 h-9 object-cover rounded-full border-2 border-[#121416]" alt="Student" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=150&auto=format&fit=crop"/>
                <img class="w-9 h-9 object-cover rounded-full border-2 border-[#121416]" alt="Student" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=150&auto=format&fit=crop"/>
                <div class="w-9 h-9 rounded-full border-2 border-[#121416] bg-slate-900 flex items-center justify-center text-[10px] font-bold text-white">+99</div>
            </div>
        </div>
    </div>

    <!-- كود الجافا سكريبت الأصلي للتحكم بظهور كلمة المرور -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('toggle-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>
