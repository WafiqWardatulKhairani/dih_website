<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusDeskripsiDeadlineToKolaborasiIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kolaborasi_ideas', function (Blueprint $table) {
            // Tambah kolom status setelah kolom is_active (jika ada)
            // Jika kamu lebih suka VARCHAR, ubah ->enum(...) menjadi ->string('status', 50)
            $table->enum('status', ['pending', 'active', 'closed'])
                  ->default('pending')
                  ->after('is_active');

            // Tambah deskripsi panjang
            $table->text('deskripsi')->nullable()->after('deskripsi_singkat');

            // Tambah deadline (tanggal)
            $table->date('deadline')->nullable()->after('estimasi_waktu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kolaborasi_ideas', function (Blueprint $table) {
            // Hapus kolom yang tadi ditambah
            // Pastikan urutan dropColumn sesuai availability DB driver
            $table->dropColumn(['status', 'deskripsi', 'deadline']);
        });
    }
}
