<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Support\Facades\DB;
use App\Events\GameStateUpdated;

class GameController extends Controller
{
    protected function broadcastGameState(Game $game): void
    {
        $game->load(['players', 'currentWinner']);

        broadcast(new GameStateUpdated($game));
    }

    public function home()
    {
        return view('buzzer.home');
    }

    public function admin()
    {
        $gameId = session('admin_game_id');

        if ($gameId) {
            $game = Game::with('players')->find($gameId);

            if ($game && $game->status !== 'closed') {
                return view('buzzer.admin', compact('game'));
            }
        }

        do {
            $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (Game::where('code', $code)->exists());

        $game = Game::create([
            'code' => $code,
            'teams_count' => 2,
            'status' => 'waiting',
        ]);

        session(['admin_game_id' => $game->id]);

        $game->load('players');

        return view('buzzer.admin', compact('game'));
    }

    public function playerJoin()
    {
        return view('buzzer.player-join');
    }

    public function storePlayer(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'size:6'],
            'team' => ['required', 'integer', 'min:1'],
        ]);

        $game = Game::where('code', $validated['code'])
            ->where('status', '!=', 'closed')
            ->first();

        if (! $game) {
            return back()->withInput()->withErrors([
                'code' => 'كود الغرفة غير صحيح أو أن اللعبة مغلقة.',
            ]);
        }

        if ($validated['team'] > $game->teams_count) {
            return back()->withInput()->withErrors([
                'team' => 'رقم الفريق أكبر من عدد الفرق المحدد في اللعبة.',
            ]);
        }

        $player = Player::create([
            'game_id' => $game->id,
            'name' => $validated['name'],
            'team_number' => $validated['team'],
            'is_active' => true,
            'is_winner' => false,
        ]);

        $this->broadcastGameState($game);

        return redirect()->route('player.room', $player);
    }

    public function playerRoom(Player $player)
    {
        $player->load(['game.currentWinner', 'game.players']);

        return view('buzzer.player-room', compact('player'));
    }

    public function updateTeams(Request $request)
    {
        $gameId = session('admin_game_id');

        if (! $gameId) {
            return back();
        }

        $game = Game::find($gameId);

        if (! $game) {
            return back();
        }

        $request->validate([
            'teams_count' => ['required', 'integer', 'min:2', 'max:6'],
        ]);

        $game->update([
            'teams_count' => $request->teams_count
        ]);

        $this->broadcastGameState($game);

        return back();
    }

    public function buzz(Player $player)
    {
        $player->load('game');

        $game = $player->game;

        if (! $game || $game->status === 'closed') {
            return back();
        }

$stateChanged = false;

        DB::transaction(function () use ($player, $game, &$stateChanged) {
            $freshGame = Game::lockForUpdate()->find($game->id);

            if (! $freshGame || $freshGame->status === 'buzzed' || $freshGame->status === 'closed') {
                return;
            }

            $freshGame->update([
                'status' => 'buzzed',
                'current_winner_id' => $player->id,
            ]);

            Player::where('game_id', $freshGame->id)->update([
                'is_winner' => false,
            ]);

            $player->update([
                'is_winner' => true,
                'buzzed_at' => now(),
            ]);

            $stateChanged = true;
        });

        if ($stateChanged) {
            $this->broadcastGameState($game->fresh());
        }

        return redirect()->route('player.room', $player->id);
    }

    public function resetRound()
    {
        $gameId = session('admin_game_id');

        if (! $gameId) {
            return back();
        }

        $game = Game::find($gameId);

        if (! $game) {
            return back();
        }

        $game->update([
            'status' => 'waiting',
            'current_winner_id' => null,
        ]);

        Player::where('game_id', $game->id)->update([
            'is_winner' => false,
            'buzzed_at' => null,
        ]);

        $this->broadcastGameState($game);

        return back();
    }

    public function closeGame()
    {
        $gameId = session('admin_game_id');

        if (! $gameId) {
            return back();
        }

        $game = Game::find($gameId);

        if (! $game) {
            return back();
        }

        $game->update([
            'status' => 'closed',
            'current_winner_id' => null,
        ]);

        Player::where('game_id', $game->id)->update([
            'is_winner' => false,
            'buzzed_at' => null,
        ]);

        $this->broadcastGameState($game);

        session()->forget('admin_game_id');

        return redirect()->route('home');
    }
}