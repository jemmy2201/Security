<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImportStatusAndTaxReceiptToBookingSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_schedules', function (Blueprint $table) {
            $table->string('Import_Status',1)->nullable();
            $table->string('TaxReceipt',20)->nullable();
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
