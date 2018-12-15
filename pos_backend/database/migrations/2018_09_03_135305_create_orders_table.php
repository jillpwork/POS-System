<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_number');
            $table->bigInteger('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->integer('discount')->default(0);
            $table->integer('sgst')->default(9);
            $table->integer('cgst')->default(9);
            $table->integer('igst')->default(0);
            $table->float('other_charges', 10, 2)->default(0);
            $table->float('total_amount', 10, 2)->default(0);
            $table->float('paid_amount', 10, 2)->default(0);
            $table->boolean('paid_status')->default(false);
            $table->string('extra_notes', 1000)->nullable();
            $table->date('order_date');
            $table->date('order_delivery_date');
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
        Schema::dropIfExists('orders');
    }
}
