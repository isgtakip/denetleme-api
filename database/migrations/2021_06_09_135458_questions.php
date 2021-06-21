<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Questions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('questions', function (Blueprint $table) {
            $table->id('question_id');
            $table->text('question');
            $table->integer('question_order')->default(0);
            $table->boolean('is_required')->default(0);
            $table->unsignedBigInteger('answer_type_id');
            $table->foreign('answer_type_id')->references('answer_type_id')->on('answer_types');
            $table->text('description')->nullable();
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
        //
        Schema::dropIfExists('questions');
    }
}
