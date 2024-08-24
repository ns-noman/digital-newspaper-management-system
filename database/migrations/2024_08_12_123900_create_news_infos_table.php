<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('news_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('VisitNumber');
            $table->integer('CommentNumber');
            $table->integer('NewsID');
            $table->dateTime('Date');
            $table->integer('NewsCategoryID');
            $table->string('NewsTitle');
            $table->string('TileUrl')->default("");
            $table->string('Thumbimage')->nullable();
            $table->tinyInteger('IsActive')->default(1);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('news_infos');
    }
};
