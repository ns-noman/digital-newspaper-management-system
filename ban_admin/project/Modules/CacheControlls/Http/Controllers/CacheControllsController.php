<?php

namespace Modules\CacheControlls\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Http;
use Auth;
use DB;
use Session;
use App\Models\Articles;

class CacheControllsController extends Controller
{   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');


        // # redis connection check default
        // $this->redisConnStatus = env('REDIS_STATUS');
        // if($this->redisConnStatus == true){
        //     try{
        //         $this->redisConnection = Redis::connection('default');
        //         $this->redisConnection->connect();
        //         $this->redisConnStatus = true;
        //     }catch(\Exception $e){
        //         $this->redisConnStatus = false;
        //     }
        // }

        // # redis connection check bd
        // $this->redisConnStatusBD = env('REDIS_BD_STATUS');
        // if($this->redisConnStatusBD == true){
        //     try{
        //         $this->redisConnectionBD = Redis::connection(env('REDIS_BD_Title'));
        //         $this->redisConnectionBD->connect();
        //         $this->redisConnStatusBD = true;
        //     }catch(\Exception $e){
        //         $this->redisConnStatusBD = false;
        //     }
        // }

        // # redis connection check sg
        // $this->redisConnStatusSG = env('REDIS_SG_STATUS');
        // if($this->redisConnStatusSG == true){
        //     try{
        //         $this->redisConnectionSG = Redis::connection(env('REDIS_SG_Title'));
        //         $this->redisConnectionSG->connect();
        //         $this->redisConnStatusSG = true;
        //     }catch(\Exception $e){
        //         $this->redisConnStatusSG = false;
        //     }
        // }
        // # redis connection check end

        // # redis connection check hit
        // $this->redisConnStatusHIT = env('REDIS_HIT_STATUS');
        // if($this->redisConnStatusHIT == true){
        //     try{
        //         $this->redisConnectionHIT = Redis::connection(env('REDIS_HIT_Title'));
        //         $this->redisConnectionHIT->connect();
        //         $this->redisConnStatusHIT = true;
        //     }catch(\Exception $e){
        //         $this->redisConnStatusHIT = false;
        //     }
        // }

    }


    # server manual cache clear
    public function index(){
        return view('cachecontrolls::index');
    }

    public function newsCacheClear(Request $request){
        // // array of curl handles
        // $curl_handle = array();
        // // data to be returned
        // $cache_data = array();
        // // multi handle
        // $mh = curl_multi_init();
        // foreach($request->articles as $key => $url){
        //     $cache_url = '';
        //     $curl_handle[$key]=curl_init();
        //     curl_setopt($curl_handle[$key], CURLOPT_URL,"$cache_url");
        //     curl_setopt($curl_handle[$key], CURLOPT_SSL_VERIFYPEER, false );
        //     curl_setopt($curl_handle[$key], CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($curl_handle[$key], CURLOPT_HEADER, false);
        //     curl_multi_add_handle($mh, $curl_handle[$key]);
        // }
        // // execute the handles
        // $running = null;
        // do {
        //     curl_multi_exec($mh, $running);
        // } while($running > 0);


        // // get content and remove handles
        // foreach($curl_handle as $id => $c) {
        //     $cache_data[$id] = curl_multi_getcontent($c);
        //     curl_multi_remove_handle($mh, $c);
        // }

        // // all done
        // curl_multi_close($mh);
        // return response()->json(['cache_data'=>$cache_data]);
    }
    # server manual cache clear end
    

    # get news view
    public function getNewsViewRedis(){
        // if($this->redisConnStatusHIT == true){
        //     $news_hits = $this->redisConnectionHIT->get('news_hit');
        //     if(!empty($news_hits)){
        //         $newsHitsData = unserialize($news_hits);
        //         dd($newsHitsData);
        //     }
        // }
    }

    # redis generate latest news
    public function redisGenerateLatestNews($newsId){
        // if($this->redisConnStatus == true || $this->redisConnStatusBD == true || $this->redisConnStatusSG == true){
        //     $latestArticles = Articles::where('articles.status', 1)->leftjoin('categories', 'categories.id', '=', 'articles.category_id')
        //     ->select('articles.id', 'articles.id as article_key_id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.description', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'categories.title', 'categories.display_name', 'categories.icon')
        //     ->orderBy('articles.created_at', 'desc')->limit(10)->get()->keyBy('article_key_id');
        //     $latestArticles = serialize($latestArticles);

        //     # redis default
        //     if($this->redisConnStatus == true){
        //         $this->redisConnection->del('latestArticles');
        //         $this->redisConnection->set('latestArticles', $latestArticles);
        //     }

        //     # redis bd
        //     if($this->redisConnStatusBD == true){
        //         $this->redisConnectionBD->del('latestArticles');
        //         $this->redisConnectionBD->set('latestArticles', $latestArticles);
        //     }

        //     # redis sg
        //     if($this->redisConnStatusSG == true){
        //         $this->redisConnectionSG->del('latestArticles');
        //         $this->redisConnectionSG->set('latestArticles', $latestArticles);
        //     }
            
        // }
    }


    # redis generate category section news
    public function redisGenerateCategorySectionNews($newCategories){
        // if($this->redisConnStatus == true || $this->redisConnStatusBD == true || $this->redisConnStatusSG == true){
        //     if(!empty($newCategories)){
        //         foreach ($newCategories as $key => $categoryId) {
        //             $articles = DB::table('articles')->where('articles.status', 1)
        //             ->leftjoin('article_categories', 'article_categories.article_id', '=', 'articles.id')->where('article_categories.category_id', $categoryId)
        //             ->leftjoin('categories', 'categories.id', '=', 'article_categories.category_id')
        //             ->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.description', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'article_categories.category_id', 'categories.display_name', 'categories.title', 'categories.icon')
        //             ->orderBy('articles.order_id', 'desc')->limit(20)->get();
        //             $articles = serialize($articles);

        //             # redis default
        //             if($this->redisConnStatus == true){
        //                 $this->redisConnection->del('category_'.$categoryId);
        //                 $this->redisConnection->set('category_'.$categoryId, $articles);
        //             }

        //             # redis bd
        //             if($this->redisConnStatusBD == true){
        //                 $this->redisConnectionBD->del('category_'.$categoryId);
        //                 $this->redisConnectionBD->set('category_'.$categoryId, $articles);
        //             }

        //             # redis sg
        //             if($this->redisConnStatusSG == true){
        //                 $this->redisConnectionSG->del('category_'.$categoryId);
        //                 $this->redisConnectionSG->set('category_'.$categoryId, $articles);
        //             }

        //         }
        //     }
        // }
    }


    # redis regenerate latest 500 news
    public function redisRegenerateNewsList($newsId = Null){
        // if($this->redisConnStatus == true || $this->redisConnStatusBD == true || $this->redisConnStatusSG == true){

        //     $article = Articles::where('status', 1)->where('id', $newsId)->select('articles.*', 'articles.id as article_key_id')->first();
        //     $articles = Articles::where('articles.status', 1)->orderBy('articles.id', 'desc')->select('articles.*', 'articles.id as article_key_id')->limit(500)->get()->keyBy('article_key_id');

        //     # redis default
        //     if($this->redisConnStatus == true){
        //         $latestArticles = $this->redisConnection->get('latestNewsList');
        //         $latestNewsListArray = unserialize($latestArticles);
        //         if(!empty($latestNewsListArray) && !empty($newsId)){
        //             $latestNewsListArray[$newsId] = $article;
        //             $this->redisConnection->set('latestNewsList', serialize($latestNewsListArray));
        //         }else{
        //             $latestNewsListArray = $articles;
        //             $this->redisConnection->set('latestNewsList', serialize($latestNewsListArray));
        //         }
        //     }

        //     # redis bd
        //     if($this->redisConnStatusBD == true){
        //         $latestArticles = $this->redisConnectionBD->get('latestNewsList');
        //         $latestNewsListArray = unserialize($latestArticles);
        //         if(!empty($latestNewsListArray) && !empty($newsId)){
        //             $latestNewsListArray[$newsId] = $article;
        //             $this->redisConnectionBD->set('latestNewsList', serialize($latestNewsListArray));
        //         }else{
        //             $latestNewsListArray = $articles;
        //             $this->redisConnectionBD->set('latestNewsList', serialize($latestNewsListArray));
        //         }
        //     }

        //     #redis sg
        //     if($this->redisConnStatusSG == true){
        //         $latestArticles = $this->redisConnectionSG->get('latestNewsList');
        //         $latestNewsListArray = unserialize($latestArticles);
        //         if(!empty($latestNewsListArray) && !empty($newsId)){
        //             $latestNewsListArray[$newsId] = $article;
        //             $this->redisConnectionSG->set('latestNewsList', serialize($latestNewsListArray));
        //         }else{
        //             $latestNewsListArray = $articles;
        //             $this->redisConnectionSG->set('latestNewsList', serialize($latestNewsListArray));
        //         }
        //     }

            
        // }
    }

    # redis regenerate latest news
    public function redisRegenerateLatestNews($newsId){
        // if($this->redisConnStatus == true || $this->redisConnStatusBD == true || $this->redisConnStatusSG == true){

        //     $article = DB::table('articles')->where('articles.id', $newsId)->where('articles.status', 1)->leftjoin('categories', 'categories.id', '=', 'articles.category_id')
        //     ->select('articles.id', 'articles.id as article_key_id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.description', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'categories.title', 'categories.display_name', 'categories.icon')
        //     ->first();

        //     $latestArticles = Articles::where('articles.status', 1)->leftjoin('categories', 'categories.id', '=', 'articles.category_id')
        //     ->select('articles.id', 'articles.id as article_key_id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.description', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'categories.title', 'categories.display_name', 'categories.icon')
        //     ->orderBy('articles.created_at', 'desc')->limit(10)->get()->keyBy('article_key_id');

        //     # redis default
        //     if($this->redisConnStatus == true){
        //         $latestArticles = $this->redisConnection->get('latestArticles');
        //         $latestArticlesArray = unserialize($latestArticles);
        //         if(!empty($latestArticlesArray)){
        //             $latestArticlesArray[$newsId] = $article;
        //             $this->redisConnection->set('latestArticles', serialize($latestArticlesArray));
        //         }else{
        //             $this->redisConnection->set('latestArticles', serialize($latestArticles));
        //         }
        //     }

        //     # redis bd
        //     if($this->redisConnStatusBD == true){
        //         $latestArticles = $this->redisConnectionBD->get('latestArticles');
        //         $latestArticlesArray = unserialize($latestArticles);
        //         if(!empty($latestArticlesArray)){
        //             $latestArticlesArray[$newsId] = $article;
        //             $this->redisConnectionBD->set('latestArticles', serialize($latestArticlesArray));
        //         }else{
        //             $this->redisConnectionBD->set('latestArticles', serialize($latestArticles));
        //         }
        //     }

        //     # redis sg
        //     if($this->redisConnStatusSG == true){
        //         $latestArticles = $this->redisConnectionSG->get('latestArticles');
        //         $latestArticlesArray = unserialize($latestArticles);
        //         if(!empty($latestArticlesArray)){
        //             $latestArticlesArray[$newsId] = $article;
        //             $this->redisConnectionSG->set('latestArticles', serialize($latestArticlesArray));
        //         }else{
        //             $this->redisConnectionSG->set('latestArticles', serialize($latestArticles));
        //         }
        //     }

        // }
    }


    # redis regenerate category section news
    public function redisRegenerateCategorySectionNews($newCategories, $oldCategories){
        // if($this->redisConnStatus == true || $this->redisConnStatusBD == true || $this->redisConnStatusSG == true){
        //     $newCategories = explode('-', $newCategories);
        //     $oldCategories = explode('-', $oldCategories);
        //     $allCategories = array_merge($newCategories, $oldCategories);
        //     $allCategories = array_unique($allCategories);
        //     if(!empty($allCategories)){
        //         foreach ($allCategories as $key => $categoryId) {

        //             $articles = DB::table('articles')->where('articles.status', 1)
        //             ->leftjoin('article_categories', 'article_categories.article_id', '=', 'articles.id')->where('article_categories.category_id', $categoryId)
        //             ->leftjoin('categories', 'categories.id', '=', 'article_categories.category_id')
        //             ->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.description', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'article_categories.category_id', 'categories.display_name', 'categories.title', 'categories.icon')
        //             ->orderBy('articles.order_id', 'desc')->limit(20)->get();
        //             $articles = serialize($articles);

        //             # redis default
        //             if($this->redisConnStatus == true){
        //                 $this->redisConnection->del('category_'.$categoryId);
        //                 $this->redisConnection->set('category_'.$categoryId, $articles);
        //             }

        //             # redis bd
        //             if($this->redisConnStatusBD == true){
        //                 $this->redisConnectionBD->del('category_'.$categoryId);
        //                 $this->redisConnectionBD->set('category_'.$categoryId, $articles);
        //             }

        //             # redis sg
        //             if($this->redisConnStatusSG == true){
        //                 $this->redisConnectionSG->del('category_'.$categoryId);
        //                 $this->redisConnectionSG->set('category_'.$categoryId, $articles);
        //             }

        //         }
        //     }
        // }
    }


    # redis regenerate displayed news
    public function redisGenerateDisplayedNews(){
        // if($this->redisConnStatus == true || $this->redisConnStatusBD == true || $this->redisConnStatusSG == true){

        //     $leadArticles = DB::table('articles')->where('articles.status', 1)->where('articles.display_position', 'lead')->leftjoin('categories', 'categories.id', '=', 'articles.category_id')
        //     ->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.description', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'categories.title', 'categories.display_name', 'categories.icon')
        //     ->orderBy('articles.order_id', 'desc')->first();
        //     $leadArticles = serialize($leadArticles);

        //     $topArticles = DB::table('articles')->where('articles.status', 1)->where('articles.display_position', 'top')->leftjoin('categories', 'categories.id', '=', 'articles.category_id')
        //     ->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.description', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'categories.title', 'categories.display_name', 'categories.icon')
        //     ->orderBy('articles.order_id', 'desc')->limit(9)->get();
        //     $topArticles = serialize($topArticles);

        //     # redis default
        //     if($this->redisConnStatus == true){
        //         $this->redisConnection->del('leadArticle');
        //         $this->redisConnection->set('leadArticle', $leadArticles);
        //         $this->redisConnection->del('topArticles');
        //         $this->redisConnection->set('topArticles', $topArticles);
        //     }

        //     # redis bd
        //     if($this->redisConnStatusBD == true){
        //         $this->redisConnectionBD->del('leadArticle');
        //         $this->redisConnectionBD->set('leadArticle', $leadArticles);
        //         $this->redisConnectionBD->del('topArticles');
        //         $this->redisConnectionBD->set('topArticles', $topArticles);
        //     }

        //     # redis sg
        //     if($this->redisConnStatusSG == true){
        //         $this->redisConnectionSG->del('leadArticle');
        //         $this->redisConnectionSG->set('leadArticle', $leadArticles);
        //         $this->redisConnectionSG->del('topArticles');
        //         $this->redisConnectionSG->set('topArticles', $topArticles);
        //     }

        // }
    }


    # redis regenerate pollInfo cache
    public function redisRegeneratePollInfoCache(){
        // if($this->redisConnStatus == true || $this->redisConnStatusBD == true || $this->redisConnStatusSG == true){

        //     $pollInfo = DB::table('polls')->orderBy('order_id','desc')->first();
        //     $pollInfo = serialize($pollInfo);

        //     # redis default
        //     if($this->redisConnStatus == true){
        //         $this->redisConnection->del('pollInfo');
        //         $this->redisConnection->set('pollInfo', $pollInfo);
        //     }

        //             # redis bd
        //     if($this->redisConnStatusBD == true){
        //         $this->redisConnectionBD->del('pollInfo');
        //         $this->redisConnectionBD->set('pollInfo', $pollInfo);
        //     }

        //             # redis sg
        //     if($this->redisConnStatusSG == true){
        //         $this->redisConnectionSG->del('pollInfo');
        //         $this->redisConnectionSG->set('pollInfo', $pollInfo);
        //     }

        // }
    }


    # redis regenerate breakings
    public function redisRegenerateBreakings(){
        // if($this->redisConnStatus == true || $this->redisConnStatusBD == true || $this->redisConnStatusSG == true){

        //     $breakingArticles = DB::table('breakings')->where('breaking_time', '>=', date('Y-m-d H:i:s'))->where('status', 1)->where('type', 1)->orderBy('order_id', 'desc')->limit(10)->get();
        //     $breakingArticles = serialize($breakingArticles);

        //     # redis default
        //     if($this->redisConnStatus == true){
        //         $this->redisConnection->del('breakingArticles');
        //         $this->redisConnection->set('breakingArticles', $breakingArticles);
        //     }

        //             # redis bd
        //     if($this->redisConnStatusBD == true){
        //         $this->redisConnectionBD->del('breakingArticles');
        //         $this->redisConnectionBD->set('breakingArticles', $breakingArticles);
        //     }

        //             # redis sg
        //     if($this->redisConnStatusSG == true){
        //         $this->redisConnectionSG->del('breakingArticles');
        //         $this->redisConnectionSG->set('breakingArticles', $breakingArticles);
        //     }

        // }
    }


    # redis regenerate justnow
    public function redisRegenerateJustnow(){
        // if($this->redisConnStatus == true || $this->redisConnStatusBD == true || $this->redisConnStatusSG == true){

        //     $justnowArticles = DB::table('breakings')->where('breaking_time', '>=', date('Y-m-d H:i:s'))->where('status', 1)->where('type', 2)->orderBy('order_id', 'desc')->limit(10)->get();
        //     $justnowArticles = serialize($justnowArticles);

        //     # redis default
        //     if($this->redisConnStatus == true){
        //         $this->redisConnection->del('justnowArticles');
        //         $this->redisConnection->set('justnowArticles', $justnowArticles);
        //     }

        //             # redis bd
        //     if($this->redisConnStatusBD == true){
        //         $this->redisConnectionBD->del('justnowArticles');
        //         $this->redisConnectionBD->set('justnowArticles', $justnowArticles);
        //     }

        //             # redis sg
        //     if($this->redisConnStatusSG == true){
        //         $this->redisConnectionSG->del('justnowArticles');
        //         $this->redisConnectionSG->set('justnowArticles', $justnowArticles);
        //     }

        // }
    }


    # redis generate headercategories
    public function redisGenerateHeaderCategories(){
        // if($this->redisConnStatus == true || $this->redisConnStatusBD == true || $this->redisConnStatusSG == true){

        //     $headerCategories = Categories::where('header_display', 1)->where('status', 1)->orderBy('order_id', 'asc')->get();
        //     $headerCategories = serialize($headerCategories);

        //     # redis default
        //     if($this->redisConnStatus == true){
        //         $this->redisConnection->del('headerCategories');
        //         $this->redisConnection->set('headerCategories', $headerCategories);
        //     }

        //             # redis bd
        //     if($this->redisConnStatusBD == true){
        //         $this->redisConnectionBD->del('headerCategories');
        //         $this->redisConnectionBD->set('headerCategories', $headerCategories);
        //     }

        //             # redis sg
        //     if($this->redisConnStatusSG == true){
        //         $this->redisConnectionSG->del('headerCategories');
        //         $this->redisConnectionSG->set('headerCategories', $headerCategories);
        //     }

        // }
    }


    # redis generate menubarcategories
    public function redisGenerateMenubarCategories(){
        // if($this->redisConnStatus == true || $this->redisConnStatusBD == true || $this->redisConnStatusSG == true){

        //     $menubarCategories = Categories::where('status', 1)->where('menubar_display', 1)->orderBy('order_id', 'asc')->get();
        //     $menubarCategories = serialize($menubarCategories);

        //     # redis default
        //     if($this->redisConnStatus == true){
        //         $this->redisConnection->del('menubarCategories');
        //         $this->redisConnection->set('menubarCategories', $menubarCategories);
        //     }

        //             # redis bd
        //     if($this->redisConnStatusBD == true){
        //         $this->redisConnectionBD->del('menubarCategories');
        //         $this->redisConnectionBD->set('menubarCategories', $menubarCategories);
        //     }

        //             # redis sg
        //     if($this->redisConnStatusSG == true){
        //         $this->redisConnectionSG->del('menubarCategories');
        //         $this->redisConnectionSG->set('menubarCategories', $menubarCategories);
        //     }

        // }
    }


    # redis generate settings info
    public function redisGenerateSettingsInfo(){
        // if($this->redisConnStatus == true || $this->redisConnStatusBD == true || $this->redisConnStatusSG == true){

        //     $settingsInfo = DB::table('settings_general')->leftjoin('settings_meta', 'settings_meta.settings_id', '=', 'settings_general.id')->leftjoin('settings_social', 'settings_social.settings_id', '=', 'settings_general.id')->first();
        //     $settingsInfo = serialize($settingsInfo);

        //     # redis default
        //     if($this->redisConnStatus == true){
        //         $this->redisConnection->del('settingsInfo');
        //         $this->redisConnection->set('settingsInfo', $settingsInfo);
        //     }

        //             # redis bd
        //     if($this->redisConnStatusBD == true){
        //         $this->redisConnectionBD->del('settingsInfo');
        //         $this->redisConnectionBD->set('settingsInfo', $settingsInfo);
        //     }

        //             # redis sg
        //     if($this->redisConnStatusSG == true){
        //         $this->redisConnectionSG->del('settingsInfo');
        //         $this->redisConnectionSG->set('settingsInfo', $settingsInfo);
        //     }

        // }
    }


    # redis generate trending topics
    public function redisGenerateTrendingTopics(){
        // if($this->redisConnStatus == true || $this->redisConnStatusBD == true || $this->redisConnStatusSG == true){

        //     $trendingTopics = DB::table('trending_topics')->where('status', 1)->orderBy('order_id', 'desc')->get();
        //     $trendingTopics = serialize($trendingTopics);

        //     # redis default
        //     if($this->redisConnStatus == true){
        //         $this->redisConnection->del('trendingTopics');
        //         $this->redisConnection->set('trendingTopics', $trendingTopics);
        //     }

        //             # redis bd
        //     if($this->redisConnStatusBD == true){
        //         $this->redisConnectionBD->del('trendingTopics');
        //         $this->redisConnectionBD->set('trendingTopics', $trendingTopics);
        //     }

        //             # redis sg
        //     if($this->redisConnStatusSG == true){
        //         $this->redisConnectionSG->del('trendingTopics');
        //         $this->redisConnectionSG->set('trendingTopics', $trendingTopics);
        //     }

        // }
    }


    # redis generate event info
    public function redisGenerateEventInfo(){
        // if($this->redisConnStatus == true || $this->redisConnStatusBD == true || $this->redisConnStatusSG == true){

        //     $mainEventInfo1 = DB::table('events')->where('status', 1)->where('type', 1)->orderBy('id', 'desc')->first();
        //     $mainEventInfo2 = DB::table('events')->where('status', 1)->where('type', 2)->orderBy('id', 'desc')->first();
        //     $mainEventInfo3 = DB::table('events')->where('status', 1)->where('type', 3)->orderBy('id', 'desc')->first();
        //     $sideEventInfo = DB::table('events')->where('status', 1)->where('type', 4)->orderBy('id', 'desc')->first();
        //     $specialEventInfo = DB::table('events')->where('status', 1)->where('type', 5)->orderBy('id', 'desc')->first();

        //     # redis default
        //     if($this->redisConnStatus == true){
        //         $this->redisConnection->del('mainEventInfo1');
        //         $this->redisConnection->set('mainEventInfo1', serialize($mainEventInfo1));

        //         $this->redisConnection->del('mainEventInfo2');
        //         $this->redisConnection->set('mainEventInfo2', serialize($mainEventInfo2));

        //         $this->redisConnection->del('mainEventInfo3');
        //         $this->redisConnection->set('mainEventInfo3', serialize($mainEventInfo3));

        //         $this->redisConnection->del('sideEventInfo');
        //         $this->redisConnection->set('sideEventInfo', serialize($sideEventInfo));

        //         $this->redisConnection->del('specialEventInfo');
        //         $this->redisConnection->set('specialEventInfo', serialize($specialEventInfo));
        //     }

        //             # redis bd
        //     if($this->redisConnStatusBD == true){
        //         $this->redisConnectionBD->del('mainEventInfo1');
        //         $this->redisConnectionBD->set('mainEventInfo1', serialize($mainEventInfo1));

        //         $this->redisConnectionBD->del('mainEventInfo2');
        //         $this->redisConnectionBD->set('mainEventInfo2', serialize($mainEventInfo2));

        //         $this->redisConnectionBD->del('mainEventInfo3');
        //         $this->redisConnectionBD->set('mainEventInfo3', serialize($mainEventInfo3));

        //         $this->redisConnectionBD->del('sideEventInfo');
        //         $this->redisConnectionBD->set('sideEventInfo', serialize($sideEventInfo));

        //         $this->redisConnectionBD->del('specialEventInfo');
        //         $this->redisConnectionBD->set('specialEventInfo', serialize($specialEventInfo));
        //     }

        //             # redis sg
        //     if($this->redisConnStatusSG == true){
        //         $this->redisConnectionSG->del('mainEventInfo1');
        //         $this->redisConnectionSG->set('mainEventInfo1', serialize($mainEventInfo1));

        //         $this->redisConnectionSG->del('mainEventInfo2');
        //         $this->redisConnectionSG->set('mainEventInfo2', serialize($mainEventInfo2));

        //         $this->redisConnectionSG->del('mainEventInfo3');
        //         $this->redisConnectionSG->set('mainEventInfo3', serialize($mainEventInfo3));

        //         $this->redisConnectionSG->del('sideEventInfo');
        //         $this->redisConnectionSG->set('sideEventInfo', serialize($sideEventInfo));

        //         $this->redisConnectionSG->del('specialEventInfo');
        //         $this->redisConnectionSG->set('specialEventInfo', serialize($specialEventInfo));
        //     }

        // }
    }



    # redis flush cache
    public function redisFlush(){
        // if($this->redisConnStatus == true || $this->redisConnStatusBD == true || $this->redisConnStatusSG == true){

        //     # redis default
        //     if($this->redisConnStatus == true){
        //         $this->redisConnection->flushDB();
        //     }

        //     # redis bd
        //     if($this->redisConnStatusBD == true){
        //         $this->redisConnectionBD->flushDB();
        //     }

        //     # redis sg
        //     if($this->redisConnStatusSG == true){
        //         $this->redisConnectionSG->flushDB();
        //     }

        //     return 'Redis Cache Flushed';
        // }
    }


    # home page category section
    public function homePageCategoryCheck($category){
        // $homePageCategories = [5,6,10,11,8,14,55,301,32,12,27,18,323,324];
        // $result = array_search($category, $homePageCategories);
        // return $result;
    }


    public function clearServerUrlCache($url){
        return true;
    }

}
