<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kolaborasi_ideas', function (Blueprint $table) {
            // Tambahkan kolom 'field' jika belum ada
            if (!Schema::hasColumn('kolaborasi_ideas', 'field')) {
                $table->string('field', 255)->nullable()->after('deskripsi_singkat');
            }

            // Ubah tipe kolom agar lebih panjang / fleksibel
            $table->text('deskripsi_singkat')->change();
            $table->string('judul', 500)->change();
            $table->string('category', 255)->change();
            $table->string('subcategory', 255)->change();
            $table->string('dokumen_path', 500)->nullable()->change();
            $table->string('image_path', 500)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('kolaborasi_ideas', function (Blueprint $table) {
            // Kembalikan tipe kolom lama
            $table->string('deskripsi_singkat', 255)->change();
            $table->string('judul', 255)->change();
            $table->string('category', 100)->change();
            $table->string('subcategory', 100)->change();
            $table->string('dokumen_path', 255)->nullable()->change();
            $table->string('image_path', 255)->nullable()->change();

            // Hapus kolom 'field' jika ada
            if (Schema::hasColumn('kolaborasi_ideas', 'field')) {
                $table->dropColumn('field');
            }
        });
    }
};
