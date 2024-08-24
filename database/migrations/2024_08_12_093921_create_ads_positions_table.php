<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ads_positions', function (Blueprint $table) {
            $table->id();
            $table->string('PositionName');
            $table->integer('UserID');
            $table->tinyInteger('IsActive');
            $table->datetime('EntryDate');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('ads_positions');
    }
};
