<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname');
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('email', 100)->nullable();
            $table->bigInteger('phone_number')->nullable();
            $table->bigInteger('mobile')->nullable();
            $table->string('address_street')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('postalcode')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
