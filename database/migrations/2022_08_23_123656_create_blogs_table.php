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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->text('blog_headline');
            $table->text('blog_slug');
            $table->integer('blog_category_id');
            $table->longText('blog_quota');
            $table->string('blog_thumbnail_photo')->default('default_blog_thumbnail_photo.jpg');
            $table->string('blog_cover_photo')->default('default_blog_cover_photo.jpg');
            $table->longText('blog_details');
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
        Schema::dropIfExists('blogs');
    }
};
