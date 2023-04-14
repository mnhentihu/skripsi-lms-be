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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('id_soal');
            $table->unsignedBigInteger('id_user');
            $table->integer('level');
            $table->string('subject');
            $table->string('jawaban')->nullable();
            $table->integer('score')->nullable();
            $table->integer('kesempatan')->nullable();
            $table->string('status_kelulusan')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('id_soal')->references('id_str')->on('banksoal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
    }
};
?>