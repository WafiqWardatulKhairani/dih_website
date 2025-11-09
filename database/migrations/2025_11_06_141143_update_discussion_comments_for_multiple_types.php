<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::table('discussion_comments', function (Blueprint $table) {
            // Hapus foreign key lama
            DB::statement('ALTER TABLE discussion_comments DROP FOREIGN KEY discussion_comments_innovation_id_foreign');

            // Tambahkan kolom tipe inovasi
            $table->string('innovation_type')->default('academic')->after('innovation_id');

            // Tambahkan index gabungan (optional, tapi bagus untuk performa)
            $table->index(['innovation_type', 'innovation_id']);
        });
    }

    public function down()
    {
        Schema::table('discussion_comments', function (Blueprint $table) {
            $table->dropIndex(['innovation_type', 'innovation_id']);
            $table->dropColumn('innovation_type');

            // Tambahkan lagi foreign key lama kalau rollback
            $table->foreign('innovation_id')->references('id')->on('academic_innovations')->onDelete('cascade');
        });
    }
};

