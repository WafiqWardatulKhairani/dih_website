<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKolaborasiReviewsTable extends Migration
{
    public function up()
    {
        // Cek apakah tabel sudah ada
        if (!Schema::hasTable('kolaborasi_reviews')) {
            Schema::create('kolaborasi_reviews', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('kolaborasi_id')->index();
                $table->unsignedBigInteger('reviewer_id')->index();
                $table->tinyInteger('rating')->nullable();
                $table->text('comment')->nullable();
                $table->timestamps();

                // Foreign key
                $table->foreign('kolaborasi_id')->references('id')->on('kolaborasi_ides')->cascadeOnDelete();
                $table->foreign('reviewer_id')->references('id')->on('users')->cascadeOnDelete();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('kolaborasi_reviews');
    }
}
