<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OptionHasSets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('option_has_sets', function (Blueprint $table) {
            $table->id('option_set_id');
            $table->unsignedBigInteger('option_id');
            $table->unsignedBigInteger('set_id');
            $table->foreign('option_id')->references('option_id')->on('options')->onDelete('cascade');;
            $table->foreign('set_id')->references('set_id')->on('option_sets')->onDelete('cascade');;
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
        Schema::dropIfExists('option_has_sets');

    }
}
