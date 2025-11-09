<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKolaborasiTasksTable extends Migration
{
    public function up()
    {
        Schema::create('kolaborasi_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kolaborasi_id')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable()->index();
            $table->dateTime('deadline')->nullable();
            $table->string('status')->default('todo'); // todo, in_progress, done
            $table->timestamps();

            // ✅ ubah ke tabel yang benar
            $table->foreign('kolaborasi_id')->references('id')->on('kolaborasi_ideas')->cascadeOnDelete();
            $table->foreign('assigned_to')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kolaborasi_tasks');
    }
}
