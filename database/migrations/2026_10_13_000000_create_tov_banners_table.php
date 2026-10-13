<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTovBannersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tov_banners')) {
            Schema::create('tov_banners', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('image')->nullable();
                $table->string('image_mobile')->nullable();
                $table->string('eyebrow')->nullable();
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->string('button_text')->nullable();
                $table->string('button_link')->nullable();
                $table->string('video_text')->nullable();
                $table->string('video_link')->nullable();
                $table->integer('sort')->default(0);
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('tov_banners');
    }
}
