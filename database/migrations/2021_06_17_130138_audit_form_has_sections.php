<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AuditFormHasSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('audit_form_has_section', function (Blueprint $table) {
            $table->id('form_section_id');
            $table->unsignedBigInteger('audit_form_id');
            $table->foreign('audit_form_id')->references('audit_form_id')->on('audits_form');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('section_id')->on('audit_form_sections');
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
        Schema::dropIfExists('audit_form_has_section');
    }
}
