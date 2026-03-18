<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameStateUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $payload;

    public function __construct(Game $game)
    {
        $game->loadMissing(['players', 'currentWinner']);

        $this->payload = [
            'game_id' => $game->id,
            'status' => $game->status,
            'current_winner_id' => $game->current_winner_id,
            'current_winner_name' => optional($game->currentWinner)->name,
            'players' => $game->players
                ->sortBy('id')
                ->values()
                ->map(fn ($player) => [
                    'id' => $player->id,
                    'name' => $player->name,
                    'team_number' => $player->team_number,
                    'is_winner' => (bool) $player->is_winner,
                    'buzzed_at' => optional($player->buzzed_at)?->toIso8601String(),
                ])
                ->all(),
        ];
    }

    public function broadcastOn(): array
    {
        return [new Channel('game.'.$this->payload['game_id'])];
    }

    public function broadcastAs(): string
    {
        return 'game.state.updated';
    }

    public function broadcastWith(): array
    {
        return $this->payload;
    }
}
