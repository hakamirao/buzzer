<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('code', 6)->unique();
            $table->unsignedTinyInteger('teams_count')->default(2);
            $table->enum('status', ['waiting', 'active', 'buzzed', 'closed'])->default('waiting');
            $table->unsignedBigInteger('current_winner_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};