<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('Caption');
            $table->text('Detail')->nullable();
            $table->string('Image',100)->default(0);
            $table->string('MediumImage',255)->nullable();
            $table->string('Thumbimage',100)->nullable();
            $table->timestamp('EntryDate')->useCurrent();
            $table->dateTime('Date');
            $table->tinyInteger('IsActive');
            $table->integer('UserID');
            $table->integer('NewsCategoryID');
            $table->integer('ParentCategoryID');
            $table->integer('SubCategoryID')->default(0);
            $table->string('CategoryName');
            $table->string('TagWord')->nullable();
            $table->tinyInteger('GalleryType')->default(1);
            $table->integer('Priority')->default(100);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('galleries');
    }
};
