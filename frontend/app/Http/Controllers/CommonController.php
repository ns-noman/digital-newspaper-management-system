<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;
use App\Models\Categories;
use App\Models\Articles;
use App\Models\ArticleCategories;
use App\Models\Polls;
use App\Models\LiveVideos;
use App\Models\Breakings;
use App\Models\Locations;
use App\Models\Events;
use App\Models\AdvertisementPlacements;
use App\Models\PopularNews;
use App\Models\CustomerSubscribed;
use DB;
use Auth;
use Response;

class CommonController extends Controller
{
	public function __construct()
	{
		# redis connection check
		// $this->redisConnStatus = false;
		// if($this->redisConnStatus == true){
		// 	try{
		// 		$redisConnection = Redis::connection();
		// 		$redisConnection->connect();
		// 		$this->redisConnStatus = true;
		// 	}catch(\Exception $e){
		// 		$this->redisConnStatus = false;
		// 	}
		// }
		# redis connection check end
		$this->redisConnStatus = false;
	}


	# lead news
	public function getLeadArticles($limit){
		$articles = DB::table('articles')->where('articles.status', 1)->where('articles.display_position', 'lead')->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy('articles.display_order_id', 'asc')->first();
		return $articles;
	}

	# featured lead news
	public function getFeaturedLeadArticles($limit){
		$articles = DB::table('articles')->where('articles.status', 1)->where('articles.display_position', 'flead')->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy('articles.order_id', 'desc')->first();
		return $articles;
	}
	
	# topic news
	public function getTopArticles($limit){
		$articles = DB::table('articles')->where('articles.status', 1)->where('articles.display_position', 'top')->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy('articles.display_order_id', 'asc')->limit($limit)->get();
		return $articles;
	}

	# selected news
	public function getSelectedArticles($selectedType, $limit){
		$articles = DB::table('articles')->where('articles.status', 1)
		->when($selectedType == 'selected', function ($query) {
			$query->where('articles.selected_status', 1);
		})
		->when($selectedType == 'selected2', function ($query) {
			$query->where('articles.selected2_status', 1);
		})
		->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy('articles.order_id', 'desc')->limit($limit)->get();
		return $articles;
	}

	# latest news
	public function getLatestArticles($limit){
		$latestArticles = Articles::where('articles.status', 1)->whereNull('articles.hide_latest')->where('articles.news_type', 1)->where('articles.category_id', '!=', 243)->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.id as article_key_id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy('articles.created_at', 'desc')->limit($limit)->get();
		return $latestArticles;
	}

	# popular news
	public function getPopularArticles($limit){
		return Null;
		$popularArticles = DB::table('popular_articles')->where('status', 1)->orderBy('order_id', 'desc')->limit($limit)->get();
		return $popularArticles;
		// $from = date('Y-m-d H:i:s', strtotime('-12 hour'));
		// $to = date('Y-m-d H:i:s');
		// $articles = DB::table('articles')->where('articles.status', 1)->where('articles.news_type', 1)->whereBetween('articles.created_at',array($from, $to))->select('articles.id', 'created_at')->get();

		// $highestHit = Null;
		// if (!empty($articles)) {
		// 	foreach ($articles as $key => $article) {
		// 		$newsHitFile = "uploads/newshit/".date('Y/m', strtotime($article->created_at))."/".$article->id.'.txt';
		// 		$content = \File::get($newsHitFile);
		// 		$highestHit[$article->id] = $content;
		// 	}
		// }

		// $highestHitNews = Null;
		// if (!empty($highestHit)) {
		// 	arsort($highestHit);
		// 	$count = array_count_values($highestHit);
		// 	$topTen = array_slice($highestHit, 0, $limit, true);
		// 	foreach ($topTen as $key => $news) {
		// 		$highestHitNews[] = DB::table('articles')->where('articles.status', 1)->where('articles.news_type', 1)->where('articles.id', $key)->leftjoin('categories', 'categories.id', '=', 'articles.category_id')
		// 		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon')->first();
		// 	}
		// }
		// return $highestHitNews;
	}

	# section wise category news
	public function getCategoryArticlesBySection($categoryId, $limit){
		if($this->redisConnStatus == true){
			$categoryArticles = Redis::get('category_'.$categoryId);
			if(!empty($categoryArticles)){
				$articles = unserialize($categoryArticles);
			}else{
				$articles = DB::table('articles')->where('articles.status', 1)
				->leftjoin('article_categories', 'article_categories.article_id', '=', 'articles.id')->where('article_categories.category_id', $categoryId)
				->leftjoin('categories', 'categories.id', '=', 'article_categories.category_id')
				->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
				->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'article_categories.category_id', 'categories.display_name', 'categories.title', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
				->orderBy('articles.order_id', 'desc')->limit(20)->get();
				Redis::set('category_'.$categoryId, serialize($articles));
			}
		}else{
			$articles = DB::table('article_categories')->where('article_categories.category_id', 'like', $categoryId)
			->leftjoin('articles', 'articles.id', '=', 'article_categories.article_id')->where('articles.status', 1)
			->leftjoin('categories', 'categories.id', '=', 'article_categories.category_id')
			->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
			->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'article_categories.category_id', 'categories.display_name', 'categories.title', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
			->orderBy('articles.order_id', 'desc')->limit($limit)->get();
		}

		return $articles;
	}


	public function getCategoryArticlesHome($categoryId, $limit){
		$articles = DB::table('article_categories')->where('article_categories.category_id', 'like', $categoryId)->where('article_categories.home_section_display', 1)
		->leftjoin('articles', 'articles.id', '=', 'article_categories.article_id')->where('articles.status', 1)->whereNull('articles.display_position')
		->leftjoin('categories', 'categories.id', '=', 'article_categories.category_id')
		->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'article_categories.category_id', 'categories.display_name', 'categories.title', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy('articles.order_id', 'desc')->limit($limit)->get();
		return $articles;
	}


	// public function getCategoryArticlesBySection($categoryId, $limit){
	// 	$articles = DB::table('article_categories')->where('article_categories.category_id', 'like', $categoryId)
	// 		->leftjoin('articles', 'articles.id', '=', 'article_categories.article_id')->where('articles.status', 1)
	// 		->leftjoin('categories', 'categories.id', '=', 'article_categories.category_id')
	// 		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'article_categories.category_id', 'categories.display_name', 'categories.title', 'categories.icon')
	// 		->orderBy('articles.order_id', 'desc')->limit($limit)->get();
	// 	return $articles;
	// }

	# category page news
	public function getCategoryArticlesPage($categoryId, $limit){
		$articles = DB::table('articles')->where('articles.status', 1)
		->when(isset($_GET['date']) && !empty($_GET['date']), function ($query) {
			$query->whereDate('articles.created_at', $_GET['date']);
		})
		->leftjoin('article_categories', 'article_categories.article_id', '=', 'articles.id')->where('article_categories.category_id', $categoryId)
		->leftjoin('categories', 'categories.id', '=', 'article_categories.category_id')
		->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'article_categories.category_id', 'categories.display_name', 'categories.title', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy('articles.order_id', 'desc')->limit($limit)->get();
		return $articles;
	}

	# category news full table data
	public function getCategoryArticlesAllColumn($categoryId, $limit){
		$articles = Articles::where('articles.status', 1)->where('articles.home_status', 1)
		->leftjoin('article_categories', 'article_categories.article_id', '=', 'articles.id')->where('article_categories.category_id', $categoryId)
		->leftjoin('categories', 'categories.id', '=', 'article_categories.category_id')
		->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->orderBy('articles.order_id', 'desc')->select('articles.*', 'article_categories.category_id', 'categories.display_name', 'categories.title', 'categories.icon', 'urlCategory.title as urlCategoryTitle')->limit($limit)->get();
		return $articles;
	}

	# event news by news tag
	public function getEventArticlesByTag($eventTag, $limit){
		$tags = explode(',', $eventTag);
		$articles = DB::table('articles')->where('articles.status', 1)
		->where(function ($q) use ($tags) {
			foreach ($tags as $tag) {
				$q->orWhere("articles.tags", "like", '%'.trim($tag).'%');
			}
		})->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy(DB::raw('FIELD('.'articles.event_display_position, "eventLead")') , 'desc')->orderBy('articles.order_id', 'desc')->limit($limit)->get();
		return $articles;
	}

	# event news by news topic
	public function getEventArticlesByTopic($topic_id, $limit){
		$articles = DB::table('articles')->where('articles.status', 1)
		->leftjoin('article_topics', 'article_topics.article_id', '=', 'articles.id')->where('article_topics.topic_id', $topic_id)
		->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy(DB::raw('FIELD('.'articles.event_display_position, "eventLead")') , 'desc')->orderBy('articles.order_id', 'desc')->limit($limit)->get();
		return $articles;
	}

	# news tag news
	public function getTagArticles($articleTags, $articleId, $limit){
		$tags = explode(',', $articleTags);
		$articles = DB::table('articles')->where('articles.id', '!=', $articleId)->where('articles.status', 1)
		->where(function ($q) use ($tags) {
			foreach ($tags as $tag) {
				$q->orWhere("articles.tags", "like", "%".trim($tag)."%");
			}
		})->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy('articles.id', 'desc')->limit($limit)->get();
		return $articles;
	}

	# news topic news
	public function getTopicArticles($topicIds, $articleId, $limit){
		$topics = explode(',', $topicIds);
		$articles = DB::table('article_topics')->whereIn('article_topics.topic_id', $topics)
		->leftjoin('articles', 'articles.id', '=', 'article_topics.article_id')
		->where('articles.id', '!=', $articleId)->where('articles.status', 1)
		->leftjoin('categories', 'categories.id', '=', 'articles.category_id')
		->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy('articles.id', 'desc')->limit($limit)->get();
		return $articles;
	}

	# archive search news
	public function getArchiveArticles($limit){
		$articles =  DB::table('articles')->where('articles.status', 1)
		->when(isset($_GET['headline']) && !empty($_GET['headline']), function ($query) {
			$query->where('articles.headline', 'articles.headline_color', 'like', '%'.$_GET['headline'].'%');
		})
		->when(isset($_GET['headline']) && !empty($_GET['headline']), function ($query) {
			$query->orWhere('articles.reporter', 'like', '%'.$_GET['headline'].'%');
		})
		->when(isset($_GET['headline']) && !empty($_GET['headline']), function ($query) {
			$tags[] = $_GET['headline'];
			foreach ($tags as $tag) {
				$query->orWhere('articles.tags', "like", '%'.trim($tag)."%");
			}
		})
		->when(isset($_GET['date']) && !empty($_GET['date']), function ($query) {
			$query->whereDate('articles.created_at', $_GET['date']);
		})
		->when(isset($_GET['category']) && !empty($_GET['category']), function ($query) {
			$query->leftjoin('article_categories', 'article_categories.article_id', '=', 'articles.id')->where('article_categories.category_id', $_GET['category']);
		})->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy('articles.id', 'desc')->simplePaginate($limit);
		return $articles;
	}

	# print archive news
	public function printArchiveArticles(){
		$articles =  DB::table('articles')->where('articles.status', 1)
		->when(isset($_GET['date']) && !empty($_GET['date']), function ($query) {
			$query->whereDate('articles.created_at', $_GET['date']);
		})
		->when(empty($_GET['date']), function ($query) {
			$query->whereDate('articles.created_at', date('Y-m-d'));
		})
		->when(isset($_GET['category']) && !empty($_GET['category']), function ($query) {
			$query->leftjoin('article_categories', 'article_categories.article_id', '=', 'articles.id')->where('article_categories.category_id', $_GET['category']);
		})->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy('articles.id', 'desc')->get();
		return $articles;
	}

	# author news
	public function getAuthorArticles($authorId, $limit){
		$articles = DB::table('article_authors')->where('article_authors.author_id', $authorId)
		->leftjoin('articles', 'articles.id', '=', 'article_authors.article_id')->where('articles.status', 1)->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy('articles.id', 'desc')->limit($limit)->get();
		return $articles;
	}

	# subscribed news
	public function getSubscribedArticles($customerId, $limit){
		$articles = CustomerSubscribed::where('customer_subscribed_news.customer_id', $customerId)
		->leftjoin('articles', 'articles.id', '=', 'customer_subscribed_news.article_id')->where('articles.status', 1)->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy('articles.id', 'desc')->simplePaginate($limit);
		return $articles;
	}

	# location news
	public function getLocationArticles($locationInfo, $limit){
		$articles = DB::table('articles')->where('articles.status', 1)->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->when(!empty($locationInfo) && ($locationInfo->type == 'division'), function ($query) use ($locationInfo) {
			$query->where('articles.division', $locationInfo->id);
		})
		->when(!empty($locationInfo) && ($locationInfo->type == 'district'), function ($query) use ($locationInfo) {
			$query->where('articles.district', $locationInfo->id);
		})
		->when(!empty($locationInfo) && ($locationInfo->type == 'upazila'), function ($query) use ($locationInfo) {
			$query->where('articles.upazila', $locationInfo->id);
		})
		->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->orderBy('articles.order_id', 'desc')->limit($limit)->get();
		return $articles;
	}

	# breaking news
	public function getBreakingArticles($limit = Null){
		$limit = $limit ? $limit : 10;
		if($this->redisConnStatus == true){
			$breakingArticles = Redis::get('breakingArticles');
		}

		if(!empty($breakingArticles)){
			$breakingArticles = unserialize($breakingArticles);
		}else{
			$breakingArticles = DB::table('breakings')->where('breaking_time', '>=', date('Y-m-d H:i:s'))->where('status', 1)->where('type', 1)->orderBy('order_id', 'desc')->limit($limit)->get();

			if($this->redisConnStatus == true){
				Redis::set('breakingArticles', serialize($breakingArticles));
			}
		}
		return $breakingArticles;
	}

	# justnow news
	public function getJustnowArticles($limit = Null){
		$limit = $limit ? $limit : 10;

		if($this->redisConnStatus == true){
			$justnowArticles = Redis::get('justnowArticles');
		}

		if(!empty($justnowArticles)){
			$justnowArticles = unserialize($justnowArticles);
		}else{
			$justnowArticles = DB::table('breakings')->where('breaking_time', '>=', date('Y-m-d H:i:s'))->where('status', 1)->where('type', 2)->orderBy('order_id', 'desc')->limit($limit)->get();

			if($this->redisConnStatus == true){
				Redis::set('justnowArticles', serialize($justnowArticles));
			}
		}
		return $justnowArticles;
	}

	# breaking news
	public function getAdvertisementPlacements($limit = Null){
		if($this->redisConnStatus == true){
			$advPlacements = Redis::get('advPlacements');
		}

		if(!empty($advPlacements)){
			$placements = unserialize($advPlacements);
		}else{
			$placements = AdvertisementPlacements::where('status', 1)->orderBy('order_id', 'desc')->get()->keyBy('id');

			if($this->redisConnStatus == true){
				Redis::set('advPlacements', serialize($placements));
			}
		}
		return $placements;
	}


	# get sitemap news
	public function getSitemapArticles($limit = 200, $dateFrom = Null, $dateTo = Null, $categoryId = Null, $customXml = Null){
		$sitemapArticles = Articles::where('articles.status', 1)->whereNull('articles.exclude_xml')->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
		->select('articles.id', 'articles.id as article_key_id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.keywords', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
		->when(!empty($categoryId), function ($query) use ($categoryId) {
			$query->leftjoin('article_categories', 'article_categories.article_id', '=', 'articles.id')->where('article_categories.category_id', $categoryId);
		})
		->when(!empty($dateFrom) && !empty($dateTo), function ($query) use ($dateFrom, $dateTo) {
			$query->where('articles.created_at', '>=', $dateFrom);
			$query->where('articles.created_at', '<=', $dateTo);
		})
		->when(!empty($dateFrom) && empty($dateTo), function ($query) use ($dateFrom) {
			$query->whereDate('articles.created_at', $dateFrom);
		})
		->when(!empty($customXml), function ($query) {
			$query->whereNotNull('articles.custom_xml');
		})
		->orderBy('articles.id', 'desc')
		->when(empty($dateFrom), function ($query) use ($limit){
			$query->limit($limit);
		})
		->get();

		return $sitemapArticles;
	}


	# ajax selected news
	public function ajaxSelectedArticles($limit, $paginate, $summary, $headlineCount = 100){
		if($limit <= 30){
			$articles = DB::table('articles')->where('articles.status', 1)->where('articles.selected_status', 1)
			->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
			->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
			->orderBy('articles.order_id', 'desc')->skip($limit*$paginate)->limit($limit)->get();
		}

		$processedArticles = Null;
		if(!empty($articles) && (count($articles)>0)){
			foreach ($articles as $key => $list) {
				$processedArticles[] = \App\Models\Helper::processArticleShortly($list, $summary, $headlineCount);
			}
		}
		return !empty($processedArticles) ? Response::json($processedArticles) : Null;
	}

	# ajax latest news
	public function ajaxLatestArticles($limit, $paginate, $summary, $headlineCount = 100){
		if($limit <= 30){
			$articles = DB::table('articles')->whereNull('articles.hide_latest')->where('articles.status', 1)->where('articles.news_type', 1)->where('articles.category_id', '!=', 243)
			->when(isset($_GET['lastID']) && !empty($_GET['lastID']), function ($query) {
				$query->where('articles.id', '<=', $_GET['lastID']);
			})
			->leftjoin('categories', 'categories.id', '=', 'articles.category_id')
			->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
			->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
			->orderBy('articles.created_at', 'desc')->skip($limit*$paginate)->limit($limit)->get();
		}

		$processedArticles = Null;
		if(!empty($articles) && (count($articles)>0)){
			foreach ($articles as $key => $list) {
				$processedArticles[] = \App\Models\Helper::processArticleShortly($list, $summary, $headlineCount);
			}
		}
		return !empty($processedArticles) ? Response::json($processedArticles) : Null;
	}
	
	# ajax api latest news
	public function ajaxApiLatestArticles($limit, $paginate, $summary, $headlineCount = 100){
		if($limit <= 30){
			$articles = DB::table('articles')->whereNull('articles.hide_latest')->where('articles.status', 1)->where('articles.news_type', 1)->where('articles.category_id', '!=', 243)
			->when(isset($_GET['lastID']) && !empty($_GET['lastID']), function ($query) {
				$query->where('articles.id', '<=', $_GET['lastID']);
			})
			->leftjoin('categories', 'categories.id', '=', 'articles.category_id')
			->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
			->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
			->orderBy('articles.created_at', 'desc')->skip($limit*$paginate)->limit($limit)->get();
		}

		$processedArticles = Null;
		if(!empty($articles) && (count($articles)>0)){
			foreach ($articles as $key => $list) {
				$processedArticles[] = \App\Models\Helper::processArticleShortly($list, $summary, $headlineCount);
			}
		}

		return Response::json($processedArticles)->header('Access-Control-Allow-Origin', '*')->header('Access-Control-Allow-Credentials', 'true')->header('Access-Control-Allow-Methods', 'GET')->header('Access-Control-Allow-Headers', 'DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type');
	}

	# ajax latest photos
	public function ajaxLatestPhotos($limit, $paginate){
		if($limit <= 30){
			$latestPhotos = DB::table('article_photos')->where('article_photos.status', 1)->leftjoin('articles', 'articles.id', '=', 'article_photos.article_id')->select('article_photos.id', 'article_photos.article_id', 'article_photos.image', 'article_photos.image_caption', 'articles.created_at')->orderBy('articles.order_id', 'desc')->skip($limit*$paginate)->limit($limit)->get();
		}

		$processedArticles = Null;
		if(!empty($latestPhotos) && (count($latestPhotos)>0)){
			foreach ($latestPhotos as $key => $list) {
				$processedArticles[] = \App\Models\Helper::processPhotos($list);
			}
		}
		return !empty($processedArticles) ? Response::json($processedArticles) : Null;
	}

	# ajax latest videos
	public function ajaxLatestVideos($limit, $paginate){
		if($limit <= 30){
			$articles = DB::table('articles')->where('articles.status', 1)->whereNotNull('articles.video_code')
			->leftjoin('categories', 'categories.id', '=', 'articles.category_id')
			->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
			->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
			->orderBy('articles.created_at', 'desc')->skip($limit*$paginate)->limit($limit)->get();
		}

		$processedArticles = Null;
		if(!empty($articles) && (count($articles)>0)){
			foreach ($articles as $key => $list) {
				$processedArticles[] = \App\Models\Helper::processArticleShortly($list);
			}
		}
		return !empty($processedArticles) ? Response::json($processedArticles) : Null;
	}

	# ajax popular news
	public function ajaxPopularArticles($limit, $summary){
		if($limit <= 30){
			$popularArticles = DB::table('popular_articles')->where('status', 1)->orderBy('order_id', 'desc')->limit($limit)->get();
			return !empty($popularArticles) ? Response::json($popularArticles) : Null;
		}
		return Null;
	}

	# ajax category news
	public function ajaxCategoryArticles($categoryId, $limit, $paginate, $summary, $articleId = Null){
		if($limit <= 30){
			$articles = DB::table('articles')->where('articles.status', 1)->where('articles.id', '!=', $articleId)
			->when(isset($_GET['date']) && !empty($_GET['date']), function ($query) {
				$query->whereDate('articles.created_at', $_GET['date']);
			})
			->when(isset($_GET['lastID']) && !empty($_GET['lastID']), function ($query) {
				$query->where('articles.id', '<=', $_GET['lastID']);
			})
			->leftjoin('article_categories', 'article_categories.article_id', '=', 'articles.id')->where('article_categories.category_id', $categoryId)
			->leftjoin('categories', 'categories.id', '=', 'article_categories.category_id')
			->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
			->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'article_categories.category_id', 'categories.display_name', 'categories.title', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
			->orderBy('articles.order_id', 'desc')->skip($limit*$paginate)->limit($limit)->get();
		}

		$processedArticles = Null;
		if(!empty($articles) && (count($articles)>0)){
			foreach ($articles as $key => $list) {
				$processedArticles[] = \App\Models\Helper::processArticleShortly($list, $summary);
			}
		}
		return !empty($processedArticles) ? Response::json($processedArticles) : Null;
	}

	# ajax tag news
	public function ajaxTagArticles($articleTags, $articleId, $limit, $paginate, $summary){
		if($limit <= 20){
			$tags = explode(',', $articleTags);
			$articles = DB::table('articles')->where('articles.id', '!=', $articleId)->where('articles.status', 1)
			->where(function ($q) use ($tags) {
				foreach ($tags as $tag) {
					$q->orWhere("articles.tags", "like", "%".trim($tag)."%");
				}
			})->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
			->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
			->orderBy('articles.id', 'desc')->skip($limit*$paginate)->limit($limit)->get();
		}
		
		$processedArticles = Null;
		if(!empty($articles) && (count($articles)>0)){
			foreach ($articles as $key => $list) {
				$processedArticles[] = \App\Models\Helper::processArticleShortly($list, $summary);
			}
		}
		return !empty($processedArticles) ? Response::json($processedArticles) : Null;
	}

	# ajax topic news
	public function ajaxTopicArticles($topicIds, $articleId, $limit, $paginate, $summary){
		if($limit <= 20){
			$topics = explode(',', $topicIds);
			$articles = DB::table('article_topics')->whereIn('article_topics.topic_id', $topics)
			->leftjoin('articles', 'articles.id', '=', 'article_topics.article_id')
			->where('articles.id', '!=', $articleId)->where('articles.status', 1)
			->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
			->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
			->orderBy('articles.id', 'desc')->distinct('id')->skip($limit*$paginate)->limit($limit)->get();
		}
		
		$processedArticles = Null;
		if(!empty($articles) && (count($articles)>0)){
			foreach ($articles as $key => $list) {
				$processedArticles[] = \App\Models\Helper::processArticleShortly($list, $summary);
			}
		}
		return !empty($processedArticles) ? Response::json($processedArticles) : Null;
	}


	# ajax timeline news
	public function ajaxTimelineArticles($incidentId, $limit, $paginate, $summary){
		if($limit <= 30){
			$articles = DB::table('articles')->where('articles.status', 1)->where('articles.incident_id', $incidentId)
			->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
			->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
			->orderBy('articles.created_at', 'desc')->skip($limit*$paginate)->limit($limit)->get();
		}

		$processedArticles = Null;
		if(!empty($articles) && (count($articles)>0)){
			foreach ($articles as $key => $list) {
				$processedArticles[] = \App\Models\Helper::processArticleShortly($list, $summary);
			}
		}
		return !empty($processedArticles) ? Response::json($processedArticles) : Null;
	}

	# ajax event news
	public function ajaxEventArticles($eventId, $limit, $paginate, $summary){
		$eventInfo = DB::table('events')->where('id', $eventId)->where('status', '!=', 2)->orderBy('id', 'desc')->first();
		if(!empty($eventInfo)){
			if($limit <= 30){
				$articles = DB::table('articles')->where('articles.status', 1)->where("articles.tags", "like", "%".trim($eventInfo->tag)."%")
				->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
				->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
				->orderBy('articles.order_id', 'desc')->skip($limit*$paginate)->limit($limit)->get();
			}

			$processedArticles = Null;
			if(!empty($articles) && (count($articles)>0)){
				foreach ($articles as $key => $list) {
					$processedArticles[] = \App\Models\Helper::processArticleShortly($list, $summary);
				}
			}
			return !empty($processedArticles) ? Response::json($processedArticles) : Null;
		}
	}

	# ajax author news
	public function ajaxAuthorArticles($authorId, $limit, $paginate, $summary){
		if($limit <= 30){
			$articles = DB::table('article_authors')->where('article_authors.author_id', $authorId)
			->leftjoin('articles', 'articles.id', '=', 'article_authors.article_id')->where('articles.status', 1)
			->leftjoin('categories', 'categories.id', '=', 'articles.category_id')
			->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
			->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
			->orderBy('articles.id', 'desc')->skip($limit*$paginate)->limit($limit)->get();
		}

		$processedArticles = Null;
		if(!empty($articles) && (count($articles)>0)){
			foreach ($articles as $key => $list) {
				$processedArticles[] = \App\Models\Helper::processArticleShortly($list, $summary);
			}
		}
		return !empty($processedArticles) ? Response::json($processedArticles) : Null;
	}


	# ajax location news
	public function ajaxLocationArticles($locationId, $locationType, $limit, $paginate, $summary){
		if($limit <= 30){
			$articles = DB::table('articles')->where('articles.status', 1)->leftjoin('categories', 'categories.id', '=', 'articles.category_id')->leftjoin('categories as urlCategory', 'urlCategory.id', '=', 'articles.category_id')
			->when(!empty($locationType) && ($locationType == 'division'), function ($query) use ($locationId) {
				$query->where('articles.division', $locationId);
			})
			->when(!empty($locationType) && ($locationType == 'district'), function ($query) use ($locationId) {
				$query->where('articles.district', $locationId);
			})
			->when(!empty($locationType) && ($locationType == 'upazila'), function ($query) use ($locationId) {
				$query->where('articles.upazila', $locationId);
			})
			->select('articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.headline_color', 'articles.display_position', 'articles.reporter', 'articles.video_code', 'articles.excerpt', 'articles.news_type', 'articles.created_at', 'articles.updated_at', 'articles.thumbnail', 'articles.liveupdate_status', 'articles.thumbnail2', 'categories.title', 'categories.display_name', 'categories.icon', 'urlCategory.title as urlCategoryTitle')
			->orderBy('articles.order_id', 'desc')->skip($limit*$paginate)->limit($limit)->get();
		}

		$processedArticles = Null;
		if(!empty($articles) && (count($articles)>0)){
			foreach ($articles as $key => $list) {
				$processedArticles[] = \App\Models\Helper::processArticleShortly($list, $summary);
			}
		}
		return !empty($processedArticles) ? Response::json($processedArticles) : Null;
	}

	# ajax polls
	public function ajaxPolls($limit, $paginate){
		if($limit <= 20){
			$polls = DB::table('polls')->orderBy('poll_date', 'desc')->skip($limit*$paginate)->limit($limit)->get();
		}

		$processedPolls = Null;
		if(!empty($polls) && (count($polls)>0)){
			foreach ($polls as $key => $poll) {
				$processedPolls[] = \App\Models\Helper::processPoll($poll);
			}
		}
		return !empty($processedPolls) ? Response::json($processedPolls) : Null;
	}

	# ajax menubar categories
	public function ajaxMenubarCategories(){
		if($this->redisConnStatus == true){
			$menubarCategories = Redis::get('menubarCategories');
		}

		if(!empty($menubarCategories)){
			$categories = unserialize($menubarCategories);
		}else{
			$categories = Categories::where('status', 1)->where('menubar_display', 1)->orderBy('order_id', 'asc')->get();

			if($this->redisConnStatus == true){
				Redis::set('menubarCategories', serialize($categories));
			}
		}

		return Response::json($categories);
	}

	# poll info
	public function getPollInfo(){
		if($this->redisConnStatus == true){
			$pollInfo = Redis::get('pollInfo');
		}

		if(!empty($pollInfo)){
			$pollInfo = unserialize($pollInfo);
		}else{
			$pollInfo = DB::table('polls')->orderBy('order_id','desc')->where('status', 1)->first();

			if($this->redisConnStatus == true){
				Redis::set('pollInfo', serialize($pollInfo));
			}
		}
		return $pollInfo;
	}

	# trending topics
	public function getTrendingTopics(){
		if($this->redisConnStatus == true){
			$trendingTopics = Redis::get('trendingTopics');
		}

		if(!empty($trendingTopics)){
			$trendingTopics = unserialize($trendingTopics);
		}else{
			$trendingTopics = DB::table('trending_topics')->where('status', 1)->orderBy('order_id', 'desc')->get();

			if($this->redisConnStatus == true){
				Redis::set('trendingTopics', serialize($trendingTopics));
			}
		}
		return $trendingTopics;
	}

	# event info
	public function getEventInfo($eventType){
		$eventTypeName = $eventType == 1 ? 'mainEventInfo1' : ($eventType == 2 ? 'mainEventInfo2' : ($eventType == 3 ? 'mainEventInfo3' : ($eventType == 4 ? 'sideEventInfo' : ($eventType == 5 ? 'specialEventInfo' : Null))));

		if($this->redisConnStatus == true){
			$eventInfo = Redis::get($eventTypeName);
		}

		if(!empty($eventInfo)){
			$eventInfo = unserialize($eventInfo);
		}else{
			$eventInfo = DB::table('events')->where('status', 1)->where('type', $eventType)->orderBy('id', 'desc')->first();

			if($this->redisConnStatus == true){
				Redis::set($eventTypeName, serialize($eventInfo));
			}
		}
		return $eventInfo;
	}

	# category info by title
	public function getCategoryInfoByTitle($title){
		$categoryInfo = Categories::where('title', $title)->where('status', 1)->first();
		return $categoryInfo;
	}

	# category info
	public function getCategoryInfo($id){
		$categoryInfo = Categories::where('id', $id)->where('status', 1)->first();
		return $categoryInfo;
	}

	# sub categories by category
	public function getSubCategories($categoryID){
		$subCategories = DB::table('categories')->where('parent', $categoryID)->where('status', 1)->orderBy('order_id', 'asc')->get();
		return $subCategories;
	}

	# divisions
	public function getDivisions(){
		if($this->redisConnStatus == true){
			$divisions = Redis::get('divisions');
		}

		if(!empty($divisions)){
			$divisions = unserialize($divisions);
		}else{
			$divisions = DB::table('locations')->where('type', 'division')->where('status', 1)->orderBy('title', 'asc')->get();

			if($this->redisConnStatus == true){
				Redis::set('divisions', serialize($divisions));
			}
		}
		return $divisions;
	}

	# get districts
	public function getDistricts($division){
		$districts = DB::table('locations')->where('type', 'district')->where('division', $division)->where('status', 1)->orderBy('title', 'asc')->get();
		return $districts;
	}

	# get upazilas
	public function getUpazilas($district){
		$upazilas = DB::table('locations')->where('type', 'upazila')->where('district', $district)->where('status', 1)->orderBy('title', 'asc')->get();
		return $upazilas;
	}

	# districts by division
	public function ajaxGetDistricts($division){
		$districts = DB::table('locations')->where('type', 'district')->where('division', $division)->where('status', 1)->orderBy('title', 'asc')->get();
		return $districts;
	}

	# upazilas by districts
	public function ajaxGetUpazilas($district){
		$upazilas = DB::table('locations')->where('type', 'upazila')->where('district', $district)->where('status', 1)->orderBy('title', 'asc')->get();
		return $upazilas;
	}

	# header categories
	public function getHeaderCategories(){
		if($this->redisConnStatus == true){
			$headerCategories = Redis::get('headerCategories');
		}

		if(!empty($headerCategories)){
			$categories = unserialize($headerCategories);
		}else{
			$categories = Categories::where('header_display', 1)->where('status', 1)->orderBy('order_id', 'asc')->get();

			if($this->redisConnStatus == true){
				Redis::set('headerCategories', serialize($categories));
			}
		}
		return $categories;
	}

	# settings info
	public function settingsInfo(){
		if($this->redisConnStatus == true){
			$settingsInfoRedis = Redis::get('settingsInfo');
		}

		if(!empty($settingsInfoRedis)){
			$settingsInfo = unserialize($settingsInfoRedis);
		}else{
			$settingsInfo = DB::table('settings_general')->leftjoin('settings_meta', 'settings_meta.settings_id', '=', 'settings_general.id')->leftjoin('settings_social', 'settings_social.settings_id', '=', 'settings_general.id')->first();

			if($this->redisConnStatus == true){
				Redis::set('settingsInfo', serialize($settingsInfo));
			}
		}
		return $settingsInfo;
	}

	# settings page info
	public function settingsPageInfo(){
		$settingsPageInfo = DB::table('settings_pages')->where('slug', \Request::path())->where('status', 1)->first();
		if(!empty($settingsPageInfo)){
			$settingsPageInfo = \App\Models\Helper::processPageInfo($settingsPageInfo);
		}
		return $settingsPageInfo;
	}
	
	# news time difference
	public static function getTimeDifference($time)
	{
		$diff = strtotime(date('Y-m-d H:i:s')) - strtotime($time); 
		$hours = $diff / 3600; 

		if(($hours<24) && ($hours>=1))
		{ 
			$hours = round($hours);
			$time = \App\Http\Controllers\CommonController::GetBangla($hours)." ঘণ্টা আগে"; 
		}
		else if(($hours<1) && ($hours>0)) 
		{ 
			$minutes = round($diff / 60); 
			$time = \App\Http\Controllers\CommonController::GetBangla($minutes)." মিনিট আগে"; 
		} 
		else
		{ 
			$time = \App\Http\Controllers\CommonController::GetBangla(date('d M Y H:i A', strtotime($time))); 
		}

		return $time;
	}

	# english to bangla
	public static function GetBangla($text){
		$search_array= array("Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", ":", ",", "PM", "AM");
		$replace_array= array("শনিবার", "রোববার", "সোমবার", "মঙ্গলবার", "বুধবার", "বৃহস্পতিবার", "শুক্রবার", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "জানুয়ারি", "ফেব্রুয়ারি", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", ":", ",", "পিএম", "এএম");
		$text = str_replace($search_array, $replace_array,$text);
		return $text;
	}

	# check category pattern
	public function checkCategory($categoryTitle){
		$strCount = strlen($categoryTitle);
		return $strCount > 60 ? abort(404) : true;
	}


	public function ajaxStoreNewsView($createDate, $articleId){
		$newsHitFile = "uploads/news_hit/".date('Y/m/d', strtotime($createDate))."/".$articleId.'.txt';
		$content = \File::get($newsHitFile);
		$hit = $content+1;
		\File::put($newsHitFile, $hit);
		return $hit;
	}


}
