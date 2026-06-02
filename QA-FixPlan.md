# خطة إصلاح QA الشاملة

تم تحليل كامل الكود (Controllers, Models, Views, Migrations, Routes).
المشاكل مصنفة حسب الخطورة.

---

## حرج — سيسبب انهيار الصفحة أو كسر وظيفة أساسية

### 1. انهيار JavaScript في صفحة أداء الاختبار عندما `duration` يكون null

**الملف:** `resources/views/student/quizzes/take.blade.php` سطر 15 و 64
**المشكلة:** إذا الأستاذ ما حدد مدة الاختبار (`duration = null`)، الكود يصير:
```js
const duration = ;  // ← خطأ syntax → JS ينهار بالكامل
```
كمان العرض: `":00"` بدل وقت فعلي.
**التأثير:** الصفحة ما بتعمل auto-submit عند انتهاء الوقت + خطأ بالكونسول.
**الإصلاح:**
```blade
{{-- سطر 15: --}}
<p id="quiz-timer" class="text-2xl font-black text-white font-plus-jakarta">
    {{ $quiz->duration ? $quiz->duration . ':00' : 'بدون وقت' }}
</p>

{{-- سطر 64: --}}
const duration = {{ $quiz->duration ?? 0 }};
if (duration > 0) {
    // ... كود التايمر الحالي
}
```
وإخفاء أيقونة/قسم التايمر بالكامل إذا ما في مدة.

---

### 2. زر التلخيص بالذكاء الاصطناعي في صفحة المحاضرة لا يعمل (AJAX يرجع HTML بدل JSON)

**الملف:** `resources/views/student/lectures/show.blade.php` سطر 94-106
**المشكلة:** الـ `fetch` لا يرسل header `Accept: application/json` ولا `X-Requested-With: XMLHttpRequest`، فالكونترولر ما يعرف إنه طلب AJAX ← يرجع HTML (صفحة كاملة) ← `res.json()` ينهار.
**الإصلاح:** إضافة headers للـ fetch:
```js
headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': ...
}
```

---

### 3. `file_path` بدل `file_url` في صفحة محاضرات الأستاذ

**الملف:** `resources/views/teacher/lectures/index.blade.php` سطر 32-33
**المشكلة:** نفس المشكلة التي أصلحناها في صفحة الطالب — العمود بقاعدة البيانات اسمه `file_url` مو `file_path`.
**التأثير:** رابط تحميل الملف لا يظهر نهائياً حتى لو فيه ملف مرفوع.
**الإصلاح:** `$lecture->file_path` → `$lecture->file_url` (سطر 32 و 33).

---

### 4. عنوان صفحة عرض المادة يظهر حرفياً `{{ $course->title }}`

**الملف:** `resources/views/student/courses/show.blade.php` سطر 3
**المشكلة:**
```blade
@section('title', '{{ $course->title }} - Smart Learn')
```
في بنية `@section('title', 'string')` ← Blade لا يحلل `{{ }}` داخل string.
عنوان التبويب يظهر حرفياً: `{{ $course->title }} - Smart Learn`
**الإصلاح:**
```blade
@section('title', $course->title . ' - Smart Learn')
```

---

## مرتفع — عرض بيانات خاطئة أو ميزة لا تعمل

### 5. اسم الطالب يظهر '؟' في صفحة نتائج الأستاذ

**الملف:** `resources/views/teacher/quizzes/results.blade.php` سطر 54 و 57
**المشكلة:** يصل لـ `$attempt->student->user->first_name` — لكن model الـ `User` ما فيه حقل `first_name`! حقل `first_name` موجود على model الـ `Student` مباشرة.
**التأثير:** الأيقونة دائماً '؟' والاسم فارغ.
**الإصلاح:**
```blade
{{-- سطر 54: --}}
{{ mb_substr($attempt->student->first_name ?? '؟', 0, 1) }}

{{-- سطر 57: --}}
{{ $attempt->student->first_name ?? '' }} {{ $attempt->student->last_name ?? '' }}
```

---

### 6. ترحيب "مرحباً" في header الطالب دائماً فارغ

**الملف:** `resources/views/layouts/student.blade.php` سطر 171
**المشكلة:** `auth()->user()->first_name` — الـ `User` model ما فيه `first_name`. الحقل على model الـ `Student`.
**التأثير:** يظهر "مرحباً، " بدون اسم.
**الإصلاح:**
```blade
{{ auth()->user()->student->first_name ?? auth()->user()->username }}
```
**ملاحظة:** يجب التحقق من layout الأستاذ أيضاً (`layouts/teacher.blade.php`) لنفس المشكلة.

---

### 7. نموذج تغيير كلمة المرور لا يعمل

**الملف:** `resources/views/profile/show.blade.php` سطر 104-128 و `AuthController@updateProfile`
**المشكلة:** الفورم يرسل `current_password`, `password`, `password_confirmation` لكن `updateProfile()` لا يتعامل معها أبداً — يتجاهلها بالكامل.
**التأثير:** الطالب/الأستاذ يضغط "تحديث كلمة المرور" ← لا شيء يحصل (بدون رسالة خطأ حتى).
**الإصلاح:** إضافة منطق تغيير كلمة المرور في `AuthController@updateProfile`:
```php
if ($request->filled('current_password')) {
    $request->validate([
        'current_password' => ['required', 'current_password'],
        'password'         => ['required', 'confirmed', Password::min(8)],
    ]);
    $user->update(['password' => Hash::make($request->password)]);
    return back()->with('success', 'تم تحديث كلمة المرور بنجاح');
}
```
أو الأفضل: فصل route تغيير كلمة المرور عن route تحديث الملف الشخصي.

---

### 8. نص مقطوع في صفحة نتيجة الاختبار

**الملف:** `resources/views/student/quizzes/result.blade.php` سطر 14
**المشكلة:** `'لم تحصل على درجة النج'` ← ناقص حرفين "اح" (المقصود: "النجاح").
**الإصلاح:** `'لم تحصل على درجة النجاح'`

---

## متوسط — مشاكل منطقية / أداء

### 9. إنشاء محاولة جديدة عند كل تحديث لصفحة الاختبار

**الملف:** `app/Http/Controllers/Student/QuizController.php` سطر 25-29
**المشكلة:** `start()` دائماً ينشئ `StudentQuizAttempt` جديد بدون التحقق إذا فيه محاولة `in_progress` موجودة. إذا الطالب حدّث الصفحة ← محاولة ثانية. وإذا فتح الاختبار عدة مرات ← محاولات بدون إجابات بالقاعدة.
**الإصلاح:**
```php
$attempt = StudentQuizAttempt::firstOrCreate(
    ['student_id' => $student->id, 'quiz_id' => $quiz->id, 'status' => 'in_progress'],
    []
);
```

---

### 10. فقدان وقت بداية الاختبار

**الملف:** `app/Models/StudentQuizAttempt.php` سطر 61-66
**المشكلة:** `submit()` يعمل `taken_at = now()` ← يكتب فوق وقت البداية الأصلي. فلا يوجد سجل لمتى بدأ الطالب الاختبار.
**الإصلاح:** عدم تغيير `taken_at` عند التسليم (يبقى كوقت البداية)، أو إضافة عمود `submitted_at` منفصل (يحتاج migration جديد).
الحل الأسرع:
```php
public function submit(): void
{
    $total   = $this->answers()->count();
    $correct = $this->answers()->where('is_correct', true)->count();
    $this->update([
        'status' => 'submitted',
        'score'  => $total > 0 ? round(($correct / $total) * 100, 2) : 0,
        // لا نغير taken_at
    ]);
}
```
وتحديث العرض في `result.blade.php` سطر 15 ليعرض "بدأ بتاريخ" بدل "تم التسليم بتاريخ".

---

### 11. استعلامات N+1 في كونترولرات جلسة الذكاء الاصطناعي

**الملفات:**
- `app/Http/Controllers/Student/AISessionController.php`
- `app/Http/Controllers/Teacher/AISessionController.php`

**المشكلة:** الـ Views تصل لـ `$lecture->course->title` لكن الكونترولر يحمّل `with('lectures')` فقط بدون `lectures.course`. كل محاضرة تعمل استعلام منفصل لجلب course.
**الإصلاح:**
```php
$teacher->courses()
        ->with('lectures.course')  // أو ببساطة 'lectures' لأن course محمّل أصلاً
        ->get()
```
الحل الأبسط: بما أننا نمر عبر `$course->lectures`، يمكن تمرير اسم المادة مع كل محاضرة:
```php
$lectures = $teacher->courses()
                    ->with('lectures')
                    ->get()
                    ->flatMap(fn($c) => $c->lectures->each(fn($l) => $l->setRelation('course', $c)));
```

---

## ملخص سريع

| # | الخطورة | الملف | المشكلة |
|---|---------|-------|---------|
| 1 | حرج | take.blade.php | JS ينهار إذا duration=null |
| 2 | حرج | lectures/show.blade.php | AJAX تلخيص يرجع HTML بدل JSON |
| 3 | حرج | teacher/lectures/index | file_path → file_url |
| 4 | حرج | courses/show.blade.php | عنوان الصفحة حرفي |
| 5 | مرتفع | teacher/quizzes/results | اسم الطالب '؟' دائماً |
| 6 | مرتفع | layouts/student.blade.php | "مرحباً، " بدون اسم |
| 7 | مرتفع | profile + AuthController | تغيير كلمة المرور لا يعمل |
| 8 | مرتفع | result.blade.php | نص مقطوع "النج" |
| 9 | متوسط | QuizController@start | محاولات مكررة عند refresh |
| 10 | متوسط | StudentQuizAttempt | فقدان وقت البداية |
| 11 | متوسط | AISessionControllers | N+1 queries |
