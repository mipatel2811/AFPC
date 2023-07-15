<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomBuildImageGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_build_image_galleries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('custom_build_id')->unsigned()->nullable();
            $table->foreign('custom_build_id')->references('id')->on('custom_builds')->onUpdate('cascade');
            $table->string('image', 191);
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
        Schema::dropIfExists('custom_build_image_galleries');
    }
}
