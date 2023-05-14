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
        Schema::create('order_returns', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('order_no');
            $table->integer('order_detail_id');
            $table->longText('return_reason_details');
            $table->string('return_reason_photo')->nullable();
            $table->string('account_holder_name');
            $table->string('account_type');
            $table->string('account_number');
            $table->string('return_status');
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
        Schema::dropIfExists('order_returns');
    }
};
