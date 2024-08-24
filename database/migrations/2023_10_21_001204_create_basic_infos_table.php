<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('basic_infos', function (Blueprint $table) {
            $table->id();
            $table->string('SiteName')->nullable();
            $table->string('HomePageTitle')->nullable();
            $table->text('MetaTag')->nullable();
            $table->longText('MetaDescription')->nullable();
            $table->string('SiteBanner', 100)->nullable();
            $table->longText('GoogleAnalytics')->nullable();
            $table->string('Logo',100)->nullable();
            $table->string('FavIcon',100)->nullable();
            $table->string('SiteContact');
            $table->string('SiteEmail');
            $table->string('SiteFaceBook')->nullable();
            $table->string('SiteTwitter')->nullable();
            $table->string('SiteGooglePlus')->nullable();
            $table->string('SiteYouTube')->nullable();
            $table->string('SiteLinkdin')->nullable();
            $table->string('Currency');
            $table->text('Address');
            $table->text('GoogleMap');
            $table->string('DefaultImage')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('basic_infos');
    }
};
