# 🔧 خطة تصليح المشروع — AI-Powered Smart Learning Platform

> خطة تنفيذية شاملة لإصلاح جميع الأخطاء والمشاكل المكتشفة في المشروع، مرتبة حسب الأولوية.

---

## 📋 ملخص المشاكل المكتشفة

| # | النوع | المشكلة | الخطورة |
|---|-------|---------|---------|
| 1 | **PSR-4** | أسماء Models بحروف صغيرة تخالف معايير PHP | 🔴 عالية |
| 2 | **Config** | غياب إعداد `config/services.php` لـ Anthropic API | 🔴 عالية |
| 3 | **Routes** | مسارات الأستاذ (courses, lectures, quizzes) غير مسجلة في `web.php` | 🔴 عالية |
| 4 | **Middleware** | غياب middleware للتحقق من الأدوار (Role Guard) | 🔴 عالية |
| 5 | **Views** | غياب Layout مشترك (`app.blade.php`) | 🟠 متوسطة |
| 6 | **Views** | غياب واجهات الطالب (dashboard, courses, quizzes) | 🟠 متوسطة |
| 7 | **Views** | غياب واجهات الأستاذ (courses, lectures, quizzes) | 🟠 متوسطة |
| 8 | **Model** | User Model يشير لـ `teachers` بـ lowercase (Route Model Binding) | 🟠 متوسطة |
| 9 | **AIService** | دالة `summarize()` لا تقبل مستوى التلخيص | 🟡 منخفضة |
| 10 | **Env** | `.env.example` لا يحتوي متغيرات AI | 🟡 منخفضة |
| 11 | **Seeder** | غياب بيانات تجريبية (DatabaseSeeder) | 🟡 منخفضة |
| 12 | **Code Style** | مسافة ناقصة `quizzes$quiz` في QuizController | 🟡 منخفضة |
| 13 | **Views** | غياب صفحة profile (المذكورة في Routes) | 🟡 منخفضة |
| 14 | **Student** | غياب Student controllers views كاملة | 🟠 متوسطة |

---

## 🔴 المرحلة الأولى: إصلاحات حرجة (Critical Fixes)

### 1. إعادة تسمية Models حسب PSR-4 Convention

**المشكلة:** جميع أسماء النماذج بأحرف صغيرة (`courses`, `teachers`, `quizzes`...) وهذا يخالف معيار PSR-4 ويسبب مشاكل في:
- Route Model Binding (`{course}` لن يعمل مع `courses.php`)
- IDE autocompletion
- قابلية القراءة

**الحل:**

| الملف الحالي | الاسم الجديد | Class الحالي | Class الجديد |
|-------------|-------------|-------------|-------------|
| `teachers.php` | `Teacher.php` | `class teachers` | `class Teacher` |
| `students.php` | `Student.php` | `class students` | `class Student` |
| `courses.php` | `Course.php` | `class courses` | `class Course` |
| `lectures.php` | `Lecture.php` | `class lectures` | `class Lecture` |
| `quizzes.php` | `Quiz.php` | `class quizzes` | `class Quiz` |
| `questions.php` | `Question.php` | `class questions` | `class Question` |
| `question_options.php` | `QuestionOption.php` | `class question_options` | `class QuestionOption` |
| `course_enrollments.php` | `CourseEnrollment.php` | `class course_enrollments` | `class CourseEnrollment` |
| `student_quiz_attempts.php` | `StudentQuizAttempt.php` | `class student_quiz_attempts` | `class StudentQuizAttempt` |
| `student_answers.php` | `StudentAnswer.php` | `class student_answers` | `class StudentAnswer` |

**الملفات المتأثرة بالتغيير:**
- جميع الـ Models (10 ملفات) — إعادة تسمية + تحديث references
- جميع الـ Controllers (8 ملفات) — تحديث `use` statements
- `User.php` — تحديث العلاقات من `teachers::class` إلى `Teacher::class`

> ⚠️ **ملاحظة:** يجب إضافة `protected $table = 'table_name'` لكل Model لأن Laravel يتوقع اسم جدول مبني على اسم الـ Class.
> مثال: `class Quiz` → Laravel يبحث عن `quizzes` (صحيح افتراضياً).
> لكن `class Teacher` → Laravel يبحث عن `teachers` (صحيح أيضاً).
> `class CourseEnrollment` → يبحث عن `course_enrollments` (صحيح).
> `class StudentQuizAttempt` → يبحث عن `student_quiz_attempts` (صحيح).
> `class QuestionOption` → يبحث عن `question_options` (صحيح).

---

### 2. إصلاح إعداد config/services.php

**المشكلة:** `AIService.php` يستدعي `config('services.anthropic.key')` لكن الإعداد غير موجود.

**الحل:** إضافة في `config/services.php`:

```php
'anthropic' => [
    'key' => env('ANTHROPIC_API_KEY'),
],
```

---

### 3. تسجيل مسارات الأستاذ في web.php

**المشكلة:** ملف `routes/web.php` يحتوي فقط مسار `teacher.dashboard` ولا يحتوي مسارات:
- إدارة المقررات (CourseController CRUD)
- إدارة المحاضرات (LectureController CRUD)
- إدارة الاختبارات (QuizController — generate, review, publish, add/delete question, results)

**الحل:** إضافة المسارات التالية داخل `Route::prefix('teacher')`:

```php
Route::prefix('teacher')->name('teacher.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // المقررات
    Route::resource('courses', CourseController::class);

    // المحاضرات
    Route::get('/lectures/create', [LectureController::class, 'create'])->name('lectures.create');
    Route::post('/lectures', [LectureController::class, 'store'])->name('lectures.store');
    Route::get('/courses/{course}/lectures', [LectureController::class, 'index'])->name('lectures.index');
    Route::get('/lectures/{lecture}/edit', [LectureController::class, 'edit'])->name('lectures.edit');
    Route::put('/lectures/{lecture}', [LectureController::class, 'update'])->name('lectures.update');
    Route::delete('/lectures/{lecture}', [LectureController::class, 'destroy'])->name('lectures.destroy');

    // الاختبارات
    Route::get('/quizzes/generate/{lecture}', [QuizController::class, 'generate'])->name('quizzes.generate');
    Route::get('/quizzes/{quiz}/review', [QuizController::class, 'review'])->name('quizzes.review');
    Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
    Route::post('/quizzes/{quiz}/publish', [QuizController::class, 'publish'])->name('quizzes.publish');
    Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');
    Route::post('/quizzes/{quiz}/questions', [QuizController::class, 'addQuestion'])->name('quizzes.addQuestion');
    Route::delete('/questions/{question}', [QuizController::class, 'deleteQuestion'])->name('quizzes.deleteQuestion');
    Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])->name('quizzes.results');
});
```

---

### 4. إضافة Middleware للتحقق من الأدوار

**المشكلة:** لا يوجد middleware يمنع الطالب من الوصول لمسارات الأستاذ والعكس.

**الحل:** إنشاء middleware:

```bash
php artisan make:middleware EnsureUserRole
```

```php
// app/Http/Middleware/EnsureUserRole.php
class EnsureUserRole
{
    public function handle($request, Closure $next, string $role)
    {
        if (auth()->user()->role !== $role) {
            abort(403, 'غير مصرح لك بالوصول.');
        }
        return $next($request);
    }
}
```

تسجيله في `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\EnsureUserRole::class,
    ]);
})
```

استخدامه في Routes:
```php
Route::prefix('teacher')->middleware(['auth', 'role:teacher'])->group(function () { ... });
Route::prefix('student')->middleware(['auth', 'role:student'])->group(function () { ... });
```

---

## 🟠 المرحلة الثانية: إصلاحات متوسطة (Medium Priority)

### 5. إنشاء Layout مشترك (app.blade.php)

**المشكلة:** لا يوجد layout مشترك. كل صفحة تحتوي HTML كامل مكرر.

**الحل:** إنشاء `resources/views/layouts/app.blade.php`:
- Header مشترك
- Sidebar مع قوائم حسب الدور
- منطقة `@yield('content')`
- Footer

وإنشاء layouts فرعية:
- `resources/views/layouts/teacher.blade.php` — extends app, sidebar أستاذ
- `resources/views/layouts/student.blade.php` — extends app, sidebar طالب

---

### 6. إنشاء واجهات الأستاذ الناقصة

| الواجهة | الملف المطلوب | الوصف |
|---------|-------------|-------|
| قائمة المقررات | `teacher/courses/index.blade.php` | عرض كل المقررات مع إحصائيات |
| إنشاء مقرر | `teacher/courses/create.blade.php` | فورم إنشاء مقرر جديد |
| تعديل مقرر | `teacher/courses/edit.blade.php` | فورم تعديل المقرر |
| قائمة المحاضرات | `teacher/lectures/index.blade.php` | محاضرات مقرر محدد |
| إنشاء محاضرة | `teacher/lectures/create.blade.php` | فورم رفع محاضرة |
| تعديل محاضرة | `teacher/lectures/edit.blade.php` | فورم تعديل المحاضرة |
| مراجعة اختبار | `teacher/quizzes/review.blade.php` | عرض أسئلة + تعديل + نشر |
| نتائج اختبار | `teacher/quizzes/results.blade.php` | درجات الطلاب |

---

### 7. إنشاء واجهات الطالب

| الواجهة | الملف المطلوب | الوصف |
|---------|-------------|-------|
| لوحة التحكم | `student/dashboard.blade.php` | إحصائيات + مقررات مسجلة |
| المقررات المتاحة | `student/courses/index.blade.php` | تصفح وتسجيل |
| تفاصيل مقرر | `student/courses/show.blade.php` | المحاضرات + الاختبارات |
| محاضرة | `student/lectures/show.blade.php` | عرض محتوى المحاضرة |
| الاختبار | `student/quizzes/take.blade.php` | أداء الاختبار |
| النتيجة | `student/quizzes/result.blade.php` | عرض الدرجة والإجابات |

---

### 8. إكمال Student Controllers

**المشكلة:** الـ Controllers الخاصة بالطالب موجودة لكنها لا تحتوي كل الوظائف المطلوبة (التسجيل في المقررات، أداء الاختبارات).

**الملفات المتأثرة:**
- `Student/CourseController.php` — إضافة `enroll()`, `show()`
- `Student/LectureController.php` — إضافة `show()`
- `Student/QuizController.php` — إضافة `take()`, `submit()`, `result()`

---

### 9. تسجيل مسارات الطالب في web.php

إضافة مسارات مقابلة لـ Student Controllers:

```php
Route::prefix('student')->name('student.')->middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses', [StudentCourseController::class, 'index'])->name('courses.index');
    Route::post('/courses/{course}/enroll', [StudentCourseController::class, 'enroll'])->name('courses.enroll');
    Route::get('/courses/{course}', [StudentCourseController::class, 'show'])->name('courses.show');
    Route::get('/lectures/{lecture}', [StudentLectureController::class, 'show'])->name('lectures.show');
    Route::get('/quizzes/{quiz}/take', [StudentQuizController::class, 'take'])->name('quizzes.take');
    Route::post('/quizzes/{quiz}/submit', [StudentQuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quizzes/{quiz}/result', [StudentQuizController::class, 'result'])->name('quizzes.result');
});
```

---

## 🟡 المرحلة الثالثة: تحسينات (Low Priority)

### 10. تحديث .env.example

إضافة المتغيرات الناقصة:

```env
# Anthropic Claude AI
ANTHROPIC_API_KEY=

# Database
DB_DATABASE=smart_learning
```

---

### 11. إصلاح Code Style في QuizController

**المشكلة:** مسافة ناقصة في سطرين:
```php
// خطأ:
public function publish(quizzes$quiz)
public function results(quizzes$quiz)

// الصحيح:
public function publish(Quiz $quiz)
public function results(Quiz $quiz)
```

---

### 12. تحسين AIService

**المشكلة:** دالة `summarize()` لا تقبل مستوى التلخيص (`brief`, `medium`, `detailed`).

**الحل:** تحديث signature:
```php
public function summarize(string $text, string $level = 'medium'): string
{
    $instructions = match($level) {
        'brief'    => 'لخص في 3-5 نقاط فقط',
        'detailed' => 'لخص بالتفصيل مع أمثلة',
        default    => 'لخص بشكل متوازن مع إبراز النقاط الرئيسية',
    };
    // ...
}
```

---

### 13. إنشاء DatabaseSeeder

إنشاء بيانات تجريبية:
- 2 أساتذة + 5 طلاب
- 3 مقررات لكل أستاذ
- 2-4 محاضرات لكل مقرر
- اختبار واحد لبعض المحاضرات
- تسجيل الطلاب في المقررات

---

### 14. إنشاء صفحة Profile

إنشاء `resources/views/auth/profile.blade.php` — المذكورة في Routes لكنها غير موجودة.

---

## 📊 ملخص ترتيب التنفيذ

```
المرحلة 1 (يوم 1-2):
  ├── 1. إعادة تسمية Models ← أولوية قصوى
  ├── 2. إصلاح config/services.php
  ├── 3. تسجيل Routes الأستاذ
  └── 4. إنشاء Role Middleware

المرحلة 2 (يوم 3-5):
  ├── 5. إنشاء Layout مشترك
  ├── 6. إنشاء واجهات الأستاذ (8 views)
  ├── 7. إنشاء واجهات الطالب (6 views)
  ├── 8. إكمال Student Controllers
  └── 9. تسجيل Routes الطالب

المرحلة 3 (يوم 6-7):
  ├── 10. تحديث .env.example
  ├── 11. إصلاح Code Style
  ├── 12. تحسين AIService
  ├── 13. إنشاء DatabaseSeeder
  └── 14. إنشاء صفحة Profile
```

---

## ✅ معايير النجاح

| المعيار | الوصف |
|---------|-------|
| **التشغيل** | `php artisan serve` يعمل بدون أخطاء |
| **التسجيل** | يمكن إنشاء حساب أستاذ وطالب |
| **الدخول** | كل دور يُوجَّه للوحة الصحيحة |
| **الحماية** | طالب لا يمكنه الوصول لمسارات الأستاذ |
| **المقررات** | الأستاذ يمكنه CRUD كامل |
| **المحاضرات** | رفع ملف + نص + صورة يعمل |
| **الاختبارات** | توليد AI → مراجعة → نشر → أداء الطالب |
| **الكود** | Models بأسماء PSR-4 صحيحة |
| **البيئة** | `.env.example` يحتوي كل المتغيرات |

---

## 🧪 خطة الاختبار

### اختبارات يدوية:

| # | السيناريو | النتيجة المتوقعة |
|---|----------|-----------------|
| 1 | تسجيل أستاذ جديد | يُوجَّه لـ `/teacher/dashboard` |
| 2 | تسجيل طالب جديد | يُوجَّه لـ `/student/dashboard` |
| 3 | أستاذ يفتح `/student/dashboard` | خطأ 403 |
| 4 | طالب يفتح `/teacher/dashboard` | خطأ 403 |
| 5 | أستاذ ينشئ مقرر + محاضرة | يظهران في القوائم |
| 6 | أستاذ يولد اختبار بالـ AI | أسئلة MCQ تُعرض للمراجعة |
| 7 | أستاذ ينشر الاختبار | الحالة تتغير لـ `published` |
| 8 | طالب يتسجل في مقرر | يظهر في مقرراته |
| 9 | طالب يؤدي اختبار | تُحسب الدرجة وتُعرض |
| 10 | تشغيل `php artisan migrate:fresh` | لا أخطاء |

### أوامر التحقق:
```bash
php artisan route:list          # التحقق من كل المسارات
php artisan migrate:fresh       # التحقق من الـ Migrations
php artisan config:cache        # التحقق من الإعدادات
```
