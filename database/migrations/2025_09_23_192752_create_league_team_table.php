<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('league_team', function (Blueprint $table) {
            $table->foreignId('league_id')
                  ->constrained('leagues')
                  ->cascadeOnDelete();

            $table->foreignId('team_id')
                  ->constrained('teams')
                  ->cascadeOnDelete();

            $table->unsignedInteger('points')->default(0);

            $table->primary(['league_id', 'team_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('league_team');
    }
};
