<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_amounts', function (Blueprint $table) {
            $table->id();
            $table->string('app_type')->nullable();
            $table->string('card_type')->nullable();
            $table->string('grade_id')->nullable();
            $table->string('transaction_amount')->nullable();

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
        Schema::dropIfExists('transaction_amounts');
    }
}
