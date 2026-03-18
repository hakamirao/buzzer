<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دخول اللاعب</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="page">
        <div class="container">
            <div class="card centered-card">
                <h1 class="page-title">دخول اللاعب</h1>
                <p class="page-subtitle">أدخل بياناتك للانضمام إلى غرفة اللعبة</p>

                @if ($errors->any())
                    <div style="background:#fee2e2; color:#991b1b; padding:12px 14px; border-radius:12px; margin-bottom:18px;">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('player.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="label">ادخل اسمك</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="label">ادخل كود الغرفة</label>
                        <input type="text" name="code" value="{{ old('code') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="label">ادخل رقم الفريق</label>
                        <input type="number" name="team" min="1" value="{{ old('team') }}" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">دخول</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>