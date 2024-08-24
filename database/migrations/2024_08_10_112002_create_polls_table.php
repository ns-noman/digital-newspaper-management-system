<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->integer('UserID');
            $table->tinyInteger('IsActive');
            $table->timestamp('Date')->useCurrent();
            $table->text('Caption');
            $table->integer('PositiveComment')->default(0);
            $table->integer('NegativeComment')->default(0);
            $table->integer('NoComment')->default(0);
            $table->string('IsClosed',10);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('polls');
    }
};
