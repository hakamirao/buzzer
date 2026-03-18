<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لعبة البازر</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="page">
        <div class="container">
            <div class="card" style="max-width:700px; margin: 70px auto; text-align:center;">
                <h1 class="page-title">لعبة البازر</h1>
                <p class="page-subtitle">نظام مسابقات مباشر لتحديد أول متسابق يملك أولوية الإجابة</p>

                <div class="hero-actions">
                    <a href="{{ route('player.join') }}" class="btn-link btn btn-primary">لاعب</a>
                    <a href="{{ route('admin') }}" class="btn-link btn btn-dark">مسؤول</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>