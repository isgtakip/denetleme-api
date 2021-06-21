<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AuditsForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('audits_form', function (Blueprint $table) {
            $table->id('audit_form_id');
            $table->string('audit_form_name',190);
            $table->string('audit_form_no',100)->nullable();
            $table->unsignedBigInteger('icon_id');
            $table->foreign('icon_id')->references('icon_id')->on('icons');
            $table->integer('audit_form_icon_id')->nullable();
            $table->boolean('audit_form_score_needed')->default(0);
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
        Schema::dropIfExists('audits_form');
    }
}
