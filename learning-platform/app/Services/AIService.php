<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected string $apiKey;
    protected string $model = 'claude-sonnet-4-20250514';
    protected string $baseUrl = 'https://api.anthropic.com/v1/messages';

    public function __construct()
    {
        $this->apiKey = config('services.anthropic.key');
    }

    // ── Generate Quiz ────────────────────────────
    public function generateQuiz(string $lectureText, int $count = 10): array
    {
        $prompt = "بناءً على النص التالي، أنشئ {$count} أسئلة اختيار من متعدد (MCQ) باللغة العربية.
لكل سؤال: نص السؤال، و4 خيارات، وحدد الإجابة الصحيحة.
أعد النتيجة بصيغة JSON فقط بالشكل التالي:
{
  \"questions\": [
    {
      \"question\": \"نص السؤال\",
      \"options\": [
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

        return json_decode($response, true) ?? ['questions' => []];
    }

    // ── Summarize ────────────────────────────────
    public function summarize(string $lectureText, string $level = 'medium'): string
    {
        $instructions = match($level) {
            'brief'    => 'لخص في 3-5 نقاط فقط',
            'detailed' => 'لخص بالتفصيل مع أمثلة',
            default    => 'لخص بشكل متوازن مع إبراز النقاط الرئيسية',
        };

        $prompt = "لخّص النص التالي باللغة العربية {$instructions}:

{$lectureText}";

        return $this->call($prompt);
    }

    // ── Core API Call ────────────────────────────
    protected function call(string $prompt): string
    {
        try {
            $response = Http::withHeaders([
                'x-api-key'         => $this->apiKey,
                'anthropic-version' => '2023-06-01',
                'Content-Type'      => 'application/json',
            ])->post($this->baseUrl, [
                'model'      => $this->model,
                'max_tokens' => 4096,
                'messages'   => [
                    ['role' => 'user', 'content' => $prompt]
                ],
            ]);

            return $response->json('content.0.text', '');

        } catch (\Exception $e) {
            Log::error('AIService error: ' . $e->getMessage());
            return '';
        }
    }
}
