<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banksoal', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('soal');
            $table->text('ansA');
            $table->text('ansB');
            $table->text('ansC');
            $table->text('ansD');
            $table->string('corAns');
            $table->integer('level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banksoals');
    }
};
