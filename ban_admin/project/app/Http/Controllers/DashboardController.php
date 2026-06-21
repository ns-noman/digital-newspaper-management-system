<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;

use App\User;
use Auth;
use DB;
use Schema;
use Response;


class DashboardController extends Controller
{


	public function index(){
		$tableObj = new TableController();
		$tableObj->createRequiredFolders();
		return view('dashboard')->with('pieData', $this->getPieChartData())->with('totalUser', $this->getActiveUsers())->with('activeScrolls', $this->getActiveScrolls())->with('todaysNews', $this->getTodaysNews());
	}


	public function getPieChartData(){
		$articleTable = 'articles';
		$articleCategoryTable = 'article_categories';

		return DB::table($articleCategoryTable)->select('categories.display_name as label', DB::raw('count('.$articleCategoryTable.'.article_id) as data'))->leftJoin('categories', $articleCategoryTable.'.category_id', '=', 'categories.id')->leftJoin($articleTable, $articleCategoryTable.'.article_id', '=', $articleTable.'.id')->where('categories.parent', 0)->where($articleTable.'.created_at', '>=', date("Y-m-d"))->groupBy('categories.display_name')->get();
	}

	public function getActiveUsers(){
		$totalUser = User::where('users.status', 1)->count();
		if($totalUser < 10)
		{
			$totalUser = "0".$totalUser;
		}
		return $totalUser;
	}

	public function getActiveScrolls(){
		return DB::table('breakings')->where('breaking_time', '>=', date('Y-m-d H:i:s'))->where('status', 1)->count();
	}

	public function getTodaysNews(){
		return DB::table('articles')->whereDate('articles.created_at', '=', date('Y-m-d'))->where('status', 1)->count();
	}


	public function getTodaysHit(){
		$articles = DB::table('articles')->whereDate('articles.created_at', '=', date('Y-m-d'))->where('status', 1)->select('articles.id', 'articles.created_at')->get();

		$totalHit = 0;
		if (!empty($articles)) {
			foreach ($articles as $key => $article) {
				$newsHitFile = "../uploads/news_hit/".date('Y/m/d', strtotime($article->created_at))."/".$article->id.'.txt';

				if(file_exists($newsHitFile)){
					$content = \File::get($newsHitFile);
					$totalHit = $totalHit+$content;
				}else{
					$newsHitPath = "../uploads/news_hit/".date('Y/m/d/', strtotime($article->created_at));
					if(!is_dir($newsHitPath)){
						mkdir($newsHitPath,0777,true);
					}
					\File::put($newsHitPath.$article->id.'.txt','0');
					$totalHit = $totalHit+0;
				}
			}
		}
		return Response::json($totalHit*10);
	}


}
