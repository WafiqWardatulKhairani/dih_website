<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kolaborasi_reviews', function (Blueprint $table) {
            // Tambahkan kolom kolaborasi_id jika belum ada
            if (!Schema::hasColumn('kolaborasi_reviews', 'kolaborasi_id')) {
                $table->unsignedBigInteger('kolaborasi_id')->nullable()->after('id');
                $table->foreign('kolaborasi_id')
                      ->references('id')
                      ->on('kolaborasi_ideas')
                      ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kolaborasi_reviews', function (Blueprint $table) {
            if (Schema::hasColumn('kolaborasi_reviews', 'kolaborasi_id')) {
                $table->dropForeign(['kolaborasi_id']);
                $table->dropColumn('kolaborasi_id');
            }
        });
    }
};
