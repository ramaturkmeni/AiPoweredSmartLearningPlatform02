# 🎓 AI-Powered Smart Learning Platform

> منصة تعليمية ذكية مبنية بـ Laravel 12 + Anthropic Claude AI، تدعم دورين (أستاذ / طالب) مع نظام مصادقة متعدد الأدوار، إدارة مقررات ومحاضرات، وتوليد اختبارات آلياً بالذكاء الاصطناعي.

---

## 📊 معلومات المشروع

| البند | التفاصيل |
|-------|----------|
| **الإطار** | Laravel 12 (PHP 8.2+) |
| **قاعدة البيانات** | MySQL |
| **الذكاء الاصطناعي** | Anthropic Claude API (claude-sonnet-4-20250514) |
| **الواجهة** | Blade Templates + Vite |
| **المصادقة** | نظام مخصص (Username + Password + Role) |

---

## 🏗️ المعمارية

المشروع يعتمد على بنية **MVC** مع فصل الأدوار (Teacher/Student) في مجلدات مستقلة:

```
learning-platform/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/
│   │   │   └── AuthController.php          # تسجيل + دخول + خروج
│   │   ├── Teacher/
│   │   │   ├── DashboardController.php     # لوحة تحكم الأستاذ
│   │   │   ├── CourseController.php        # CRUD المقررات
│   │   │   ├── LectureController.php       # CRUD المحاضرات + رفع ملفات
│   │   │   └── QuizController.php          # توليد اختبارات AI + مراجعة + نشر
│   │   └── Student/
│   │       ├── DashboardController.php     # لوحة تحكم الطالب
│   │       ├── CourseController.php        # عرض المقررات المسجل فيها
│   │       ├── LectureController.php       # عرض المحاضرات
│   │       └── QuizController.php          # أداء الاختبارات + عرض النتائج
│   ├── Models/
│   │   ├── User.php                        # المستخدم (role: teacher|student)
│   │   ├── teachers.php                    # بيانات الأستاذ (1:1 مع User)
│   │   ├── students.php                    # بيانات الطالب (1:1 مع User)
│   │   ├── courses.php                     # المقررات الدراسية
│   │   ├── lectures.php                    # المحاضرات
│   │   ├── quizzes.php                     # الاختبارات
│   │   ├── questions.php                   # الأسئلة
│   │   ├── question_options.php            # خيارات الأسئلة (MCQ)
│   │   ├── course_enrollments.php          # تسجيل الطلاب في المقررات
│   │   ├── student_quiz_attempts.php       # محاولات الطلاب
│   │   └── student_answers.php             # إجابات الطلاب
│   ├── Services/
│   │   └── AIService.php                   # خدمة Anthropic Claude API
│   └── Providers/
├── database/migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 2026_04_19_160240_create_teachers_table.php
│   ├── 2026_04_19_161654_create_students_table.php
│   ├── 2026_04_19_161802_create_courses_table.php
│   ├── 2026_04_19_161912_create_course_enrollments_table.php
│   ├── 2026_04_19_162006_create_lectures_table.php
│   ├── 2026_04_19_162136_create_quizzes_table.php
│   ├── 2026_04_19_162220_create_questions_table.php
│   ├── 2026_04_19_162319_create_question_options_table.php
│   ├── 2026_04_19_162426_create_student_quiz_attempts_table.php
│   └── 2026_04_19_162613_create_student_answers_table.php
├── resources/views/
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── teacher/
│   │   └── dashboard.blade.php
│   ├── welcome.blade.php
│   └── test.blade.php
├── routes/
│   └── web.php
├── composer.json
├── package.json
└── vite.config.js
```

---

## 🗄️ قاعدة البيانات (ERD)

### الجداول (11 جدول)

```
User (1) ─── HasOne ──→ teachers
     │
     └── HasOne ──→ students

teachers (1) ─── HasMany ──→ courses

courses (1) ─── HasMany ──→ lectures
    │
    └── BelongsToMany ──→ students  (عبر course_enrollments)

lectures (1) ─── HasOne ──→ quizzes

quizzes (1) ─── HasMany ──→ questions

questions (1) ─── HasMany ──→ question_options

quizzes (1) ─── HasMany ──→ student_quiz_attempts

student_quiz_attempts (1) ─── HasMany ──→ student_answers
```

### تفاصيل الجداول

#### `users` — المستخدمون
| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف الفريد |
| `username` | string (unique) | اسم المستخدم |
| `password` | string (hashed) | كلمة المرور |
| `role` | enum('teacher','student') | الدور |
| `remember_token` | string | توكن "تذكرني" |
| `timestamps` | | تاريخ الإنشاء والتحديث |

#### `teachers` — الأساتذة
| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف الفريد |
| `user_id` | bigint (FK → users, unique) | ربط 1:1 مع المستخدم |
| `first_name` | string | الاسم الأول |
| `last_name` | string | اسم العائلة |
| `email` | string (unique) | البريد الإلكتروني |
| `gender` | enum('male','female') | الجنس |
| `phone` | string (nullable) | الهاتف |
| `location` | string (nullable) | الموقع |

#### `students` — الطلاب
| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف الفريد |
| `user_id` | bigint (FK → users, unique) | ربط 1:1 مع المستخدم |
| `first_name` | string | الاسم الأول |
| `last_name` | string | اسم العائلة |
| `email` | string (unique) | البريد الإلكتروني |
| `gender` | enum('male','female') | الجنس |
| `phone` | string (nullable) | الهاتف |
| `location` | string (nullable) | الموقع |
| `major` | string (nullable) | التخصص |

#### `courses` — المقررات
| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف |
| `teacher_id` | bigint (FK → teachers) | الأستاذ المسؤول |
| `title` | string | عنوان المقرر |
| `description` | text (nullable) | الوصف |

#### `lectures` — المحاضرات
| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف |
| `course_id` | bigint (FK → courses) | المقرر |
| `title` | string | العنوان |
| `content_text` | text (nullable) | محتوى نصي (يُستخدم لتوليد الاختبارات) |
| `file_url` | string (nullable) | رابط ملف PDF/DOCX |
| `video_url` | string (nullable) | رابط فيديو |
| `img_url` | string (nullable) | صورة غلاف |
| `order_index` | integer | ترتيب المحاضرة |

#### `quizzes` — الاختبارات
| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف |
| `lecture_id` | bigint (FK → lectures) | المحاضرة المرتبطة |
| `title` | string | عنوان الاختبار |
| `is_ai_generated` | boolean | هل تم توليده بالـ AI؟ |
| `status` | enum('draft','published') | حالة النشر |
| `start_time` | datetime (nullable) | وقت البدء |
| `end_time` | datetime (nullable) | وقت الانتهاء |
| `duration` | integer (nullable) | المدة بالدقائق |

#### `questions` — الأسئلة
| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف |
| `quiz_id` | bigint (FK → quizzes) | الاختبار |
| `question_text` | text | نص السؤال |

#### `question_options` — خيارات الأسئلة
| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف |
| `question_id` | bigint (FK → questions) | السؤال |
| `option_text` | string | نص الخيار |
| `is_correct` | boolean | هل هو الإجابة الصحيحة؟ |

#### `course_enrollments` — تسجيل الطلاب
| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف |
| `student_id` | bigint (FK → students) | الطالب |
| `course_id` | bigint (FK → courses) | المقرر |
| `status` | enum('active','dropped') | حالة التسجيل |
| `enrolled_at` | timestamp | تاريخ التسجيل |

#### `student_quiz_attempts` — محاولات الاختبارات
| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف |
| `student_id` | bigint (FK → students) | الطالب |
| `quiz_id` | bigint (FK → quizzes) | الاختبار |
| `score` | decimal (nullable) | الدرجة |
| `status` | enum('in_progress','submitted') | الحالة |
| `started_at` | timestamp | وقت البدء |
| `submitted_at` | timestamp (nullable) | وقت التسليم |

#### `student_answers` — إجابات الطلاب
| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف |
| `attempt_id` | bigint (FK → student_quiz_attempts) | المحاولة |
| `question_id` | bigint (FK → questions) | السؤال |
| `selected_option_id` | bigint (FK → question_options, nullable) | الخيار المحدد |
| `is_correct` | boolean | هل الإجابة صحيحة؟ |

---

## 🤖 الذكاء الاصطناعي (AI Integration)

المشروع يستخدم **Anthropic Claude API** عبر `App\Services\AIService`:

### الميزات الحالية:
1. **توليد اختبارات MCQ** — الأستاذ يرفع محاضرة نصية → النظام يولّد أسئلة اختيار من متعدد
2. **تلخيص محاضرات** — دالة جاهزة لتلخيص النصوص الأكاديمية

### إعداد API:
```env
# أضف في ملف .env
ANTHROPIC_API_KEY=sk-ant-your-key-here
```

```php
// أضف في config/services.php
'anthropic' => [
    'key' => env('ANTHROPIC_API_KEY'),
],
```

---

## 🔐 نظام المصادقة

### نوعان من المستخدمين:
- **أستاذ (teacher):** يدير المقررات، يرفع المحاضرات، يولّد ويراجع الاختبارات
- **طالب (student):** يتصفح المقررات، يشاهد المحاضرات، يؤدي الاختبارات

### آلية التسجيل:
1. المستخدم يختار الدور (أستاذ/طالب)
2. يُنشأ سجل في `users` (username + password + role)
3. يُنشأ سجل تفصيلي في `teachers` أو `students` (1:1)
4. توجيه تلقائي بعد الدخول حسب الدور:
   - أستاذ → `/teacher/dashboard`
   - طالب → `/student/dashboard`

---

## 🛣️ المسارات (Routes)

### مسارات عامة:
| Method | المسار | الوظيفة |
|--------|--------|---------|
| GET | `/` | الصفحة الرئيسية (redirect لـ dashboard إذا مسجل) |
| GET | `/login` | صفحة تسجيل الدخول |
| POST | `/login` | معالجة تسجيل الدخول |
| GET | `/register` | صفحة التسجيل |
| POST | `/register` | معالجة التسجيل |

### مسارات محمية (auth):
| Method | المسار | الوظيفة |
|--------|--------|---------|
| POST | `/logout` | تسجيل الخروج |
| GET | `/profile` | الملف الشخصي |
| PUT | `/profile` | تحديث الملف الشخصي |
| GET | `/dashboard` | توجيه ذكي حسب الدور |

### مسارات الأستاذ:
| Method | المسار | الوظيفة |
|--------|--------|---------|
| GET | `/teacher/dashboard` | لوحة التحكم |
| _CRUD_ | `/teacher/courses/*` | إدارة المقررات |
| _CRUD_ | `/teacher/lectures/*` | إدارة المحاضرات |
| GET | `/teacher/quizzes/generate/{lecture}` | توليد اختبار بالـ AI |
| GET | `/teacher/quizzes/{quiz}/review` | مراجعة الاختبار |
| POST | `/teacher/quizzes/{quiz}/publish` | نشر الاختبار |

### مسارات الطالب:
| Method | المسار | الوظيفة |
|--------|--------|---------|
| GET | `/student/dashboard` | لوحة التحكم |
| _يُضاف لاحقاً_ | | مسارات الاختبارات والتسجيل |

---

## 🚀 التثبيت والتشغيل

### المتطلبات:
- PHP 8.2+
- Composer
- MySQL / MariaDB
- Node.js + npm

### خطوات التثبيت:

```bash
# 1. الدخول لمجلد المشروع
cd learning-platform

# 2. تثبيت التبعيات
composer install
npm install

# 3. إعداد البيئة
cp .env.example .env
php artisan key:generate

# 4. إعداد قاعدة البيانات (عدّل .env أولاً)
php artisan migrate

# 5. ربط التخزين العام
php artisan storage:link

# 6. تشغيل السيرفر
php artisan serve
# في تيرمينال ثاني:
npm run dev
```

---

## 📦 التبعيات الحالية

### Composer (PHP):
| الحزمة | الإصدار | الوظيفة |
|--------|---------|---------|
| `laravel/framework` | ^12.0 | إطار العمل الأساسي |
| `laravel/tinker` | ^2.10.1 | REPL للتطوير |

### NPM (Frontend):
يُدار عبر `package.json` و Vite.

---

## ⚠️ الحالة الحالية للمشروع

### ✅ تم تنفيذه:
- [x] نظام المصادقة (تسجيل + دخول + خروج)
- [x] نظام الأدوار (أستاذ / طالب)
- [x] Models مع العلاقات (11 نموذج)
- [x] Migrations (11 جدول + جداول النظام)
- [x] لوحة تحكم الأستاذ (إحصائيات)
- [x] لوحة تحكم الطالب (إحصائيات)
- [x] إدارة المقررات (CRUD كامل للأستاذ)
- [x] إدارة المحاضرات (CRUD + رفع ملفات)
- [x] توليد الاختبارات بالذكاء الاصطناعي
- [x] مراجعة ونشر الاختبارات
- [x] إضافة/حذف أسئلة يدوياً
- [x] صفحة تسجيل (واجهة كاملة)
- [x] صفحة دخول (واجهة كاملة)
- [x] صفحة لوحة تحكم الأستاذ (واجهة)
- [x] خدمة AIService (Anthropic Claude)

### ❌ لم يُنفذ بعد:
- [ ] صفحة لوحة تحكم الطالب (View)
- [ ] واجهات إدارة المقررات (Views)
- [ ] واجهات المحاضرات (Views)
- [ ] واجهات الاختبارات والمراجعة (Views)
- [ ] تسجيل الطلاب في المقررات (Enrollment flow)
- [ ] أداء الاختبارات للطلاب (Quiz taking)
- [ ] عرض النتائج والدرجات
- [ ] تلخيص المحاضرات بالـ AI
- [ ] Middleware للتحقق من الأدوار
- [ ] Seeders للبيانات التجريبية
- [ ] اختبارات (Unit/Feature tests)
- [ ] Layout مشترك (app.blade.php)
- [ ] إعداد config/services.php

---

## 📝 ملاحظات تقنية

### أسماء الـ Models:
> ⚠️ أسماء النماذج بحروف صغيرة (`courses`, `teachers`, `quizzes`) بدلاً من المعيار (`Course`, `Teacher`, `Quiz`). هذا يسبب مشاكل مع Route Model Binding ويخالف PSR-4.

### خدمة الذكاء الاصطناعي:
- `AIService.php` مُعد للاتصال بـ Anthropic Claude
- يحتاج `ANTHROPIC_API_KEY` في `.env`
- يحتاج إعداد `config/services.php`

---

## 📄 الرخصة

MIT License
