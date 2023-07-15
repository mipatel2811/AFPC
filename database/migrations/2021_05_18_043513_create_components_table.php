<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned()->nullable();
            // $table->foreign('category_id')->references('id')->on('component_categories')->onUpdate('cascade');
            $table->string('title', 191);
            $table->longText('description');
            $table->double('regular_price');
            $table->double('special_price')->nullable();
            $table->string('sku', 191);
            $table->integer('stock');
            $table->tinyInteger('is_active')->default(1);
            $table->text('image')->nullable();
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
        Schema::dropIfExists('components');
    }
}
