<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة المسؤول</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body data-admin-game-id="{{ $game->id }}">
    <div class="page">
        <div class="container">
            <h1 class="page-title">صفحة المسؤول</h1>

            <div class="card">
                <div class="top-bar">
                    <div>
                        <div class="label">كود اللعبة</div>
                        <div id="game-code" class="game-code">{{ $game->code }}</div>
                    </div>

                    <div>
                        <form action="{{ route('admin.updateTeams') }}" method="POST">
                            @csrf
                            <label class="label">عدد الفرق</label>

                            <select name="teams_count" onchange="this.form.submit()" class="form-control" style="min-width:180px;">
                                @for ($i = 2; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ $game->teams_count == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </form>
                    </div>
                </div>

                <hr class="section-line">

                <div id="winner-box" class="winner-box" style="{{ $game->currentWinner ? '' : 'display:none;' }}">
                    <div class="winner-title">أولوية الإجابة الحالية</div>
                    <div id="winner-name" class="winner-name">{{ optional($game->currentWinner)->name }}</div>
                    <div id="winner-team" class="winner-team">
                        @if($game->currentWinner)
                            فريق {{ $game->currentWinner->team_number }}
                        @endif
                    </div>
                </div>

                <h3 style="margin:0;">اللاعبون المنضمون</h3>

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
</body>
</html>