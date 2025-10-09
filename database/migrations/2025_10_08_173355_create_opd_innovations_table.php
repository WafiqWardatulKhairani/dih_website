<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('opd_innovations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('institution');
            $table->string('category');
            $table->string('subcategory')->nullable();
            $table->string('author_name')->nullable();
            $table->text('keywords')->nullable();
            $table->text('purpose')->nullable();
            $table->integer('technology_readiness_level')->default(1);
            $table->string('image')->nullable();
            $table->string('document_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('contact')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('opd_innovations');
    }
};