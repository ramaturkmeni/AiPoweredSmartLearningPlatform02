<!DOCTYPE html>
<html class="dark" dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Smart Learn - إنشاء حساب جديد</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-background": "#e2e2e5",
                        "surface-container-high": "#282a2c",
                        "on-surface-variant": "#c4c5d7",
                        "secondary": "#ffb778",
                        "primary-fixed": "#dde1ff",
                        "error-container": "#93000a",
                        "on-primary-fixed-variant": "#0034c0",
                        "on-surface": "#e2e2e5",
                        "on-secondary": "#4c2700",
                        "outline-variant": "#444654",
                        "surface-variant": "#333537",
                        "on-primary-fixed": "#001257",
                        "inverse-surface": "#e2e2e5",
                        "outline": "#8e90a0",
                        "secondary-container": "#fd9000",
                        "surface-container-lowest": "#0c0e10",
                        "surface-container-low": "#1a1c1e",
                        "surface-tint": "#b9c3ff",
                        "primary": "#b9c3ff",
                        "primary-container": "#6e88ff",
                        "on-primary-fixed": "#001257",
                        "background": "#121416",
                        "error": "#ffb4ab",
                        "secondary-fixed-dim": "#ffb778",
                        "tertiary": "#f9abff",
                        "tertiary-container": "#d560e6"
                    },
                    fontFamily: {
                        "headline": ["Plus Jakarta Sans"],
                        "body": ["Inter"],
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #121416; }
        .font-plus-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .prism-glow:focus-within {
            box-shadow: 0 4px 20px -5px rgba(185, 195, 255, 0.2);
            backdrop-filter: saturate(150%) brightness(110%);
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #121416; }
        ::-webkit-scrollbar-thumb { background: #333537; border-radius: 10px; }
    </style>
</head>
<body class="bg-background text-on-background antialiased overflow-x-hidden min-h-screen flex items-center justify-center p-4">

    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -right-[10%] w-[50%] h-[50%] bg-primary/5 blur-[120px] rounded-full"></div>
        <div class="absolute -bottom-[10%] -left-[10%] w-[40%] h-[40%] bg-tertiary/5 blur-[120px] rounded-full"></div>
    </div>

    <main class="relative w-full max-w-5xl grid grid-cols-1 lg:grid-cols-12 gap-0 bg-surface-container-low rounded-3xl overflow-hidden shadow-2xl shadow-black/50 border border-outline-variant/10 my-8">

        <!-- Brand & Visual Side -->
        <div class="hidden lg:flex lg:col-span-5 relative flex-col justify-between p-12 bg-surface-container-lowest overflow-hidden">
            <div class="relative z-10">
                <a href="{{ route('home') }}" class="flex items-center gap-3 mb-12 hover:opacity-80 transition-opacity">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary-container rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-primary-fixed font-bold">school</span>
                    </div>
                    <h1 class="text-2xl font-black font-plus-jakarta tracking-tight text-primary">Smart Learn</h1>
                </a>
                <h2 class="text-4xl font-bold font-plus-jakarta leading-tight mb-6 text-on-surface">
                    ابدأ رحلتك التعليمية <br/> <span class="text-secondary">في المنصة الأذكى</span>
                </h2>
                <p class="text-on-surface-variant text-lg leading-relaxed max-w-sm">
                    انضم إلى آلاف الطلاب والأساتذة في بيئة تعليمية متطورة تعتمد على الذكاء الاصطناعي لتطوير مهاراتك.
                </p>
            </div>
            <div class="relative z-10">
                <div class="flex flex-col gap-6">
                    <div class="flex items-center gap-4 bg-surface-container p-4 rounded-2xl border border-outline-variant/5">
                        <div class="w-12 h-12 rounded-full bg-tertiary/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-tertiary" style="font-variation-settings: 'FILL' 1;">psychology</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-on-surface">دروس مدعومة بالذكاء الاصطناعي</p>
                            <p class="text-xs text-on-surface-variant">تحليلات دقيقة لمستوى تقدمك الدراسي</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Background Image -->
            <div class="absolute inset-0 opacity-20 pointer-events-none">
                <img class="w-full h-full object-cover grayscale contrast-125" alt="Library" src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=800&auto=format&fit=crop"/>
                <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-transparent to-transparent"></div>
            </div>
        </div>

        <!-- Form Side -->
        <div class="lg:col-span-7 p-8 lg:p-16 flex flex-col">
            <!-- Mobile Logo -->
            <div class="lg:hidden flex items-center gap-3 mb-8">
                <div class="w-8 h-8 bg-gradient-to-br from-primary to-primary-container rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-primary-fixed text-sm font-bold">school</span>
                </div>
                <h1 class="text-xl font-black font-plus-jakarta tracking-tight text-primary">Smart Learn</h1>
            </div>

            <header class="mb-10">
                <h3 class="text-2xl font-bold font-plus-jakarta text-on-surface mb-2">إنشاء حساب جديد</h3>
                <p class="text-on-surface-variant">قم بملء البيانات التالية لتتمكن من الوصول إلى المنصة</p>
            </header>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- الحقل الخفي لتحديد نوع المستخدم -->
                <input type="hidden" name="role" id="role_input" value="{{ old('role', 'student') }}">

                <!-- User Type Toggle -->
                <div class="flex p-1 bg-surface-container-lowest rounded-2xl w-full max-w-xs border border-outline-variant/10 relative">
                    <button id="btn_student" onclick="setRole('student')" class="flex-1 py-2 text-sm font-bold rounded-xl bg-gradient-to-br from-primary to-primary-container text-on-primary-fixed shadow-lg transition-all duration-300 z-10" type="button">
                        طالب
                    </button>
                    <button id="btn_teacher" onclick="setRole('teacher')" class="flex-1 py-2 text-sm font-medium rounded-xl text-on-surface-variant hover:text-on-surface transition-all z-10" type="button">
                        أستاذ
                    </button>
                </div>

                <!-- Fields Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">

                    <!-- First Name -->
                    <div class="space-y-1.5 prism-glow">
                        <label class="text-xs font-bold text-on-surface-variant mr-1">الاسم الأول</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-outline"><span class="material-symbols-outlined">person</span></span>
                            <input name="first_name" value="{{ old('first_name') }}" class="w-full bg-surface-container-lowest border-none focus:ring-0 rounded-2xl py-3 pr-12 pl-4 text-on-surface transition-all border-b-2 border-transparent focus:border-primary" placeholder="أدخل اسمك الأول" type="text" required/>
                        </div>
                        @error('first_name') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="space-y-1.5 prism-glow">
                        <label class="text-xs font-bold text-on-surface-variant mr-1">الاسم الأخير</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-outline"><span class="material-symbols-outlined">badge</span></span>
                            <input name="last_name" value="{{ old('last_name') }}" class="w-full bg-surface-container-lowest border-none focus:ring-0 rounded-2xl py-3 pr-12 pl-4 text-on-surface transition-all border-b-2 border-transparent focus:border-primary" placeholder="أدخل اسم العائلة" type="text" required/>
                        </div>
                        @error('last_name') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    <!-- Username -->
                    <div class="space-y-1.5 prism-glow">
                        <label class="text-xs font-bold text-on-surface-variant mr-1">اسم المستخدم</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-outline"><span class="material-symbols-outlined">alternate_email</span></span>
                            <input name="username" value="{{ old('username') }}" class="w-full bg-surface-container-lowest border-none focus:ring-0 rounded-2xl py-3 pr-12 pl-4 text-on-surface text-right transition-all border-b-2 border-transparent focus:border-primary" dir="ltr" placeholder="user123" type="text" required/>
                        </div>
                        @error('username') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-1.5 prism-glow">
                        <label class="text-xs font-bold text-on-surface-variant mr-1">البريد الإلكتروني</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-outline"><span class="material-symbols-outlined">mail</span></span>
                            <input name="email" value="{{ old('email') }}" class="w-full bg-surface-container-lowest border-none focus:ring-0 rounded-2xl py-3 pr-12 pl-4 text-on-surface text-right transition-all border-b-2 border-transparent focus:border-primary" dir="ltr" placeholder="example@mail.com" type="email" required/>
                        </div>
                        @error('email') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    <!-- Phone -->
                    <div class="space-y-1.5 prism-glow">
                        <label class="text-xs font-bold text-on-surface-variant mr-1">رقم الهاتف</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-outline"><span class="material-symbols-outlined">call</span></span>
                            <input name="phone" value="{{ old('phone') }}" class="w-full bg-surface-container-lowest border-none focus:ring-0 rounded-2xl py-3 pr-12 pl-4 text-on-surface text-right transition-all border-b-2 border-transparent focus:border-primary" dir="ltr" placeholder="05XXXXXXXX" type="tel" required/>
                        </div>
                        @error('phone') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    <!-- City -->
                    <div class="space-y-1.5 prism-glow">
                        <label class="text-xs font-bold text-on-surface-variant mr-1">المدينة (مكان الإقامة)</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-outline"><span class="material-symbols-outlined">location_on</span></span>
                            <input name="location" value="{{ old('location') }}" class="w-full bg-surface-container-lowest border-none focus:ring-0 rounded-2xl py-3 pr-12 pl-4 text-on-surface transition-all border-b-2 border-transparent focus:border-primary" placeholder="مثال: الرياض" type="text" required/>
                        </div>
                        @error('location') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    <!-- Gender -->
                    <div class="space-y-1.5 prism-glow">
                        <label class="text-xs font-bold text-on-surface-variant mr-1">الجنس</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-outline"><span class="material-symbols-outlined">wc</span></span>
                            <select name="gender" class="w-full bg-surface-container-lowest border-none focus:ring-0 rounded-2xl py-3 pr-12 pl-4 text-on-surface appearance-none transition-all border-b-2 border-transparent focus:border-primary" required>
                                <option disabled selected value="">اختر الجنس</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                            </select>
                            <span class="absolute inset-y-0 left-4 flex items-center text-outline"><span class="material-symbols-outlined">expand_more</span></span>
                        </div>
                        @error('gender') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    <!-- Major (Dynamic - For Students Only) -->
                    <div id="major_container" class="space-y-1.5 prism-glow {{ old('role', 'student') == 'teacher' ? 'hidden' : '' }}">
                        <label class="text-xs font-bold text-on-surface-variant mr-1">التخصص الدراسي</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-outline"><span class="material-symbols-outlined">school</span></span>
                            <input name="major" id="major_input" value="{{ old('major') }}" class="w-full bg-surface-container-lowest border-none focus:ring-0 rounded-2xl py-3 pr-12 pl-4 text-on-surface transition-all border-b-2 border-transparent focus:border-primary" placeholder="مثال: هندسة برمجيات" type="text"/>
                        </div>
                        @error('major') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password -->
                    <div class="md:col-span-2 space-y-1.5 prism-glow">
                        <label class="text-xs font-bold text-on-surface-variant mr-1">كلمة المرور</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 right-4 flex items-center text-outline"><span class="material-symbols-outlined">lock</span></span>
                            <input name="password" id="password" class="w-full bg-surface-container-lowest border-none focus:ring-0 rounded-2xl py-3 pr-12 pl-12 text-on-surface text-right transition-all border-b-2 border-transparent focus:border-primary" dir="ltr" placeholder="••••••••" type="password" required/>
                            <span onclick="togglePassword()" class="absolute inset-y-0 left-4 flex items-center text-outline cursor-pointer hover:text-primary transition-colors">
                                <span id="toggle-icon" class="material-symbols-outlined">visibility</span>
                            </span>
                        </div>
                        @error('password') <p class="text-error text-xs">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 flex flex-col gap-6">
                    <button class="w-full py-4 bg-gradient-to-br from-primary to-primary-container text-on-primary-fixed font-bold text-lg rounded-2xl shadow-xl shadow-primary/10 hover:shadow-primary/20 active:scale-[0.98] transition-all flex items-center justify-center gap-3 group" type="submit">
                        إنشاء الحساب
                        <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    </button>

                    <div class="flex items-center justify-center gap-2">
                        <span class="text-on-surface-variant text-sm">لديك حساب بالفعل؟</span>
                        <a class="text-primary font-bold text-sm hover:underline decoration-2 underline-offset-4 transition-all" href="{{ route('login') }}">
                            تسجيل الدخول
                        </a>
                    </div>
                </div>
            </form>

            <footer class="mt-auto pt-10 flex items-center justify-between border-t border-outline-variant/10">
                <p class="text-[10px] text-outline font-medium tracking-widest uppercase">Smart Learn © {{ date('Y') }}</p>
                <div class="flex gap-4">
                    <a class="text-[10px] text-outline hover:text-on-surface transition-colors" href="#">شروط الاستخدام</a>
                    <a class="text-[10px] text-outline hover:text-on-surface transition-colors" href="#">سياسة الخصوصية</a>
                </div>
            </footer>
        </div>
    </main>

    <!-- Scripts for dynamic UI -->
    <script>
        // دالة إظهار وإخفاء كلمة المرور
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

        // دالة تغيير نوع الحساب (طالب / أستاذ)
        function setRole(role) {
            const roleInput = document.getElementById('role_input');
            const btnStudent = document.getElementById('btn_student');
            const btnTeacher = document.getElementById('btn_teacher');
            const majorContainer = document.getElementById('major_container');
            const majorInput = document.getElementById('major_input');

            // تحديث الحقل الخفي
            roleInput.value = role;

            // تنسيق الأزرار
            const activeClasses = 'font-bold bg-gradient-to-br from-primary to-primary-container text-on-primary-fixed shadow-lg'.split(' ');
            const inactiveClasses = 'font-medium text-on-surface-variant hover:text-on-surface bg-transparent shadow-none'.split(' ');

            if (role === 'student') {
                btnStudent.classList.add(...activeClasses);
                btnStudent.classList.remove(...inactiveClasses);
                btnTeacher.classList.add(...inactiveClasses);
                btnTeacher.classList.remove(...activeClasses);

                // إظهار حقل التخصص وجعله مطلوباً
                majorContainer.classList.remove('hidden');
                majorInput.required = true;
            } else {
                btnTeacher.classList.add(...activeClasses);
                btnTeacher.classList.remove(...inactiveClasses);
                btnStudent.classList.add(...inactiveClasses);
                btnStudent.classList.remove(...activeClasses);

                // إخفاء حقل التخصص
                majorContainer.classList.add('hidden');
                majorInput.required = false;
                majorInput.value = ''; // تفريغ الحقل
            }
        }

        // تشغيل الدالة عند تحميل الصفحة للتأكد من الحالة (في حال عودة المستخدم بعد وجود خطأ في الفورم)
        document.addEventListener("DOMContentLoaded", function() {
            setRole(document.getElementById('role_input').value);
        });
    </script>
</body>
</html>
