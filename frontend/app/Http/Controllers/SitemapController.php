<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use DateTime;
use App\Models\Articles;
use App\Models\Categories;
use App\Models\ArchivedTopics;

class SitemapController extends Controller
{

	public function sitemapXml(){
		$startDate = date('Y-m-d');
		$endDate = '2025-01-01';
		$startDate = new DateTime($startDate);
		$endDate = new DateTime($endDate);
		$dates = Null;
		for($i = $startDate; $i >= $endDate; $i->modify('-1 day')){
			$dates[] = $i->format("Y-m-d");
		}
		return response()->view('sitemap.sitemap', ['dates' => $dates])->header('Content-Type', 'text/xml');
	}

	public function sitemapStaticXml(){
		return response()->view('sitemap.sitemap-static-pages')->header('Content-Type', 'text/xml');
	}

	public function sitemapSectionXml(){
		$categories = Categories::where('status', 1)->orderBy('id', 'asc')->get();
		return response()->view('sitemap.sitemap-section', ['categories' => $categories])->header('Content-Type', 'text/xml');
	}

	public function sitemapTopicXml(){
		$topics = ArchivedTopics::where('status', 1)->whereNull('exclude_xml')->orderBy('order_id', 'desc')->limit(1000)->get();
		return response()->view('sitemap.sitemap-topic', ['topics' => $topics])->header('Content-Type', 'text/xml');
	}

	public function sitemapNewsXml(){
		$commonController = new CommonController;
		$articles = $commonController->getSitemapArticles('', date('Y-m-d H:i:s', strtotime('-48 hours')), date('Y-m-d H:i:s'), '', '');
		return response()->view('sitemap.sitemap-news', ['articles' => $articles])->header('Content-Type', 'text/xml');
	}

	public function sitemapDailyXml($dailyDate){
		$date = str_replace("sitemap-daily-", "", $dailyDate);
		$date = str_replace(".xml", "", $date);
		$commonController = new CommonController;
		$articles = $commonController->getSitemapArticles('', $date, '', '', '');
		return response()->view('sitemap.sitemap-daily', ['articles' => $articles])->header('Content-Type', 'text/xml');
	}

	public function rssCategoryXml($category){
		$commonController = new CommonController;
		if($category == 'latest'){
			$articles = $commonController->getLatestArticles(100);
		}else{
			$articles = $commonController->getSitemapArticles(100, '', '', $category, '');
		}
		return response()->view('sitemap.rss-categorynews', ['articles' => $articles])->header('Content-Type', 'text/xml');
	}

	public function sitemapCustomXml(){
		$commonController = new CommonController;
		$articles = $commonController->getSitemapArticles(200, '', '', '', 1);
		return response()->view('sitemap.sitemap-custom', ['articles' => $articles])->header('Content-Type', 'text/xml');
	}

}
