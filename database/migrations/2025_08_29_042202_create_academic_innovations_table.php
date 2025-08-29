<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('academic_innovations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('keywords')->nullable();
            $table->text('abstract')->nullable();
            $table->longText('description');
            $table->text('purpose')->nullable();
            $table->string('technology_readiness_level')->nullable();
            $table->string('image_path')->nullable();
            $table->string('document_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('author_name');
            $table->string('institution');
            $table->string('contact')->nullable();
            // gunakan string untuk status agar fleksibel (sesuaikan nilai dari form: 'Draft' / 'Publish')
            $table->string('status', 50)->default('Draft');
            $table->string('copyright_status')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_innovations');
    }
};
