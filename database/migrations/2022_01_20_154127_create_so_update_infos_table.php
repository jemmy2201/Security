<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoUpdateInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('so_update_info', function (Blueprint $table) {
            $table->id();
            $table->string('PassID')->nullable()->unique();
            $table->string('NRIC')->nullable();
            $table->string('Name')->nullable();
            $table->string('Grade')->nullable();
            $table->string('New_Grade')->nullable();
            $table->string('TR_RTT')->nullable();
            $table->string('TR_CSSPB')->nullable();
            $table->string('TR_CCTC')->nullable();
            $table->string('TR_HCTA')->nullable();
            $table->string('TR_X_RAY')->nullable();
            $table->string('SKILL_BFM')->nullable();
            $table->string('SKILL_BSS')->nullable();
            $table->string('SKILL_FSM')->nullable();
            $table->string('SKILL_CERT')->nullable();
            $table->string('SKILL_COSEM')->nullable();
            $table->string('Date_Submitted')->nullable();
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
        Schema::dropIfExists('so_update_infos');
    }
}
