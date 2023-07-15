<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomBuildsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_builds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('custom_build_category_id')->unsigned()->nullable();
            $table->string('title', 191);
            $table->longText('description');
            $table->string('sku', 191);
            $table->text('tags')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->string('video_title', 191)->nullable();
            $table->text('video')->nullable();
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
        Schema::dropIfExists('custom_builds');
    }
}
