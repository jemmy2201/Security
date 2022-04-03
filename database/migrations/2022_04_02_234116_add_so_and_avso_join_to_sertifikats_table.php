<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoAndAvsoJoinToSertifikatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->string('TR_RTT',3)->nullable();
            $table->string('TR_CSSPB',3)->nullable();
            $table->string('TR_CCTC',3)->nullable();
            $table->string('TR_HCTA',3)->nullable();
            $table->string('TR_X_RAY',3)->nullable();
            $table->string('TR_AVSO',3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            //
        });
    }
}
