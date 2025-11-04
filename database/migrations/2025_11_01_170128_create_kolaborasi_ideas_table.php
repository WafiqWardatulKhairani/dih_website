<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kolaborasi_ideas', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke user
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Relasi ke academic_innovations
            $table->unsignedBigInteger('innovation_id')->nullable();
            $table->foreign('innovation_id')->references('id')->on('academic_innovations')->onDelete('set null');

            // Kategori & subkategori
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();

            // Judul & deskripsi
            $table->string('judul', 255);
            $table->text('deskripsi_singkat');

            // Estimasi waktu (string supaya fleksibel, misal "6 bulan")
            $table->string('estimasi_waktu', 50)->nullable();

            // Dokumen & cover image opsional
            $table->string('dokumen_path')->nullable();
            $table->string('image_path')->nullable();

            // Tanggal submit & review
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kolaborasi_ideas');
    }
};
