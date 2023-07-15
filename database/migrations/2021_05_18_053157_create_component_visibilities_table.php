<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentVisibilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_visibilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('component_id')->unsigned()->nullable();
            // $table->foreign('component_id')->references('id')->on('components')->onUpdate('cascade');
            $table->longText('conditions')->nullable();
            $table->text('message_on_disable')->nullable();
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
        Schema::dropIfExists('component_visibilities');
    }
}
