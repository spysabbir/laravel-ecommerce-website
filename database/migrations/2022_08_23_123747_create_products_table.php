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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->integer('regular_price');
            $table->integer('discounted_price')->nullable();
            $table->string('product_slug')->unique();
            $table->text('short_description');
            $table->string('sku')->unique();
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->integer('childcategory_id');
            $table->integer('brand_id');
            $table->string('flashsale_status')->default('No');
            $table->integer('flashsale_id')->nullable();
            $table->string('today_deal_status')->default('No');
            $table->longText('long_description');
            $table->string('weight')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('materials')->nullable();
            $table->text('other_info')->nullable();
            $table->string('product_thumbnail_photo')->default('default_product_thumbnail_photo.jpg');
            $table->integer('view_count')->default(0);
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
        Schema::dropIfExists('products');
    }
};
