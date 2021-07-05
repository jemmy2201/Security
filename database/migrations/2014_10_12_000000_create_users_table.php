<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('nric')->nullable()->comment('National Registration Identity Card or Foreign Identification Number');
            $table->string('passportexpirydate')->nullable();
            $table->string('passportnumber')->nullable();
            $table->string('mobileno')->nullable();
            $table->string('homeno')->nullable();
            $table->string('photo')->nullable();
            $table->date('time_login_at')->nullable()->comment('time login');
            $table->string('role')->nullable();
            $table->string('web')->nullable()->comment('Field by default is 0 not entring expiry date, when field is 1, WP expiry date
is mandatory.');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
