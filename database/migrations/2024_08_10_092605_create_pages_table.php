<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('IsActive');
            $table->text('PageName');
            $table->text('MetaTag');
            $table->text('MetaDescription');
            $table->integer('Priority');
            $table->longText('Detail');
            $table->integer('UserID');
            $table->timestamp('Date');
            $table->string('TagWord')->nullable();
            $table->text('Summary');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
    }
};
