<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus unique constraint dari institution_name
            $table->dropUnique('users_institution_name_unique');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Kalo mau rollback, tambahin kembali unique constraint
            $table->unique('institution_name', 'users_institution_name_unique');
        });
    }
};