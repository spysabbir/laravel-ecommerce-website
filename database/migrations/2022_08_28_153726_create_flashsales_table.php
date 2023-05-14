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
        Schema::create('flashsales', function (Blueprint $table) {
            $table->id();
            $table->string('flashsale_offer_name');
            $table->string('flashsale_offer_slug');
            $table->string('flashsale_offer_type');
            $table->float('flashsale_offer_amount');
            $table->dateTime('flashsale_offer_start_date');
            $table->dateTime('flashsale_offer_end_date');
            $table->string('flashsale_offer_banner_photo');
            $table->string('status')->default('Yes');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flashsales');
    }
};
