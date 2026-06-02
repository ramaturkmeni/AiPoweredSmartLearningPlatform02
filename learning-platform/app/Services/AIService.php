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
        $this->apiKey = config('services.gemini.key', '');
        $this->model = config('services.gemini.model', 'gemini-2.0-flash-lite');
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';
    }

    public function generateQuiz(string $lectureText, int $count = 10, ?string $pdfPath = null): array
    {
        $prompt = "بناءً على المحتوى التالي، أنشئ {$count} أسئلة اختيار من متعدد (MCQ) باللغة العربية.
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
}";

        if ($lectureText) {
            $prompt .= "\n\nالنص:\n{$lectureText}";
        }

        $response = $pdfPath
            ? $this->callWithPdf($prompt, $pdfPath)
            : $this->call($prompt);

        $cleanJson = preg_replace('/```json\s*(.*?)\s*```/s', '$1', $response);
        $cleanJson = preg_replace('/```\s*(.*?)\s*```/s', '$1', $cleanJson);

        return json_decode($cleanJson, true) ?? ['questions' => []];
    }

    public function summarize(string $lectureText, string $level = 'medium', ?string $pdfPath = null): string
    {
        $instructions = match($level) {
            'brief'    => 'لخص في 3 إلى 5 نقاط رئيسية فقط وبشكل مكثف جداً.',
            'detailed' => 'لخص بالتفصيل مع ذكر الأمثلة والشروحات الوافية.',
            default    => 'لخص بشكل متوازن ومفهوم مع إبراز المفاهيم والنقاط الأساسية.',
        };

        $prompt = "أنت مساعد أكاديمي متخصص. لخّص المحتوى الأكاديمي التالي باللغة العربية. {$instructions}";

        if ($lectureText) {
            $prompt .= "\n\nالنص:\n{$lectureText}";
        }

        return $pdfPath
            ? $this->callWithPdf($prompt, $pdfPath)
            : $this->call($prompt);
    }

    protected function call(string $prompt): string
    {
        try {
            $url = $this->baseUrl . $this->model . ':generateContent?key=' . $this->apiKey;

            $response = Http::timeout(120)->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                ],
            ]);

            if ($response->failed()) {
                Log::error('Gemini API error: ' . $response->body());
                return 'عذراً، حدث خطأ أثناء الاتصال بالذكاء الاصطناعي.';
            }

            return $response->json('candidates.0.content.parts.0.text', '');

        } catch (\Exception $e) {
            Log::error('AIService exception: ' . $e->getMessage());
            return 'عذراً، تعذر إتمام العملية في الوقت الحالي.';
        }
    }

    protected function callWithPdf(string $prompt, string $pdfPath): string
    {
        try {
            if (!file_exists($pdfPath)) {
                Log::error('AIService: PDF not found at ' . $pdfPath);
                return 'عذراً، ملف المحاضرة غير موجود.';
            }

            $pdfData = base64_encode(file_get_contents($pdfPath));
            $url = $this->baseUrl . $this->model . ':generateContent?key=' . $this->apiKey;

            $response = Http::timeout(180)->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'inlineData' => [
                                    'mimeType' => 'application/pdf',
                                    'data' => $pdfData,
                                ],
                            ],
                            ['text' => $prompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                ],
            ]);

            if ($response->failed()) {
                Log::error('Gemini API error (PDF): ' . $response->body());
                return 'عذراً، حدث خطأ أثناء تحليل الملف بالذكاء الاصطناعي.';
            }

            return $response->json('candidates.0.content.parts.0.text', '');

        } catch (\Exception $e) {
            Log::error('AIService PDF exception: ' . $e->getMessage());
            return 'عذراً، تعذر تحليل الملف في الوقت الحالي.';
        }
    }
}
