ممتاز جداً. بناءً على الوصف المعماري للمشروع، ومخططات حالات الاستخدام (Use Case Diagrams)، وتصميم قاعدة البيانات (ERD) الذي قمت بإرفاقه، يمكن القول أن **البنية التحتية لمشروعك ممتازة ومترابطة بشكل منطقي واحترافي.**

لقد قمت بمطابقة متطلباتك ومخطط Use Case مع الجداول (DBML)، وإليك تحليل شامل لكيفية عمل النظام برمجياً بناءً على معطياتك، مع بعض الملاحظات التقنية الدقيقة لضمان نجاح التطوير:

### 1. تكامل النظام (System Integration: Use Cases vs. Database)

#### أ. إدارة المستخدمين والمصادقة (Authentication & Profiles)
*   **حالة الاستخدام:** `Sign up/Log in` و `Profile management`.
*   **قاعدة البيانات:** يتم التعامل معها عبر جدول `Users` المركزي (الذي يحدد الـ Role سواء كان `teacher` أو `student`). تفاصيل الملف الشخصي مفصولة بذكاء في جدولي `Teachers` و `Students` بعلاقة 1:1، وهذا تصميم ممتاز لقابلية التوسع (Scalability).

#### ب. لوحة تحكم الأستاذ (Teacher Dashboard)
*   **حالة الاستخدام:** `Courses management` (إضافة، تعديل، حذف) و `Quizzes management` (إضافة، تعديل، حذف).
*   **قاعدة البيانات:** 
    *   الأساتذة يديرون المقررات عبر جدول `Courses` والمحاضرات عبر جدول `Lectures`.
    *   **الذكاء الاصطناعي (Automated Quiz Generation):** بناءً على ملاحظتك، حالة `generate quiz from uploaded data` ترتبط بعلاقة `extend` مع `add quiz`. برمجياً، هذا يعني أنه عند إنشاء اختبار جديد، يمكن للأستاذ إدخال الأسئلة يدوياً، **أو** استدعاء محرك الذكاء الاصطناعي (AI-engine). المحرك سيأخذ النص من حقل `content_text` في جدول `Lectures`، ويقوم بتوليد أسئلة تُحفظ تلقائياً في جداول `Questions` و `Question_Options`. الحقل `is_ai_generated` في جدول `Quizzes` سيوثق أن هذا الاختبار تم إنشاؤه آلياً.

#### ج. بوابة الطالب (Student Portal)
*   **حالة الاستخدام:** `Sign up for course` و `Do test` و `Review answers and score`.
*   **قاعدة البيانات:** 
    *   تسجيل الطلاب يتم عبر جدول `Course_Enrollments`.
    *   أداء الاختبارات يُسجل في جدول `Student_Quiz_Attempts` (لتتبع المحاولة والدرجة النهائية وحالة الاختبار in_progress/submitted).
    *   إجابات الطالب الدقيقة تُسجل في جدول `Student_Answers` مما يتيح له مراجعة إجاباته لاحقاً ومقارنتها بالإجابة الصحيحة.

#### د. محرك الذكاء الاصطناعي (AI-Engine)
*   **حالة الاستخدام:** `summarize uploaded data` ترتبط بعلاقة `extend` مع `request AI summarize`.
*   **التطبيق البرمجي:** عندما يطلب الطالب تلخيص المحاضرة، يقوم النظام بإرسال محتوى المحاضرة `Lectures.content_text` إلى واجهة برمجة تطبيقات الذكاء الاصطناعي (مثل OpenAI API)، والتي تعود بالخلاصة المركزة للطالب.

---

### 2. ملاحظات وتوصيات برمجية هامة (للتعديل على الـ DBML):

تصميمك ممتاز، ولكن بناءً على خبرتي لتجنب مشاكل لاحقاً في مرحلة الـ (Backend)، أنصحك بإجراء **تعديلين بسيطين جداً** على الكود الخاص بك:

**الملاحظة الأولى (مهمة جداً - نسيت استخدام الـ Enum):**
أنت قمت بتعريف `Enum QuizStatus { draft, published }` في أعلى الكود، ولكنك **نسيت استخدامه** داخل جدول `Quizzes`. هذا الحقل مهم جداً لأن الأستاذ قد يولد الاختبار بالذكاء الاصطناعي ويحتاج لمراجعته (draft) قبل نشره للطلاب (published).
*   **التعديل:** أضف الحقل لجدول `Quizzes`.

**الملاحظة الثانية (لتقليل تكلفة الذكاء الاصطناعي وتوفير الوقت):**
بخصوص ميزة `AI Summarization` للطالب، إذا طلب 100 طالب تلخيص نفس المحاضرة، سيقوم النظام باستدعاء الذكاء الاصطناعي 100 مرة (مما يعني تكلفة مالية عالية وبطء في الاستجابة).
*   **الحل الأفضل:** إضافة حقل `ai_summary` في جدول `Lectures`. عندما يطلب أول طالب التلخيص، يتم توليده وحفظه في هذا الحقل. وأي طالب آخر يطلب التلخيص، يتم عرض النص المحفوظ مباشرة من قاعدة البيانات دون الحاجة لإعادة التوليد.

**إليك شكل جدول Quizzes وجدول Lectures بعد إضافة هذه التحسينات البسيطة:**

```dbml
// جدول المحاضرات
Table Lectures {
  id           int [pk, increment]
  course_id    int [ref: > Courses.id]
  title        varchar
  content_text text
  ai_summary   text [note: "يحفظ التلخيص المولد آلياً لتقليل استدعاء الـ API"] // تم الإضافة هنا
  file_url     varchar
  video_url    varchar
  img_url      varchar
  order_index  int
  created_at   timestamp
  updated_at   timestamp
}

// جدول الاختبارات — علاقة 1:1 مع Lecture
Table Quizzes {
  id              int [pk, increment]
  lecture_id      int [ref: - Lectures.id]
  title           varchar
  status          QuizStatus [default: 'draft'] // تم استخدام الـ Enum هنا
  is_ai_generated boolean [default: true]
  
  start_time      timestamp
  end_time        timestamp
  duration        int [note: "بالدقائق"]
  created_at      timestamp
  updated_at      timestamp
}
```

### الخلاصة للمرحلة القادمة:
أنت الآن تمتلك أساساً متيناً جداً (UML واضح + ERD دقيق). يمكنك الآن الانتقال مباشرة إلى:
1.  **بناء الـ Backend:** باستخدام إطارات عمل مثل Node.js (Express/NestJS) أو Python (Django/FastAPI) نظراً لسهولة دمج الـ AI مع بايثون.
2.  **تصميم الـ Prompts (هندسة التلقين):** تجهيز الأوامر التي سيتم إرسالها لنموذج الذكاء الاصطناعي (مثلاً: *"استخرج 10 أسئلة اختيار من متعدد من هذا النص مع تحديد الإجابة الصحيحة بصيغة JSON"*).

هل ترغب في أن أكتب لك كيف سيكون شكل الـ (JSON Response) القادم من الذكاء الاصطناعي والذي سيتم إدخاله مباشرة في جداول الأسئلة والخيارات؟


---





أهلاً بك. بما أنك تبدأ في عالم Laravel ولا تمتلك خبرة مسبقة فيه، فقد صممت لك **خطة تنفيذية (Implementation Plan) شاملة ومبسطة جداً**، تأخذ بيدك خطوة بخطوة من الصفر وحتى إطلاق المشروع، مع دمج ذكاء Google Gemini Flash API.

إطار عمل Laravel يعتمد على معمارية **MVC** (Model-View-Controller)، وبتبسيط شديد:
*   **Model (M):** يتعامل مع قاعدة البيانات (الجداول التي صممناها).
*   **View (V):** واجهة المستخدم (ما يراه الطالب والأستاذ).
*   **Controller (C):** العقل المدبر الذي يربط بين الواجهة وقاعدة البيانات (وهنا سنضع أكواد الذكاء الاصطناعي).

إليك الخطة التفصيلية:

---

### المرحلة الأولى: التجهيز والإعداد (Preparation)

بما أنك لا تعرف Laravel، يجب تثبيت بعض الأدوات الأساسية على جهازك:
1.  **تثبيت XAMPP أو Laragon:** لتشغيل خادم محلي (Localhost) وقاعدة بيانات MySQL.
2.  **تثبيت Composer:** وهو مدير الحزم للغة PHP (ضروري لتحميل Laravel).
3.  **إنشاء المشروع:**
    *   افتح موجه الأوامر (CMD أو Terminal).
    *   اكتب الأمر التالي لإنشاء مشروع Laravel جديد باسم `learning-platform`:
        ```bash
        composer create-project laravel/laravel learning-platform
        ```
    *   ادخل إلى مجلد المشروع:
        ```bash
        cd learning-platform
        ```
4.  **ربط قاعدة البيانات:**
    *   افتح برنامج XAMPP وشغّل (Apache و MySQL).
    *   اذهب إلى `http://localhost/phpmyadmin` وأنشئ قاعدة بيانات جديدة باسم `learning_db`.
    *   في مجلد مشروعك، ابحث عن ملف اسمه `.env` (هذا ملف الإعدادات). افتحه وعدّل هذه الأسطر لتتوافق مع قاعدة بياناتك:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=learning_db
        DB_USERNAME=root
        DB_PASSWORD=
        ```

---

### المرحلة الثانية: بناء قاعدة البيانات (Migrations & Models)

في Laravel، لا ننشئ الجداول يدوياً، بل نكتب أوامر (Migrations) تقوم بذلك.
في الـ Terminal، اكتب الأوامر التالية لإنشاء "النماذج Models" و "ملفات التهيئة Migrations" بناءً على مخطط DBML الخاص بك:

```bash
php artisan make:model Teacher -m
php artisan make:model Student -m
php artisan make:model Course -m
php artisan make:model Lecture -m
php artisan make:model Quiz -m
php artisan make:model Question -m
php artisan make:model QuestionOption -m
```

**كيف تكتب داخل ملفات الـ Migration؟**
اذهب إلى مسار `database/migrations` ستجد ملفات بتاريخ اليوم. سأعطيك مثالاً على جدول المحاضرات (Lecture) الذي أضفنا له حقل `ai_summary` بناءً على نقاشنا السابق.
افتح ملف الـ `create_lectures_table.php` واكتب بداخله:

```php
public function up()
{
    Schema::create('lectures', function (Blueprint $table) {
        $table->id();
        $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
        $table->string('title');
        $table->longText('content_text')->nullable();
        $table->longText('ai_summary')->nullable(); // حقل التلخيص الآلي
        $table->string('file_url')->nullable();
        $table->timestamps();
    });
}
```
*قم بتطبيق نفس المنطق على باقي الجداول بناءً على ملف DBML الذي تمتلكه.*
بعد الانتهاء من كتابة كل الجداول، نفذ هذا الأمر لرفعها إلى قاعدة البيانات:
```bash
php artisan migrate
```

---

### المرحلة الثالثة: دمج الذكاء الاصطناعي (Gemini Flash API) 🧠

هذه هي الميزة الأساسية في مشروعك. سنستخدم موديل `gemini-1.5-flash` لأنه سريع جداً وممتاز في التلخيص واستخراج البيانات (ومجاني للتجارب).

**الخطوة 1: الحصول على مفتاح API**
1. اذهب إلى Google AI Studio.
2. أنشئ API Key جديد.
3. افتح ملف `.env` في مشروعك وأضف هذا السطر في آخره:
   ```env
   GEMINI_API_KEY=ضع_المفتاح_هنا
   ```

**الخطوة 2: إنشاء خدمة الذكاء الاصطناعي (Service)**
لكي يكون كودك مرتباً، سننشئ ملفاً مخصصاً للتواصل مع Gemini.
1. في مجلد `app`، أنشئ مجلداً جديداً باسم `Services`.
2. داخله، أنشئ ملفاً باسم `GeminiService.php`.
3. انسخ هذا الكود بالكامل وضعه فيه (هذا الكود جاهز للتحدث مع قوقل):

```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        // نستخدم موديل flash لأنه الأسرع والأفضل لهكذا مهام
        $this->apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $this->apiKey;
    }

    // دالة التلخيص للطالب
    public function summarizeText($text)
    {
        $prompt = "قم بتلخيص النص الأكاديمي التالي بشكل دقيق ومبسط للطلاب في شكل نقاط رئيسية:\n\n" . $text;
        
        return $this->callGemini($prompt);
    }

    // دالة توليد الاختبار للأستاذ
    public function generateQuiz($text, $numberOfQuestions = 5)
    {
        $prompt = "بناءً على النص الأكاديمي التالي، قم بإنشاء $numberOfQuestions أسئلة اختيار من متعدد (MCQ). 
        يجب أن يكون الرد بصيغة JSON فقط بهذا الشكل المطابق تماماً دون أي إضافات أو علامات markdown:[
            {
                'question_text': 'نص السؤال هنا',
                'options':[
                    {'option_text': 'الخيار الأول', 'is_correct': true},
                    {'option_text': 'الخيار الثاني', 'is_correct': false},
                    {'option_text': 'الخيار الثالث', 'is_correct': false},
                    {'option_text': 'الخيار الرابع', 'is_correct': false}
                ]
            }
        ]
        النص:\n" . $text;

        $response = $this->callGemini($prompt);
        
        // تنظيف الرد من علامات ```json التي قد يرسلها الذكاء الاصطناعي
        $cleanedResponse = str_replace(['```json', '```'], '', $response);
        return json_decode($cleanedResponse, true); // تحويل النص إلى مصفوفة برمجية
    }

    // دالة الاتصال بـ API
    private function callGemini($prompt)
    {
        $response = Http::post($this->apiUrl, [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ]
        ]);

        if ($response->successful()) {
            return $response->json('candidates.0.content.parts.0.text');
        }
        return null;
    }
}
```

---

### المرحلة الرابعة: ربط الواجهات بالمنطق (Controllers)

الآن سنقوم بإنشاء العقل المدبر الذي يستقبل طلب الطالب والأستاذ ويستدعي خدمة Gemini.
في الـ Terminal:
```bash
php artisan make:controller AIController
```

اذهب إلى `app/Http/Controllers/AIController.php` واكتب التالي:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lecture;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Services\GeminiService;

class AIController extends Controller
{
    protected $geminiService;

    // استدعاء خدمة الذكاء الاصطناعي
    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    // وظيفة: تلخيص المحاضرة (Use Case: Request AI Summarize)
    public function summarizeLecture($lectureId)
    {
        $lecture = Lecture::findOrFail($lectureId);

        // التحقق مما إذا كان التلخيص موجوداً مسبقاً (لتوفير التكلفة والوقت كما اتفقنا)
        if ($lecture->ai_summary) {
            return response()->json(['summary' => $lecture->ai_summary]);
        }

        // إذا لم يكن موجوداً، نطلبه من Gemini
        $summary = $this->geminiService->summarizeText($lecture->content_text);
        
        // حفظ التلخيص في قاعدة البيانات
        $lecture->update(['ai_summary' => $summary]);

        return response()->json(['summary' => $summary]);
    }

    // وظيفة: التوليد التلقائي للاختبار (Use Case: Generate quiz from uploaded data)
    public function generateQuizForLecture(Request $request, $lectureId)
    {
        $lecture = Lecture::findOrFail($lectureId);
        
        // استدعاء Gemini لإنشاء الأسئلة بصيغة JSON
        $quizData = $this->geminiService->generateQuiz($lecture->content_text, 5); // 5 أسئلة مثلاً

        if(!$quizData) {
            return response()->json(['error' => 'فشل توليد الاختبار'], 500);
        }

        // 1. إنشاء الاختبار (Draft) في جدول Quizzes
        $quiz = Quiz::create([
            'lecture_id' => $lecture->id,
            'title' => 'اختبار الذكاء الاصطناعي: ' . $lecture->title,
            'status' => 'draft',
            'is_ai_generated' => true,
            'duration' => 15
        ]);

        // 2. إدخال الأسئلة والخيارات في قاعدة البيانات
        foreach ($quizData as $qData) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $qData['question_text']
            ]);

            foreach ($qData['options'] as $optData) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $optData['option_text'],
                    'is_correct' => $optData['is_correct']
                ]);
            }
        }

        return response()->json([
            'message' => 'تم إنشاء الاختبار بنجاح، وهو الآن في المسودات',
            'quiz_id' => $quiz->id
        ]);
    }
}
```

---

### المرحلة الخامسة: إنشاء الروابط (Routes)

لكي يتمكن النظام من الوصول إلى الدوال التي برمجناها، يجب تحديد "عناوين URL" لها.
افتح ملف `routes/web.php` (أو `routes/api.php` إذا كنت تبني تطبيق موبايل/React)، وأضف:

```php
use App\Http\Controllers\AIController;

// رابط للطالب لطلب التلخيص
Route::get('/lecture/{id}/summarize',[AIController::class, 'summarizeLecture']);

// رابط للأستاذ لتوليد الاختبار آلياً
Route::post('/lecture/{id}/generate-quiz', [AIController::class, 'generateQuizForLecture']);
```

---

### كيف تبدأ التطبيق العملي كشخص مبتدئ؟ (خلاصة سريعة)

1.  **لا تحاول فهم كل الكود دفعة واحدة:** ابدأ بنسخ ولصق أوامر الـ `Terminal` بالترتيب.
2.  **ركز على قاعدة البيانات أولاً:** تأكد أن الجداول ظهرت في `phpMyAdmin` بشكل صحيح.
3.  **جرب الـ AI:** بعد كتابة ملف `GeminiService.php` وملف `AIController.php`، قم بإضافة محاضرة يدوياً (وهمية) في قاعدة البيانات (في جدول `Lectures`) واكتب أي مقال طويل في حقل `content_text`.
4.  قم بتشغيل السيرفر عن طريق كتابة:
    ```bash
    php artisan serve
    ```
5.  اذهب للمتصفح واكتب: `http://localhost:8000/lecture/1/summarize` (بافتراض أن رقم المحاضرة 1). ستشاهد سحر الـ Gemini يعيد لك التلخيص!

هل الشرح واضح بالنسبة لك بهذا التسلسل؟ إذا كنت مستعداً، ابدأ بتنفيذ (المرحلة الأولى والثانية) وأخبرني إذا واجهتك أي رسالة خطأ في الـ Terminal لنقوم بحلها معاً.

---

## 🗃️ شرح تفصيلي للنماذج (Models) والترحيلات (Migrations)

هذا القسم يشرح كل ملف Model و Migration المقابل له، بما يجب أن يحتويه من حقول وعلاقات وكود.

---

### 1. 📌 نموذج المستخدم — User

**الملف:** `app/Models/User.php`
**الترحيل:** `database/migrations/xxxx_create_users_table.php`

#### حقول قاعدة البيانات:

| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف الفريد |
| `name` | string | اسم الطالب الكامل |
| `email` | string (unique) | البريد الإلكتروني |
| `password` | string (hashed) | كلمة المرور (مشفرة بـ bcrypt) |
| `avatar` | string (nullable) | مسار صورة الملف الشخصي |
| `university` | string (nullable) | اسم الجامعة |
| `major` | string (nullable) | التخصص |
| `level` | string (nullable) | المستوى الدراسي (سنة أولى، ثانية...) |
| `email_verified_at` | timestamp (nullable) | وقت تأكيد البريد |
| `created_at` | timestamp | تاريخ التسجيل |
| `updated_at` | timestamp | تاريخ آخر تحديث |

#### Migration:
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->string('avatar')->nullable();
    $table->string('university')->nullable();
    $table->string('major')->nullable();
    $table->string('level')->nullable();
    $table->rememberToken();
    $table->timestamps();
});
```

#### Model — العلاقات:
```php
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'avatar',
        'university', 'major', 'level',
    ];

    protected $hidden = ['password', 'remember_token'];

    // الطالب لديه عدة مواد
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    // الطالب لديه عدة مهام
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // الطالب لديه عدة ملخصات
    public function summaries()
    {
        return $this->hasMany(Summary::class);
    }

    // الطالب لديه عدة خطط دراسية
    public function studyPlans()
    {
        return $this->hasMany(StudyPlan::class);
    }

    // الطالب لديه عدة اختبارات
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
```

---

### 2. 📚 نموذج المادة الدراسية — Subject

**الملف:** `app/Models/Subject.php`
**الترحيل:** `database/migrations/xxxx_create_subjects_table.php`

#### حقول قاعدة البيانات:

| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف الفريد |
| `user_id` | bigint (FK → users) | صاحب المادة (الطالب) |
| `name` | string | اسم المادة (مثال: "هندسة البرمجيات") |
| `code` | string (nullable) | رمز المادة (مثال: "CS301") |
| `color` | string (nullable) | لون تمييز المادة (hex code) |
| `difficulty` | enum('easy','medium','hard') | مستوى صعوبة المادة |
| `credit_hours` | integer (nullable) | عدد الساعات المعتمدة |
| `description` | text (nullable) | وصف المادة |
| `created_at` | timestamp | تاريخ الإضافة |
| `updated_at` | timestamp | تاريخ آخر تحديث |

#### Migration:
```php
Schema::create('subjects', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('name');
    $table->string('code')->nullable();
    $table->string('color')->nullable();
    $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
    $table->integer('credit_hours')->nullable();
    $table->text('description')->nullable();
    $table->timestamps();
});
```

#### Model — العلاقات:
```php
class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'code', 'color',
        'difficulty', 'credit_hours', 'description',
    ];

    // المادة تتبع لطالب واحد
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // المادة لديها عدة مهام
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // المادة لديها عدة ملخصات
    public function summaries()
    {
        return $this->hasMany(Summary::class);
    }

    // المادة لديها عدة اختبارات
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    // المادة تظهر في عدة خطط دراسية (علاقة متعددة إلى متعددة)
    public function studyPlans()
    {
        return $this->belongsToMany(StudyPlan::class, 'plan_subject')
                    ->withPivot('allocated_hours', 'day_of_week')
                    ->withTimestamps();
    }
}
```

---

### 3. ✅ نموذج المهمة — Task

**الملف:** `app/Models/Task.php`
**الترحيل:** `database/migrations/xxxx_create_tasks_table.php`

#### حقول قاعدة البيانات:

| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف الفريد |
| `user_id` | bigint (FK → users) | صاحب المهمة |
| `subject_id` | bigint (FK → subjects, nullable) | المادة المرتبطة (اختياري) |
| `title` | string | عنوان المهمة |
| `description` | text (nullable) | تفاصيل المهمة |
| `priority` | enum('low','medium','high','urgent') | مستوى الأولوية |
| `status` | enum('pending','in_progress','completed') | حالة المهمة |
| `due_date` | datetime (nullable) | الموعد النهائي |
| `completed_at` | datetime (nullable) | وقت الإنجاز الفعلي |
| `is_crisis` | boolean (default: false) | هل المهمة في وضع الأزمة؟ |
| `created_at` | timestamp | تاريخ الإنشاء |
| `updated_at` | timestamp | تاريخ آخر تحديث |

#### Migration:
```php
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('subject_id')->nullable()->constrained()->onDelete('set null');
    $table->string('title');
    $table->text('description')->nullable();
    $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
    $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
    $table->dateTime('due_date')->nullable();
    $table->dateTime('completed_at')->nullable();
    $table->boolean('is_crisis')->default(false);
    $table->timestamps();
});
```

#### Model — العلاقات:
```php
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'subject_id', 'title', 'description',
        'priority', 'status', 'due_date', 'completed_at', 'is_crisis',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // المهمة تتبع لطالب واحد
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // المهمة قد تكون مرتبطة بمادة
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // نطاق: المهام غير المكتملة
    public function scopePending($query)
    {
        return $query->where('status', '!=', 'completed');
    }

    // نطاق: مهام الأولوية العالية
    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }

    // نطاق: مهام وضع الأزمة
    public function scopeCrisis($query)
    {
        return $query->where('is_crisis', true);
    }
}
```

---

### 4. 📝 نموذج الملخص — Summary

**الملف:** `app/Models/Summary.php`
**الترحيل:** `database/migrations/xxxx_create_summaries_table.php`

#### حقول قاعدة البيانات:

| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف الفريد |
| `user_id` | bigint (FK → users) | صاحب الملخص |
| `subject_id` | bigint (FK → subjects, nullable) | المادة المرتبطة |
| `title` | string | عنوان الملخص |
| `original_text` | longText | النص الأصلي (من الملف أو الإدخال) |
| `summary_text` | longText | الملخص المُنتج بالذكاء الاصطناعي |
| `summary_level` | enum('brief','medium','detailed') | مستوى التلخيص |
| `file_path` | string (nullable) | مسار ملف PDF الأصلي |
| `file_name` | string (nullable) | اسم الملف الأصلي |
| `word_count_original` | integer | عدد كلمات النص الأصلي |
| `word_count_summary` | integer | عدد كلمات الملخص |
| `created_at` | timestamp | تاريخ الإنشاء |
| `updated_at` | timestamp | تاريخ آخر تحديث |

#### Migration:
```php
Schema::create('summaries', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('subject_id')->nullable()->constrained()->onDelete('set null');
    $table->string('title');
    $table->longText('original_text');
    $table->longText('summary_text');
    $table->enum('summary_level', ['brief', 'medium', 'detailed'])->default('medium');
    $table->string('file_path')->nullable();
    $table->string('file_name')->nullable();
    $table->integer('word_count_original')->default(0);
    $table->integer('word_count_summary')->default(0);
    $table->timestamps();
});
```

#### Model — العلاقات:
```php
class Summary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'subject_id', 'title', 'original_text',
        'summary_text', 'summary_level', 'file_path', 'file_name',
        'word_count_original', 'word_count_summary',
    ];

    // الملخص يتبع لطالب واحد
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // الملخص قد يكون مرتبطاً بمادة
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
```

---

### 5. 📅 نموذج خطة الدراسة — StudyPlan

**الملف:** `app/Models/StudyPlan.php`
**الترحيل:** `database/migrations/xxxx_create_study_plans_table.php`

#### حقول قاعدة البيانات:

| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف الفريد |
| `user_id` | bigint (FK → users) | صاحب الخطة |
| `name` | string | اسم الخطة (مثال: "خطة الأسبوع 5") |
| `start_date` | date | تاريخ بداية الأسبوع |
| `end_date` | date | تاريخ نهاية الأسبوع |
| `total_study_hours` | decimal(5,2) | إجمالي ساعات المذاكرة المخططة |
| `is_active` | boolean (default: true) | هل الخطة فعّالة حالياً؟ |
| `is_crisis_mode` | boolean (default: false) | هل الخطة في وضع الأزمة؟ |
| `notes` | text (nullable) | ملاحظات عامة على الخطة |
| `created_at` | timestamp | تاريخ الإنشاء |
| `updated_at` | timestamp | تاريخ آخر تحديث |

#### Migration:
```php
Schema::create('study_plans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('name');
    $table->date('start_date');
    $table->date('end_date');
    $table->decimal('total_study_hours', 5, 2)->default(0);
    $table->boolean('is_active')->default(true);
    $table->boolean('is_crisis_mode')->default(false);
    $table->text('notes')->nullable();
    $table->timestamps();
});
```

#### الجدول الوسيط — `plan_subject` (علاقة متعدد إلى متعدد):

```php
Schema::create('plan_subject', function (Blueprint $table) {
    $table->id();
    $table->foreignId('study_plan_id')->constrained()->onDelete('cascade');
    $table->foreignId('subject_id')->constrained()->onDelete('cascade');
    $table->decimal('allocated_hours', 4, 1)->default(0);
    $table->enum('day_of_week', ['saturday','sunday','monday','tuesday','wednesday','thursday','friday']);
    $table->time('start_time')->nullable();
    $table->time('end_time')->nullable();
    $table->timestamps();

    $table->unique(['study_plan_id', 'subject_id', 'day_of_week']);
});
```

#### Model — العلاقات:
```php
class StudyPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'start_date', 'end_date',
        'total_study_hours', 'is_active', 'is_crisis_mode', 'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'is_crisis_mode' => 'boolean',
    ];

    // الخطة تتبع لطالب واحد
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // الخطة تحتوي عدة مواد (متعدد إلى متعدد)
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'plan_subject')
                    ->withPivot('allocated_hours', 'day_of_week', 'start_time', 'end_time')
                    ->withTimestamps();
    }

    // نطاق: الخطط الفعّالة فقط
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // نطاق: خطط وضع الأزمة
    public function scopeCrisisMode($query)
    {
        return $query->where('is_crisis_mode', true);
    }
}
```

---

### 6. 📋 نموذج الاختبار — Exam

**الملف:** `app/Models/Exam.php`
**الترحيل:** `database/migrations/xxxx_create_exams_table.php`

#### حقول قاعدة البيانات:

| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف الفريق |
| `user_id` | bigint (FK → users) | صاحب الاختبار |
| `subject_id` | bigint (FK → subjects) | المادة المرتبطة |
| `title` | string | عنوان الاختبار (مثال: "ميدترم هندسة برمجيات") |
| `exam_date` | datetime | موعد الاختبار |
| `exam_type` | enum('quiz','midterm','final','oral','practical') | نوع الاختبار |
| `location` | string (nullable) | مكان الاختبار |
| `notes` | text (nullable) | ملاحظات |
| `grade` | decimal(5,2) (nullable) | الدرجة (بعد الاختبار) |
| `max_grade` | decimal(5,2) (nullable) | الدرجة العظمى |
| `is_notified` | boolean (default: false) | هل تم تنبيه الطالب؟ |
| `created_at` | timestamp | تاريخ الإنشاء |
| `updated_at` | timestamp | تاريخ آخر تحديث |

#### Migration:
```php
Schema::create('exams', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('subject_id')->constrained()->onDelete('cascade');
    $table->string('title');
    $table->dateTime('exam_date');
    $table->enum('exam_type', ['quiz', 'midterm', 'final', 'oral', 'practical']);
    $table->string('location')->nullable();
    $table->text('notes')->nullable();
    $table->decimal('grade', 5, 2)->nullable();
    $table->decimal('max_grade', 5, 2)->nullable();
    $table->boolean('is_notified')->default(false);
    $table->timestamps();
});
```

#### Model — العلاقات:
```php
class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'subject_id', 'title', 'exam_date',
        'exam_type', 'location', 'notes', 'grade',
        'max_grade', 'is_notified',
    ];

    protected $casts = [
        'exam_date' => 'datetime',
    ];

    // الاختبار يتبع لطالب واحد
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // الاختبار يتبع لمادة واحدة
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // نطاق: الاختبارات القادمة
    public function scopeUpcoming($query)
    {
        return $query->where('exam_date', '>', now())->orderBy('exam_date');
    }

    // نطاق: اختبارات هذا الأسبوع
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('exam_date', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    // نطاق: اختبارات الأيام القادمة القريبة (لوضع الأزمة)
    public function scopeWithinDays($query, $days = 3)
    {
        return $query->whereBetween('exam_date', [now(), now()->addDays($days)]);
    }
}
```

---

### 7. 🤖 نموذج محادثة المساعد — ChatMessage

**الملف:** `app/Models/ChatMessage.php`
**الترحيل:** `database/migrations/xxxx_create_chat_messages_table.php`

#### حقول قاعدة البيانات:

| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف الفريد |
| `user_id` | bigint (FK → users) | صاحب المحادثة |
| `subject_id` | bigint (FK → subjects, nullable) | المادة المرتبطة |
| `role` | enum('user','assistant') | دور المرسل (طالب أو المساعد الذكي) |
| `message` | longText | محتوى الرسالة |
| `created_at` | timestamp | وقت الإرسال |

#### Migration:
```php
Schema::create('chat_messages', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('subject_id')->nullable()->constrained()->onDelete('set null');
    $table->enum('role', ['user', 'assistant']);
    $table->longText('message');
    $table->timestamps();
});
```

#### Model — العلاقات:
```php
class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'subject_id', 'role', 'message',
    ];

    // الرسالة تتبع لطالب واحد
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // الرسالة قد تكون مرتبطة بمادة
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // نطاق: رسائل مساعد الذكاء الاصطناعي
    public function scopeAssistant($query)
    {
        return $query->where('role', 'assistant');
    }

    // نطاق: رسائل الطالب
    public function scopeUserMessages($query)
    {
        return $query->where('role', 'user');
    }
}
```

---

### 8. 🔔 نموذج التنبيه — Notification

**الملف:** `app/Models/Notification.php`
**الترحيل:** `database/migrations/xxxx_create_notifications_table.php`

#### حقول قاعدة البيانات:

| الحقل | النوع | الوصف |
|-------|------|-------|
| `id` | bigint (PK) | المعرف الفريق |
| `user_id` | bigint (FK → users) | صاحب التنبيه |
| `type` | enum('exam_reminder','task_due','crisis_mode','study_plan','general') | نوع التنبيه |
| `title` | string | عنوان التنبيه |
| `message` | text | محتوى التنبيه |
| `related_type` | string (nullable) | نوع الكيان المرتبط (Exam, Task, etc.) |
| `related_id` | bigint (nullable) | معرف الكيان المرتبط |
| `is_read` | boolean (default: false) | هل تمت قراءة التنبيه؟ |
| `read_at` | timestamp (nullable) | وقت القراءة |
| `created_at` | timestamp | وقت الإنشاء |

#### Migration:
```php
Schema::create('notifications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->enum('type', ['exam_reminder', 'task_due', 'crisis_mode', 'study_plan', 'general']);
    $table->string('title');
    $table->text('message');
    $table->string('related_type')->nullable();
    $table->unsignedBigInteger('related_id')->nullable();
    $table->boolean('is_read')->default(false);
    $table->timestamp('read_at')->nullable();
    $table->timestamps();
});
```

#### Model — العلاقات:
```php
class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'title', 'message',
        'related_type', 'related_id', 'is_read', 'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    // التنبيه يتبع لطالب واحد
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // نطاق: التنبيهات غير المقروءة
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // نطاق: تنبيهات وضع الأزمة
    public function scopeCrisis($query)
    {
        return $query->where('type', 'crisis_mode');
    }

    // تحديد التنبيه كمقروء
    public function markAsRead()
    {
        $this->update(['is_read' => true, 'read_at' => now()]);
    }
}
```

---

### 🗺️ مخطط العلاقات (ER Diagram)

```
User (1) ──────< (N) Subject
  │                   │
  │                   ├──< Task
  │                   ├──< Summary
  │                   ├──< Exam
  │                   └──>< StudyPlan  (متعدد إلى متعدد عبر plan_subject)
  │
  ├──< Task
  ├──< Summary
  ├──< StudyPlan
  ├──< Exam
  ├──< ChatMessage
  └──< Notification
```

### 📊 ملخص الجداول

| # | الجدول | الوصف | العلاقة مع User |
|---|--------|-------|----------------|
| 1 | `users` | بيانات الطلاب | — |
| 2 | `subjects` | المواد الدراسية | واحد إلى متعدد |
| 3 | `tasks` | المهام الدراسية | واحد إلى متعدد |
| 4 | `summaries` | ملخصات الذكاء الاصطناعي | واحد إلى متعدد |
| 5 | `study_plans` | خطط المذاكرة الأسبوعية | واحد إلى متعدد |
| 6 | `plan_subject` | جدول وسيط (خطة ↔ مادة) | — |
| 7 | `exams` | الاختبارات والمواعيد | واحد إلى متعدد |
| 8 | `chat_messages` | محادثات المساعد الذكي | واحد إلى متعدد |
| 9 | `notifications` | التنبيهات والإشعارات | واحد إلى متعدد |

---

### 🚀 أوامر إنشاء الـ Migrations والـ Models

```bash
# إنشاء Model + Migration معاً
php artisan make:model Subject -m
php artisan make:model Task -m
php artisan make:model Summary -m
php artisan make:model StudyPlan -m
php artisan make:model Exam -m
php artisan make:model ChatMessage -m
php artisan make:model Notification -m

# إنشاء الجدول الوسيط
php artisan make:migration create_plan_subject_table

# بعد تعبئة كل migration، شغّل:
php artisan migrate
```

> **ملاحظة:** نموذج `User` يأتي جاهزاً مع Laravel، فقط عدّل عليه بإضافة الحقول والعلاقات الجديدة.
