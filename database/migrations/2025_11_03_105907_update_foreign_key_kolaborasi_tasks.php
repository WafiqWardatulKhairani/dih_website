<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kolaborasi_tasks', function (Blueprint $table) {
            // Hapus foreign key lama yang menunjuk ke kolaborasi_ides
            $table->dropForeign(['kolaborasi_id']);

            // Buat foreign key baru yang menunjuk ke kolaborasi_ideas
            $table->foreign('kolaborasi_id')
                ->references('id')
                ->on('kolaborasi_ideas')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('kolaborasi_tasks', function (Blueprint $table) {
            // Rollback ke kondisi sebelumnya (tidak disarankan)
            $table->dropForeign(['kolaborasi_id']);
            $table->foreign('kolaborasi_id')
                ->references('id')
                ->on('kolaborasi_ides')
                ->cascadeOnDelete();
        });
    }
};
