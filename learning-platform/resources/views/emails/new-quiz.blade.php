<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
            direction: rtl;
            text-align: right;
            background-color: #121416;
            color: #e2e2e5;
            padding: 20px;
        }
        .card {
            background-color: #1e2022;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 30px;
            max-width: 550px;
            margin: 0 auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        .logo {
            color: #b9c3ff;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 10px;
        }
        .highlight {
            color: #ffb778;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            background-color: #b9c3ff;
            color: #001257;
            font-weight: bold;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 10px;
            margin-top: 25px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">Smart Learn</div>
        <p>مرحباً بك في منصة التعلم الذكي.</p>
        <p>يسعدنا إعلامك بأن الأستاذ قام بنشر اختبار جديد في مادة: <span class="highlight">{{ $quiz->lecture->course->title }}</span></p>
        <hr style="border: none; border-top: 1px solid rgba(255, 255, 255, 0.05); margin: 20px 0;">
        <p><strong>عنوان الاختبار:</strong> {{ $quiz->title }}</p>
        <p><strong>المحاضرة:</strong> {{ $quiz->lecture->title }}</p>
        <p><strong>مدة الاختبار المتاحة:</strong> {{ $quiz->duration }} دقيقة</p>

        <a href="{{ url('/student/quizzes/'.$quiz->id.'/take') }}" class="btn">ابدأ الاختبار الآن</a>
    </div>
</body>
</html>
