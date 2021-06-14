<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDateholidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dateholidays', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable()->comment("date");
            $table->string('name_holiday')->nullable()->comment("example Pancasila Day,etc");
            $table->string('time_work')->nullable()->comment("Half-day up to 13:00 ");
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
        Schema::dropIfExists('dateholidays');
    }
}
