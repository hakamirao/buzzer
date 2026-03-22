<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>صفحة المسؤول</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            font-family: "Cairo", sans-serif;
            background: linear-gradient(135deg, #081028 0%, #0f1f5c 45%, #0f766e 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            color: #fff;
        }

        .admin-bg {
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
            top: 40px;
            right: 90px;
        }

        .glow.two {
            width: 340px;
            height: 340px;
            background: #22c55e;
            bottom: 40px;
            left: 70px;
            animation-delay: 2s;
        }

        .glow.three {
            width: 240px;
            height: 240px;
            background: #a855f7;
            top: 45%;
            left: 45%;
            animation-delay: 1s;
        }

        .float-symbol {
            position: absolute;
            opacity: 0.12;
            font-size: 28px;
            animation: floatY 9s ease-in-out infinite;
            user-select: none;
        }

        .s1 { top: 55px; right: 160px; }
        .s2 { top: 140px; left: 120px; animation-delay: 1s; }
        .s3 { top: 220px; right: 60px; animation-delay: 2s; }
        .s4 { top: 380px; left: 70px; animation-delay: .5s; }
        .s5 { bottom: 110px; right: 140px; animation-delay: 1.5s; }
        .s6 { bottom: 70px; left: 180px; animation-delay: 2.5s; }
        .s7 { top: 90px; left: 50%; animation-delay: .7s; }
        .s8 { bottom: 220px; right: 48%; animation-delay: 1.8s; }

        .page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            padding: 36px 18px 50px;
        }

        .admin-shell {
            max-width: 1180px;
            margin: 0 auto;
        }

        .admin-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .admin-title-wrap {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .admin-icon {
            width: 76px;
            height: 76px;
            border-radius: 24px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.16);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: inset 0 0 18px rgba(255,255,255,0.08);
        }

        .page-title {
            margin: 0;
            font-size: 38px;
            font-weight: 800;
            line-height: 1.2;
        }

        .page-subtitle {
            margin: 6px 0 0;
            color: rgba(255,255,255,0.78);
            font-size: 15px;
        }

        .admin-badge {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.14);
            color: #fff;
            padding: 10px 16px;
            border-radius: 999px;
            font-size: 14px;
            backdrop-filter: blur(12px);
        }

        .glass-card {
            background: rgba(255,255,255,0.11);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 28px;
            padding: 26px;
            box-shadow: 0 24px 60px rgba(0,0,0,0.24);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .top-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 18px;
            margin-bottom: 20px;
        }

        .info-box {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 22px;
            padding: 20px;
        }

        .label {
            font-size: 14px;
            color: rgba(255,255,255,0.72);
            margin-bottom: 10px;
            display: block;
        }

        .game-code-row {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .game-code {
            background: rgba(255,255,255,0.14);
            border: 1px dashed rgba(255,255,255,0.25);
            color: #fff;
            padding: 14px 18px;
            border-radius: 16px;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 2px;
            min-width: 180px;
            text-align: center;
        }

        .copy-btn {
            border: none;
            background: rgba(255,255,255,0.14);
            color: #fff;
            padding: 12px 16px;
            border-radius: 14px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 700;
            transition: .25s ease;
        }

        .copy-btn:hover {
            background: rgba(255,255,255,0.22);
            transform: translateY(-2px);
        }

        .form-control {
            width: 100%;
            min-width: 180px;
            background: rgba(255,255,255,0.14);
            border: 1px solid rgba(255,255,255,0.15);
            color: #fff;
            padding: 14px 16px;
            border-radius: 16px;
            font-size: 16px;
            outline: none;
        }

        .form-control option {
            color: #111827;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 20px;
            padding: 16px 18px;
        }

        .stat-label {
            font-size: 13px;
            color: rgba(255,255,255,0.72);
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
        }

        .winner-box {
            background: linear-gradient(135deg, rgba(245,158,11,0.18), rgba(255,255,255,0.08));
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 24px;
            padding: 22px;
            margin-bottom: 22px;
            text-align: center;
            box-shadow: inset 0 0 25px rgba(255,255,255,0.04);
        }

        .winner-icon {
            font-size: 34px;
            margin-bottom: 8px;
        }

        .winner-title {
            font-size: 15px;
            color: rgba(255,255,255,0.78);
            margin-bottom: 10px;
        }

        .winner-name {
            font-size: 34px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .winner-team {
            font-size: 17px;
            color: #fde68a;
            font-weight: 700;
        }

        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 10px 0 18px;
            flex-wrap: wrap;
        }

        .section-title {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
        }

        .section-note {
            color: rgba(255,255,255,0.7);
            font-size: 14px;
        }

        .players-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
        }

        .player-item {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 22px;
            padding: 18px;
            text-align: center;
            transition: .25s ease;
        }

        .player-item:hover {
            transform: translateY(-4px);
            background: rgba(255,255,255,0.11);
        }

        .player-circle {
            width: 62px;
            height: 62px;
            border-radius: 50%;
            margin: 0 auto 14px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.25);
            border: 3px solid rgba(255,255,255,0.22);
        }

        .player-circle.winner {
            box-shadow: 0 0 0 4px rgba(255, 215, 0, 0.28), 0 12px 28px rgba(0,0,0,0.28);
            border-color: rgba(255, 221, 87, 0.85);
        }

        .player-name {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .player-meta {
            font-size: 14px;
            color: rgba(255,255,255,0.72);
        }

        .empty-note {
            grid-column: 1 / -1;
            text-align: center;
            padding: 32px 16px;
            background: rgba(255,255,255,0.08);
            border-radius: 20px;
            color: rgba(255,255,255,0.76);
            margin: 0;
        }

        .actions-row {
            display: flex;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
            margin-top: 28px;
        }

        .btn {
            border: none;
            cursor: pointer;
            padding: 15px 22px;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 800;
            color: #fff;
            transition: .25s ease;
            min-width: 180px;
        }

        .btn:hover {
            transform: translateY(-3px);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            box-shadow: 0 14px 30px rgba(245, 158, 11, 0.28);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            box-shadow: 0 14px 30px rgba(239, 68, 68, 0.28);
        }

        @keyframes glowMove {
            from {
                transform: translate(0, 0) scale(1);
            }
            to {
                transform: translate(18px, -18px) scale(1.07);
            }
        }

        @keyframes floatY {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-18px) rotate(7deg);
            }
        }

        @media (max-width: 900px) {
            .top-grid,
            .stats-row {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 30px;
            }

            .game-code {
                width: 100%;
            }
        }

        @media (max-width: 640px) {
            .page {
                padding: 20px 12px 35px;
            }

            .glass-card {
                padding: 18px;
                border-radius: 22px;
            }

            .admin-icon {
                width: 62px;
                height: 62px;
                font-size: 28px;
            }

            .page-title {
                font-size: 26px;
            }

            .winner-name {
                font-size: 28px;
            }

            .btn {
                width: 100%;
            }

            .players-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 460px) {
            .players-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body
    data-admin-game-id="{{ $game->id }}"
    data-game-status="{{ $game->status }}"
    data-current-winner-id="{{ $game->current_winner_id ?? '' }}"
>
    <div class="admin-bg">
        <div class="glow one"></div>
        <div class="glow two"></div>
        <div class="glow three"></div>

        <span class="float-symbol s1">🛠️</span>
        <span class="float-symbol s2">⚡</span>
        <span class="float-symbol s3">👑</span>
        <span class="float-symbol s4">🔔</span>
        <span class="float-symbol s5">✨</span>
        <span class="float-symbol s6">🎯</span>
        <span class="float-symbol s7">⏱️</span>
        <span class="float-symbol s8">⚙️</span>
    </div>

    <div class="page">
        <div class="admin-shell">
            <div class="admin-header">
                <div class="admin-title-wrap">
                    <div class="admin-icon">🛠️</div>
                    <div>
                        <h1 class="page-title">لوحة المسؤول</h1>
                        <div class="page-subtitle">إدارة اللعبة، متابعة اللاعبين، والتحكم في أولوية الإجابة</div>
                    </div>
                </div>

                <div class="admin-badge">إدارة مباشرة للجولة الحالية</div>
            </div>

            <div class="glass-card">
                <div class="top-grid">
                    <div class="info-box">
                        <span class="label">كود اللعبة</span>
                        <div class="game-code-row">
                            <div id="game-code" class="game-code">{{ $game->code }}</div>
                            <button type="button" class="copy-btn" onclick="copyGameCode()">نسخ الكود</button>
                        </div>
                    </div>

                    <div class="info-box">
                        <form action="{{ route('admin.updateTeams') }}" method="POST">
                            @csrf
                            <label class="label">عدد الفرق</label>
                            <select name="teams_count" onchange="this.form.submit()" class="form-control">
                                @for ($i = 2; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ $game->teams_count == $i ? 'selected' : '' }}>
                                        {{ $i }} فرق
                                    </option>
                                @endfor
                            </select>
                        </form>
                    </div>
                </div>

                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-label">عدد اللاعبين</div>
                        <div class="stat-value">{{ $game->players->count() }}</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-label">عدد الفرق الحالي</div>
                        <div class="stat-value">{{ $game->teams_count }}</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-label">حالة الأولوية</div>
                        <div class="stat-value" style="font-size:20px;">
                            {{ $game->currentWinner ? 'تم تحديدها' : 'بانتظار الجرس' }}
                        </div>
                    </div>
                </div>

                <div id="winner-box" class="winner-box" style="{{ $game->currentWinner ? '' : 'display:none;' }}">
                    <div class="winner-icon">👑</div>
                    <div class="winner-title">أولوية الإجابة الحالية</div>
                    <div id="winner-name" class="winner-name">{{ optional($game->currentWinner)->name }}</div>
                    <div id="winner-team" class="winner-team">
                        @if($game->currentWinner)
                            فريق {{ $game->currentWinner->team_number }}
                        @endif
                    </div>
                </div>

                <div class="section-head">
                    <h3 class="section-title">اللاعبون المنضمون</h3>
                    <div class="section-note">تحديث حيّ لحالة اللاعبين داخل اللعبة</div>
                </div>

                <div id="players-list" class="players-grid">
                    @forelse ($game->players as $player)
                        <div class="player-item">
                            <div
                                class="player-circle {{ $player->is_winner ? 'winner' : '' }}"
                                style="background:
                                    {{ $player->team_number == 1 ? '#3b82f6' :
                                       ($player->team_number == 2 ? '#ef4444' :
                                       ($player->team_number == 3 ? '#10b981' :
                                       ($player->team_number == 4 ? '#f59e0b' :
                                       ($player->team_number == 5 ? '#8b5cf6' : '#6b7280')))) }};"
                            ></div>
                            <div class="player-name">{{ $player->name }}</div>
                            <div class="player-meta">فريق {{ $player->team_number }}</div>
                        </div>
                    @empty
                        <p class="empty-note">لا يوجد لاعبون منضمون حتى الآن.</p>
                    @endforelse
                </div>

                <div class="actions-row">
                    <form action="{{ route('admin.resetRound') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning">إعادة تعيين الدوائر</button>
                    </form>

                    <form action="{{ route('admin.closeGame') }}" method="POST" onsubmit="return confirm('هل أنت متأكد من إغلاق اللعبة؟');">
                        @csrf
                        <button type="submit" class="btn btn-danger">إغلاق اللعبة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyGameCode() {
            const code = document.getElementById('game-code')?.innerText?.trim();

            if (!code) return;

            navigator.clipboard.writeText(code).then(() => {
                const btn = event.target;
                const oldText = btn.innerText;
                btn.innerText = 'تم النسخ ✓';

                setTimeout(() => {
                    btn.innerText = oldText;
                }, 1600);
            }).catch(() => {
                alert('تعذر نسخ الكود');
            });
        }
    </script>
</body>
</html>