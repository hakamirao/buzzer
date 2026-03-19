<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جرس السرعة</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            font-family: "Cairo", sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e3a8a, #0f766e);
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
            padding: 24px;
        }

        .background-glow {
            position: absolute;
            inset: 0;
            overflow: hidden;
            z-index: 0;
        }

        .glow {
            position: absolute;
            border-radius: 9999px;
            filter: blur(80px);
            opacity: 0.35;
            animation: floatGlow 8s ease-in-out infinite alternate;
        }

        .glow.one {
            width: 260px;
            height: 260px;
            background: #38bdf8;
            top: 8%;
            right: 10%;
        }

        .glow.two {
            width: 300px;
            height: 300px;
            background: #22c55e;
            bottom: 5%;
            left: 8%;
            animation-delay: 2s;
        }

        .glow.three {
            width: 220px;
            height: 220px;
            background: #f59e0b;
            top: 45%;
            left: 40%;
            animation-delay: 1s;
        }

        .floating-symbols {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            overflow: hidden;
        }

        .symbol {
            position: absolute;
            font-size: 28px;
            opacity: 0.22;
            animation: floatSymbol linear infinite;
            user-select: none;
        }

        .symbol.s1 { top: 8%; right: 18%; animation-duration: 11s; }
        .symbol.s2 { top: 20%; left: 12%; animation-duration: 14s; }
        .symbol.s3 { top: 32%; right: 8%; animation-duration: 13s; }
        .symbol.s4 { top: 48%; left: 22%; animation-duration: 12s; }
        .symbol.s5 { top: 60%; right: 28%; animation-duration: 15s; }
        .symbol.s6 { top: 72%; left: 10%; animation-duration: 10s; }
        .symbol.s7 { top: 80%; right: 14%; animation-duration: 16s; }
        .symbol.s8 { top: 15%; left: 42%; animation-duration: 12s; }
        .symbol.s9 { top: 55%; left: 50%; animation-duration: 14s; }
        .symbol.s10 { top: 35%; right: 45%; animation-duration: 11s; }

        .main-card {
            width: 100%;
            max-width: 760px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 28px;
            padding: 48px 32px;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
            color: white;
            position: relative;
            z-index: 3;
        }

        .logo-badge {
            width: 88px;
            height: 88px;
            margin: 0 auto 20px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: inset 0 0 20px rgba(255,255,255,0.08);
        }

        .page-title {
            margin: 0 0 12px;
            font-size: 42px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .page-subtitle {
            margin: 0 auto 32px;
            font-size: 18px;
            line-height: 1.9;
            color: rgba(255,255,255,0.88);
            max-width: 520px;
        }

        .hero-actions {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .hero-btn {
            min-width: 170px;
            padding: 16px 24px;
            border-radius: 16px;
            font-size: 18px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .hero-btn.player {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            box-shadow: 0 12px 25px rgba(34, 197, 94, 0.28);
        }

        .hero-btn.admin {
            background: rgba(255,255,255,0.14);
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .hero-btn:hover {
            transform: translateY(-4px) scale(1.02);
        }

        .hero-btn.player:hover {
            box-shadow: 0 18px 35px rgba(34, 197, 94, 0.38);
        }

        .hero-btn.admin:hover {
            background: rgba(255,255,255,0.2);
        }

        .mini-text {
            margin-top: 28px;
            font-size: 14px;
            color: rgba(255,255,255,0.72);
        }

        @keyframes floatGlow {
            from {
                transform: translateY(0px) translateX(0px) scale(1);
            }
            to {
                transform: translateY(-20px) translateX(15px) scale(1.08);
            }
        }

        @keyframes floatSymbol {
            0% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-18px) rotate(8deg);
            }
            100% {
                transform: translateY(0px) rotate(-8deg);
            }
        }

        @media (max-width: 640px) {
            .main-card {
                padding: 36px 20px;
                border-radius: 22px;
            }

            .page-title {
                font-size: 32px;
            }

            .page-subtitle {
                font-size: 16px;
            }

            .hero-btn {
                width: 100%;
                min-width: unset;
            }

            .logo-badge {
                width: 72px;
                height: 72px;
                font-size: 32px;
            }
        }
    </style>
</head>
<body>
    <div class="background-glow">
        <div class="glow one"></div>
        <div class="glow two"></div>
        <div class="glow three"></div>
    </div>

    <div class="floating-symbols">
        <span class="symbol s1">🔔</span>
        <span class="symbol s2">⚡</span>
        <span class="symbol s3">⏱️</span>
        <span class="symbol s4">✨</span>
        <span class="symbol s5">🎯</span>
        <span class="symbol s6">🔔</span>
        <span class="symbol s7">⚡</span>
        <span class="symbol s8">⏱️</span>
        <span class="symbol s9">✨</span>
        <span class="symbol s10">🎯</span>
    </div>

    <div class="page">
        <div class="main-card">
            <div class="logo-badge">🔔</div>

            <h1 class="page-title">جرس السرعة</h1>
            <p class="page-subtitle">
                نظام ذكي وممتع لتحديد أول متسابق يمتلك أولوية الإجابة بسرعة ووضوح
            </p>

            <div class="hero-actions">
                <a href="{{ route('player.join') }}" class="hero-btn player">
                    <span>🎮</span>
                    <span>دخول لاعب</span>
                </a>

                <a href="{{ route('admin') }}" class="hero-btn admin">
                    <span>🛠️</span>
                    <span>دخول المسؤول</span>
                </a>
            </div>

            <div class="mini-text">
                جاهز لبداية سريعة وحماسية؟ اختر وضع الدخول المناسب
            </div>
        </div>
    </div>
</body>
</html>