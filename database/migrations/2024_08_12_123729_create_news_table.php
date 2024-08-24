<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('NewsTitle');
            $table->string('TileUrl')->default("");
            $table->string('HomepageTitle');
            $table->string('ShareTitle');
            $table->longText('DetailNews')->nullable();
            $table->string('NewsShoulder')->nullable();
            $table->string('NewsHanger')->nullable();
            $table->text('NewsSummary')->nullable();
            $table->string('Image',100)->nullable();
            $table->string('MediumImage',255)->nullable();
            $table->string('Thumbimage',100)->nullable();
            $table->string('Image2')->nullable();
            $table->string('MediumImage2')->nullable();
            $table->string('Thumbimage2')->nullable();
            $table->text('ImageTitle')->nullable();
            $table->timestamp('EntryDate')->useCurrent();
            $table->dateTime('Date');
            $table->dateTime('UpdateTime')->nullable();
            $table->tinyInteger('IsActive');
            $table->integer('UserID');
            $table->integer('NewsCategoryID');
            $table->integer('ParentCategoryID');
            $table->integer('SubCategoryID')->default(0);
            $table->smallInteger('Priority')->default(15);
            $table->smallInteger('CategoryPriority')->default(16);
            $table->smallInteger('SubCategoryPriority')->default(16);
            $table->smallInteger('SelectedPriority')->default(13);
            $table->tinyInteger('IsEditorChoice')->default(0);
            $table->smallInteger('EditorChoicePriority')->default(13);
            $table->tinyInteger('TopRightPriority')->default(6);
            $table->string('CategoryName');
            $table->string('CategoryBngName')->nullable();
            $table->text('NewsSource')->nullable();
            $table->tinyInteger('HasVideo')->nullable();
            $table->integer('TVID')->nullable();
            $table->integer('WriterID')->nullable();
            $table->string('TagWord')->nullable();
            $table->tinyInteger('IsBreaking')->default(0);
            $table->dateTime('BreakingTime')->nullable();
            $table->tinyInteger('IsSeleted')->default(1);
            $table->tinyInteger('IsTop')->default(0);
            $table->string('RelatedNews')->nullable();
            $table->tinyInteger('ImageShow')->default(1);
            $table->tinyInteger('ImageHomePage')->default(1);
            $table->string('ReporterName')->default("");
            $table->text('ImageTag')->nullable();
            $table->text('CaptionHeading')->nullable();
            $table->integer('DivisionID')->nullable();
            $table->tinyInteger('IsRecent')->default(1);
            $table->integer('TodaysCategory')->nullable();
            $table->tinyInteger('IsScroll')->default(0);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('news');
    }
};
