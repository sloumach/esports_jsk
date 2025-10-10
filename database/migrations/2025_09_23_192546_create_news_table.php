<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->json('title');      // {"fr": "...", "en": "...", "ar": "..."}
            $table->json('content');    // same format
            $table->string('slug', 150)->unique();
            $table->string('cover_image', 255)->nullable();
            $table->foreignUuid('author_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
