<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->integer('AdsPositionID');
            $table->string('AdsUrl');
            $table->text('AdsDetail');
            $table->string('CustomerName');
            $table->dateTime('StartDate');
            $table->dateTime('EndDate');
            $table->integer('UserID');
            $table->tinyInteger('IsActive');
            $table->timestamp('EntryDate');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('ads');
    }
};
