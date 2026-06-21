<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

## all 301 redirect routes
Route::get('latest', function(){ return Redirect::to('/todays-news', 301); });
## all 301 redirect routes


## artisan command ##
Route::get('/clear-all', function() {
	$exitCode = Artisan::call('route:clear');
	$exitCode = Artisan::call('view:clear');
	$exitCode = Artisan::call('cache:clear'); 
	$exitCode = Artisan::call('config:clear');
	// $exitCode = Artisan::call('config:cache');
	return 'Clear & Cached Everything';
});

## other routes ##
Auth::routes();
Route::get('/profile', 'App\Http\Controllers\CustomerController@profile');
Route::post('/profile/update', 'App\Http\Controllers\CustomerController@profileUpdate');
Route::get('/subscribe/{articleId}', 'App\Http\Controllers\CustomerController@subscribeNews');

Route::get('/bn-converter', 'App\Http\Controllers\OtherController@unicodeConverter');
Route::get('/privacy-policy', 'App\Http\Controllers\OtherController@privacy');
Route::get('/terms', 'App\Http\Controllers\OtherController@terms');
Route::get('/advertisement', 'App\Http\Controllers\OtherController@advertisement');
Route::get('/contact', 'App\Http\Controllers\OtherController@contact');
Route::get('/about', 'App\Http\Controllers\OtherController@about');
Route::get('/team', 'App\Http\Controllers\OtherController@team');
Route::get('/404', 'App\Http\Controllers\OtherController@error');
Route::get('/search', 'App\Http\Controllers\OtherController@search');
Route::get('/selected', 'App\Http\Controllers\OtherController@selectedNews');
Route::get('/todays-news', 'App\Http\Controllers\OtherController@latestNews');
Route::get('/popular', 'App\Http\Controllers\OtherController@popularNews');
Route::get('/news-issue/{tag}', 'App\Http\Controllers\OtherController@topicNews');
Route::get('/tag/{tag}', 'App\Http\Controllers\OtherController@topicNews');
Route::get('/archive', 'App\Http\Controllers\OtherController@archive');
Route::get('/archive/print', 'App\Http\Controllers\OtherController@archivePrint');
Route::get('/categories', 'App\Http\Controllers\OtherController@categories');
Route::get('/links/{slug}', 'App\Http\Controllers\OtherController@links');

Route::get('/poll/{id?}', 'App\Http\Controllers\OtherController@polls')->where('id', '[0-9]+');
Route::get('/poll/store/{id}/{answer}', 'App\Http\Controllers\OtherController@pollStore');
Route::get('/authors', 'App\Http\Controllers\OtherController@authors');
Route::get('/author/{id}/{title?}', 'App\Http\Controllers\OtherController@authorProfile');
Route::get('/events/{id?}/{title?}', 'App\Http\Controllers\OtherController@events');
Route::get('/lives/{id?}/{title?}', 'App\Http\Controllers\OtherController@lives');
// Route::get('/area', 'App\Http\Controllers\OtherController@locationPage');
Route::get('/area/{locationTitle}', 'App\Http\Controllers\OtherController@locationNews');

## sitemaps ##
// Route::get('/sitemap.xml', 'App\Http\Controllers\SitemapController@sitemapXml');
// Route::get('/sitemap/sitemap-static-pages.xml', 'App\Http\Controllers\SitemapController@sitemapStaticXml');
// Route::get('/sitemap/sitemap-section.xml', 'App\Http\Controllers\SitemapController@sitemapSectionXml');
// Route::get('/sitemap/{dailyDate}', 'App\Http\Controllers\SitemapController@sitemapDailyXml');
Route::get('/newsissue.xml', 'App\Http\Controllers\SitemapController@sitemapTopicXml');
Route::get('/news.xml', 'App\Http\Controllers\SitemapController@sitemapNewsXml');
Route::get('/custom.xml', 'App\Http\Controllers\SitemapController@sitemapCustomXml');
Route::get('/rss/category/{category}', 'App\Http\Controllers\SitemapController@rssCategoryXml');

## ajax routes ##
Route::get('/ajax/load/menubarcategories', 'App\Http\Controllers\CommonController@ajaxMenubarCategories');
Route::get('/ajax/load/menubarcategoriesNews/{id}', 'App\Http\Controllers\CommonController@ajaxMenubarCategoriesNews');
Route::get('/ajax/load/polls/{limit}/{paginate}', 'App\Http\Controllers\CommonController@ajaxPolls');
Route::get('/ajax/load/categorynews/{cat_id}/{limit}/{paginate}/{summary}', 'App\Http\Controllers\CommonController@ajaxCategoryArticles');
Route::get('/ajax/load/selectednews/{limit}/{paginate}/{summary}', 'App\Http\Controllers\CommonController@ajaxSelectedArticles');
Route::get('/ajax/load/latestnews/{limit}/{paginate}/{summary}/{headlineCount?}', 'App\Http\Controllers\CommonController@ajaxLatestArticles');
Route::get('/ajax/load/latestphotos/{limit}/{paginate}', 'App\Http\Controllers\CommonController@ajaxLatestPhotos');
Route::get('/ajax/load/latestvideos/{limit}/{paginate}', 'App\Http\Controllers\CommonController@ajaxLatestVideos');
Route::get('/ajax/load/leadnews/{limit}/{summary}', 'App\Http\Controllers\CommonController@ajaxLeadArticles');
Route::get('/ajax/load/tagnews/{tag}/{articleId}/{limit}/{paginate}/{summary}', 'App\Http\Controllers\CommonController@ajaxTagArticles');
Route::get('/ajax/load/topicnews/{topicIds}/{articleId}/{limit}/{paginate}/{summary}', 'App\Http\Controllers\CommonController@ajaxTopicArticles');
Route::get('/ajax/load/popularnews/{limit}/{summary}', 'App\Http\Controllers\CommonController@ajaxPopularArticles');
Route::get('/ajax/load/authornews/{authorId}/{limit}/{paginate}/{summary}', 'App\Http\Controllers\CommonController@ajaxAuthorArticles');
Route::get('/ajax/load/eventnews/{eventId}/{limit}/{paginate}/{summary}', 'App\Http\Controllers\CommonController@ajaxEventArticles');
Route::get('/ajax/load/livevideos/{limit}/{paginate}', 'App\Http\Controllers\CommonController@ajaxLiveVideos');
Route::get('/ajax/store/newsView/{articleDate}/{articleId}', 'App\Http\Controllers\CommonController@ajaxStoreNewsView');
Route::get('/ajax/load/districts/{division}', 'App\Http\Controllers\CommonController@ajaxGetDistricts');
Route::get('/ajax/load/upazilas/{district}', 'App\Http\Controllers\CommonController@ajaxGetUpazilas');
Route::get('/ajax/load/timelinenews/{incident_id}/{limit}/{paginate}/{summary}', 'App\Http\Controllers\CommonController@ajaxTimelineArticles');
Route::get('/ajax/load/specialnews/{archived_topic_id}/{limit}/{paginate}/{summary}', 'App\Http\Controllers\CommonController@ajaxArchivedTopicArticles');
Route::get('/ajax/api/latestnews/{limit}/{paginate}/{summary}', 'App\Http\Controllers\CommonController@ajaxApiLatestArticles');
Route::get('/ajax/load/locationnews/{location_id}/{type}/{limit}/{paginate}/{summary}', 'App\Http\Controllers\CommonController@ajaxLocationArticles')->where('location_id', '[0-9]+')->where('limit', '[0-9]+')->where('paginate', '[0-9]+')->where('summary', '[0-9]+');

## site routes ##
Route::get('/ajax/load/desktop/home', 'App\Http\Controllers\HomeController@ajaxDesktopHome');
Route::get('/ajax/load/mobile/home', 'App\Http\Controllers\HomeController@ajaxMobileHome');
Route::get('/', 'App\Http\Controllers\HomeController@home')->name('Home');
Route::get('/{category}/{id}', 'App\Http\Controllers\DetailController@detail')->where('id', '[0-9]+')->name('Detail');
Route::get('/{category}/{subcategory}/{id}', 'App\Http\Controllers\DetailController@detail2')->where('id', '[0-9]+')->name('Detail2');
Route::get('/ajax/load/detail/{articleId}/{categoryId}/{paginate}', 'App\Http\Controllers\DetailController@ajaxDetail');
Route::get('/{category}/{subcategory?}', 'App\Http\Controllers\CategoryController@category')->name('Category');


Route::any('{query}', 
	function() { return 'Access denied. Requested page not found.'; })
->where('query', '.*');
