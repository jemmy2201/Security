<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLincesStatusCardIssueBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_schedules', function (Blueprint $table) {
            $table->string('licence_status')->nullable();
            $table->string('card_issue')->nullable()->default('N');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_schedules', function (Blueprint $table) {
            //
        });
    }
}
