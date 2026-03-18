<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/', [GameController::class, 'home'])->name('home');

Route::get('/admin', [GameController::class, 'admin'])->name('admin');

Route::get('/player/join', [GameController::class, 'playerJoin'])->name('player.join');
Route::post('/player/join', [GameController::class, 'storePlayer'])->name('player.store');

Route::get('/player/room/{player}', [GameController::class, 'playerRoom'])->name('player.room');

Route::post('/admin/update-teams', [GameController::class, 'updateTeams'])->name('admin.updateTeams');

Route::post('/player/buzz/{player}', [GameController::class, 'buzz'])->name('player.buzz');

Route::post('/admin/reset-round', [GameController::class, 'resetRound'])->name('admin.resetRound');

Route::post('/admin/close-game', [GameController::class, 'closeGame'])->name('admin.closeGame');