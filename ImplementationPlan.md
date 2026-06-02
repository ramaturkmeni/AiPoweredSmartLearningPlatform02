# خطة تنفيذ: إصلاح التلخيص + التحويل لـ Gemini API

## تشخيص المشكلة

### السبب الجذري
عندما يطلب الطالب تلخيص محاضرة، الكود الحالي في `Student\LectureController@summarize` يرسل **فقط** حقل `content_text` إلى نموذج الذكاء الاصطناعي:

```php
// LectureController.php سطر 48
$summaryResult = $this->ai->summarize($lecture->content_text, $level);
```

**المشكلة**: عندما الأستاذ يرفع ملف PDF للمحاضرة، الملف يُخزّن في `file_url` (مثلاً `lectures/files/abc.pdf`)، لكن **لا يتم استخراج محتوى الـ PDF نهائياً**. حقل `content_text` يبقى فارغاً أو يحتوي فقط على نص بسيط كتبه الأستاذ يدوياً (مثل "OOP").

**النتيجة**: الـ AI يستلم كلمة "OOP" فقط ← يرد "أرسلت فقط كلمة OOP بدون محتوى".

### التدفق الحالي (المعطل)
```
أستاذ يرفع محاضرة → [title: "OOP", content_text: "OOP", file_url: "lectures/files/oop.pdf"]
                                                    ↓
طالب يطلب تلخيص → LectureController يأخذ content_text ("OOP") → يرسله للـ AI
                                                    ↓
                          AI يستلم "OOP" فقط ← يرد "لا يوجد محتوى كافٍ"
```

---

## الحل المقترح

### التحويل من DeepSeek/HuggingFace إلى Gemini API

**لماذا Gemini؟**
- نموذج `gemini-2.0-flash-lite` (مجاني/رخيص وسريع)
- يدعم إرسال ملفات PDF مباشرة كمحتوى multimodal (لا نحتاج مكتبة PHP لتحليل PDF)
- API متوافقة مع OpenAI format عبر `https://generativelanguage.googleapis.com/v1beta/`
- الـ AI نفسه يحلل الـ PDF ويفهم محتواه

### التدفق الجديد (بعد الإصلاح)
```
أستاذ يرفع محاضرة → [title: "OOP", content_text: "...", file_url: "lectures/files/oop.pdf"]
                                                    ↓
طالب يطلب تلخيص → LectureController يقرأ الـ PDF من التخزين
                                                    ↓
                   يحوّل الـ PDF إلى base64 → يرسله لـ Gemini كمحتوى multimodal
                                                    ↓
              Gemini يحلل الـ PDF كاملاً ← يرد بتلخيص شامل ومفصل
```

---

## خطوات التنفيذ

### الخطوة 1: تحديث ملف `.env` و `config/services.php`

**الملف**: `.env.example` و `.env`
```env
# إزالة
# HF_API_KEY=...

# إضافة
GEMINI_API_KEY=your-gemini-api-key-here
```

**الملف**: `config/services.php`
```php
'gemini' => [
    'key' => env('GEMINI_API_KEY'),
    'model' => env('GEMINI_MODEL', 'gemini-2.0-flash-lite'),
],
```

---

### الخطوة 2: إعادة كتابة `AIService.php`

**الملف**: `app/Services/AIService.php`

**التغييرات الرئيسية:**

1. **تغيير الـ API endpoint** من HuggingFace Router إلى Gemini API:
   - الـ URL الجديد: `https://generativelanguage.googleapis.com/v1beta/models/{model}:generateContent`
   
2. **إضافة دعم multimodal (PDF)**:
   - دالة جديدة `callWithPdf()` ترسل ملف PDF كـ base64 مع الـ prompt
   - Gemini يقبل `inlineData` بنوع `application/pdf`

3. **تحديث دالة `summarize()`**:
   - تقبل معامل جديد: `?string $pdfPath = null`
   - إذا وُجد PDF → تستخدم `callWithPdf()`
   - إذا لم يوجد PDF → تستخدم `call()` العادية مع النص

4. **تحديث دالة `generateQuiz()`**:
   - نفس المنطق: دعم PDF إن وُجد

**هيكل الطلب لـ Gemini (نص فقط):**
```json
{
  "contents": [
    {
      "parts": [
        { "text": "لخص النص التالي..." }
      ]
    }
  ],
  "generationConfig": {
    "temperature": 0.7
  }
}
```

**هيكل الطلب لـ Gemini (مع PDF):**
```json
{
  "contents": [
    {
      "parts": [
        {
          "inlineData": {
            "mimeType": "application/pdf",
            "data": "<base64-encoded-pdf>"
          }
        },
        { "text": "لخص محتوى هذا الملف الأكاديمي باللغة العربية..." }
      ]
    }
  ],
  "generationConfig": {
    "temperature": 0.7
  }
}
```

**استخراج الرد:**
```php
// بدلاً من:
$response->json('choices.0.message.content')
// يصبح:
$response->json('candidates.0.content.parts.0.text')
```

---

### الخطوة 3: تحديث `Student\LectureController.php`

**الملف**: `app/Http/Controllers/Student/LectureController.php`

**التغييرات:**

```php
public function summarize(Request $request, Lecture $lecture)
{
    // ... التحقق من الصلاحيات (موجود) ...

    $level = $request->input('level', 'medium');

    // المنطق الجديد: أولوية للـ PDF ثم النص
    if ($lecture->file_url && Storage::disk('public')->exists($lecture->file_url)) {
        // إرسال الـ PDF مباشرة لـ Gemini
        $pdfPath = Storage::disk('public')->path($lecture->file_url);
        $summaryResult = $this->ai->summarize('', $level, $pdfPath);
    } elseif ($lecture->content_text) {
        // fallback: إرسال النص فقط
        $summaryResult = $this->ai->summarize($lecture->content_text, $level);
    } else {
        abort(422, 'لا يوجد محتوى لهذه المحاضرة (لا نص ولا ملف).');
    }

    // ... باقي الكود (موجود) ...
}
```

**إزالة الشرط القديم:**
```php
// حذف هذا السطر:
abort_if(!$lecture->content_text, 422, 'لا يوجد نص لهذه المحاضرة.');
```

---

### الخطوة 4: تحديث `Teacher\QuizController.php` (اختياري لكن مهم)

**الملف**: `app/Http/Controllers/Teacher/QuizController.php`

نفس المنطق: عند توليد اختبار، إذا المحاضرة فيها PDF بدون `content_text`، يتم إرسال الـ PDF لـ Gemini لتوليد الأسئلة.

```php
public function generate(Lecture $lecture)
{
    // بدلاً من:
    // abort_if(!$lecture->content_text, 422, ...);
    
    if ($lecture->file_url && Storage::disk('public')->exists($lecture->file_url)) {
        $pdfPath = Storage::disk('public')->path($lecture->file_url);
        $generated = $this->ai->generateQuiz('', 10, $pdfPath);
    } elseif ($lecture->content_text) {
        $generated = $this->ai->generateQuiz($lecture->content_text);
    } else {
        abort(422, 'المحاضرة لا تحتوي على محتوى للتحليل.');
    }
    
    // ... باقي الكود ...
}
```

---

### الخطوة 5: تحديث الواجهات (Views)

**الملف**: `resources/views/student/ai-session.blade.php`
- تغيير النص من "محرك DeepSeek-V4 النشط" إلى "محرك Gemini النشط"

**الملف**: `resources/views/student/lectures/show.blade.php`
- الزر موجود ويعمل، لا يحتاج تغيير
- لكن يجب إصلاح الـ AJAX call: حالياً الـ route `student.lectures.summarize` تتوقع POST عادي (form submit) لكن الـ JavaScript يرسل fetch ويتوقع JSON — هناك عدم توافق يجب حله (الكونترولر يرجع view بدل JSON)

**إصلاح عدم التوافق:**
- إضافة check في `LectureController@summarize`: إذا الطلب AJAX (`$request->wantsJson()`) → إرجاع JSON
- إذا الطلب عادي (من الفورم) → إرجاع view

---

## ملخص الملفات المتأثرة

| الملف | نوع التغيير | الأولوية |
|-------|------------|----------|
| `app/Services/AIService.php` | إعادة كتابة كاملة | **حرج** |
| `app/Http/Controllers/Student/LectureController.php` | تعديل دالة summarize | **حرج** |
| `config/services.php` | إضافة إعداد gemini | **حرج** |
| `.env` / `.env.example` | إضافة GEMINI_API_KEY | **حرج** |
| `app/Http/Controllers/Teacher/QuizController.php` | تعديل دالة generate | متوسط |
| `resources/views/student/ai-session.blade.php` | تغيير نص اسم النموذج | منخفض |

---

## ملاحظات تقنية

### حدود Gemini لحجم الملفات
- `inlineData` (base64): حد أقصى ~20MB
- ملفات المحاضرات المرفوعة حالياً محددة بـ 20MB (`max:20480` في validation)
- لذلك `inlineData` كافٍ ولا نحتاج Files API

### الأمان
- مفتاح الـ API يُخزّن في `.env` فقط (لا يُكتب في الكود)
- استخدام `config('services.gemini.key')` بدلاً من `env()` مباشرة

### التوافقية
- لا حاجة لتثبيت مكتبات PHP إضافية (لا `smalot/pdfparser` ولا أي SDK)
- Laravel HTTP Client (`Http::`) كافٍ للتعامل مع Gemini REST API
- لا حاجة لتغيير الـ database أو الـ migrations

### التكلفة
- `gemini-2.0-flash-lite` مجاني حتى 30 طلب/دقيقة (Free tier)
- أو رخيص جداً ($0.075 / 1M token input) على الخطة المدفوعة
