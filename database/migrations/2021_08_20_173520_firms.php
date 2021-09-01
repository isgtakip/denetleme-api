<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Firms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('firms', function (Blueprint $table){

            $table->id('firma_id');
            $table->string('firma_tam_unvan')->nullable();
            $table->string('firma_kisa_ad')->nullable();
            $table->integer('nace_kod_id')->nullable();
            $table->integer('firma_tip_id')->nullable();
            $table->text('firma_sgk')->nullable();
            $table->integer('ust_firma_id')->nullable();
            $table->string('sahis_ad_soyad')->nullable();
            $table->integer('firma_turu')->nullable();
            $table->integer('firma_il_id')->nullable();
            $table->integer('firma_ilce_id')->nullable();
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
        Schema::dropIfExists('firms');
    }
}
