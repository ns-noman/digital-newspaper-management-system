<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use DB;
use Auth;
Use App\Models\ElectionResults;

class HomeController extends Controller
{


	public function home(){
		## common controller ##
		$commonController = new CommonController;

		$data['leadArticle'] = $commonController->getLeadArticles(1);
		$data['topArticles'] = $commonController->getTopArticles(!empty(env('topnews')) ? env('topnews') : 7);
		if(!empty(env('selected2news')) && env('selected2news') == 1){
			$data['selected2news'] = $commonController->getSelectedArticles('selected2', 3);
		}
		$data['selectednews'] = $commonController->getSelectedArticles('selected', 4);
		if(!empty(env('showlive')) && env('showlive') == 1){
			$data['liveNews'] = $commonController->getCategoryArticlesHome(43, 1);
		}

		## category articles ##
		$data['category_1'] = $commonController->getCategoryArticlesAllColumn(16, 2);
		$data['category_2'] = $commonController->getCategoryArticlesHome(1, 7);
		$data['category_3'] = $commonController->getCategoryArticlesHome(12, 7);
		$data['category_4'] = $commonController->getCategoryArticlesHome(6, 5);
		$data['category_5'] = $commonController->getCategoryArticlesHome(11, 5);
		$data['category_6'] = $commonController->getCategoryArticlesHome(13, 9);
		$data['category_7'] = $commonController->getCategoryArticlesHome(15, 6);
		$data['category_8'] = $commonController->getCategoryArticlesHome(14, 5);
		$data['videoGalleries'] = $commonController->getCategoryArticlesHome(32, 9);

		$data['breakingArticles'] = $commonController->getBreakingArticles(10);
		$data['justnowArticles'] = $commonController->getJustnowArticles(10);
		// $data['todaysQuestion'] = $commonController->getPollInfo();
		$data['divisions'] = $commonController->getDivisions();
		$data['trendingTopics'] = $commonController->getTrendingTopics();
		
		$data['mainEventInfo'] = $commonController->getEventInfo(1);
		if(!empty($data['mainEventInfo'])){
			$data['mainEventArticles'] = $commonController->getEventArticlesByTopic($data['mainEventInfo']->topic_id, $data['mainEventInfo']->no_of_article);
		}

		$data['mainEvent2Info'] = $commonController->getEventInfo(2);
		if(!empty($data['mainEvent2Info'])){
			$data['mainEvent2Articles'] = $commonController->getEventArticlesByTopic($data['mainEvent2Info']->topic_id, $data['mainEvent2Info']->no_of_article);
		}

		if(date('Y-m-d') <= '2025-03-31'){
			$data['ramadanTimings'] = DB::table('ramadan_timings')->where('date', date('Y-m-d'))->orWhere('date', date('Y-m-d', strtotime('+ 1 day')))->get();
		}

		$data['advPlacements'] = $commonController->getAdvertisementPlacements();
		$data['electionInfo'] = ElectionResults::orderBy('id', 'desc')->where('status', 1)->get();
		
		return view('home', $data);
	}


	// ajax desktop home
	public function ajaxDesktopHome(){
		## common controller ##
		$commonController = new CommonController;
		$data['category_9'] = $commonController->getCategoryArticlesHome(21, 8);
		$data['category_11'] = $commonController->getCategoryArticlesHome(22, 5);
		$data['category_12'] = $commonController->getCategoryArticlesHome(17, 5);
		$data['category_13'] = $commonController->getCategoryArticlesHome(41, 5);
		$data['category_14'] = $commonController->getCategoryArticlesHome(2, 5);
		$data['category_15'] = $commonController->getCategoryArticlesHome(4, 5);
		$data['category_16'] = $commonController->getCategoryArticlesHome(27, 9);
		$data['category_17'] = $commonController->getCategoryArticlesHome(19, 5);
		$data['category_18'] = $commonController->getCategoryArticlesHome(20, 5);
		$data['category_19'] = $commonController->getCategoryArticlesHome(25, 9);
		$data['category_20'] = $commonController->getCategoryArticlesHome(24, 5);
		$data['category_21'] = $commonController->getCategoryArticlesHome(23, 5);
		$data['category_22'] = $commonController->getCategoryArticlesHome(26, 5);
		$data['category_23'] = $commonController->getCategoryArticlesHome(38, 5);
		$data['category_24'] = $commonController->getCategoryArticlesHome(18, 5);
		// $data['photoGalleries'] = $commonController->getCategoryArticlesAllColumn(1, 5);
		return view('home-ajax-desktop', $data);
	}


	// ajax mobile home
	public function ajaxMobileHome(){
		## common controller ##
		$commonController = new CommonController;
		$data['category_9'] = $commonController->getCategoryArticlesHome(21, 8);
		$data['category_11'] = $commonController->getCategoryArticlesHome(22, 5);
		$data['category_12'] = $commonController->getCategoryArticlesHome(17, 5);
		$data['category_13'] = $commonController->getCategoryArticlesHome(41, 5);
		$data['category_14'] = $commonController->getCategoryArticlesHome(2, 5);
		$data['category_15'] = $commonController->getCategoryArticlesHome(4, 5);
		$data['category_16'] = $commonController->getCategoryArticlesHome(27, 9);
		$data['category_17'] = $commonController->getCategoryArticlesHome(19, 5);
		$data['category_18'] = $commonController->getCategoryArticlesHome(20, 5);
		$data['category_19'] = $commonController->getCategoryArticlesHome(25, 9);
		$data['category_20'] = $commonController->getCategoryArticlesHome(24, 5);
		$data['category_21'] = $commonController->getCategoryArticlesHome(23, 5);
		$data['category_22'] = $commonController->getCategoryArticlesHome(26, 5);
		$data['category_23'] = $commonController->getCategoryArticlesHome(38, 5);
		$data['category_24'] = $commonController->getCategoryArticlesHome(18, 5);
		// $data['photoGalleries'] = $commonController->getCategoryArticlesAllColumn(1, 5);
		return view('home-ajax-mobile', $data);
	}

}
