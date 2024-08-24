<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('poll_details', function (Blueprint $table) {
            $table->id();
            $table->integer('OnlinepollID')->nullable();
            $table->string('IPAddress',50)->nullable();
            $table->dateTime('Date')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('poll_details');
    }
};
