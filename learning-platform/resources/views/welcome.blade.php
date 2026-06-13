<!DOCTYPE html>
<html class="dark" dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Smart Learn - مستقبل التعليم الذكي</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-fixed": "#dde1ff",
                        "primary-container": "#6e88ff",
                        "background": "#121416",
                        "surface": "#121416",
                        "surface-container-low": "#1a1c1e",
                        "surface-container-high": "#282a2c",
                        "primary": "#b9c3ff",
                        "secondary": "#ffb778",
                        "tertiary": "#f9abff",
                        "on-surface": "#e2e2e5",
                        "on-surface-variant": "#c4c5d7",
                        "outline-variant": "#444654",
                        // ... تم الاحتفاظ بباقي الألوان الأساسية لعمل التصميم
                    },
                    fontFamily: {
                        "plus-jakarta": ["Plus Jakarta Sans"],
                        "inter": ["Inter"]
                    }
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #121416;
            color: #e2e2e5;
            -webkit-font-smoothing: antialiased;
        }
        .font-plus-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-panel {
            background: rgba(51, 53, 55, 0.6);
            backdrop-filter: blur(20px);
        }
        .prism-glow:hover {
            backdrop-filter: saturate(150%) brightness(110%);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background text-on-surface">

<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 bg-slate-950/60 backdrop-blur-xl shadow-[0_20px_40px_rgba(0,0,0,0.4)] h-20">
    <div class="flex flex-row-reverse justify-between items-center px-8 h-full w-full max-w-[1440px] mx-auto">
        <!-- Brand Logo -->
        <div class="text-2xl font-bold tracking-tighter text-blue-400 font-plus-jakarta">
            Smart Learn
        </div>

        <!-- Navigation Links -->
        <div class="hidden md:flex flex-row-reverse gap-8 items-center">
            <a class="text-blue-400 border-b-2 border-blue-400 pb-1 font-plus-jakarta leading-relaxed hover:text-blue-200 transition-colors duration-300" href="#">الرئيسية</a>
            <a class="text-slate-400 font-plus-jakarta leading-relaxed hover:text-blue-200 transition-colors duration-300" href="#features">المميزات</a>
            <a class="text-slate-400 font-plus-jakarta leading-relaxed hover:text-blue-200 transition-colors duration-300" href="{{ route('login') }}">منصة الطلاب</a>
        </div>

        <!-- CTA Actions (Laravel Routes Integrated) -->
        <div class="flex flex-row-reverse gap-4 items-center">
            <a href="{{ route('register') }}" class="px-6 py-2 bg-gradient-to-br from-primary to-primary-container text-blue-900 rounded-xl font-bold transition-transform scale-95 active:scale-90 duration-300">
                ابدأ الآن
            </a>
            <a href="{{ route('login') }}" class="hidden sm:block px-4 py-2 text-slate-400 hover:text-blue-200 transition-colors duration-300 font-medium">
                تسجيل الدخول
            </a>
        </div>
    </div>
</nav>

<main class="pt-20">
    <!-- Hero Section -->
    <section class="relative min-h-[921px] flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-primary/20 blur-[120px] rounded-full"></div>
            <div class="absolute bottom-1/4 left-1/4 w-64 h-64 bg-tertiary/10 blur-[100px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Text Content -->
                <div class="lg:col-span-7 text-right">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container-high rounded-full mb-6 border border-outline-variant/15">
                        <span class="material-symbols-outlined text-tertiary text-sm" style="font-variation-settings: 'FILL' 1;">psychology</span>
                        <span class="text-label-sm text-tertiary font-medium">مدعوم بأحدث تقنيات الذكاء الاصطناعي</span>
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-extrabold text-on-surface mb-6 leading-[1.1] font-plus-jakarta tracking-tight">
                        مستقبل التعليم الذكي <br/>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-primary-container">بين يديك</span>
                    </h1>
                    <p class="text-xl text-on-surface-variant mb-10 max-w-2xl leading-relaxed">
                        اختبر تجربة تعليمية فريدة تعتمد على تحليل البيانات والذكاء الاصطناعي لتخصيص مسارك الدراسي وتحويل محاضراتك إلى ملخصات واختبارات تفاعلية في ثوانٍ.
                    </p>
                    <div class="flex flex-row-reverse gap-6">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-br from-primary to-primary-container text-blue-900 rounded-xl text-lg font-bold shadow-[0_20px_40px_rgba(185,195,255,0.2)] transition-all hover:scale-105 active:scale-95 text-center inline-block">
                            ابدأ رحلتك مجاناً
                        </a>
                    </div>
                </div>

                <!-- Visual Side -->
                <div class="lg:col-span-5 relative">
                    <div class="relative rounded-2xl overflow-hidden glass-panel border border-outline-variant/10 shadow-2xl p-4 rotate-1 lg:rotate-3 scale-105">
                        <img class="w-full h-auto rounded-xl" alt="AI Education" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDpv104ySkzjVPHjndl_FnVjuiezKf0h5UyLuk3kexfx_DsFyme2hCRIpZFALKvdbzFlPd7kFfEZbwNAeh2mpYdP-1Cw5sYToN9KSVAjb7XeO0eDjnqj2EwquWh3Vube3eMcjvRnJdlg8ONLI4ZURKBa1fy8PhbMvM7ojcdB9IZz8hcVEBZB6XsC0AWrM-TBhFK4KQ1vxYjWx0ZadepvIvIcZe09AheB_2BpLuogxXKdL96D4_9sRy-_ie7KI1pYk1ZQAlUFyM4tDc"/>
                        <div class="absolute bottom-8 right-8 bg-surface-container-highest/90 p-4 rounded-xl border border-outline-variant/20 backdrop-blur-md">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-pink-500/20 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-pink-400">auto_awesome</span>
                                </div>
                                <div>
                                    <div class="text-xs text-on-surface-variant">تحليل الذكاء</div>
                                    <div class="text-sm font-bold">تم إنتاج 12 ملخصاً اليوم</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Bento Grid -->
    <section id="features" class="py-32 bg-background relative overflow-hidden">
        <div class="container mx-auto px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl font-bold text-on-surface mb-4 font-plus-jakarta">مميزات صُممت لنجاحك</h2>
                <p class="text-on-surface-variant max-w-xl mx-auto leading-relaxed">نستخدم أحدث تقنيات معالجة اللغات الطبيعية لجعل عملية التعلم أسرع، أذكى، وأكثر إنتاجية.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 h-full lg:h-[600px]">
                <!-- Feature 1: AI Quizzes -->
                <div class="md:col-span-8 bg-surface-container-low rounded-2xl p-8 prism-glow transition-all duration-300 relative group overflow-hidden border border-transparent hover:border-primary/20">
                    <div class="flex flex-col h-full justify-between relative z-10">
                        <div>
                            <div class="w-14 h-14 bg-blue-500/20 rounded-xl flex items-center justify-center mb-6">
                                <span class="material-symbols-outlined text-primary text-3xl">quiz</span>
                            </div>
                            <h3 class="text-2xl font-bold text-on-surface mb-4 font-plus-jakarta">اختبارات ذكية</h3>
                            <p class="text-on-surface-variant max-w-md leading-relaxed">
                                حول أي محاضرة أو فيديو أو ملف PDF إلى اختبار تفاعلي شامل. يقوم نظامنا بتحليل المحتوى وتوليد أسئلة لقياس مدى استيعابك.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2: Summaries -->
                <div class="md:col-span-4 bg-surface-container-low rounded-2xl p-8 prism-glow transition-all duration-300 border border-transparent hover:border-tertiary/20">
                    <div class="w-14 h-14 bg-pink-500/20 rounded-xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-tertiary text-3xl">summarize</span>
                    </div>
                    <h3 class="text-2xl font-bold text-on-surface mb-4 font-plus-jakarta">تلخيص فوري</h3>
                    <p class="text-on-surface-variant leading-relaxed">احصل على جوهر الفائدة من أي محتوى في لحظات معدودة.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24">
        <div class="container mx-auto px-8">
            <div class="bg-gradient-to-br from-primary-container/10 to-pink-500/10 rounded-[2rem] p-12 lg:p-20 text-center border border-outline-variant/10 relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="text-4xl lg:text-5xl font-bold text-on-surface mb-6 font-plus-jakarta tracking-tight">جاهز لرفع مستوى تحصيلك العلمي؟</h2>
                    <p class="text-on-surface-variant text-lg mb-10 max-w-2xl mx-auto">انضم إلى أكثر من 50,000 طالب ومعلم يستخدمون سمارت ليرن يومياً.</p>
                    <a href="{{ route('register') }}" class="inline-block px-10 py-5 bg-gradient-to-br from-primary to-primary-container text-blue-900 rounded-xl text-xl font-bold shadow-[0_25px_50px_-12px_rgba(0,0,0,0.5)] transition-transform hover:scale-105 active:scale-95">
                        سجل الآن مجاناً
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="w-full py-12 border-t border-slate-800/15 bg-slate-950">
    <div class="flex flex-col items-center gap-6 max-w-7xl mx-auto px-4">
        <div class="text-lg font-black text-blue-400 font-plus-jakarta">Smart Learn</div>
        <div class="text-slate-500 text-sm font-plus-jakarta opacity-80">
            © {{ date('Y') }} سمارت ليرن. جميع الحقوق محفوظة.
        </div>
    </div>
</footer>

</body>
</html>

