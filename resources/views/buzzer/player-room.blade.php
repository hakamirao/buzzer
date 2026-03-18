<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>غرفة اللاعب</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body data-player-game-id="{{ $player->game->id }}">
    <div class="page">
        <div class="container" style="max-width: 900px;">
            <div id="closed-box" class="closed-box" style="{{ $player->game->status === 'closed' ? '' : 'display:none;' }}">
                <h1 class="page-title" style="margin-bottom:10px;">تم إغلاق اللعبة</h1>
                <p class="page-subtitle" style="margin-bottom:0;">أنهى المسؤول هذه الجولة، وتم إخراج جميع المتسابقين.</p>

                <div style="margin-top:25px;">
                    <a href="{{ route('home') }}" class="btn-link btn btn-primary">العودة للصفحة الرئيسية</a>
                </div>
            </div>

            <div id="room-content" style="{{ $player->game->status === 'closed' ? 'display:none;' : '' }}">
                <div class="card" style="text-align:center;">
                    <h1 class="page-title">غرفة اللاعب</h1>

                    <div class="info-list">
                        <div>الاسم: <strong>{{ $player->name }}</strong></div>
                        <div>الفريق: <strong>{{ $player->team_number }}</strong></div>
                        <div>كود اللعبة: <strong>{{ $player->game->code }}</strong></div>
                    </div>

                    <div id="buzz-section" style="margin-top: 30px; {{ $player->game->status === 'waiting' ? '' : 'display:none;' }}">
                        <div class="big-buzzer-wrap">
                            <form action="{{ route('player.buzz', $player) }}" method="POST">
                                @csrf
                                <button type="submit" class="big-buzzer">اضغط</button>
                            </form>
                        </div>
                    </div>

                    <div id="result-section" style="{{ $player->game->status === 'waiting' ? 'display:none;' : '' }}">
                        <h2 style="margin-top: 30px;">تم تسجيل أول ضغطة</h2>

                        <div id="all-players-state" class="players-grid" style="justify-content:center;">
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
                                    <div class="player-name" style="font-weight:{{ $p->is_winner ? '700' : '500' }};">
                                        {{ $p->name }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <p id="winner-text" style="margin-top: 25px; font-size: 20px; {{ $player->game->currentWinner ? '' : 'display:none;' }}">
                            صاحب أولوية الإجابة:
                            <strong>{{ optional($player->game->currentWinner)->name }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>