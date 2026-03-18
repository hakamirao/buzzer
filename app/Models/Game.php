<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'code',
        'teams_count',
        'status',
        'current_winner_id',
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function currentWinner()
    {
        return $this->belongsTo(Player::class, 'current_winner_id');
    }
}