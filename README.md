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

---

## 🎮 شرح تفصيلي لوحدات التحكم (Controllers)

هذا القسم يشرح كل ملف Controller بالتفصيل: دواله، المنطق البرمجي، والـ endpoints الخاصة به، مبني على قواعد البيانات المعرفة أعلاه.

---

### 1. 🔐 وحدة تحكم المصادقة — AuthController

**الملف:** `app/Http/Controllers/AuthController.php`
**الأمر:** `php artisan make:controller AuthController`

#### الدوال المطلوبة:

| الدالة | الوصف | Method | Route |
|--------|-------|--------|-------|
| `showRegisterForm()` | عرض صفحة التسجيل | GET | `/register` |
| `register()` | معالجة بيانات التسجيل وحفظ المستخدم الجديد | POST | `/register` |
| `showLoginForm()` | عرض صفحة تسجيل الدخول | GET | `/login` |
| `login()` | التحقق من البيانات وتسجيل الدخول | POST | `/login` |
| `logout()` | تسجيل الخروج وحذف الجلسة | POST | `/logout` |
| `profile()` | عرض صفحة الملف الشخصي | GET | `/profile` |
| `updateProfile()` | تحديث بيانات الملف الشخصي | PUT | `/profile` |

#### الكود التفصيلي:

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    // ========== عرض صفحة التسجيل ==========
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // ========== معالجة التسجيل ==========
    public function register(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:8|confirmed',
            'university'   => 'nullable|string|max:255',
            'major'        => 'nullable|string|max:255',
            'level'        => 'nullable|string|max:255',
        ]);

        // تشفير كلمة المرور
        $validated['password'] = Hash::make($validated['password']);

        // إنشاء المستخدم
        $user = User::create($validated);

        // تسجيل الدخول تلقائياً بعد التسجيل
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'تم التسجيل بنجاح!');
    }

    // ========== عرض صفحة تسجيل الدخول ==========
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ========== معالجة تسجيل الدخول ==========
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // محاولة تسجيل الدخول مع خيار "تذكرني"
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate(); // منع هجوم session fixation
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->onlyInput('email');
    }

    // ========== تسجيل الخروج ==========
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // ========== عرض الملف الشخصي ==========
    public function profile()
    {
        return view('auth.profile', ['user' => Auth::user()]);
    }

    // ========== تحديث الملف الشخصي ==========
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'university' => 'nullable|string|max:255',
            'major'      => 'nullable|string|max:255',
            'level'      => 'nullable|string|max:255',
            'avatar'     => 'nullable|image|max:2048',
        ]);

        // رفع الصورة الشخصية إن وُجدت
        if ($request->hasFile('avatar')) {
            // حذف الصورة القديمة إن وجدت
            if ($user->avatar) {
                \Storage::delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return back()->with('success', 'تم تحديث الملف الشخصي بنجاح.');
    }
}
```

#### الـ Middleware المطلوب:
```php
// في Routes: تطبيق middleware auth على الصفحات المحمية
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
```

---

### 2. 🏠 وحدة تحكم لوحة التحكم — DashboardController

**الملف:** `app/Http/Controllers/DashboardController.php`
**الأمر:** `php artisan make:controller DashboardController`

#### الدوال المطلوبة:

| الدالة | الوصف | Method | Route |
|--------|-------|--------|-------|
| `index()` | الصفحة الرئيسية — عرض ملخص شامل للطالب | GET | `/dashboard` |

#### الكود التفصيلي:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Summary;
use App\Models\Exam;
use App\Models\Notification;
use App\Models\StudyPlan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // ========== عرض لوحة التحكم الرئيسية ==========
    public function index()
    {
        $user = Auth::user();

        // 1. إحصائيات المهام
        $totalTasks       = $user->tasks()->count();
        $completedTasks   = $user->tasks()->where('status', 'completed')->count();
        $pendingTasks     = $user->tasks()->where('status', 'pending')->count();
        $progressPercent  = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        // 2. الاختبارات القادمة (أقرب 5)
        $upcomingExams = $user->exams()
            ->where('exam_date', '>', now())
            ->orderBy('exam_date')
            ->take(5)
            ->get();

        // 3. هل نحن في وضع الأزمة؟ (اختبار خلال 3 أيام)
        $crisisActive = $user->exams()
            ->whereBetween('exam_date', [now(), now()->addDays(3)])
            ->exists();

        // 4. الخطة الدراسية الفعّالة
        $activePlan = $user->studyPlans()->where('is_active', true)->first();

        // 5. آخر الملخصات
        $recentSummaries = $user->summaries()
            ->latest()
            ->take(5)
            ->get();

        // 6. التنبيهات غير المقروءة
        $unreadNotifications = $user->notifications ?? collect();
        // ملاحظة: لو استخدمت Laravel Notification الأصلي:
        // $unreadNotifications = $user->unreadNotifications;

        // 7. تفعيل وضع الأزمة تلقائياً إن لزم
        if ($crisisActive && $activePlan && !$activePlan->is_crisis_mode) {
            $activePlan->update(['is_crisis_mode' => true]);
        }

        return view('dashboard', compact(
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'progressPercent',
            'upcomingExams',
            'crisisActive',
            'activePlan',
            'recentSummaries',
            'unreadNotifications'
        ));
    }
}
```

#### ما تعرضه صفحة `dashboard.blade.php`:
- **شريط تقدم** المهام (مثلاً: 65% مكتمل)
- **بطاقات** بالاختبارات القادمة مع العد التنازلي
- **تنبيه وضع الأزمة** 🔴 إن كان مفعّلاً
- **الخطة الأسبوعية** الحالية
- **آخر الملخصات** مع روابط سريعة
- **عدد التنبيهات** غير المقروءة

---

### 3. 📝 وحدة تحكم التلخيص — SummaryController

**الملف:** `app/Http/Controllers/SummaryController.php`
**الأمر:** `php artisan make:controller SummaryController`

#### الدوال المطلوبة:

| الدالة | الوصف | Method | Route |
|--------|-------|--------|-------|
| `index()` | عرض قائمة كل الملخصات | GET | `/summaries` |
| `create()` | عرض صفحة إنشاء ملخص جديد | GET | `/summaries/create` |
| `store()` | حفظ الملخص الجديد (مع استدعاء AI) | POST | `/summaries` |
| `show($id)` | عرض ملخص محدد | GET | `/summaries/{id}` |
| `destroy($id)` | حذف ملخص | DELETE | `/summaries/{id}` |

#### الكود التفصيلي:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Summary;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Smalot\PdfParser\Parser; // لت parsed PDF — يُثبّت via composer

class SummaryController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    // ========== عرض كل الملخصات ==========
    public function index()
    {
        $summaries = Auth::user()->summaries()
            ->with('subject')
            ->latest()
            ->paginate(10);

        return view('summaries.index', compact('summaries'));
    }

    // ========== عرض صفحة إنشاء ملخص ==========
    public function create()
    {
        $subjects = Auth::user()->subjects;
        return view('summaries.create', compact('subjects'));
    }

    // ========== حفظ الملخص الجديد ==========
    public function store(Request $request)
    {
        // التحقق من المدخلات
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'subject_id'    => 'nullable|exists:subjects,id',
            'content'       => 'nullable|string',           // النص المُدخل يدوياً
            'pdf_file'      => 'nullable|file|mimes:pdf|max:20480', // ملف PDF (حد 20MB)
            'summary_level' => 'required|in:brief,medium,detailed',
        ]);

        $originalText = '';
        $filePath = null;
        $fileName = null;

        // ===== استخراج النص من PDF إن وُجد =====
        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('uploads/pdfs', 'public');

            // استخراج النص باستخدام PdfParser
            $parser = new Parser();
            $pdf = $parser->parseFile($file->getRealPath());
            $originalText = $pdf->getText();
        }

        // أو استخدام النص المُدخل يدوياً
        if (empty($originalText) && $request->filled('content')) {
            $originalText = $request->input('content');
        }

        // التأكد من وجود نص للتلخيص
        if (empty(trim($originalText))) {
            return back()->withErrors(['content' => 'يرجى إدخال نص أو رفع ملف PDF.'])->withInput();
        }

        // ===== استدعاء خدمة الذكاء الاصطناعي للتلخيص =====
        $summaryText = $this->aiService->summarize($originalText, $validated['summary_level']);

        // ===== حفظ الملخص في قاعدة البيانات =====
        $summary = Summary::create([
            'user_id'              => Auth::id(),
            'subject_id'           => $validated['subject_id'],
            'title'                => $validated['title'],
            'original_text'        => $originalText,
            'summary_text'         => $summaryText,
            'summary_level'        => $validated['summary_level'],
            'file_path'            => $filePath,
            'file_name'            => $fileName,
            'word_count_original'  => str_word_count($originalText),
            'word_count_summary'   => str_word_count($summaryText),
        ]);

        return redirect()->route('summaries.show', $summary->id)
            ->with('success', 'تم إنشاء الملخص بنجاح!');
    }

    // ========== عرض ملخص محدد ==========
    public function show($id)
    {
        $summary = Summary::where('user_id', Auth::id())
            ->where('id', $id)
            ->with('subject')
            ->firstOrFail();

        // حساب نسبة التلخيص
        $reductionPercent = $summary->word_count_original > 0
            ? round((1 - $summary->word_count_summary / $summary->word_count_original) * 100)
            : 0;

        return view('summaries.show', compact('summary', 'reductionPercent'));
    }

    // ========== حذف ملخص ==========
    public function destroy($id)
    {
        $summary = Summary::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        // حذف ملف PDF من التخزين
        if ($summary->file_path) {
            \Storage::disk('public')->delete($summary->file_path);
        }

        $summary->delete();

        return redirect()->route('summaries.index')
            ->with('success', 'تم حذف الملخص بنجاح.');
    }
}
```

#### الحزم الإضافية المطلوبة:
```bash
# لاستخراج النص من PDF
composer require smalot/pdfparser
```

---

### 4. 🤖 وحدة تحكم المساعد الذكي — AssistantController

**الملف:** `app/Http/Controllers/AssistantController.php`
**الأمر:** `php artisan make:controller AssistantController`

#### الدوال المطلوبة:

| الدالة | الوصف | Method | Route |
|--------|-------|--------|-------|
| `index()` | عرض صفحة المحادثة | GET | `/assistant` |
| `chat()` | إرسال رسالة واستلام رد AI | POST | `/assistant/chat` |
| `history()` | عرض سجل المحادثات | GET | `/assistant/history` |
| `generateQuiz()` | توليد أسئلة تدريبية | POST | `/assistant/generate-quiz` |

#### الكود التفصيلي:

```php
<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistantController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    // ========== عرض صفحة المحادثة ==========
    public function index(Request $request)
    {
        $subjectId = $request->query('subject_id');
        $subjects = Auth::user()->subjects;

        // جلب آخر 50 رسالة في المحادثة (أو لمادة محددة)
        $messages = ChatMessage::where('user_id', Auth::id())
            ->when($subjectId, fn($q) => $q->where('subject_id', $subjectId))
            ->latest()
            ->take(50)
            ->get()
            ->reverse()
            ->values();

        return view('assistant.index', compact('messages', 'subjects', 'subjectId'));
    }

    // ========== إرسال رسالة واستلام رد AI ==========
    public function chat(Request $request)
    {
        $validated = $request->validate([
            'message'    => 'required|string|max:5000',
            'subject_id' => 'nullable|exists:subjects,id',
        ]);

        // حفظ رسالة المستخدم
        ChatMessage::create([
            'user_id'    => Auth::id(),
            'subject_id' => $validated['subject_id'],
            'role'       => 'user',
            'message'    => $validated['message'],
        ]);

        // جلب آخر 10 رسائل كسياق للمحادثة
        $chatHistory = ChatMessage::where('user_id', Auth::id())
            ->when($validated['subject_id'], fn($q) => $q->where('subject_id', $validated['subject_id']))
            ->latest()
            ->take(10)
            ->get()
            ->reverse();

        // استدعاء الذكاء الاصطناعي
        $aiReply = $this->aiService->chat($chatHistory, $validated['message']);

        // حفظ رد المساعد
        ChatMessage::create([
            'user_id'    => Auth::id(),
            'subject_id' => $validated['subject_id'],
            'role'       => 'assistant',
            'message'    => $aiReply,
        ]);

        return response()->json([
            'reply' => $aiReply,
        ]);
    }

    // ========== عرض سجل المحادثات ==========
    public function history(Request $request)
    {
        $conversations = ChatMessage::where('user_id', Auth::id())
            ->selectRaw('subject_id, DATE(created_at) as date, COUNT(*) as message_count')
            ->groupBy('subject_id', \DB::raw('DATE(created_at)'))
            ->orderByDesc('date')
            ->paginate(20);

        return view('assistant.history', compact('conversations'));
    }

    // ========== توليد أسئلة تدريبية ==========
    public function generateQuiz(Request $request)
    {
        $validated = $request->validate([
            'subject_id'    => 'required|exists:subjects,id',
            'topic'         => 'required|string|max:500',
            'question_type' => 'required|in:multiple_choice,true_false,essay,mixed',
            'count'         => 'required|integer|min:1|max:20',
            'difficulty'    => 'required|in:easy,medium,hard',
        ]);

        $subject = Auth::user()->subjects()->findOrFail($validated['subject_id']);

        // استدعاء AI لتوليد الأسئلة
        $questions = $this->aiService->generateQuiz(
            $subject->name,
            $validated['topic'],
            $validated['question_type'],
            $validated['count'],
            $validated['difficulty']
        );

        return response()->json([
            'subject'   => $subject->name,
            'questions' => $questions,
        ]);
    }
}
```

---

### 5. ✅ وحدة تحكم المهام — TaskController

**الملف:** `app/Http/Controllers/TaskController.php`
**الأمر:** `php artisan make:controller TaskController`

#### الدوال المطلوبة:

| الدالة | الوصف | Method | Route |
|--------|-------|--------|-------|
| `index()` | عرض قائمة المهام مع فلترة وترتيب | GET | `/tasks` |
| `create()` | عرض صفحة إنشاء مهمة جديدة | GET | `/tasks/create` |
| `store()` | حفظ المهمة الجديدة | POST | `/tasks` |
| `show($id)` | عرض تفاصيل مهمة | GET | `/tasks/{id}` |
| `edit($id)` | عرض صفحة تعديل مهمة | GET | `/tasks/{id}/edit` |
| `update()` | تحديث المهمة | PUT/PATCH | `/tasks/{id}` |
| `destroy($id)` | حذف مهمة | DELETE | `/tasks/{id}` |
| `toggleStatus($id)` | تبديل حالة المهمة (مكتمل/غير مكتمل) | PATCH | `/tasks/{id}/toggle` |
| `reorderPriorities()` | إعادة ترتيب الأولويات ذكياً | POST | `/tasks/reorder` |

#### الكود التفصيلي:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // ========== عرض كل المهام مع فلترة ==========
    public function index(Request $request)
    {
        $query = Task::where('user_id', Auth::id())->with('subject');

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب الأولوية
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // فلترة حسب المادة
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // فلترة: المهام المتأخرة
        if ($request->boolean('overdue')) {
            $query->where('due_date', '<', now())
                  ->where('status', '!=', 'completed');
        }

        // ترتيب: الأقرب موعداً أولاً
        $tasks = $query->orderByRaw("
            CASE priority
                WHEN 'urgent' THEN 1
                WHEN 'high' THEN 2
                WHEN 'medium' THEN 3
                WHEN 'low' THEN 4
            END
        ")->orderBy('due_date', 'asc')->paginate(15);

        $subjects = Auth::user()->subjects;

        return view('tasks.index', compact('tasks', 'subjects'));
    }

    // ========== عرض صفحة إنشاء مهمة ==========
    public function create()
    {
        $subjects = Auth::user()->subjects;
        return view('tasks.create', compact('subjects'));
    }

    // ========== حفظ مهمة جديدة ==========
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id'  => 'nullable|exists:subjects,id',
            'priority'    => 'required|in:low,medium,high,urgent',
            'due_date'    => 'nullable|date|after:now',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        Task::create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'تم إنشاء المهمة بنجاح.');
    }

    // ========== عرض مهمة محددة ==========
    public function show($id)
    {
        $task = Task::where('user_id', Auth::id())
            ->where('id', $id)
            ->with('subject')
            ->firstOrFail();

        return view('tasks.show', compact('task'));
    }

    // ========== عرض صفحة التعديل ==========
    public function edit($id)
    {
        $task = Task::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $subjects = Auth::user()->subjects;
        return view('tasks.edit', compact('task', 'subjects'));
    }

    // ========== تحديث مهمة ==========
    public function update(Request $request, $id)
    {
        $task = Task::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id'  => 'nullable|exists:subjects,id',
            'priority'    => 'required|in:low,medium,high,urgent',
            'status'      => 'required|in:pending,in_progress,completed',
            'due_date'    => 'nullable|date',
        ]);

        // إذا تم تحديد المهمة كمكتملة، سجّل وقت الإنجاز
        if ($validated['status'] === 'completed' && $task->status !== 'completed') {
            $validated['completed_at'] = now();
        }

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'تم تحديث المهمة بنجاح.');
    }

    // ========== حذف مهمة ==========
    public function destroy($id)
    {
        $task = Task::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'تم حذف المهمة.');
    }

    // ========== تبديل حالة المهمة (AJAX) ==========
    public function toggleStatus($id)
    {
        $task = Task::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if ($task->status === 'completed') {
            $task->update([
                'status'       => 'pending',
                'completed_at' => null,
            ]);
        } else {
            $task->update([
                'status'       => 'completed',
                'completed_at' => now(),
            ]);
        }

        return response()->json([
            'status'       => $task->status,
            'completed_at' => $task->completed_at?->format('Y-m-d H:i'),
        ]);
    }

    // ========== إعادة ترتيب الأولويات ذكياً ==========
    public function reorderPriorities()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->where('status', '!=', 'completed')
            ->get();

        foreach ($tasks as $task) {
            $newPriority = $this->calculateSmartPriority($task);
            $task->update(['priority' => $newPriority]);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'تم إعادة ترتيب الأولويات بناءً على الموعد والأهمية.');
    }

    /**
     * حساب الأولوية الذكية للمهمة
     * كلما اقترب الموعد وزادت الأهمية، ارتفعت الأولوية
     */
    private function calculateSmartPriority(Task $task): string
    {
        if (!$task->due_date) return 'medium';

        $daysLeft = now()->diffInDays($task->due_date, false);

        if ($daysLeft < 0) return 'urgent';       // متأخر
        if ($daysLeft <= 1) return 'urgent';       // غداً
        if ($daysLeft <= 3) return 'high';         // خلال 3 أيام
        if ($daysLeft <= 7) return 'medium';       // خلال أسبوع
        return 'low';                              // أكثر من أسبوع
    }
}
```

---

### 6. 📅 وحدة تحكم خطة الدراسة — ScheduleController

**الملف:** `app/Http/Controllers/ScheduleController.php`
**الأمر:** `php artisan make:controller ScheduleController`

#### الدوال المطلوبة:

| الدالة | الوصف | Method | Route |
|--------|-------|--------|-------|
| `index()` | عرض خطط الدراسة | GET | `/plans` |
| `create()` | عرض صفحة إنشاء خطة | GET | `/plans/create` |
| `store()` | حفظ خطة جديدة (بناءً على خوارزمية ذكية) | POST | `/plans` |
| `show($id)` | عرض خطة محددة بالتفصيل | GET | `/plans/{id}` |
| `destroy($id)` | حذف خطة | DELETE | `/plans/{id}` |
| `activateCrisisMode()` | تفعيل وضع الأزمة يدوياً | POST | `/plans/crisis` |

#### الكود التفصيلي:

```php
<?php

namespace App\Http\Controllers;

use App\Models\StudyPlan;
use App\Models\Subject;
use App\Services\ScheduleGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    protected $scheduleGenerator;

    public function __construct(ScheduleGenerator $scheduleGenerator)
    {
        $this->scheduleGenerator = $scheduleGenerator;
    }

    // ========== عرض كل الخطط ==========
    public function index()
    {
        $plans = Auth::user()->studyPlans()
            ->with('subjects')
            ->latest()
            ->paginate(10);

        return view('plans.index', compact('plans'));
    }

    // ========== عرض صفحة إنشاء خطة ==========
    public function create()
    {
        $subjects = Auth::user()->subjects;
        $exams = Auth::user()->exams()
            ->where('exam_date', '>', now())
            ->orderBy('exam_date')
            ->get();

        return view('plans.create', compact('subjects', 'exams'));
    }

    // ========== إنشاء خطة دراسية ذكية ==========
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after:start_date',
            'subjects'          => 'required|array|min:1',
            'subjects.*.id'     => 'required|exists:subjects,id',
            'subjects.*.hours'  => 'required|numeric|min:0.5|max:12',
            'daily_study_hours' => 'required|numeric|min:1|max:16',
            'preferred_days'    => 'nullable|array',
            'preferred_days.*'  => 'in:saturday,sunday,monday,tuesday,wednesday,thursday,friday',
        ]);

        // إنشاء الخطة
        $plan = StudyPlan::create([
            'user_id'            => Auth::id(),
            'name'               => $validated['name'],
            'start_date'         => $validated['start_date'],
            'end_date'           => $validated['end_date'],
            'total_study_hours'  => collect($validated['subjects'])->sum('hours'),
        ]);

        // استدعاء خوارزمية الجدولة الذكية
        $schedule = $this->scheduleGenerator->generate(
            $plan,
            $validated['subjects'],
            $validated['daily_study_hours'],
            $validated['preferred_days'] ?? null
        );

        // ربط المواد بالخطة عبر الجدول الوسيط
        foreach ($schedule as $entry) {
            $plan->subjects()->attach($entry['subject_id'], [
                'allocated_hours' => $entry['hours'],
                'day_of_week'     => $entry['day'],
                'start_time'      => $entry['start_time'] ?? null,
                'end_time'        => $entry['end_time'] ?? null,
            ]);
        }

        return redirect()->route('plans.show', $plan->id)
            ->with('success', 'تم إنشاء خطة المذاكرة بنجاح!');
    }

    // ========== عرض خطة محددة ==========
    public function show($id)
    {
        $plan = StudyPlan::where('user_id', Auth::id())
            ->where('id', $id)
            ->with('subjects')
            ->firstOrFail();

        // ترتيب المواد حسب الأيام
        $scheduleByDay = $plan->subjects->groupBy('pivot.day_of_week');

        return view('plans.show', compact('plan', 'scheduleByDay'));
    }

    // ========== حذف خطة ==========
    public function destroy($id)
    {
        $plan = StudyPlan::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $plan->delete();

        return redirect()->route('plans.index')
            ->with('success', 'تم حذف الخطة.');
    }

    // ========== تفعيل وضع الأزمة ==========
    public function activateCrisisMode(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:study_plans,id',
        ]);

        $plan = StudyPlan::where('user_id', Auth::id())
            ->where('id', $validated['plan_id'])
            ->firstOrFail();

        // تفعيل وضع الأزمة
        $plan->update(['is_crisis_mode' => true]);

        // جلب الاختبارات القريبة
        $upcomingExams = Auth::user()->exams()
            ->whereBetween('exam_date', [now(), now()->addDays(5)])
            ->orderBy('exam_date')
            ->get();

        // إعادة ترتيب المواد: الأقرب اختباراً يحصل على ساعات أكثر
        foreach ($plan->subjects as $subject) {
            $nearestExam = $upcomingExams->firstWhere('subject_id', $subject->id);
            if ($nearestExam) {
                $daysUntilExam = now()->diffInDays($nearestExam->exam_date);
                // كلما الاختبار أقرب، زادت الساعات
                $extraHours = max(1, 5 - $daysUntilExam);

                $plan->subjects()->updateExistingPivot($subject->id, [
                    'allocated_hours' => $subject->pivot->allocated_hours + $extraHours,
                ]);
            }
        }

        // تحويل المهام غير المكتملة إلى وضع أزمة
        Auth::user()->tasks()
            ->where('status', '!=', 'completed')
            ->update(['is_crisis' => true]);

        return back()->with('warning', '🚨 تم تفعيل وضع الأزمة! تم إعادة ترتيب الأولويات.');
    }
}
```

---

### 7. 📚 وحدة تحكم المواد — SubjectController

**الملف:** `app/Http/Controllers/SubjectController.php`
**الأمر:** `php artisan make:controller SubjectController`

#### الدوال المطلوبة:

| الدالة | الوصف | Method | Route |
|--------|-------|--------|-------|
| `index()` | عرض قائمة المواد | GET | `/subjects` |
| `store()` | إضافة مادة جديدة | POST | `/subjects` |
| `update()` | تعديل مادة | PUT | `/subjects/{id}` |
| `destroy()` | حذف مادة | DELETE | `/subjects/{id}` |

#### الكود التفصيلي:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    // ========== عرض كل المواد ==========
    public function index()
    {
        $subjects = Auth::user()->subjects()
            ->withCount(['tasks', 'summaries', 'exams'])
            ->latest()
            ->get();

        return view('subjects.index', compact('subjects'));
    }

    // ========== إضافة مادة جديدة ==========
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'nullable|string|max:50',
            'color'         => 'nullable|string|max:7',  // hex color
            'difficulty'    => 'required|in:easy,medium,hard',
            'credit_hours'  => 'nullable|integer|min:1|max:10',
            'description'   => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = Auth::id();

        Subject::create($validated);

        return redirect()->route('subjects.index')
            ->with('success', 'تمت إضافة المادة بنجاح.');
    }

    // ========== تعديل مادة ==========
    public function update(Request $request, $id)
    {
        $subject = Subject::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'nullable|string|max:50',
            'color'         => 'nullable|string|max:7',
            'difficulty'    => 'required|in:easy,medium,hard',
            'credit_hours'  => 'nullable|integer|min:1|max:10',
            'description'   => 'nullable|string|max:1000',
        ]);

        $subject->update($validated);

        return redirect()->route('subjects.index')
            ->with('success', 'تم تحديث المادة.');
    }

    // ========== حذف مادة ==========
    public function destroy($id)
    {
        $subject = Subject::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $subject->delete();

        return redirect()->route('subjects.index')
            ->with('success', 'تم حذف المادة.');
    }
}
```

---

### 8. 📋 وحدة تحكم الاختبارات — ExamController

**الملف:** `app/Http/Controllers/ExamController.php`
**الأمر:** `php artisan make:controller ExamController`

#### الدوال المطلوبة:

| الدالة | الوصف | Method | Route |
|--------|-------|--------|-------|
| `index()` | عرض الاختبارات | GET | `/exams` |
| `store()` | إضافة اختبار | POST | `/exams` |
| `update()` | تعديل اختبار | PUT | `/exams/{id}` |
| `destroy()` | حذف اختبار | DELETE | `/exams/{id}` |

#### الكود التفصيلي:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    // ========== عرض الاختبارات ==========
    public function index(Request $request)
    {
        $query = Exam::where('user_id', Auth::id())->with('subject');

        // فلترة: القادمة فقط
        if ($request->boolean('upcoming')) {
            $query->where('exam_date', '>', now());
        }

        // فلترة: حسب المادة
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        $exams = $query->orderBy('exam_date', 'asc')->paginate(15);
        $subjects = Auth::user()->subjects;

        return view('exams.index', compact('exams', 'subjects'));
    }

    // ========== إضافة اختبار ==========
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title'      => 'required|string|max:255',
            'exam_date'  => 'required|date|after:now',
            'exam_type'  => 'required|in:quiz,midterm,final,oral,practical',
            'location'   => 'nullable|string|max:255',
            'notes'      => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        Exam::create($validated);

        return redirect()->route('exams.index')
            ->with('success', 'تمت إضافة الاختبار بنجاح.');
    }

    // ========== تعديل اختبار ==========
    public function update(Request $request, $id)
    {
        $exam = Exam::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title'      => 'required|string|max:255',
            'exam_date'  => 'required|date',
            'exam_type'  => 'required|in:quiz,midterm,final,oral,practical',
            'location'   => 'nullable|string|max:255',
            'notes'      => 'nullable|string',
            'grade'      => 'nullable|numeric|min:0',
            'max_grade'  => 'nullable|numeric|min:0',
        ]);

        $exam->update($validated);

        return redirect()->route('exams.index')
            ->with('success', 'تم تحديث الاختبار.');
    }

    // ========== حذف اختبار ==========
    public function destroy($id)
    {
        $exam = Exam::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $exam->delete();

        return redirect()->route('exams.index')
            ->with('success', 'تم حذف الاختبار.');
    }
}
```

---

### 9. 🔔 وحدة تحكم التنبيهات — NotificationController

**الملف:** `app/Http/Controllers/NotificationController.php`
**الأمر:** `php artisan make:controller NotificationController`

#### الدوال المطلوبة:

| الدالة | الوصف | Method | Route |
|--------|-------|--------|-------|
| `index()` | عرض كل التنبيهات | GET | `/notifications` |
| `markAsRead($id)` | تحديد تنبيه كمقروء | PATCH | `/notifications/{id}/read` |
| `markAllRead()` | تحديد الكل كمقروء | POST | `/notifications/read-all` |

#### الكود التفصيلي:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // ========== عرض التنبيهات ==========
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    // ========== تحديد تنبيه كمقروء ==========
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json(['status' => 'read']);
    }

    // ========== تحديد الكل كمقروء ==========
    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return back()->with('success', 'تم تحديد كل التنبيهات كمقروءة.');
    }
}
```

---

### 🔗 ملخص الـ Routes

ضع الكود التالي في ملف `routes/web.php`:

```php
use App\Http\Controllers\{
    AuthController,
    DashboardController,
    SummaryController,
    AssistantController,
    TaskController,
    ScheduleController,
    SubjectController,
    ExamController,
    NotificationController
};

// ========== صفحات عامة (بدون تسجيل دخول) ==========
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// ========== صفحات محمية (تتطلب تسجيل دخول) ==========
Route::middleware('auth')->group(function () {

    // خروج
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // الملف الشخصي
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // لوحة التحكم
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // المواد الدراسية
    Route::resource('subjects', SubjectController::class)->except(['create', 'show', 'edit']);

    // المهام
    Route::resource('tasks', TaskController::class);
    Route::patch('/tasks/{id}/toggle', [TaskController::class, 'toggleStatus'])->name('tasks.toggle');
    Route::post('/tasks/reorder', [TaskController::class, 'reorderPriorities'])->name('tasks.reorder');

    // الملخصات
    Route::resource('summaries', SummaryController::class);
    Route::post('/summaries', [SummaryController::class, 'store'])->name('summaries.store');

    // خطط الدراسة
    Route::resource('plans', ScheduleController::class);
    Route::post('/plans/crisis', [ScheduleController::class, 'activateCrisisMode'])->name('plans.crisis');

    // الاختبارات
    Route::resource('exams', ExamController::class)->except(['create', 'show', 'edit']);

    // المساعد الذكي
    Route::get('/assistant', [AssistantController::class, 'index'])->name('assistant');
    Route::post('/assistant/chat', [AssistantController::class, 'chat'])->name('assistant.chat');
    Route::get('/assistant/history', [AssistantController::class, 'history'])->name('assistant.history');
    Route::post('/assistant/generate-quiz', [AssistantController::class, 'generateQuiz'])->name('assistant.quiz');

    // التنبيهات
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');

    // الصفحة الرئيسية → Dashboard
    Route::get('/', fn() => redirect()->route('dashboard'));
});
```

---

### 📊 ملخص الـ Controllers

| # | Controller | الدوال | المسؤولية |
|---|-----------|--------|-----------|
| 1 | `AuthController` | 7 | التسجيل، الدخول، الخروج، الملف الشخصي |
| 2 | `DashboardController` | 1 | عرض لوحة التحكم الشاملة |
| 3 | `SummaryController` | 5 | رفع الملفات، التلخيص بالـ AI، عرض الملخصات |
| 4 | `AssistantController` | 4 | المحادثة الذكية، توليد الأسئلة |
| 5 | `TaskController` | 9 | CRUD المهام + تبديل الحالة + ترتيب ذكي |
| 6 | `ScheduleController` | 6 | خطط المذاكرة + وضع الأزمة |
| 7 | `SubjectController` | 4 | CRUD المواد الدراسية |
| 8 | `ExamController` | 4 | CRUD الاختبارات |
| 9 | `NotificationController` | 3 | عرض وتحديد التنبيهات |

---

### 🚀 أوامر إنشاء الـ Controllers

```bash
php artisan make:controller AuthController
php artisan make:controller DashboardController
php artisan make:controller SummaryController
php artisan make:controller AssistantController
php artisan make:controller TaskController
php artisan make:controller ScheduleController
php artisan make:controller SubjectController
php artisan make:controller ExamController
php artisan make:controller NotificationController
```
