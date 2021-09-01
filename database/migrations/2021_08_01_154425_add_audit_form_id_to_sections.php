<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuditFormIdToSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_form_sections', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('audit_form_id');
            $table->foreign('audit_form_id')->references('audit_form_id')->on('audits_form');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_form_sections', function (Blueprint $table) {
            //
            $table->dropColumn('audit_form_id');
        });

    }
}
