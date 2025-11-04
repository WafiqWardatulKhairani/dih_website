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
        Schema::table('kolaborasi_documents', function (Blueprint $table) {
            // Tambahkan kolom progress_id, bisa null
            $table->unsignedBigInteger('progress_id')->nullable()->after('kolaborasi_id');

            // Tambahkan foreign key ke kolaborasi_progress
            $table->foreign('progress_id')
                ->references('id')
                ->on('kolaborasi_progress')
                ->onDelete('set null'); // Jika progress dihapus, kolom ini null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kolaborasi_documents', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['progress_id']);
            // Hapus kolom
            $table->dropColumn('progress_id');
        });
    }
};
