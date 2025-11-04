<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kolaborasi_reviews', function (Blueprint $table) {
            // Hapus foreign key lama
            $table->dropForeign(['kolaborasi_project_id']);

            // Rename kolom menjadi kolaborasi_task_id
            $table->renameColumn('kolaborasi_project_id', 'kolaborasi_task_id');

            // Tambahkan foreign key baru ke kolaborasi_tasks
            $table->foreign('kolaborasi_task_id')
                  ->references('id')
                  ->on('kolaborasi_tasks')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kolaborasi_reviews', function (Blueprint $table) {
            // Hapus foreign key task
            $table->dropForeign(['kolaborasi_task_id']);

            // Rename kembali ke kolaborasi_project_id
            $table->renameColumn('kolaborasi_task_id', 'kolaborasi_project_id');

            // Tambahkan foreign key lama jika diperlukan
            $table->foreign('kolaborasi_project_id')
                  ->references('id')
                  ->on('kolaborasi_projects')
                  ->onDelete('cascade');
        });
    }
};
