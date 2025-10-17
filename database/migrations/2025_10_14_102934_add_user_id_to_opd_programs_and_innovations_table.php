<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('opd_programs', function (Blueprint $table) {
            if (!Schema::hasColumn('opd_programs', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });

        Schema::table('opd_innovations', function (Blueprint $table) {
            if (!Schema::hasColumn('opd_innovations', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }
    public function down(): void
    {
        Schema::table('opd_programs', function (Blueprint $table) {
            if (Schema::hasColumn('opd_programs', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });

        Schema::table('opd_innovations', function (Blueprint $table) {
            if (Schema::hasColumn('opd_innovations', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
