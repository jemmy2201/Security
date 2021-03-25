<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('app_type')->nullable()->comment('new or replacement or renewal');
            $table->string('card_id')->nullable()->comment('get table application');
            $table->string('grade_id')->nullable()->comment('get table detail application');
            $table->timestamp('declaration_date')->nullable();
            $table->timestamp('trans_date')->nullable();
            $table->timestamp('expired_date')->nullable();
            $table->timestamp('appointment_date')->nullable();
            $table->string('gst_id')->nullable();
            $table->string('transaction_amount_id')->nullable();
            $table->string('Status_app')->nullable();
            $table->string('paymentby')->nullable();
            $table->string('status_payment')->nullable();
            $table->string('user_id');
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
        Schema::dropIfExists('booking_schedules');
    }
}
