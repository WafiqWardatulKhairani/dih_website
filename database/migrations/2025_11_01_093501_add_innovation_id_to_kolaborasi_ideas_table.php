<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kolaborasi_ideas', function (Blueprint $table) {
            // Tambahkan kolom innovation_id sebagai foreign key
            $table->unsignedBigInteger('innovation_id')->after('user_id')->nullable();

            // Jika mau pakai foreign key constraint (opsional)
            // $table->foreign('innovation_id')->references('id')->on('academic_innovations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kolaborasi_ideas', function (Blueprint $table) {
            // Hapus kolom dan foreign key jika rollback
            // $table->dropForeign(['innovation_id']);
            $table->dropColumn('innovation_id');
        });
    }
};
