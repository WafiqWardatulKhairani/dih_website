<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('kolaborasi_ideas', function (Blueprint $table) {
        // DROP FOREIGN KEYS dulu
        $table->dropForeign(['category_id']);
        $table->dropForeign(['subcategory_id']);

        // Hapus kolom
        $table->dropColumn([
            'category_id',
            'subcategory_id',
            'latar_belakang',
            'solusi',
            'kompleksitas',
            'dampak',
            'status',
            'catatan_admin',
            'deleted_at'
        ]);

        // Tambah kolom baru string
        $table->string('category')->nullable()->after('innovation_id');
        $table->string('subcategory')->nullable()->after('category');
    });
}

    public function down(): void
    {
        Schema::table('kolaborasi_ideas', function (Blueprint $table) {
            // Mengembalikan kolom lama
            $table->unsignedBigInteger('category_id')->nullable()->after('innovation_id');
            $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');

            $table->text('latar_belakang')->nullable()->after('deskripsi_singkat');
            $table->text('solusi')->nullable()->after('latar_belakang');
            $table->string('kompleksitas')->nullable()->after('solusi');
            $table->string('dampak')->nullable()->after('kompleksitas');
            $table->string('status')->default('draft')->after('dampak');
            $table->text('catatan_admin')->nullable()->after('status');
            $table->softDeletes();
            
            // Hapus kolom string baru
            $table->dropColumn(['category', 'subcategory']);
        });
    }
};
