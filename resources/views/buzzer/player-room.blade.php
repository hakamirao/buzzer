<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>غرفة اللاعب</title>
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

        .room-bg {
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
            width: 320px;
            height: 320px;
            background: #38bdf8;
            top: 60px;
            right: 80px;
        }

        .glow.two {
            width: 330px;
            height: 330px;
            background: #22c55e;
            bottom: 40px;
            left: 70px;
            animation-delay: 2s;
        }

        .glow.three {
            width: 220px;
            height: 220px;
            background: #f59e0b;
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

        .room-shell {
            width: 100%;
            max-width: 960px;
        }

        .glass-card {
            background: rgba(255,255,255,0.11);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 30px;
            padding: 30px 24px;
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
            background: linear-gradient(135deg, var(--team-light), var(--team-base));
            border: 1px solid rgba(255,255,255,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            box-shadow:
                0 14px 30px rgba(var(--team-rgb), 0.28),
                inset 0 0 18px rgba(255,255,255,0.10);
        }

        .page-title {
            margin: 0 0 10px;
            font-size: 40px;
            font-weight: 800;
        }

        .page-subtitle {
            margin: 0 auto 24px;
            max-width: 500px;
            color: rgba(255,255,255,0.8);
            font-size: 16px;
            line-height: 1.9;
        }

        .info-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-top: 24px;
        }

        .info-box {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 20px;
            padding: 16px;
        }

        .info-label {
            font-size: 13px;
            color: rgba(255,255,255,0.72);
            margin-bottom: 8px;
        }

        .info-value {
            font-size: 22px;
            font-weight: 800;
        }

        .big-buzzer-wrap {
            margin-top: 34px;
            display: flex;
            justify-content: center;
        }

        .big-buzzer {
            width: 240px;
            height: 240px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            font-size: 38px;
            font-weight: 900;
            color: #fff;
            background: radial-gradient(circle at top, var(--team-light), var(--team-base) 60%, var(--team-dark) 100%);
            box-shadow:
                0 18px 40px rgba(var(--team-rgb), 0.35),
                inset 0 8px 18px rgba(255,255,255,0.18),
                inset 0 -10px 18px rgba(0,0,0,0.18);
            transition: transform .15s ease, box-shadow .2s ease;
            animation: pulseBuzzer 2s infinite;
        }

        .big-buzzer:hover {
            transform: scale(1.04);
        }

        .big-buzzer:active {
            transform: scale(0.96);
            box-shadow:
                0 10px 20px rgba(239, 68, 68, 0.25),
                inset 0 6px 14px rgba(255,255,255,0.12),
                inset 0 -8px 16px rgba(0,0,0,0.22);
        }

        .buzz-note {
            margin-top: 16px;
            font-size: 14px;
            color: rgba(255,255,255,0.68);
        }

        .result-head {
            margin-top: 30px;
            margin-bottom: 18px;
        }

        .result-icon {
            font-size: 34px;
            margin-bottom: 8px;
        }

        .result-title {
            margin: 0;
            font-size: 30px;
            font-weight: 800;
        }

        .players-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            margin-top: 22px;
        }

        .player-item {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 22px;
            padding: 18px 14px;
            text-align: center;
            transition: .25s ease;
        }

        .player-item:hover {
            transform: translateY(-4px);
            background: rgba(255,255,255,0.11);
        }

        .player-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            margin: 0 auto 14px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.25);
            border: 3px solid rgba(255,255,255,0.22);
        }

        .player-circle.lg {
            width: 72px;
            height: 72px;
        }

        .player-circle.winner {
            box-shadow:
                0 0 0 4px rgba(255, 215, 0, 0.28),
                0 12px 28px rgba(0,0,0,0.28);
            border-color: rgba(255, 221, 87, 0.85);
        }

        .player-name {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .winner-banner {
            margin-top: 26px;
            background: linear-gradient(135deg, rgba(245,158,11,0.18), rgba(255,255,255,0.08));
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 22px;
            padding: 18px;
            font-size: 20px;
            box-shadow: inset 0 0 25px rgba(255,255,255,0.04);
        }

        .winner-banner strong {
            color: #fde68a;
            font-size: 24px;
        }

        .closed-box {
            width: 100%;
            max-width: 760px;
            margin: 0 auto;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.16);
            border-radius: 30px;
            padding: 34px 24px;
            box-shadow: 0 24px 60px rgba(0,0,0,0.24);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            text-align: center;
        }

        .closed-icon {
            width: 84px;
            height: 84px;
            margin: 0 auto 18px;
            border-radius: 24px;
            background: rgba(239, 68, 68, 0.18);
            border: 1px solid rgba(248, 113, 113, 0.28);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            border-radius: 16px;
            padding: 15px 22px;
            font-size: 16px;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            box-shadow: 0 16px 34px rgba(34, 197, 94, 0.28);
            transition: .25s ease;
        }

        .btn-home:hover {
            transform: translateY(-3px);
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

        @keyframes pulseBuzzer {
            0%, 100% {
                box-shadow:
                    0 18px 40px rgba(var(--team-rgb), 0.35),
                    inset 0 8px 18px rgba(255,255,255,0.18),
                    inset 0 -10px 18px rgba(0,0,0,0.18);
            }
            50% {
                box-shadow:
                    0 22px 54px rgba(var(--team-rgb), 0.48),
                    0 0 0 12px rgba(var(--team-rgb), 0.08),
                    inset 0 8px 18px rgba(255,255,255,0.18),
                    inset 0 -10px 18px rgba(0,0,0,0.18);
            }
        }

        @media (max-width: 800px) {
            .info-list {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 30px;
            }

            .big-buzzer {
                width: 200px;
                height: 200px;
                font-size: 32px;
            }
        }

        @media (max-width: 640px) {
            .glass-card,
            .closed-box {
                padding: 24px 16px;
                border-radius: 24px;
            }

            .player-badge,
            .closed-icon {
                width: 72px;
                height: 72px;
                font-size: 32px;
            }

            .players-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 460px) {
            .players-grid {
                grid-template-columns: 1fr;
            }

            .big-buzzer {
                width: 180px;
                height: 180px;
                font-size: 28px;
            }
        }
    </style>
</head>

@php
        $teamPalette = [
            1 => ['light' => '#93c5fd', 'base' => '#3b82f6', 'dark' => '#1d4ed8', 'rgb' => '59,130,246'],
            2 => ['light' => '#fca5a5', 'base' => '#ef4444', 'dark' => '#b91c1c', 'rgb' => '239,68,68'],
            3 => ['light' => '#86efac', 'base' => '#10b981', 'dark' => '#047857', 'rgb' => '16,185,129'],
            4 => ['light' => '#fcd34d', 'base' => '#f59e0b', 'dark' => '#b45309', 'rgb' => '245,158,11'],
            5 => ['light' => '#c4b5fd', 'base' => '#8b5cf6', 'dark' => '#6d28d9', 'rgb' => '139,92,246'],
            6 => ['light' => '#d1d5db', 'base' => '#6b7280', 'dark' => '#374151', 'rgb' => '107,114,128'],
        ];

        $teamColor = $teamPalette[$player->team_number] ?? $teamPalette[6];
    @endphp

<audio id="bell-sound" preload="auto">
    <source src="{{ asset('sounds/bell.mp3') }}" type="audio/mpeg">
</audio>

<script>
    const bellSound = document.getElementById('bell-sound');

    function playBellSound() {
        if (!bellSound) return;

        bellSound.currentTime = 0;

        bellSound.play().catch((error) => {
            console.log('تعذر تشغيل الصوت تلقائيًا:', error);
        });
    }
</script>

<body
    data-player-game-id="{{ $player->game->id }}"
    style="
        --team-light: {{ $teamColor['light'] }};
        --team-base: {{ $teamColor['base'] }};
        --team-dark: {{ $teamColor['dark'] }};
        --team-rgb: {{ $teamColor['rgb'] }};
    "
>

    <div class="room-bg">
        <div class="glow one"></div>
        <div class="glow two"></div>
        <div class="glow three"></div>

        <span class="float-symbol s1">🔔</span>
        <span class="float-symbol s2">⚡</span>
        <span class="float-symbol s3">🎯</span>
        <span class="float-symbol s4">✨</span>
        <span class="float-symbol s5">🏆</span>
        <span class="float-symbol s6">⏱️</span>
        <span class="float-symbol s7">🎮</span>
        <span class="float-symbol s8">⭐</span>
    </div>

    <div class="page">
        <div class="room-shell">
            <div id="closed-box" class="closed-box" style="{{ $player->game->status === 'closed' ? '' : 'display:none;' }}">
                <div class="closed-icon">🚪</div>
                <h1 class="page-title" style="margin-bottom:10px;">تم إغلاق اللعبة</h1>
                <p class="page-subtitle" style="margin-bottom:0;">
                    أنهى المسؤول هذه الجولة، وتم إخراج جميع المتسابقين.
                </p>

                <div style="margin-top:25px;">
                    <a href="{{ route('home') }}" class="btn-home">
                        <span>🏠</span>
                        <span>العودة للصفحة الرئيسية</span>
                    </a>
                </div>
            </div>

            <div id="room-content" style="{{ $player->game->status === 'closed' ? 'display:none;' : '' }}">
                <div class="glass-card">
                    <div class="player-badge">🔔</div>
                    <h1 class="page-title">غرفة اللاعب</h1>
                    <p class="page-subtitle">استعد جيدًا، وعند بدء الجولة اضغط البازر بأسرع وقت ممكن</p>

                    <div class="info-list">
                        <div class="info-box">
                            <div class="info-label">الاسم</div>
                            <div class="info-value">{{ $player->name }}</div>
                        </div>

                        <div class="info-box">
                            <div class="info-label">الفريق</div>
                            <div class="info-value">{{ $player->team_number }}</div>
                        </div>

                        <div class="info-box">
                            <div class="info-label">كود اللعبة</div>
                            <div class="info-value">{{ $player->game->code }}</div>
                        </div>
                    </div>

                    <div id="buzz-section" style="margin-top: 10px; {{ $player->game->status === 'waiting' ? '' : 'display:none;' }}">
                        <div class="big-buzzer-wrap">
                            <form action="{{ route('player.buzz', $player) }}" method="POST">
                                @csrf
                                <button type="submit" class="big-buzzer">اضغط</button>
                            </form>
                        </div>
                        <div class="buzz-note">أول ضغطة صحيحة تحصل على أولوية الإجابة</div>
                    </div>

                    <div id="result-section" style="{{ $player->game->status === 'waiting' ? 'display:none;' : '' }}">
                        <div class="result-head">
                            <div class="result-icon">🏆</div>
                            <h2 class="result-title">تم تسجيل أول ضغطة</h2>
                        </div>

                        <div id="all-players-state" class="players-grid">
                            @foreach ($player->game->players as $p)
                                <div class="player-item">
                                    <div
                                        class="player-circle lg {{ $p->is_winner ? 'winner' : '' }}"
                                        style="background:
                                            {{ $p->team_number == 1 ? '#3b82f6' :
                                               ($p->team_number == 2 ? '#ef4444' :
                                               ($p->team_number == 3 ? '#10b981' :
                                               ($p->team_number == 4 ? '#f59e0b' :
                                               ($p->team_number == 5 ? '#8b5cf6' : '#6b7280')))) }};"
                                    ></div>

                                    <div class="player-name" style="font-weight:{{ $p->is_winner ? '800' : '600' }};">
                                        {{ $p->name }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div id="winner-text" class="winner-banner" style="{{ $player->game->currentWinner ? '' : 'display:none;' }}">
                            صاحب أولوية الإجابة:
                            <strong>{{ optional($player->game->currentWinner)->name }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>