<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('front_menus', function (Blueprint $table) {
            $table->id();
            $table->string('Caption');
            $table->string('MenuLink');
            $table->integer('ParentID')->default(0);
            $table->integer('Priority')->default(500);
            $table->tinyInteger('IsActive')->default(1);
            $table->string('LinkType',50)->default('InternalLink');
            $table->integer('MenuGroup');
            $table->string('Image',100)->nullable();
            $table->integer('UserID');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('front_menus');
    }
};
