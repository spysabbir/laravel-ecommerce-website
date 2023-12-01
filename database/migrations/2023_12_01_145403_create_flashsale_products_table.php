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
        Schema::create('flashsale_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flashsale_id');
            $table->integer('product_id');

            $table->foreign('flashsale_id')->references('id')->on('flashsales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flashsale_products');
    }
};
