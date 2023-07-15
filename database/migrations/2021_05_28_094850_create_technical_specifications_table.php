<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_specifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('custom_build_id')->unsigned()->nullable();
            $table->foreign('custom_build_id')->references('id')->on('custom_builds')->onUpdate('cascade');
            $table->string('title', 191);
            $table->longText('description');
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
        Schema::dropIfExists('technical_specifications');
    }
}
