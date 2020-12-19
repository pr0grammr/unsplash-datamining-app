<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unsplash_photos', function (Blueprint $table) {
            $table->id();
            $table->string('photo_id');
            $table->integer('likes');
            $table->integer('downloads');
            $table->integer('views');
            $table->foreignId('user_id')->constrained('unsplash_users')->onDelete('cascade');
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
        Schema::dropIfExists('unsplash_photos');
    }
}
