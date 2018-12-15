<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMesurmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mesurments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id')->nullable()->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('chest')->nullable();
            $table->string('bust')->nullable();
            $table->string('rib_cage')->nullable();
            $table->string('inseam')->nullable();
            $table->string('biceps')->nullable();
            $table->string('waist')->nullable();
            $table->string('hip')->nullable();
            $table->string('neck_to_floor')->nullable();
            $table->string('shoulder_to_elbow')->nullable();
            $table->string('shoulder_to_wrist')->nullable();
            $table->string('waist_to_knee')->nullable();
            $table->string('waist_to_floor')->nullable();
            $table->string('armpit_to_waist')->nullable();
            $table->string('backneck_to_waist')->nullable();
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
        Schema::dropIfExists('mesurments');
    }
}
