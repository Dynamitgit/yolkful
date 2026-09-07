<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedSmallInteger('prep_time')->nullable()->after('content');
            $table->unsignedSmallInteger('cook_time')->nullable()->after('prep_time');
            $table->unsignedSmallInteger('servings')->nullable()->after('cook_time');
            $table->unsignedSmallInteger('calories')->nullable()->after('servings');
            $table->decimal('protein', 6, 2)->nullable()->after('calories');
            $table->json('ingredients')->nullable()->after('protein');
            $table->json('instructions')->nullable()->after('ingredients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'prep_time',
                'cook_time',
                'servings',
                'calories',
                'protein',
                'ingredients',
                'instructions',
            ]);
        });
    }
};