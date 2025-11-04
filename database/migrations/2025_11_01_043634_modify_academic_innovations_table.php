<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('academic_innovations', function (Blueprint $table) {
            // Hapus foreign key berdasarkan nama default Laravel
            $table->dropForeign(['category_id']);
            $table->dropForeign(['subcategory_id']);

            // Hapus kolom lama
            $table->dropColumn(['category_id', 'subcategory_id']);

            // Tambah kolom subcategory baru (string)
            $table->string('subcategory')->nullable()->after('category');
        });
    }

    public function down(): void
    {
        Schema::table('academic_innovations', function (Blueprint $table) {
            // Kembalikan kolom lama
            $table->unsignedBigInteger('category_id')->nullable()->after('id');
            $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');

            // Hapus kolom baru
            $table->dropColumn('subcategory');
        });
    }
};
