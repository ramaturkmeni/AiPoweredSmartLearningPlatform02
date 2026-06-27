<!DOCTYPE html>
<html class="dark scroll-smooth" dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Smart Learn - مستقبل التعليم الذكي</title>

    <!-- جلب خط Tajawal للغة العربية و Plus Jakarta Sans للأرقام واللاتينية -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>

    <!-- Tailwind CSS CDN مع تفعيل الإضافات المطلوبة -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- استدعاء ملف Spline Viewer لتشغيل المشهد ثلاثي الأبعاد -->
    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.54/build/spline-viewer.js"></script>

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
    </style>
</head>
<body class="bg-darkbg text-slate-100 selection:bg-brand-500 selection:text-white">

<!-- خلفية تجميلية متدرجة ثابتة -->
<div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none opacity-35">
    <div class="absolute -top-[40%] start-[20%] w-[600px] h-[600px] rounded-full bg-brand-600/20 blur-[130px]"></div>
    <div class="absolute top-[60%] end-[10%] w-[400px] h-[400px] rounded-full bg-indigo-500/15 blur-[100px]"></div>
</div>

<!-- شريط التنقل العلوي -->
<nav class="fixed top-0 inset-x-0 z-50 bg-darkbg/70 backdrop-blur-xl border-b border-borderLight/60 h-20 transition-all duration-300">
    <div class="flex items-center justify-between px-6 lg:px-12 h-full max-w-7xl mx-auto w-full">
        <!-- الشعار -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-indigo-400 flex items-center justify-center shadow-lg shadow-brand-500/20">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <span class="text-xl font-bold font-latin tracking-tight bg-clip-text text-transparent bg-gradient-to-l from-slate-100 to-indigo-300">
                Smart Learn
            </span>
        </div>

        <!-- الروابط الأساسية -->
        <div class="hidden md:flex items-center gap-8">
            <a class="text-brand-400 font-medium text-sm transition-colors duration-200" href="#">الرئيسية</a>
            <a class="text-slate-400 hover:text-slate-200 font-medium text-sm transition-colors duration-200" href="#features">المميزات</a>
            <a class="text-slate-400 hover:text-slate-200 font-medium text-sm transition-colors duration-200" href="{{ route('login') }}">منصة الطلاب</a>
        </div>

        <!-- أزرار الإجراءات -->
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="hidden sm:block text-slate-400 hover:text-slate-100 font-medium text-sm transition-colors duration-200">
                تسجيل الدخول
            </a>
            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-brand-600/20 transition-all duration-300 hover:shadow-brand-600/30 hover:-translate-y-0.5">
                ابدأ الآن
            </a>
        </div>
    </div>
</nav>

<main class="pt-20">
    <!-- قسم الهيرو (Hero Section) -->
    <section class="relative py-12 lg:py-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                <!-- المحتوى النصي -->
                <div class="lg:col-span-6 text-right space-y-6">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-brand-950/80 border border-brand-800/60 rounded-full text-brand-300 text-xs font-semibold">
                        <svg class="w-4 h-4 text-indigo-400 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>مدعوم بأحدث تقنيات الذكاء الاصطناعي </span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-100 leading-[1.25] tracking-tight">
                        مستقبل التعلم الذكي
                        <span class="text-transparent bg-clip-text bg-gradient-to-l from-brand-400 via-indigo-300 to-indigo-200">
                             بين يديك اليوم
                        </span>
                    </h1>

                    <p class="text-slate-400 text-base sm:text-lg max-w-2xl leading-relaxed">
                        اختبر تجربة تعليمية فريدة تعتمد على تحليل البيانات والذكاء الاصطناعي لتخصيص مسارك الدراسي وتحويل محاضراتك إلى ملخصات واختبارات تفاعلية في ثوانٍ معدودة.
                    </p>

                    <div class="pt-4 flex flex-wrap gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-500 hover:to-indigo-500 text-white rounded-xl text-base font-bold shadow-xl shadow-brand-600/20 hover:shadow-brand-600/30 transition-all duration-300 hover:-translate-y-0.5 text-center">
                            ابدأ رحلتك مجاناً
                        </a>
                    </div>
                </div>

                <!-- الجانب البصري (عرض الروبوت عائماً ومدمجاً بالكامل مع الخلفية) -->
                <div class="lg:col-span-6 relative">
                    <div class="relative w-full h-[350px] sm:h-[450px] lg:h-[550px] overflow-hidden group">
                        <!-- استدعاء ويدجيت Spline مع إزالة أي أنماط خلفية مخصصة -->
                        <spline-viewer
                            id="robot-viewer"
                            class="absolute inset-0 w-full h-full object-cover z-10 bg-transparent"
                            url="https://prod.spline.design/LABvgoZi-kfzKtTo/scene.splinecode">
                        </spline-viewer>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- قسم شبكة المميزات (Bento Grid) -->
    <section id="features" class="py-24 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <!-- رأس القسم -->
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-slate-100">
                    مميزات صُممت لنجاحك الدراسي
                </h2>
                <p class="text-slate-400 text-base leading-relaxed">
                    نستخدم تقنيات متقدمة لمعالجة النصوص وتوليد المحتوى لمساعدتك على التعلم بشكل أسرع وأكثر إنتاجية.
                </p>
            </div>

            <!-- شبكة المميزات -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- الميزة الأولى: اختبارات ذكية -->
                <div class="md:col-span-7 bg-surfaceCard/55 hover:bg-surfaceCard/85 border border-borderLight/80 hover:border-brand-500/30 rounded-2xl p-8 transition-all duration-300 relative group flex flex-col justify-between overflow-hidden shadow-sm">
                    <div class="absolute -top-12 -start-12 w-40 h-40 bg-brand-500/5 rounded-full blur-2xl group-hover:bg-brand-500/10 transition-colors duration-300"></div>

                    <div class="relative z-10 space-y-6">
                        <div class="w-12 h-12 bg-brand-500/10 border border-brand-500/20 rounded-xl flex items-center justify-center text-brand-400 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="space-y-3">
                            <h3 class="text-xl font-bold text-slate-100">اختبارات ذكية مخصصة</h3>
                            <p class="text-slate-400 text-sm leading-relaxed max-w-lg">
                                حول أي محاضرة أو ملف PDF أو مقطع فيديو إلى اختبار تفاعلي فوري. يقوم نظامنا الذكي بتحليل المحتوى وتوليد أسئلة دقيقة تقيس مستوى استيعابك للمفاهيم الأساسية.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- الميزة الثانية: تلخيص فوري -->
                <div class="md:col-span-5 bg-surfaceCard/55 hover:bg-surfaceCard/85 border border-borderLight/80 hover:border-indigo-500/30 rounded-2xl p-8 transition-all duration-300 relative group flex flex-col justify-between overflow-hidden shadow-sm">
                    <div class="absolute -top-12 -start-12 w-40 h-40 bg-indigo-500/5 rounded-full blur-2xl group-hover:bg-indigo-500/10 transition-colors duration-300"></div>

                    <div class="relative z-10 space-y-6">
                        <div class="w-12 h-12 bg-indigo-500/10 border border-indigo-500/20 rounded-xl flex items-center justify-center text-indigo-400 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </div>
                        <div class="space-y-3">
                            <h3 class="text-xl font-bold text-slate-100">تلخيص فوري دقيق</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                احصل على جوهر الفائدة من المراجع الطويلة والمقاطع التعليمية الطويلة في ثوانٍ معدودة وبنقاط واضحة ومنظمة.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- قسم الدعوة إلى اتخاذ إجراء (CTA Section) -->
    <section class="py-16 relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-6">
            <div class="relative rounded-3xl overflow-hidden border border-borderLight bg-gradient-to-br from-surfaceCard/80 to-brand-950/20 p-10 md:p-16 text-center shadow-xl">
                <!-- تأثيرات ضوئية خلفية -->
                <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-80 h-80 bg-brand-500/10 blur-[100px] rounded-full"></div>

                <div class="relative z-10 space-y-6 max-w-2xl mx-auto">
                    <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-slate-100">
                        جاهز لرفع مستوى تحصيلك العلمي؟
                    </h2>
                    <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                        انضم إلى أكثر من 50,000 طالب ومعلم يستخدمون سمارت ليرن لتوفير الوقت وزيادة الإنتاجية اليومية.
                    </p>
                    <div class="pt-4">
                        <a href="{{ route('register') }}" class="inline-block px-8 py-3.5 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-xl shadow-lg shadow-brand-600/20 transition-all duration-300 hover:shadow-brand-600/30 hover:-translate-y-0.5">
                            سجل الآن مجاناً
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- التذييل (Footer) -->
<footer class="border-t border-borderLight/80 bg-slate-950/60 py-12">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-6">
        <!-- شعار التذييل -->
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <span class="text-base font-bold font-latin tracking-tight text-slate-300">Smart Learn</span>
        </div>

        <!-- حقوق النشر والنسخ -->
        <div class="text-slate-500 text-xs sm:text-sm font-medium">
            &copy; {{ date('Y') }} سمارت ليرن. جميع الحقوق محفوظة.
        </div>
    </div>
</footer>

<!-- نص برمجى لحذف علامة Spline المائية عند اكتمال تحميل المكون الذكي -->
<script>
    customElements.whenDefined('spline-viewer').then(() => {
        const viewer = document.getElementById('robot-viewer');
        if (viewer && viewer.shadowRoot) {
            const style = document.createElement('style');
            style.textContent = `
                #logo { display: none !important; pointer-events: none !important; opacity: 0 !important; visibility: hidden !important; }
            `;
            viewer.shadowRoot.appendChild(style);
        }
    });
</script>

</body>
</html>
