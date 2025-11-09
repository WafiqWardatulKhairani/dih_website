<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKolaborasiProgressTable extends Migration
{
    public function up()
    {
        Schema::create('kolaborasi_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kolaborasi_id');
            $table->unsignedBigInteger('task_id')->nullable();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('pending'); 
            $table->timestamps();

            $table->foreign('kolaborasi_id')
                ->references('id')
                ->on('kolaborasi_ideas')
                ->onDelete('cascade');

            $table->foreign('task_id')
                ->references('id')
                ->on('kolaborasi_tasks')
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kolaborasi_progress');
    }
}
