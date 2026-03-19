<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>دخول اللاعب</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            font-family: "Cairo", sans-serif;
            background: linear-gradient(135deg, #081028 0%, #102a70 48%, #0f766e 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            color: #fff;
        }

        .player-bg {
            position: fixed;
            inset: 0;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .glow {
            position: absolute;
            border-radius: 9999px;
            filter: blur(90px);
            opacity: 0.24;
            animation: glowMove 10s ease-in-out infinite alternate;
        }

        .glow.one {
            width: 300px;
            height: 300px;
            background: #38bdf8;
            top: 70px;
            right: 70px;
        }

        .glow.two {
            width: 330px;
            height: 330px;
            background: #22c55e;
            bottom: 50px;
            left: 60px;
            animation-delay: 2s;
        }

        .glow.three {
            width: 220px;
            height: 220px;
            background: #a855f7;
            top: 45%;
            left: 42%;
            animation-delay: 1s;
        }

        .float-symbol {
            position: absolute;
            opacity: 0.12;
            font-size: 28px;
            animation: floatY 9s ease-in-out infinite;
            user-select: none;
        }

        .s1 { top: 60px; right: 150px; }
        .s2 { top: 170px; left: 110px; animation-delay: 1.2s; }
        .s3 { top: 260px; right: 65px; animation-delay: 2.1s; }
        .s4 { top: 410px; left: 80px; animation-delay: .7s; }
        .s5 { bottom: 110px; right: 150px; animation-delay: 1.7s; }
        .s6 { bottom: 70px; left: 160px; animation-delay: 2.4s; }
        .s7 { top: 110px; left: 48%; animation-delay: .9s; }
        .s8 { bottom: 220px; right: 46%; animation-delay: 1.5s; }

        .page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 16px;
            position: relative;
            z-index: 1;
        }

        .join-card {
            width: 100%;
            max-width: 640px;
            background: rgba(255,255,255,0.11);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 30px;
            padding: 34px 28px;
            box-shadow: 0 24px 60px rgba(0,0,0,0.24);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            text-align: center;
        }

        .player-badge {
            width: 84px;
            height: 84px;
            margin: 0 auto 18px;
            border-radius: 24px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            box-shadow: inset 0 0 18px rgba(255,255,255,0.08);
        }

        .page-title {
            margin: 0 0 10px;
            font-size: 40px;
            font-weight: 800;
        }

        .page-subtitle {
            margin: 0 auto 28px;
            max-width: 430px;
            color: rgba(255,255,255,0.8);
            font-size: 16px;
            line-height: 1.9;
        }

        .error-box {
            background: rgba(239, 68, 68, 0.18);
            border: 1px solid rgba(248, 113, 113, 0.35);
            color: #fff;
            padding: 14px 16px;
            border-radius: 16px;
            margin-bottom: 20px;
            text-align: right;
        }

        .error-box div + div {
            margin-top: 6px;
        }

        .form-grid {
            display: grid;
            gap: 16px;
            text-align: right;
        }

        .form-group {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 16px;
        }

        .label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            color: rgba(255,255,255,0.76);
            font-weight: 700;
        }

        .form-control {
            width: 100%;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.12);
            color: #fff;
            border-radius: 16px;
            padding: 14px 16px;
            font-size: 16px;
            outline: none;
            box-sizing: border-box;
            transition: .25s ease;
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.45);
        }

        .form-control:focus {
            border-color: rgba(255,255,255,0.28);
            background: rgba(255,255,255,0.16);
            box-shadow: 0 0 0 4px rgba(255,255,255,0.06);
        }

        .hint {
            margin-top: 8px;
            font-size: 12px;
            color: rgba(255,255,255,0.55);
        }

        .btn-submit {
            margin-top: 22px;
            width: 100%;
            border: none;
            border-radius: 18px;
            padding: 17px 20px;
            font-size: 18px;
            font-weight: 800;
            color: #fff;
            cursor: pointer;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            box-shadow: 0 16px 34px rgba(34, 197, 94, 0.28);
            transition: .25s ease;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 38px rgba(34, 197, 94, 0.35);
        }

        .bottom-note {
            margin-top: 18px;
            font-size: 13px;
            color: rgba(255,255,255,0.65);
        }

        @keyframes glowMove {
            from {
                transform: translate(0, 0) scale(1);
            }
            to {
                transform: translate(18px, -18px) scale(1.06);
            }
        }

        @keyframes floatY {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-18px) rotate(8deg);
            }
        }

        @media (max-width: 640px) {
            .join-card {
                padding: 26px 18px;
                border-radius: 24px;
            }

            .page-title {
                font-size: 30px;
            }

            .page-subtitle {
                font-size: 15px;
            }

            .player-badge {
                width: 72px;
                height: 72px;
                font-size: 32px;
            }

            .form-group {
                padding: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="player-bg">
        <div class="glow one"></div>
        <div class="glow two"></div>
        <div class="glow three"></div>

        <span class="float-symbol s1">🎮</span>
        <span class="float-symbol s2">⚡</span>
        <span class="float-symbol s3">🔔</span>
        <span class="float-symbol s4">✨</span>
        <span class="float-symbol s5">🎯</span>
        <span class="float-symbol s6">⏱️</span>
        <span class="float-symbol s7">🕹️</span>
        <span class="float-symbol s8">⭐</span>
    </div>

    <div class="page">
        <div class="join-card">
            <div class="player-badge">🎮</div>

            <h1 class="page-title">دخول اللاعب</h1>
            <p class="page-subtitle">أدخل بياناتك للانضمام إلى غرفة اللعبة والاستعداد للمنافسة</p>

            @if ($errors->any())
                <div class="error-box">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('player.store') }}" method="POST">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label class="label">ادخل اسمك</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="مثال: محمد">
                    </div>

                    <div class="form-group">
                        <label class="label">ادخل كود الغرفة</label>
                        <input type="text" name="code" value="{{ old('code') }}" class="form-control" placeholder="مثال: A7B9X">
                        <div class="hint">احصل على الكود من مسؤول اللعبة</div>
                    </div>

                    <div class="form-group">
                        <label class="label">ادخل رقم الفريق</label>
                        <input type="number" name="team" min="1" value="{{ old('team') }}" class="form-control" placeholder="مثال: 1">
                    </div>
                </div>

                <button type="submit" class="btn-submit">دخول إلى اللعبة</button>
            </form>

            <div class="bottom-note">تأكد من صحة الكود ورقم الفريق قبل المتابعة</div>
        </div>
    </div>
</body>
</html>