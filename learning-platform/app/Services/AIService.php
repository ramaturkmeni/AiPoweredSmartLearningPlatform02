<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl;

    public function __construct()
    {
        // يفضل وضع المفتاح في ملف .env بالشكل التالي: HF_API_KEY=hf_pTQ...
        $this->apiKey = env('HF_API_KEY', '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');
        $this->model = 'deepseek-ai/DeepSeek-V4-Pro:novita'; // النموذج المحدد من قبلك
        $this->baseUrl = 'https://router.huggingface.co/v1/chat/completions'; // إضافة /chat/completions
    }

    // ── Generate Quiz ────────────────────────────
    public function generateQuiz(string $lectureText, int $count = 10): array
    {
        $prompt = "بناءً على النص التالي، أنشئ {$count} أسئلة اختيار من متعدد (MCQ) باللغة العربية.
لكل سؤال: نص السؤال، و4 خيارات، وحدد الإجابة الصحيحة.
أعد النتيجة بصيغة JSON فقط بالشكل التالي وبدون أي نص إضافي:
{
  \"questions\":[
    {
      \"question\": \"نص السؤال\",
      \"options\":[
        {\"text\": \"الخيار الأول\", \"is_correct\": false},
        {\"text\": \"الخيار الثاني\", \"is_correct\": true},
        {\"text\": \"الخيار الثالث\", \"is_correct\": false},
        {\"text\": \"الخيار الرابع\", \"is_correct\": false}
      ]
    }
  ]
}

النص:
{$lectureText}";

        $response = $this->call($prompt);

        // تنظيف الرد في حال قام النموذج بوضع الـ JSON داخل علامات Markdown (```json ... ```)
        $cleanJson = preg_replace('/```json\s*(.*?)\s*```/s', '$1', $response);
        $cleanJson = preg_replace('/```\s*(.*?)\s*```/s', '$1', $cleanJson);

        return json_decode($cleanJson, true) ??['questions' => []];
    }

    // ── Summarize ────────────────────────────────
    public function summarize(string $lectureText, string $level = 'medium'): string
    {
        $instructions = match($level) {
            'brief'    => 'لخص في 3 إلى 5 نقاط رئيسية فقط وبشكل مكثف جداً.',
            'detailed' => 'لخص بالتفصيل مع ذكر الأمثلة والشروحات الوافية.',
            default    => 'لخص بشكل متوازن ومفهوم مع إبراز المفاهيم والنقاط الأساسية.',
        };

        $prompt = "لخّص النص الأكاديمي التالي باللغة العربية. {$instructions}

النص:
{$lectureText}";

        return $this->call($prompt);
    }

    // ── Core API Call ────────────────────────────
    protected function call(string $prompt): string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ])->timeout(120)->post($this->baseUrl,[
                'model'      => $this->model,
                'messages'   => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.7, // يمكن تعديلها للتحكم في دقة/إبداع النموذج
            ]);

            if ($response->failed()) {
                Log::error('HuggingFace API error: ' . $response->body());
                return 'عذراً، حدث خطأ أثناء الاتصال بالذكاء الاصطناعي.';
            }

            // جلب محتوى الرسالة بناءً على هيكل استجابة OpenAI
            return $response->json('choices.0.message.content', '');

        } catch (\Exception $e) {
            Log::error('AIService exception: ' . $e->getMessage());
            return 'عذراً، تعذر إتمام العملية في الوقت الحالي.';
        }
    }
}
