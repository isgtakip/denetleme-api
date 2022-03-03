<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AuditsLocationsSablons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('audits_locations_sablons', function (Blueprint $table){

            $table->id('location_sablon_id');
            $table->unsignedBigInteger('audit_location_id');
            $table->foreign('audit_location_id')->references('audit_location_id')->on('audits_locations')->onDelete('cascade');
            $table->unsignedBigInteger('sablon_id');
            $table->foreign('sablon_id')->references('audit_form_id')->on('audits_form')->onDelete('cascade');
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
    }
}
