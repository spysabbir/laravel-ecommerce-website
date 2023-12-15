<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_summeries', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('billing_name');
            $table->string('billing_email');
            $table->string('billing_phone');
            $table->integer('billing_division_id');
            $table->integer('billing_district_id');
            $table->text('billing_address');
            $table->string('shipping_name');
            $table->string('shipping_email');
            $table->string('shipping_phone');
            $table->integer('shipping_division_id');
            $table->integer('shipping_district_id');
            $table->text('shipping_address');
            $table->longText('customer_order_notes')->nullable();
            $table->float('sub_total');
            $table->float('shipping_charge');
            $table->string('coupon_name')->nullable();
            $table->float('discount_amount')->default(0);
            $table->float('grand_total');
            $table->string('payment_method');
            $table->string('payment_status')->default('Unpaid');
            $table->string('transaction_id')->nullable();
            $table->string('order_status')->default('Panding');
            $table->integer('warehouse_id')->nullable();
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
        Schema::dropIfExists('order_summeries');
    }
};
