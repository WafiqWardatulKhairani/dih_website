<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKolaborasiIdesTable extends Migration
{
    public function up()
    {
        Schema::create('kolaborasi_ides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table>unsignedBigInteger('owner_id')->index();
            $table->string('field')->nullable();
            $table->string('estimated_duration')->nullable();
            $table->string('status')->default('pending'); // pending, active, completed
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kolaborasi_ides');
    }
}
