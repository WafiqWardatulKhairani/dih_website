<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kolaborasi_progress', function (Blueprint $table) {
            // Hapus foreign key lama
            $table->dropForeign(['kolaborasi_id']);
            
            // Tambahkan foreign key baru ke tabel kolaborasi_ideas
            $table->foreign('kolaborasi_id')
                ->references('id')
                ->on('kolaborasi_ideas')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('kolaborasi_progress', function (Blueprint $table) {
            // Hapus foreign key baru
            $table->dropForeign(['kolaborasi_id']);
            
            // Bisa kembalikan ke foreign key lama jika perlu
            $table->foreign('kolaborasi_id')
                ->references('id')
                ->on('kolaborasi_ides') // nama tabel lama
                ->onDelete('cascade');
        });
    }
};
