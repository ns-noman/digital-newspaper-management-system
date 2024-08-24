<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reporters', function (Blueprint $table) {
            $table->id();
            $table->string('ReporterName');
            $table->string('Email',100);
            $table->string('Image');
            $table->tinyInteger('IsActive')->default(1);
            $table->string('Address');
            $table->string('Contact');
            $table->string('NewsSection')->nullable();
            $table->string('NewsBit')->nullable();
            $table->text('Notes');
            $table->text('WebLink');
            $table->integer('UserID');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('reporters');
    }
};
