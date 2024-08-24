<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('Caption');
            $table->smallInteger('Priority')->default(100);
            $table->tinyInteger('IsActive')->default(1);
            $table->string('IsTrend', 10)->default('No');
            $table->integer('UserID');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('tags');
    }
};
