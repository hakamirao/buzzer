<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>غرفة اللاعب</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            font-family: "Cairo", sans-serif;
            background: linear-gradient(135deg, #0b132b 0%, #102a70 55%, #0f766e 100%);
            min-height: 100vh;
            overflow-x: hidden;
            color: #fff;
        }

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
            background: linear-gradient(
                180deg,
                rgba(255,255,255,0.14) 0%,
                rgba(255,255,255,0.08) 100%
            );
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 30px;
            padding: 30px 24px;
            box-shadow: 0 16px 36px rgba(0,0,0,0.20);
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
                0 14px 28px rgba(var(--team-rgb), 0.26),
                inset 0 6px 14px rgba(255,255,255,0.14),
                inset 0 -8px 14px rgba(0,0,0,0.16);
            transition: transform .12s ease, box-shadow .16s ease;
        }

        .big-buzzer:hover {
            transform: scale(1.02);
            box-shadow:
                0 16px 32px rgba(var(--team-rgb), 0.30),
                inset 0 6px 14px rgba(255,255,255,0.14),
                inset 0 -8px 14px rgba(0,0,0,0.16);
        }

        .big-buzzer:active {
            transform: scale(0.97);
            box-shadow:
                0 8px 18px rgba(var(--team-rgb), 0.22),
                inset 0 4px 10px rgba(255,255,255,0.10),
                inset 0 -6px 12px rgba(0,0,0,0.20);
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

<body
    data-player-game-id="{{ $player->game->id }}"
    style="
        --team-light: {{ $teamColor['light'] }};
        --team-base: {{ $teamColor['base'] }};
        --team-dark: {{ $teamColor['dark'] }};
        --team-rgb: {{ $teamColor['rgb'] }};
    "
>

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
                            <button
                                type="button"
                                class="big-buzzer"
                                id="buzz-button"
                                data-buzz-url="{{ route('player.buzz', $player) }}"
                            >
                                اضغط
                            </button>
                        </div>
                        <div class="buzz-note" id="buzz-note">أول ضغطة صحيحة تحصل على أولوية الإجابة</div>
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