<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Rebuild likes table to support both
        // registered users and guests.
        Schema::dropIfExists('likes');

        Schema::create('likes', function (Blueprint $table) {
            $table->id();

            // Registered user
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            // Guest browser/device identifier
            $table->string('guest_token', 64)->nullable();

            // Liked post
            $table->foreignId('post_id')
                ->constrained()
                ->onDelete('cascade');

            $table->timestamps();

            // One like per registered user per post
            $table->unique(['user_id', 'post_id']);

            // One like per guest token per post
            $table->unique(['guest_token', 'post_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');

        // Restore the original likes structure
        Schema::create('likes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('post_id')
                ->constrained()
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['user_id', 'post_id']);
        });
    }
};