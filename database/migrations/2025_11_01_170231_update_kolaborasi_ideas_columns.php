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
    Schema::table('kolaborasi_ideas', function (Blueprint $table) {
        // Ubah kolom deskripsi_singkat menjadi text
        $table->text('deskripsi_singkat')->change();

        // Ubah estimasi_waktu menjadi string(50)
        $table->string('estimasi_waktu', 50)->nullable()->change();

        // Tambahkan kolom lain jika perlu
        $table->string('category')->nullable()->change();
        $table->string('subcategory')->nullable()->change();
        $table->string('dokumen_path')->nullable()->change();
        $table->string('image_path')->nullable()->change();
    });
}
};