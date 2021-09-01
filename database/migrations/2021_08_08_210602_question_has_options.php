<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuestionHasOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('question_has_options', function (Blueprint $table) {
            $table->id('question_option_id');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('question_id')->on('questions');
            $table->unsignedBigInteger('option_id');
            $table->foreign('option_id')->references('option_id')->on('options');
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
        Schema::dropIfExists('question_has_options');
    }
    
}
