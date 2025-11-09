<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKolaborasiDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('kolaborasi_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kolaborasi_id')->index();
            $table->string('title')->nullable();
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->string('category')->default('teknis');
            $table->string('visibility')->default('member-only'); 
            $table->unsignedBigInteger('uploaded_by')->index();
            $table->timestamps();

            $table->foreign('kolaborasi_id')->references('id')->on('kolaborasi_ideas')->cascadeOnDelete();
            $table->foreign('uploaded_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kolaborasi_documents');
    }
}
