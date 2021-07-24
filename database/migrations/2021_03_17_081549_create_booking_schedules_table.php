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
            $table->string('declaration_date')->nullable()->comment('date select declaration');
            $table->string('trans_date')->nullable()->comment('date transaction amount');
            $table->string('expired_date')->nullable()->comment('date after transaction amount');
            $table->string('appointment_date')->nullable()->comment('date appointment');
            $table->string('time_start_appointment')->nullable()->comment('time start declaration');
            $table->string('time_end_appointment')->nullable()->comment('time end declaration');
            $table->string('gst_id')->nullable();
            $table->string('transaction_amount_id')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('Status_app')->nullable();
            $table->string('Status_draft')->nullable();
            $table->string('paymentby')->nullable();
            $table->string('status_payment')->nullable();
            $table->string('receiptNo')->nullable();
            $table->string('nric');
            $table->string('passid')->unique();
            $table->string('passexpirydate')->nullable();
            $table->string('resubmission_date')->nullable();
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
