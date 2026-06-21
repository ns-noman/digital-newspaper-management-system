<?php

namespace Modules\Reports\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redis;
use Modules\CacheControlls\Http\Controllers\CacheControllsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CommonController;
use DB;
use Auth;
use Session;
use Validator;
use App\Models\User;
use App\Models\Articles;
use App\Models\ArticlePhotos;
use App\Models\ArticleDetails;
use App\Models\ArticleCategories;
use App\Models\Categories;
use App\Models\EmployeeInitials;
use App\Models\EmployeeInitialsType;
use App\Models\MarketingPersons;
use App\Models\MarketingCompanies;
use App\Models\ArticleMis;

class ReportsController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}


	public function uploadGAData(){
		$reportDates = Null;
		$startDate = new \DateTime('2025-01-01'); 
		$endDate = new \DateTime(date('Y-m-d'));
		for($selectedDate = $startDate; $selectedDate <= $endDate; $selectedDate->modify('+1 month')) {
			$resultY = $selectedDate->format('Y');
			$resultM = $selectedDate->format('m');
			$reportDates[] = array(
				'year_month' => $resultY.'-'.$resultM,
				'year_month_title' => date('M Y', strtotime($resultY.'-'.$resultM.'-01')),
			);
		}
		$data['reportDates'] = $reportDates;
		return view('reports::uploadGAData', $data);
	}


	public function uploadGADataStore(Request $request){
		$validator = Validator::make($request->all(), [
			'report_date' => 'required',
			'ga_file' => 'required',
		]);

		if ($validator->fails()) {
			return redirect()->route('Upload GAData')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
		}

		$postInfo = Null;
		DB::table('reports_articlehit')->where('hit_date', $request->report_date)->delete();
		$csvArray = array_map('str_getcsv', file($request->ga_file));
		$chunk_result = array_chunk($csvArray, 500, true);
		$dataArray = Null;
		if(!empty($chunk_result) && (count($chunk_result)>0)){
			foreach ($chunk_result as $key => $dataArray) {
				if(!empty($dataArray) && (count($dataArray)>0)){
					foreach ($dataArray as $key => $value) {
						if(count($value) == 2){
							$explodeData = explode('/', $value[0]);
							if(((count($explodeData) == 3)) && (is_numeric($explodeData[2]) == true) && (is_numeric($value[1]) == true)){
								if(empty($postInfo[$explodeData[2]])){
									$postInfo[$explodeData[2]] = array(
										'article_id' => $explodeData[2],
										'hit' => !empty($value[1]) ? $value[1] : 0,
										'hit_date' => $request->report_date,
										'created_by' => Auth::user()->id,
										'created_at' => date('Y-m-d H:i:s'),
									);
								}else{
									$postInfo[$explodeData[2]] = array(
										'article_id' => $explodeData[2],
										'hit' => !empty($value[1]) ? $postInfo[$explodeData[2]]['hit']+$value[1] : $postInfo[$explodeData[2]]['hit']+0,
										'hit_date' => $request->report_date,
										'created_by' => Auth::user()->id,
										'created_at' => date('Y-m-d H:i:s'),
									);
								}

							}
						}
					}
				}
			}
		}

		if(!empty($postInfo)){
			foreach(array_chunk($postInfo, 2000) as $key => $smallerArray) {
				foreach ($smallerArray as $index => $value) {
					$temp[$index] = $value;
				}
				DB::table('reports_articlehit')->insert($temp);
			}
			return redirect()->route('Upload GAData')->with('success_message', 'Google Analytics hit data has been processed successfully!.');
		}else{
			return redirect()->route('Upload GAData')->with('error_message', 'Failed to process article hit google analytics data.');
		}
	}

	public function gaReport(){
		$reportDates = Null;
		$startDate = new \DateTime('2025-01-01'); 
		$endDate = new \DateTime(date('Y-m-d'));
		for($selectedDate = $startDate; $selectedDate <= $endDate; $selectedDate->modify('+1 month')) {
			$resultY = $selectedDate->format('Y');
			$resultM = $selectedDate->format('m');
			$reportDates[] = array(
				'year_month' => $resultY.'-'.$resultM,
				'year_month_title' => date('M Y', strtotime($resultY.'-'.$resultM.'-01')),
			);
		}
		$data['reportDates'] = $reportDates;
		$data['types'] = EmployeeInitialsType::where('status', 1)->orderBy('order_id', 'asc')->get();
		$data['initials'] = EmployeeInitials::where('status', 1)->orderBy('order_id', 'asc')->get();
		if(isset($_GET['mis_type']) && !empty($_GET['mis_type'])){
			$data['misTypeInfo'] = EmployeeInitialsType::where('status', 1)->where('id', $_GET['mis_type'])->first();
		}
		if(isset($_GET['initial']) && !empty($_GET['initial'])){
			$data['initialInfo'] = EmployeeInitials::where('status', 1)->where('id', $_GET['initial'])->first();
		}

		if(isset($_GET['report_date']) && !empty($_GET['report_date'])){
			$dateFrom = $_GET['report_date'].'-01';
			$dateTo = $_GET['report_date'].'-31';
			$data['misReports'] = EmployeeInitials::where('employee_initials.status', 1)
			->when(isset($_GET['initial']) && !empty($_GET['initial']), function ($query) {
				$query->where('employee_initials.id', $_GET['initial']);
			})
			->leftjoin('article_mis', 'article_mis.employee_initial_id', '=', 'employee_initials.id')->whereBetween('article_mis.article_date', [$_GET['report_date'].'-01', $_GET['report_date'].'-31'])
			->when(isset($_GET['mis_type']) && !empty($_GET['mis_type']), function ($query) {
				$query->where('article_mis.employee_initial_type_id', $_GET['mis_type']);
			})
			->leftjoin('reports_articlehit', 'reports_articlehit.article_id', '=', 'article_mis.article_id')->where('reports_articlehit.hit_date', $_GET['report_date'])
			->selectRaw('employee_initials.id as id, employee_initials.name as name, count(article_mis.id) as total_news, sum(reports_articlehit.hit) as total_hit')
			->groupBy('employee_initials.id','employee_initials.name')
			->orderBy('total_hit', 'desc')
			->get();
		}

		return view('reports::ga-report', $data);
	}


	public function subeditorReport(){
		$reportDates = Null;
		$startDate = new \DateTime('2025-01-01'); 
		$endDate = new \DateTime(date('Y-m-d'));
		for($selectedDate = $startDate; $selectedDate <= $endDate; $selectedDate->modify('+1 month')) {
			$resultY = $selectedDate->format('Y');
			$resultM = $selectedDate->format('m');
			$reportDates[] = array(
				'year_month' => $resultY.'-'.$resultM,
				'year_month_title' => date('M Y', strtotime($resultY.'-'.$resultM.'-01')),
			);
		}
		$data['reportDates'] = $reportDates;
		$data['users'] = User::where('status', 1)->orderBy('order_id', 'asc')->get();
		if(isset($_GET['users']) && !empty($_GET['users'])){
			$data['userInfo'] = User::where('status', 1)->where('id', $_GET['users'])->first();
		}

		if(isset($_GET['report_date']) && !empty($_GET['report_date'])){
			$dateFrom = $_GET['report_date'].'-01';
			$dateTo = $_GET['report_date'].'-31';
			$data['usersReport'] = User::where('users.status', 1)->where('users.role', '!=', 'uploader')
			->when(isset($_GET['users']) && !empty($_GET['users']), function ($query) {
				$query->where('users.id', $_GET['users']);
			})
			->selectRaw('users.id as id,users.name as name, count(articles.id) as total_news, sum(reports_articlehit.hit) as total_hit')
			->leftjoin('articles', 'articles.created_by', '=', 'users.id')->whereDate('articles.created_at', '>=', $dateFrom)->whereDate('articles.created_at', '<=', $dateTo)
			->leftJoin('reports_articlehit', function($join){
				$join->on('articles.id', '=', 'reports_articlehit.article_id');
				$join->where('reports_articlehit.hit_date', '=',  $_GET['report_date']);
			})
			->groupBy('users.id','users.name')
			->orderBy('total_hit', 'desc')
			->get();
		}

		return view('reports::subeditor-report', $data);
	}


	public function mpReport(){
		$data['marketingCompanies'] = MarketingCompanies::where('status', 1)->orderBy('order_id', 'desc')->get();
		$data['marketingPersons'] = MarketingPersons::where('status', 1)->orderBy('order_id', 'desc')->get();
		if(isset($_GET['marketing_person_id']) && !empty($_GET['marketing_person_id'])){
			$data['marketingPersonInfo'] = MarketingPersons::where('status', 1)->where('id', $_GET['marketing_person_id'])->first();
		}
		if(isset($_GET['marketing_company_id']) && !empty($_GET['marketing_company_id'])){
			$data['marketingCompanyInfo'] = MarketingCompanies::where('status', 1)->where('id', $_GET['marketing_company_id'])->first();
		}

		$data['mpReports'] = MarketingPersons::where('marketing_persons.status', 1)
		->when(isset($_GET['marketing_person_id']) && !empty($_GET['marketing_person_id']), function ($query) {
			$query->where('marketing_persons.id', $_GET['marketing_person_id']);
		})
		->selectRaw('marketing_persons.id as id,marketing_persons.title as title, count(articles.id) as total_news')
		->leftjoin('articles', 'articles.marketing_person_id', '=', 'marketing_persons.id')
		->when(isset($_GET['marketing_company_id']) && !empty($_GET['marketing_company_id']), function ($query) {
			$query->where('articles.marketing_company_id', $_GET['marketing_company_id']);
		})
		->when(isset($_GET['dateFrom']) && !empty($_GET['dateFrom']), function ($query) {
			$query->whereDate('articles.created_at', '>=', $_GET['dateFrom']);
		})
		->when(empty($_GET['dateFrom']), function ($query) {
			$query->whereDate('articles.created_at', '=', date('Y-m-d'));
		})
		->when(isset($_GET['dateTo']) && !empty($_GET['dateTo']), function ($query) {
			$query->whereDate('articles.created_at', '<=', $_GET['dateTo']);
		})
		->when(empty($_GET['dateTo']), function ($query) {
			$query->whereDate('articles.created_at', '=', date('Y-m-d'));
		})
		->groupBy('marketing_persons.id','marketing_persons.title')
		->orderBy('total_news', 'desc')
		->get();
		return view('reports::mp-report', $data);
	}


	public function mcReport(){
		$data['marketingCompanies'] = MarketingCompanies::where('status', 1)->orderBy('order_id', 'desc')->get();
		$data['marketingPersons'] = MarketingPersons::where('status', 1)->orderBy('order_id', 'desc')->get();
		if(isset($_GET['marketing_person_id']) && !empty($_GET['marketing_person_id'])){
			$data['marketingPersonInfo'] = MarketingPersons::where('status', 1)->where('id', $_GET['marketing_person_id'])->first();
		}
		if(isset($_GET['marketing_company_id']) && !empty($_GET['marketing_company_id'])){
			$data['marketingCompanyInfo'] = MarketingCompanies::where('status', 1)->where('id', $_GET['marketing_company_id'])->first();
		}

		$data['mcReports'] = MarketingCompanies::where('marketing_companies.status', 1)
		->when(isset($_GET['marketing_company_id']) && !empty($_GET['marketing_company_id']), function ($query) {
			$query->where('marketing_companies.id', $_GET['marketing_company_id']);
		})
		->selectRaw('marketing_companies.id as id,marketing_companies.title as title, count(articles.id) as total_news')
		->leftjoin('articles', 'articles.marketing_company_id', '=', 'marketing_companies.id')
		->when(isset($_GET['marketing_person_id']) && !empty($_GET['marketing_person_id']), function ($query) {
			$query->where('articles.marketing_person_id', $_GET['marketing_person_id']);
		})
		->when(isset($_GET['dateFrom']) && !empty($_GET['dateFrom']), function ($query) {
			$query->whereDate('articles.created_at', '>=', $_GET['dateFrom']);
		})
		->when(empty($_GET['dateFrom']), function ($query) {
			$query->whereDate('articles.created_at', '=', date('Y-m-d'));
		})
		->when(isset($_GET['dateTo']) && !empty($_GET['dateTo']), function ($query) {
			$query->whereDate('articles.created_at', '<=', $_GET['dateTo']);
		})
		->when(empty($_GET['dateTo']), function ($query) {
			$query->whereDate('articles.created_at', '=', date('Y-m-d'));
		})
		->groupBy('marketing_companies.id','marketing_companies.title')
		->orderBy('total_news', 'desc')
		->get();
		return view('reports::mc-report', $data);
	}

	public function prNewsReport(){
		$data['marketingCompanies'] = MarketingCompanies::where('status', 1)->orderBy('order_id', 'desc')->get();
		$data['marketingPersons'] = MarketingPersons::where('status', 1)->orderBy('order_id', 'desc')->get();
		if(isset($_GET['marketing_person_id']) && !empty($_GET['marketing_person_id'])){
			$data['marketingPersonInfo'] = MarketingPersons::where('status', 1)->where('id', $_GET['marketing_person_id'])->first();
		}
		if(isset($_GET['marketing_company_id']) && !empty($_GET['marketing_company_id'])){
			$data['marketingCompanyInfo'] = MarketingCompanies::where('status', 1)->where('id', $_GET['marketing_company_id'])->first();
		}

		$data['prReports'] = Articles::where('articles.status', 1)
		->when(isset($_GET['marketing_company_id']) && !empty($_GET['marketing_company_id']), function ($query) {
			$query->where('articles.marketing_company_id', $_GET['marketing_company_id']);
		})
		->when(isset($_GET['marketing_person_id']) && !empty($_GET['marketing_person_id']), function ($query) {
			$query->where('articles.marketing_person_id', $_GET['marketing_person_id']);
		})
		->when(isset($_GET['dateFrom']) && !empty($_GET['dateFrom']), function ($query) {
			$query->whereDate('articles.created_at', '>=', $_GET['dateFrom']);
		})
		->when(empty($_GET['dateFrom']), function ($query) {
			$query->whereDate('articles.created_at', '=', date('Y-m-d'));
		})
		->when(isset($_GET['dateTo']) && !empty($_GET['dateTo']), function ($query) {
			$query->whereDate('articles.created_at', '<=', $_GET['dateTo']);
		})
		->when(empty($_GET['dateTo']), function ($query) {
			$query->whereDate('articles.created_at', '=', date('Y-m-d'));
		})
		->select('articles.category_id', 'articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.created_at', 'articles.marketing_person_id', 'articles.marketing_company_id')
		->orderBy('order_id', 'desc')
		->get();
		return view('reports::pr-report-news', $data);
	}


	public function postReport(){
		$data['subEditors'] = User::where('status', 1)->whereNotIn('id', [1,2])->orderBy('order_id', 'asc')->get();

		if(isset($_GET['subeditor']) && !empty($_GET['subeditor'])){
			$data['subEditorInfo'] = User::where('status', 1)->where('id', $_GET['subeditor'])->first();
		}

		if(!empty($_GET['dateFrom']) && !empty($_GET['dateTo'])){

			if(isset($_GET['reportType']) && $_GET['reportType'] == 'detail'){
				$data['postReports'] =  Articles::where('articles.status', 1)
				->when(isset($_GET['dateFrom']) && !empty($_GET['dateFrom']), function ($query) {
					$query->where('articles.created_at', '>=', $_GET['dateFrom']);
				})
				->when(isset($_GET['dateTo']) && !empty($_GET['dateTo']), function ($query) {
					$query->where('articles.created_at', '<=', $_GET['dateTo']);
				})
				->when(isset($_GET['subeditor']) && !empty($_GET['subeditor']), function ($query) {
					$query->where('articles.created_by', $_GET['subeditor']);
				})
				->when(isset($_GET['category']) && !empty($_GET['category']), function ($query) {
					$query->leftjoin('article_categories', 'article_categories.article_id', '=', 'articles.id')->where('article_categories.category_id', $_GET['category']);
				})->leftjoin('categories', 'categories.id', '=', 'articles.category_id')
				->select('articles.category_id', 'articles.id', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.created_at', 'articles.created_by', 'categories.title', 'categories.display_name')
				->orderBy('articles.id', 'desc')->get();
			}

			if(isset($_GET['reportType']) && $_GET['reportType'] == 'summary'){
				$data['usersReport'] = User::where('users.status', 1)->where('users.role', '!=', 'uploader')
				->when(isset($_GET['subeditor']) && !empty($_GET['subeditor']), function ($query) {
					$query->where('users.id', $_GET['subeditor']);
				})
				->select('users.id', 'users.name')
				->orderBy('users.id', 'asc')
				->get();
			}

		}

		return view('reports::post-report', $data);
	}


	public function misReport(){

		$data['types'] = EmployeeInitialsType::where('status', 1)->orderBy('order_id', 'asc')->get();
		$data['initials'] = EmployeeInitials::where('status', 1)->orderBy('order_id', 'asc')->get();
		if(isset($_GET['mis_type']) && !empty($_GET['mis_type'])){
			$data['misTypeInfo'] = EmployeeInitialsType::where('status', 1)->where('id', $_GET['mis_type'])->first();
		}
		if(isset($_GET['initial']) && !empty($_GET['initial'])){
			$data['initialInfo'] = EmployeeInitials::where('status', 1)->where('id', $_GET['initial'])->first();
		}

		if(!empty($_GET['dateFrom']) && !empty($_GET['dateTo'])){

			if(isset($_GET['reportType']) && $_GET['reportType'] == 'detail'){
				$data['postReports'] =  ArticleMis::leftjoin('articles', 'articles.id', '=', 'article_mis.article_id')->where('articles.status', 1)
				->when(isset($_GET['dateFrom']) && !empty($_GET['dateFrom']), function ($query) {
					$query->where('articles.created_at', '>=', $_GET['dateFrom']);
				})
				->when(isset($_GET['dateTo']) && !empty($_GET['dateTo']), function ($query) {
					$query->where('articles.created_at', '<=', $_GET['dateTo']);
				})
				->when(isset($_GET['initial']) && !empty($_GET['initial']), function ($query) {
					$query->where('article_mis.employee_initial_id', $_GET['initial']);
				})
				->when(isset($_GET['mis_type']) && !empty($_GET['mis_type']), function ($query) {
					$query->where('article_mis.employee_initial_type_id', $_GET['mis_type']);
				})
				->select('articles.headline_color', 'articles.shoulder', 'articles.hanger', 'articles.headline', 'articles.category_id', 'articles.id', 'articles.created_at', 'articles.created_by', 'article_mis.employee_initial_id', 'article_mis.employee_initial_type_id')
				->orderBy('articles.id', 'desc')->get();
			}

			if(isset($_GET['reportType']) && $_GET['reportType'] == 'summary'){
				$data['usersReport'] = EmployeeInitials::where('employee_initials.status', 1)
				->when(isset($_GET['initial']) && !empty($_GET['initial']), function ($query) {
					$query->where('employee_initials.id', $_GET['initial']);
				})
				->select('employee_initials.id', 'employee_initials.name')
				->orderBy('employee_initials.id', 'asc')
				->get();
			}

		}

		return view('reports::mis-report', $data);

	}


}
