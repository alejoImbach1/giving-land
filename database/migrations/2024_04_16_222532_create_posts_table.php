<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Storage::deleteDirectory('public/posts_images');
        Storage::makeDirectory('public/posts_images');
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name',45);
            $table->enum('purpose',['Donación','Intercambio']);
            $table->string('description');
            $table->string('location',45);
            $table->boolean('draft')->default(1);
            $table->boolean('reported')->default(0);
            $table->boolean('banned')->default(0);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
