<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('ParentID')->nullable();
            $table->string('Caption');
            $table->string('SEOCaption');
            $table->string('ParentName')->nullable();
            $table->integer('Priority')->default(500);
            $table->tinyInteger('IsActive')->default(1);
            $table->string('Image')->nullable();
            $table->integer('CategoryGroupID');
            $table->integer('UserID');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
