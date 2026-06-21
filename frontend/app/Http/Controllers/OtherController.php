<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;
use App\Models\Categories;
use App\Models\Articles;
use App\Models\ArticleCategories;
use App\Models\Polls;
use App\Models\Authors;
use App\Models\Departments;
use App\Models\Events;
use App\Models\LiveVideos;
use App\Models\CityElection;
use App\Models\ArchivedTopics;
use App\Models\ImportantLinkCategories;
use App\Models\ImportantLinks;
use DB;
use Auth;

class OtherController extends Controller
{
	public function __construct()
	{
		# redis connection check
		// $this->redisConnStatus = env('REDIS_STATUS');
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


	# privacy page
	public function privacy(){
		return view('other-pages.privacy');
	}

	# terms page
	public function terms(){
		return view('other-pages.terms');
	}

	# advertisement page
	public function advertisement(){
		return view('other-pages.advertisement');
	}

	# contact page
	public function contact(){
		return view('other-pages.contact');
	}

	# about page
	public function about(){
		return view('other-pages.about');
	}

	# team page
	public function team(){
		$data['departments'] = Departments::where('status', 1)->orderBy('order_id', 'desc')->get();
		return view('other-pages.team', $data);
	}

	# error page
	public function error(){
		abort(404);
	}

	# team page
	public function links($slug){
		try{
			$data['linkCategory'] = ImportantLinkCategories::where('status', 1)->where('slug', $slug)->first();
			if(!empty($data['linkCategory'])){
				return view('other-pages.links', $data);
			}
		}catch(\Exception $e){
			return abort(404);
		}
	}

	# converter page
	public function unicodeConverter(){
		$data['links'] = ImportantLinkCategories::where('status', 1)->where('menubar', 1)->orderBy('order_id', 'desc')->get();
		return view('other-pages.unicode-converter', $data);
	}

	# location
	// public function locationPage(){
	// 	## common controller ##
	// 	$commonController = new CommonController;
	// 	$data['divisions'] = $commonController->getDivisions();
	// 	return view('other-pages.location', $data);
	// }

	# location page
	public function locationNews($locationTitle){
		## common controller ##
		$commonController = new CommonController;
		$data['divisions'] = $commonController->getDivisions();

		$locationInfo = DB::table('locations')->where('title', $locationTitle)->first();
		if($locationInfo->type == 'division'){
			$data['locations'] = $commonController->getDistricts($locationInfo->id);
		}elseif($locationInfo->type == 'district'){
			$data['divisionInfo'] = DB::table('locations')->where('id', $locationInfo->division)->first();
			$data['locations'] = $commonController->getUpazilas($locationInfo->id);
		}elseif($locationInfo->type == 'upazila'){
			$data['divisionInfo'] = DB::table('locations')->where('id', $locationInfo->division)->first();
			$data['districtInfo'] = DB::table('locations')->where('id', $locationInfo->district)->first();
			$data['locations'] = $commonController->getUpazilas($locationInfo->district);
		}

		$data['locationArticles'] = $commonController->getLocationArticles($locationInfo, 20);
		
		$data['locationInfo'] = $locationInfo;
		return view('other-pages.location-news', $data);
	}

	# all category page
	public function categories(){
		## common controller ##
		$commonController = new CommonController;

		if(isset($_GET['categoryTitle']) && !empty($_GET['categoryTitle'])){
			$data['categories'] = Categories::where('status', 1)->where('parent', '=', 0)->where('display_name', 'like', '%'.$_GET['categoryTitle'].'%')->orderBy('order_id', 'asc')->get();
		}else{
			$data['categories'] = Categories::where('status', 1)->where('parent', '=', 0)->orderBy('order_id', 'asc')->get();
		}
		return view('other-pages.categories', $data);
	}

	# event page
	public function events($id = Null, $title = Null){
		## common controller ##
		$commonController = new CommonController;

		$data['events'] = Events::where('status', '!=', '-1')->orderBy('order_id', 'desc')->get();
		if(!empty($id)){
			$data['eventInfo'] = Events::where('id', $id)->where('status', '!=', '-1')->orderBy('order_id', 'desc')->first();
			if(!empty($data['eventInfo'])){
				$commonController = new CommonController;
				$data['eventArticles'] = $commonController->getEventArticlesByTag($data['eventInfo']->tag, 10);
			}
		}
		return view('other-pages.events', $data);
	}

	# search page
	public function search(){
		## common controller ##
		// $commonController = new CommonController;
		// $data['archiveArticles'] = $commonController->getArchiveArticles(10);
		return view('other-pages.search');
	}

	# archive page
	public function archive(){
		## common controller ##
		$commonController = new CommonController;
		$data['archiveArticles'] = $commonController->getArchiveArticles(10);

		return view('other-pages.archive', $data);
	}

	# archive print page
	public function archivePrint(){
		## common controller ##
		$commonController = new CommonController;
		$data['headlines'] = $commonController->printArchiveArticles();

		return view('other-pages.archive-print', $data);
	}

	# popular news page
	public function popularNews(){
		$data['popularNews'] = Null;

		return view('other-pages.popular-news', $data);
	}

	# latest news page
	public function latestNews(){
		## common controller ##
		$commonController = new CommonController;
		$data['latestNews'] = $commonController->getLatestArticles(10);
		return view('other-pages.latest-news', $data);
	}

	# selected news page
	public function selectedNews(){
		## common controller ##
		$commonController = new CommonController;
		$data['selectedNews'] = $commonController->getSelectedArticles('selected', 20);
		return view('other-pages.selected-news', $data);
	}

	# topic news page
	public function topicNews($tag){
		## common controller ##
		$commonController = new CommonController;
		$data['tag_title'] = str_replace("-", " ", $tag);
		
		## archived topic ##
		$archivedTopicInfo = ArchivedTopics::where('topic_slug', $tag)->where('status', 1)->orderBy('id', 'desc')->first();
		$data['archivedTopicInfo'] = $archivedTopicInfo;

		if(!empty($archivedTopicInfo)){
			$data['topicNews'] = $commonController->getTopicArticles($archivedTopicInfo->id, 0, 10);
		}else{
			abort(404);
		}

		return view('other-pages.topic-news', $data);
	}

	# polls page
	public function polls($pollID = Null){ 
		if(!empty($pollID)){
			$data['pollInfo'] = Polls::where('id', $pollID)->first();
		}  
		$data['polls'] = Polls::orderBy('order_id', 'desc')->simplePaginate(9);
		return view('other-pages.polls', $data);
	}

	# poll store
	public function pollStore($id, $answer){
		try{
			DB::beginTransaction();

			$pollInfo = Polls::where('id', $id)->first();
			if(!empty($pollInfo)){
				if($answer == 'yes'){
					$pollInfo->total_vote = $pollInfo->total_vote+1;
					$pollInfo->yes_vote = $pollInfo->yes_vote+1;
				}
				if($answer == 'no'){
					$pollInfo->total_vote = $pollInfo->total_vote+1;
					$pollInfo->no_vote = $pollInfo->no_vote+1;
				}
				if($answer == 'no_comment'){
					$pollInfo->total_vote = $pollInfo->total_vote+1;
					$pollInfo->no_opinion = $pollInfo->no_opinion+1;
				}
				$pollInfo->save();

				# redis regenrate
				if($this->redisConnStatus == true){
					$cacheController = new CacheController;
					$cacheController->redisRegeneratePollInfoCache();
				}
				# redis regenrate

				DB::commit();

				return \App\Models\Helper::processPoll($pollInfo);
			}
		}catch(\Exception $e){
			return abort(404);
		}
	}

	# authors page
	public function authors(){
		$data['authors'] = Authors::where('status', 1)->orderBy('author_order_id', 'desc')->get();
		return view('other-pages.authors', $data);
	}

	# author profile page
	public function authorProfile($id){
		try{
			$authorInfo = Authors::where('id', $id)->where('status', 1)->first();
			$data['authorInfo'] = $authorInfo;
        	## common controller ##
			$commonController = new CommonController;
			$data['authorArticles'] = $commonController->getAuthorArticles($authorInfo->id, 10);
			
			return view('other-pages.author-profile', $data);

		}catch(\Exception $e){
			abort(404);
		}
	}

	# news view store
	public function ajaxStoreNewsView($createDate, $articleId){
		$newsHitFile = "uploads/newshit/".date('Y/m', strtotime($createDate))."/".$articleId.'.txt';
		$content = \File::get($newsHitFile);
		$hit = $content+1;
		\File::put($newsHitFile, $hit);
		return $hit;
	}


}
