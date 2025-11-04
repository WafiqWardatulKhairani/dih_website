<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('kolaborasi_reviews', function (Blueprint $table) {
        // hapus foreign key parent_id dulu
        $table->dropForeign(['parent_id']); // <-- ini penting
        // baru hapus kolom
        $table->dropColumn(['judul', 'target_type', 'target_id', 'parent_id', 'is_final']);

        // pastikan kolom rating ada
        if (!Schema::hasColumn('kolaborasi_reviews', 'rating')) {
            $table->tinyInteger('rating')->default(0);
        }

        $table->text('komentar')->nullable(false)->change();
    });
}
};
