<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKolaborasiMembersTable extends Migration
{
    public function up()
    {
        Schema::create('kolaborasi_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kolaborasi_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('role')->default('member'); // leader, member, observer
            $table->string('status')->default('pending'); // pending, active, rejected
            $table->timestamps();

            $table->foreign('kolaborasi_id')->references('id')->on('kolaborasi_ides')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unique(['kolaborasi_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kolaborasi_members');
    }
}
