<?php

namespace Modules\PopularNews\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\CacheControlls\Http\Controllers\CacheControllsController;
use DB;
use Auth;
use Session;
use Validator;
use App\Models\PopularNews;

use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\MinuteRange;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\RunRealtimeReportRequest;

class PopularNewsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	$this->middleware('auth');
    }


    public function pullGoogleAnalyticsData()
    {
    	try{
    		DB::beginTransaction();

    		putenv("GOOGLE_APPLICATION_CREDENTIALS=credentials.json");
    		$propertyId = env('ANALYTICS_PROPERTY_ID');
    		$client = new BetaAnalyticsDataClient();

    		$request = (new RunReportRequest())
    		->setProperty('properties/' . $propertyId)
    		->setDateRanges([
    			new DateRange([
    				'start_date' => 'yesterday',
    				'end_date' => 'today',
    			]),
    		])
    		->setDimensions([new Dimension(['name' => 'pageTitle']), new Dimension(['name' => 'pagePath'])])
    		->setMetrics([new Metric(['name' => 'screenPageViews'])])
    		->setLimit(20);
    		$response = $client->runReport($request);

    		$analyticsResult = Null;
    		$pageTitles[] = Null;
    		if(!empty($response->getRows())){
    			foreach ($response->getRows() as $key => $row) {
    				$explode = explode('/', $row->getDimensionValues()[1]->getValue());
    				if(count($explode)-1 >= 2){
    					if(!array_search($row->getDimensionValues()[0]->getValue(), $pageTitles)){
    						$pageTitles[] = $row->getDimensionValues()[0]->getValue();
    						$analyticsResult[] = array(
    							'pageTitle' => $row->getDimensionValues()[0]->getValue(),
    							'pagePath' => $row->getDimensionValues()[1]->getValue(),
    							'pageView' => $row->getMetricValues()[0]->getValue(),
    						);
    					}
    				}
    			}
    		}


    		if(!empty($analyticsResult) && (count($analyticsResult)>0)){
    			PopularNews::where('type', 1)->delete();

    			$analyticsResult = array_slice($analyticsResult, 0, 10);
    			$analyticsResult = array_reverse($analyticsResult);
    			foreach ($analyticsResult as $key => $analyticsResultItem) {
    				$dataInfo = new PopularNews;
    				$dataInfo->title = $analyticsResultItem['pageTitle'];
    				$dataInfo->link = env('Domain').$analyticsResultItem['pagePath'];
    				$dataInfo->total_hit = $analyticsResultItem['pageView'];
    				$dataInfo->type = 1;
    				$dataInfo->order_id = $this->orderID();
    				$dataInfo->status = 1;
    				$dataInfo->created_by = Auth::user()->id;
    				$dataInfo->created_at = date('Y-m-d H:i:s');
    				$dataInfo->save();
    			}
    		}


    		DB::commit();
    		return redirect()->route('PopularNews')->with('success_message','Data pulled successfully from Google Analytics');

    	}catch(Exception $e){
    		DB::rollback();
    		return redirect()->route('PopularNews')->with('error_message', 'Data could not pulled from Google Analytics');
    	}

    }



    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
    	$paginationAmount = isset($_GET['paginationAmount']) && !empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : 10;

    	$data['lists'] = PopularNews::whereIn('status', [1,2])
    	->when(isset($_GET['title']) && !empty($_GET['title']), function ($query) {
    		$query->where('title', 'like', '%'.$_GET['title'].'%');
    	})
    	->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

    	return view('popularnews::index', $data);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'title' => 'required|string',
    		'link' => 'required|string',
    		'total_hit' => 'numeric|required',
    		'status' => 'numeric|between:-1,2',
    	]);

    	if ($validator->fails()) {
    		return redirect()->route('PopularNews')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

    		$dataInfo = new PopularNews;
    		$dataInfo->title = $request->title;
    		$dataInfo->link = $request->link;
    		$dataInfo->total_hit = $request->total_hit;
    		$dataInfo->type = 2;
    		$dataInfo->order_id = $this->orderID();
    		$dataInfo->status = !empty($request->status) ? $request->status : -1;
    		$dataInfo->created_by = Auth::user()->id;
    		$dataInfo->created_at = date('Y-m-d H:i:s');
    		$dataInfo->save();

    		DB::commit();

    		return redirect()->route('PopularNews')->with('success_message', 'Popular News has been created successfully!.');

    	}catch(Exception $e){
    		DB::rollback();
    		return redirect()->route('PopularNews')->with('error_message', 'Failed to create Popular News!.');
    	}
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'title' => 'required|string',
    		'link' => 'required|string',
    		'total_hit' => 'numeric|required',
    		'status' => 'numeric|between:-1,2',
    		'id' => 'required|numeric',
    	]);

    	if ($validator->fails()) {
    		return redirect()->route('PopularNews')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

    		$id = $request->id;
    		$dataInfo = PopularNews::find($id);
    		$dataInfo->title = $request->title;
    		$dataInfo->link = $request->link;
    		$dataInfo->total_hit = $request->total_hit;
    		$dataInfo->status = !empty($request->status) ? $request->status : -1;
    		$dataInfo->updated_by = Auth::user()->id;
    		$dataInfo->updated_at = date('Y-m-d H:i:s');
    		$dataInfo->save();

    		DB::commit();

    		return redirect()->route('PopularNews')->with('success_message', 'Popular News has been updated successfully!.');

    	}catch(Exception $e){
    		DB::rollback();
    		return redirect()->route('PopularNews')->with('error_message', 'Failed to update Popular News!.');
    	}
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
    	if(!empty($id)){
    		$dataInfo = PopularNews::find($id);
    		$dataInfo->status = -1;
    		$dataInfo->updated_by = Auth::user()->id;
    		$dataInfo->updated_at = date('Y-m-d H:i:s');
    		$dataInfo->save();
    		return redirect()->back()->with('success_message', 'Success! Deleted Successfully.');
    	}
    	return redirect()->back()->with('error_message', 'Alert! Error Deleting Data.');
    }


    public function bulkUpdate(Request $request)
    {
    	if (isset($request->bulkStatus) && !empty($request->ids) && (count($request->ids)>0)) {
    		if($request->bulkStatus == 'swapOrder'){
    			$order_ids = Null;
    			foreach($request->ids as $key => $value){
    				$explode = explode(',', $value);
    				$order_ids[] = $explode[1];
    			}
    			arsort($order_ids);

    			$count = 0;
    			foreach($order_ids as $key => $order_id){
    				$explode = explode(',', $request->ids[$count]);
    				$id = $explode[0];
    				$dataInfo = PopularNews::find($id);
    				$dataInfo->order_id = $order_id;
    				$dataInfo->updated_by = Auth::user()->id;
    				$dataInfo->updated_at = date('Y-m-d H:i:s');
    				$dataInfo->save();
    				$count++;
    			}
    		}else{
    			foreach($request->ids as $key => $ids){
    				$explode = explode(',', $ids);
    				$id = $explode[0];
    				$dataInfo = PopularNews::find($id);
    				$dataInfo->status = $request->bulkStatus;
    				$dataInfo->updated_by = Auth::user()->id;
    				$dataInfo->updated_at = date('Y-m-d H:i:s');
    				$dataInfo->save();
    			}
    		}

    		return redirect()->back()->with('success_message', 'Success! Action Applied Successfully.');
    	}
    	return redirect()->back()->with('error_message', 'Alert! Error Applying Action.');
    }


    public function orderID()
    {
    	$orderIDInfo = PopularNews::orderBy('order_id', 'desc')->first();
    	if(!empty($orderIDInfo)){
    		$orderID = $orderIDInfo->order_id+1;
    	}else{
    		$orderID = 1;
    	}
    	return $orderID;
    }

}
