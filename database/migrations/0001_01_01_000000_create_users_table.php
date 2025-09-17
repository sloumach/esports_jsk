<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID primary key
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('username', 100)->unique()->nullable();
            $table->string('email', 255)->unique();
            $table->string('password');
            $table->string('phone', 50)->nullable();
            $table->enum('locale', ['ar', 'fr', 'en'])->default('fr');
            $table->enum('status', ['active', 'inactive', 'banned'])->default('active');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
