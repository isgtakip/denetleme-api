<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AuditsLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('audits_locations', function (Blueprint $table){
            $table->id('audit_location_id');
            $table->unsignedBigInteger('audit_id');
            $table->foreign('audit_id')->references('audit_id')->on('audits')->onDelete('cascade');
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')->references('firma_id')->on('firms')->onDelete('cascade');
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
        Schema::dropIfExists('audits_locations');
    }
}
