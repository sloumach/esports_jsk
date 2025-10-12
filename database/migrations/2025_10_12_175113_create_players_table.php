<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('nickname', 50);
            $table->string('full_name', 100)->nullable();
            $table->string('country', 60)->nullable();
            $table->timestamps();
        });

        Schema::create('player_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->cascadeOnDelete();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
            $table->date('joined_at')->nullable();
            $table->date('left_at')->nullable();
            $table->timestamps();

            $table->unique(['player_id', 'team_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_team');
        Schema::dropIfExists('players');
    }
};
