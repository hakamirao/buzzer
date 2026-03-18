<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'game_id',
        'name',
        'team_number',
        'is_active',
        'is_winner',
        'buzzed_at',
    ];
    
    protected $casts = [
        'buzzed_at' => 'datetime',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}