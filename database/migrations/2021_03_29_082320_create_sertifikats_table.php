<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikats', function (Blueprint $table) {
            $table->id();
            $table->string('app_type')->nullable()->comment('new or replacement or renewal');
            $table->string('card_id')->nullable()->comment('get table application');
            $table->string('grade_id')->nullable()->comment('get table detail application');
            $table->timestamp('declaration_date')->nullable()->comment('date select declaration');
            $table->timestamp('trans_date')->nullable()->comment('date transaction amount');
            $table->timestamp('expired_date')->nullable()->comment('date after transaction amount');
            $table->timestamp('appointment_date')->nullable()->comment('date appointment');
            $table->string('time_start_appointment')->nullable()->comment('time start declaration');
            $table->string('time_end_appointment')->nullable()->comment('time end declaration');
            $table->string('gst')->nullable();
            $table->string('grand_gst')->nullable();
            $table->string('transaction_amount')->nullable();
            $table->string('grand_total')->nullable();
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
        Schema::dropIfExists('sertifikats');
    }
}
