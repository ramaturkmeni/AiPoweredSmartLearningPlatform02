<!DOCTYPE html>
<html class="dark" dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>تسجيل الدخول - Smart Learn</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&family=Noto+Kufi+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

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
                        "success": "#10b981" // تمت الإضافة ليظهر المؤشر الأخضر
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
            background-color: #121416;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .login-gradient-glow {
            background: radial-gradient(circle at 50% 50%, rgba(185, 195, 255, 0.08) 0%, transparent 70%);
        }
        .input-focus-border:focus-within {
            border-bottom: 2px solid #b9c3ff;
        }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen flex flex-col justify-center items-center p-4 relative overflow-hidden">

    <!-- Background Elements -->
    <div class="absolute inset-0 login-gradient-glow pointer-events-none"></div>
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary-container/10 blur-[120px] rounded-full"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[30%] h-[30%] bg-tertiary-container/5 blur-[100px] rounded-full"></div>

    <!-- Main Login Shell -->
    <main class="w-full max-w-[440px] z-10">

        <!-- Logo Section -->
        <a href="{{ route('home') }}" class="flex flex-col items-center mb-10 text-center hover:opacity-80 transition-opacity">
            <div class="mb-4 bg-primary-container p-4 rounded-xl shadow-2xl shadow-primary/20">
                <span class="material-symbols-outlined text-4xl text-on-primary-container">school</span>
            </div>
            <h1 class="text-3xl font-black font-headline tracking-tight text-primary">Smart Learn</h1>
            <p class="text-on-surface-variant mt-2 text-sm">بوابة المعرفة الذكية للمستقبل</p>
        </a>

        <!-- Login Card -->
        <div class="bg-surface-container-low rounded-xl p-8 md:p-10 shadow-2xl relative overflow-hidden">
            <!-- Decorative Header Gradient -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-primary to-transparent opacity-30"></div>

            <div class="flex flex-col gap-6">
                <!-- Laravel Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Username Field -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-widest block mr-1" for="username">اسم المستخدم</label>
                        <div class="relative group input-focus-border">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-on-surface-variant group-focus-within:text-primary transition-colors">person</span>
                            </div>
                            <input name="username" value="{{ old('username') }}" class="w-full bg-surface-container-lowest border-none text-on-surface py-4 pr-12 pl-4 rounded-xl focus:ring-0 placeholder:text-outline/50 transition-all" id="username" placeholder="أدخل اسم المستخدم" type="text" required autofocus/>
                        </div>
                        @error('username')
                            <p class="text-error text-xs font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-on-surface-variant uppercase tracking-widest block mr-1" for="password">كلمة المرور</label>
                        <div class="relative group input-focus-border">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-on-surface-variant group-focus-within:text-primary transition-colors">lock</span>
                            </div>
                            <input name="password" class="w-full bg-surface-container-lowest border-none text-on-surface py-4 pr-12 pl-12 rounded-xl focus:ring-0 placeholder:text-outline/50 transition-all" id="password" placeholder="••••••••" type="password" required/>

                            <!-- Toggle Password Button -->
                            <button onclick="togglePassword()" class="absolute inset-y-0 left-0 pl-4 flex items-center text-on-surface-variant hover:text-on-surface" type="button">
                                <span id="toggle-icon" class="material-symbols-outlined text-sm">visibility</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-error text-xs font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <input name="remember" class="w-4 h-4 bg-surface-container-lowest border-outline-variant rounded text-primary focus:ring-primary focus:ring-offset-surface" id="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}/>
                            <label class="text-sm text-on-surface-variant cursor-pointer" for="remember">تذكرني</label>
                        </div>
                        <a class="text-sm font-medium text-primary hover:text-primary-fixed-dim transition-colors" href="#">نسيت كلمة المرور؟</a>
                    </div>

                    <button class="w-full bg-gradient-to-br from-primary to-primary-container text-on-primary-fixed font-bold py-4 rounded-xl shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 group" type="submit">
                        <span class="material-symbols-outlined">login</span>
                        تسجيل الدخول
                    </button>
                </form>

                <!-- Social/Other Methods Separator -->
                <div class="relative py-2">
                    <div class="absolute inset-0 flex items-center"><span class="w-full border-t border-outline-variant/30"></span></div>
                    <div class="relative flex justify-center text-xs uppercase"><span class="bg-surface-container-low px-4 text-on-surface-variant font-medium tracking-widest">أو</span></div>
                </div>

                <!-- Registration Link -->
                <div class="text-center">
                    <p class="text-on-surface-variant text-sm">
                        ليس لديك حساب؟
                        <a class="text-secondary font-bold hover:underline underline-offset-4 transition-all" href="{{ route('register') }}">سجّل الآن</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Text -->
        <footer class="mt-8 flex flex-col items-center gap-4">
            <div class="flex items-center gap-6">
                <a class="text-xs text-on-surface-variant/60 hover:text-on-surface transition-colors" href="#">سياسة الخصوصية</a>
                <a class="text-xs text-on-surface-variant/60 hover:text-on-surface transition-colors" href="#">شروط الخدمة</a>
                <a class="text-xs text-on-surface-variant/60 hover:text-on-surface transition-colors" href="#">الدعم الفني</a>
            </div>
            <div class="flex items-center gap-2 bg-surface-container-high/40 px-3 py-1.5 rounded-full border border-outline-variant/10">
                <span class="w-2 h-2 rounded-full bg-success"></span>
                <span class="text-[10px] text-on-surface-variant font-medium">الأنظمة تعمل بشكل مثالي</span>
            </div>
        </footer>
    </main>

    <!-- Side Decoration (Asymmetric Editorial Feel) -->
    <div class="hidden lg:block fixed left-12 top-1/2 -translate-y-1/2 max-w-sm">
        <div class="bg-surface-container/30 backdrop-blur-md p-8 rounded-2xl border border-white/5 space-y-4">
            <span class="material-symbols-outlined text-tertiary-fixed-dim text-5xl" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
            <h2 class="text-2xl font-bold font-headline text-on-surface leading-tight">ابدأ رحلة التعلم المعززة بالذكاء الاصطناعي</h2>
            <p class="text-on-surface-variant leading-relaxed text-sm">
                انضم إلى آلاف الطلاب الذين يستخدمون منصة Smart Learn لتسريع عملية التعلم من خلال مسارات تعليمية مخصصة وتقييمات ذكية.
            </p>
            <div class="flex -space-x-3 space-x-reverse pt-2">
                <img class="w-10 h-10 object-cover rounded-full border-2 border-surface" alt="Student" src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?q=80&w=150&auto=format&fit=crop"/>
                <img class="w-10 h-10 object-cover rounded-full border-2 border-surface" alt="Student" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=150&auto=format&fit=crop"/>
                <img class="w-10 h-10 object-cover rounded-full border-2 border-surface" alt="Student" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=150&auto=format&fit=crop"/>
                <div class="w-10 h-10 rounded-full border-2 border-surface bg-surface-container-highest flex items-center justify-center text-[10px] font-bold text-white">+99</div>
            </div>
        </div>
    </div>

    <!-- Script to toggle password visibility -->
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
