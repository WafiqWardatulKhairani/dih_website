<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom category_id dan subcategory_id ke tabel academic_innovations.
     */
    public function up(): void
    {
        Schema::table('academic_innovations', function (Blueprint $table) {
            // Tambahkan kolom category_id dan subcategory_id
            $table->unsignedBigInteger('category_id')->nullable()->after('user_id');
            $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');

            // Relasi ke tabel categories dan subcategories
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->foreign('subcategory_id')
                  ->references('id')
                  ->on('subcategories')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Hapus kolom jika migrasi di-rollback.
     */
    public function down(): void
    {
        Schema::table('academic_innovations', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['category_id']);
            $table->dropForeign(['subcategory_id']);

            // Hapus kolom
            $table->dropColumn(['category_id', 'subcategory_id']);
        });
    }
};
