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
        Schema::table('kolaborasi_progress', function (Blueprint $table) {
            // Hapus kolom 'judul'
            $table->dropColumn('judul');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kolaborasi_progress', function (Blueprint $table) {
            // Jika rollback, tambahkan kolom 'judul' kembali
            $table->string('judul')->nullable();
        });
    }
};
