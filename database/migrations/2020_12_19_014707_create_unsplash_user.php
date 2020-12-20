<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnsplashUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unsplash_users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('name');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('twitter_username')->nullable();
            $table->string('instagram_username')->nullable();
            $table->string('bio')->nullable();
            $table->string('location')->nullable();
            $table->string('profile_image_url');
            $table->integer('total_collections');
            $table->integer('total_likes');
            $table->integer('total_photos');
            $table->integer('total_views');
            $table->integer('following_count');
            $table->integer('followers_count');
            $table->integer('downloads');
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
        Schema::dropIfExists('unsplash_users');
    }
}
