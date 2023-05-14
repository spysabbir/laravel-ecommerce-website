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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('team_member_name');
            $table->string('team_member_designation');
            $table->string('team_member_photo')->default('default_profile_photo.png');
            $table->string('team_member_facebook_link');
            $table->string('team_member_twitter_link');
            $table->string('team_member_instagram_link');
            $table->string('team_member_linkedin_link');
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
        Schema::dropIfExists('teams');
    }
};
