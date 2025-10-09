<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('opd_programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('opd_name');
            $table->string('category');
            $table->string('status');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('budget', 15, 2)->nullable();
            $table->integer('progress')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('opd_programs');
    }
};