<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('institution_name')->unique()->after('name'); // nama kantor, harus unik
            $table->string('phone')->nullable()->after('email');
            $table->string('address')->nullable()->after('phone');
            $table->enum('role', ['admin', 'pemerintah', 'akademisi'])->default('pemerintah')->after('password');
            $table->string('avatar')->nullable()->after('role'); // simpan path foto profil
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['institution_name', 'phone', 'address', 'role', 'avatar']);
        });
    }
};
