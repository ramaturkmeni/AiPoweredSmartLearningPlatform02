<!DOCTYPE html>

<html class="dark" dir="rtl" lang="ar"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&amp;family=Inter:wght@400;500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-fixed": "#dde1ff",
                        "error-container": "#93000a",
                        "error": "#ffb4ab",
                        "on-background": "#e2e2e5",
                        "inverse-surface": "#e2e2e5",
                        "on-secondary-fixed": "#2e1500",
                        "primary-container": "#6e88ff",
                        "inverse-primary": "#2d50d9",
                        "tertiary-fixed-dim": "#f9abff",
                        "surface-container-lowest": "#0c0e10",
                        "on-tertiary": "#570066",
                        "on-primary": "#00228a",
                        "background": "#121416",
                        "surface-container-high": "#282a2c",
                        "secondary-fixed": "#ffdcc1",
                        "surface": "#121416",
                        "on-error-container": "#ffdad6",
                        "surface-container-low": "#1a1c1e",
                        "surface-dim": "#121416",
                        "surface-bright": "#37393b",
                        "on-secondary-container": "#613400",
                        "tertiary": "#f9abff",
                        "on-error": "#690005",
                        "tertiary-fixed": "#ffd6fe",
                        "primary-fixed-dim": "#b9c3ff",
                        "on-primary-container": "#001d79",
                        "on-primary-fixed-variant": "#0034c0",
                        "on-primary-fixed": "#001257",
                        "on-surface": "#e2e2e5",
                        "outline": "#8e90a0",
                        "on-tertiary-fixed": "#35003f",
                        "surface-container": "#1e2022",
                        "on-surface-variant": "#c4c5d7",
                        "surface-tint": "#b9c3ff",
                        "tertiary-container": "#d560e6",
                        "outline-variant": "#444654",
                        "on-secondary-fixed-variant": "#6c3a00",
                        "secondary-fixed-dim": "#ffb778",
                        "secondary-container": "#fd9000",
                        "inverse-on-surface": "#2f3133",
                        "surface-container-highest": "#333537",
                        "on-tertiary-fixed-variant": "#7b008f",
                        "surface-variant": "#333537",
                        "on-tertiary-container": "#4c0059",
                        "primary": "#b9c3ff",
                        "secondary": "#ffb778",
                        "on-secondary": "#4c2700"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "fontFamily": {
                        "headline": ["Plus Jakarta Sans"],
                        "display": ["Plus Jakarta Sans"],
                        "body": ["Inter"],
                        "label": ["Inter"]
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
<a class="text-slate-400 font-plus-jakarta leading-relaxed hover:text-blue-200 transition-colors duration-300" href="#">المميزات</a>
<a class="text-slate-400 font-plus-jakarta leading-relaxed hover:text-blue-200 transition-colors duration-300" href="#">التسعير</a>
<a class="text-slate-400 font-plus-jakarta leading-relaxed hover:text-blue-200 transition-colors duration-300" href="#">منصة الطلاب</a>
</div>
<!-- CTA Actions -->
<div class="flex flex-row-reverse gap-4 items-center">
<button class="px-6 py-2 bg-gradient-to-br from-primary to-primary-container text-on-primary-fixed rounded-xl font-bold transition-transform scale-95 active:scale-90 duration-300">
                    ابدأ الآن
                </button>
<button class="hidden sm:block px-4 py-2 text-slate-400 hover:text-blue-200 transition-colors duration-300 font-medium">
                    تسجيل الدخول
                </button>
</div>
</div>
</nav>
<main class="pt-20">
<!-- Hero Section -->
<section class="relative min-h-[921px] flex items-center overflow-hidden">
<!-- Background Decorative Elements -->
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
<button class="px-8 py-4 bg-gradient-to-br from-primary to-primary-container text-on-primary-fixed rounded-xl text-lg font-bold shadow-[0_20px_40px_rgba(185,195,255,0.2)] transition-all hover:scale-105 active:scale-95">
                                ابدأ رحلتك مجاناً
                            </button>
<button class="px-8 py-4 bg-surface-container-low border border-outline-variant/20 rounded-xl text-lg font-medium hover:bg-surface-container-high transition-all">
                                شاهد العرض
                            </button>
</div>
</div>
<!-- Visual Side -->
<div class="lg:col-span-5 relative">
<div class="relative rounded-2xl overflow-hidden glass-panel border border-outline-variant/10 shadow-2xl p-4 rotate-1 lg:rotate-3 scale-105">
<img class="w-full h-auto rounded-xl" data-alt="Futuristic glowing digital brain interface with intricate neural networks on a dark background representing high-tech educational AI" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDpv104ySkzjVPHjndl_FnVjuiezKf0h5UyLuk3kexfx_DsFyme2hCRIpZFALKvdbzFlPd7kFfEZbwNAeh2mpYdP-1Cw5sYToN9KSVAjb7XeO0eDjnqj2EwquWh3Vube3eMcjvRnJdlg8ONLI4ZURKBa1fy8PhbMvM7ojcdB9IZz8hcVEBZB6XsC0AWrM-TBhFK4KQ1vxYjWx0ZadepvIvIcZe09AheB_2BpLuogxXKdL96D4_9sRy-_ie7KI1pYk1ZQAlUFyM4tDc"/>
<div class="absolute bottom-8 right-8 bg-surface-container-highest/90 p-4 rounded-xl border border-outline-variant/20 backdrop-blur-md">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-tertiary-container flex items-center justify-center">
<span class="material-symbols-outlined text-on-tertiary-container">auto_awesome</span>
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
<!-- Social Proof -->
<section class="py-20 bg-surface-container-lowest">
<div class="container mx-auto px-8">
<p class="text-center text-on-surface-variant font-medium mb-12">موثوق من قبل الجامعات والمؤسسات التعليمية الكبرى</p>
<div class="flex flex-wrap justify-center items-center gap-12 lg:gap-24 opacity-40 grayscale hover:grayscale-0 transition-all duration-500">
<div class="text-3xl font-black font-plus-jakarta text-on-surface">STANFORD</div>
<div class="text-3xl font-black font-plus-jakarta text-on-surface">MIT</div>
<div class="text-3xl font-black font-plus-jakarta text-on-surface">OXFORD</div>
<div class="text-3xl font-black font-plus-jakarta text-on-surface">HARVARD</div>
</div>
</div>
</section>
<!-- Features Bento Grid -->
<section class="py-32 bg-background relative overflow-hidden">
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
<div class="w-14 h-14 bg-primary-container/20 rounded-xl flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-primary text-3xl">quiz</span>
</div>
<h3 class="text-2xl font-bold text-on-surface mb-4 font-plus-jakarta">اختبارات ذكية</h3>
<p class="text-on-surface-variant max-w-md leading-relaxed">
                                    حول أي محاضرة أو فيديو أو ملف PDF إلى اختبار تفاعلي شامل. يقوم نظامنا بتحليل المحتوى وتوليد أسئلة تغطي كافة النقاط الجوهرية لقياس مدى استيعابك.
                                </p>
</div>
<div class="mt-8 flex gap-4">
<span class="px-4 py-2 bg-surface-container rounded-full text-sm font-medium">تعدد الخيارات</span>
<span class="px-4 py-2 bg-surface-container rounded-full text-sm font-medium">صح أو خطأ</span>
<span class="px-4 py-2 bg-surface-container rounded-full text-sm font-medium">تحليل الإجابة</span>
</div>
</div>
<img class="absolute left-0 bottom-0 w-1/3 opacity-20 group-hover:opacity-40 transition-opacity" data-alt="Minimalist top view of tablet with interactive quiz interface showing progress bars and academic icons in cool tones" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCU_PNjahp-iRInemr9yU58klyFAhG1yCaVgwuVACMZNGHTZWa9thofOQMnAywkefIIJFESYk6yMqKOrH-a3lzjPvBCDz8MCYQwR-e_Z0gPw6pQTUMgryT-wFyNkMaFEve2uI6HEAHC02hmjqOVtbxBEUbyAtOdX3zO94FR8h1WwvYceLS6-6EyQ8quh-QKI-Q1XV129kuD5GGWJLrFzpvW464nx8lqrSmHJzOMiy9Co3AxbfSiFjEwlSFxn7VYRj9vOtJNnHY0Hpg"/>
</div>
<!-- Feature 2: Summaries -->
<div class="md:col-span-4 bg-surface-container-low rounded-2xl p-8 prism-glow transition-all duration-300 border border-transparent hover:border-tertiary/20">
<div class="w-14 h-14 bg-tertiary-container/20 rounded-xl flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-tertiary text-3xl">summarize</span>
</div>
<h3 class="text-2xl font-bold text-on-surface mb-4 font-plus-jakarta">تلخيص فوري</h3>
<p class="text-on-surface-variant leading-relaxed">
                            لا مزيد من ضياع الوقت في القراءة الطويلة. احصل على جوهر الفائدة من أي محتوى في لحظات معدودة.
                        </p>
<div class="mt-12 bg-surface-container-lowest p-4 rounded-xl border border-outline-variant/10">
<div class="flex items-center gap-3 mb-3">
<div class="w-2 h-2 rounded-full bg-tertiary"></div>
<div class="h-2 w-3/4 bg-surface-variant rounded-full"></div>
</div>
<div class="flex items-center gap-3 mb-3">
<div class="w-2 h-2 rounded-full bg-tertiary"></div>
<div class="h-2 w-1/2 bg-surface-variant rounded-full"></div>
</div>
<div class="flex items-center gap-3">
<div class="w-2 h-2 rounded-full bg-tertiary"></div>
<div class="h-2 w-2/3 bg-surface-variant rounded-full"></div>
</div>
</div>
</div>
<!-- Feature 3: Performance Analytics -->
<div class="md:col-span-5 bg-surface-container-low rounded-2xl p-8 prism-glow transition-all duration-300 border border-transparent hover:border-secondary/20">
<div class="w-14 h-14 bg-secondary-container/20 rounded-xl flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-secondary text-3xl">insights</span>
</div>
<h3 class="text-2xl font-bold text-on-surface mb-4 font-plus-jakarta">تحليلات الأداء</h3>
<p class="text-on-surface-variant leading-relaxed">
                            لوحات تحكم متقدمة توضح نقاط القوة والضعف للطالب، وتساعد المعلمين على اتخاذ قرارات مبنية على بيانات حقيقية.
                        </p>
</div>
<!-- Feature 4: Academic Integration -->
<div class="md:col-span-7 bg-surface-container rounded-2xl p-8 relative flex items-center justify-between border border-outline-variant/10">
<div class="relative z-10">
<h3 class="text-2xl font-bold text-on-surface mb-4 font-plus-jakarta">تكامل أكاديمي شامل</h3>
<p class="text-on-surface-variant max-w-xs leading-relaxed">اربط حساباتك في المنصات التعليمية العالمية واستورد موادك بضغطة زر.</p>
</div>
<div class="grid grid-cols-2 gap-4">
<div class="w-16 h-16 bg-surface-container-highest rounded-xl flex items-center justify-center shadow-lg">
<span class="material-symbols-outlined text-primary text-2xl">school</span>
</div>
<div class="w-16 h-16 bg-surface-container-highest rounded-xl flex items-center justify-center shadow-lg">
<span class="material-symbols-outlined text-secondary text-2xl">auto_stories</span>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- CTA Section -->
<section class="py-24">
<div class="container mx-auto px-8">
<div class="bg-gradient-to-br from-primary-container/10 to-tertiary-container/10 rounded-[2rem] p-12 lg:p-20 text-center border border-outline-variant/10 relative overflow-hidden">
<div class="absolute inset-0 bg-primary/5 opacity-30"></div>
<div class="relative z-10">
<h2 class="text-4xl lg:text-5xl font-bold text-on-surface mb-6 font-plus-jakarta tracking-tight">جاهز لرفع مستوى تحصيلك العلمي؟</h2>
<p class="text-on-surface-variant text-lg mb-10 max-w-2xl mx-auto">انضم إلى أكثر من 50,000 طالب ومعلم يستخدمون سمارت ليرن يومياً.</p>
<button class="px-10 py-5 bg-gradient-to-br from-primary to-primary-container text-on-primary-fixed rounded-xl text-xl font-bold shadow-[0_25px_50px_-12px_rgba(0,0,0,0.5)] transition-transform hover:scale-105 active:scale-95">
                            سجل الآن مجاناً
                        </button>
</div>
</div>
</div>
</section>
</main>
<!-- Footer -->
<footer class="w-full py-12 border-t border-slate-800/15 bg-slate-950">
<div class="flex flex-col items-center gap-6 max-w-7xl mx-auto px-4">
<div class="text-lg font-black text-blue-400 font-plus-jakarta">Smart Learn</div>
<div class="flex flex-row-reverse gap-8 flex-wrap justify-center">
<a class="text-slate-500 text-sm font-plus-jakarta hover:text-blue-300 transition-colors opacity-80 hover:opacity-100" href="#">سياسة الخصوصية</a>
<a class="text-slate-500 text-sm font-plus-jakarta hover:text-blue-300 transition-colors opacity-80 hover:opacity-100" href="#">اتصل بنا</a>
<a class="text-slate-500 text-sm font-plus-jakarta hover:text-blue-300 transition-colors opacity-80 hover:opacity-100" href="#">شروط الاستخدام</a>
</div>
<div class="text-slate-500 text-sm font-plus-jakarta opacity-80">
                © 2024 سمارت ليرن. جميع الحقوق محفوظة.
            </div>
<div class="flex gap-4 mt-4">
<a class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center hover:bg-primary-container/20 transition-colors" href="#">
<span class="material-symbols-outlined text-slate-400 text-xl">share</span>
</a>
<a class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center hover:bg-primary-container/20 transition-colors" href="#">
<span class="material-symbols-outlined text-slate-400 text-xl">language</span>
</a>
</div>
</div>
</footer>
</body></html>
