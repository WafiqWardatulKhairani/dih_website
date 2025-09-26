<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('innovations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
            $table->string('author_name')->nullable();
            $table->string('institution')->nullable();
            $table->string('keywords')->nullable();
            $table->text('description')->nullable();
            $table->text('purpose')->nullable();
            $table->tinyInteger('technology_readiness_level')->default(1);
            $table->string('image_path')->nullable();
            $table->string('document_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('contact')->nullable();
            $table->string('status')->default('Draft'); // Draft, Review, Aktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('innovations');
    }
};
