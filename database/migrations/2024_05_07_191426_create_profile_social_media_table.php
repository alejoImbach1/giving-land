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
        Schema::create('profile_social_media', function (Blueprint $table) {
            $table->foreignId('profile_id')->constrained();
            $table->foreignId('social_media_id')->constrained();
            $table->string('url')->default('https://laravel.com/');
            $table->unique([
                'profile_id',
                'social_media_id'
            ]);

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles_social_media');
    }
};
