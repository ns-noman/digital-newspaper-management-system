<?php

namespace Modules\Advertisements\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Modules\CacheControlls\Http\Controllers\CacheControllsController;
use DB;
use Auth;
use Session;
use Validator;
use App\Models\AdvertisementPlacements;
use App\Models\AdvertisementOrders;

class AdvertisementsOrdersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    	$this->middleware('role');
    }
    
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($placementId)
    {
    	$paginationAmount = isset($_GET['paginationAmount']) && !empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : 10;

    	$data['lists'] = AdvertisementOrders::where('placement_id', $placementId)->whereIn('status', [1,2])
    	->when(isset($_GET['advertiser_name']) && !empty($_GET['advertiser_name']), function ($query) {
    		$query->where('advertisement_orders.advertiser_name', 'like', '%'.$_GET['advertiser_name'].'%');
    	})
    	->when(isset($_GET['advertiser_contact']) && !empty($_GET['advertiser_contact']), function ($query) {
    		$query->where('advertisement_orders.advertiser_contact', 'like', '%'.$_GET['advertiser_contact'].'%');
    	})
    	->when(isset($_GET['dateFrom']) && !empty($_GET['dateFrom']), function ($query) {
    		$query->whereDate('advertisement_orders.created_at', '>=', $_GET['dateFrom']);
    	})
    	->when(isset($_GET['dateTo']) && !empty($_GET['dateTo']), function ($query) {
    		$query->whereDate('advertisement_orders.created_at', '<=', $_GET['dateTo']);
    	})
    	->orderBy('id', 'desc')->simplePaginate($paginationAmount);

    	$data['placementInfo'] = AdvertisementPlacements::where('id', $placementId)->first();

    	return view('advertisements::orders', $data);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'placement_id' => 'required|numeric',
    		'ad_type' => 'required|numeric|between:1,2',
    		'ad_banner' => 'nullable|mimes:jpeg,png,jpg,gif,svg,avif,avifs|max:2048',
    		'start_date' => 'required',
    		'end_date' => 'required',
    		'advertiser_name' => 'nullable|string',
    		'advertiser_contact' => 'nullable|string',
    		'advertiser_email' => 'nullable|string',
    		'status' => 'numeric|between:-1,2',
    	]);

    	if ($validator->fails()) {
    		return redirect()->back()->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

    		$dataInfo = new AdvertisementOrders;
    		$dataInfo->placement_id = $request->placement_id;
    		$dataInfo->ad_code = $request->ad_code;
    		$dataInfo->ad_url = $request->ad_url;
    		$dataInfo->start_date = $request->start_date;
    		$dataInfo->end_date = $request->end_date;
    		$dataInfo->advertiser_name = $request->advertiser_name;
    		$dataInfo->advertiser_contact = $request->advertiser_contact;
    		$dataInfo->advertiser_email = $request->advertiser_email;
    		$dataInfo->ad_type = $request->ad_type;
    		$dataInfo->status = $request->status;
    		$dataInfo->created_by = Auth::user()->id;
    		$dataInfo->created_at = date('Y-m-d H:i:s');

    		if (!empty($request->ad_banner)) {
    			$file = $request->file('ad_banner');
    			$file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
    			$savingPath = env('UploadsFolderPath').'advertisements/';
    			Storage::disk(env('DISK'))->putFileAs($savingPath, $file, $file_name);

    			$dataInfo->ad_banner = $file_name;
    		}

    		$dataInfo->save();
    		DB::commit();

    		return redirect()->back()->with('success_message', 'Advertisements Order has been created successfully!.');

    	}catch(Exception $e){
    		DB::rollback();
    		return redirect()->back()->with('error_message', 'Failed to create Advertisements Order!.');
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
    		'ad_type' => 'required|numeric|between:1,2',
    		'ad_banner' => 'nullable|mimes:jpeg,png,jpg,gif,svg,avif,avifs|max:2048',
    		'start_date' => 'required',
    		'end_date' => 'required',
    		'advertiser_name' => 'nullable|string',
    		'advertiser_contact' => 'nullable|string',
    		'advertiser_email' => 'nullable|string',
    		'status' => 'numeric|between:-1,2',
    		'id' => 'required',
    	]);

    	if ($validator->fails()) {
    		return redirect()->back()->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

    		$dataInfo = AdvertisementOrders::find($request->id);
    		$dataInfo->ad_code = $request->ad_code;
    		$dataInfo->ad_url = $request->ad_url;
    		$dataInfo->start_date = $request->start_date;
    		$dataInfo->end_date = $request->end_date;
    		$dataInfo->advertiser_name = $request->advertiser_name;
    		$dataInfo->advertiser_contact = $request->advertiser_contact;
    		$dataInfo->advertiser_email = $request->advertiser_email;
    		$dataInfo->ad_type = $request->ad_type;
    		$dataInfo->status = $request->status;
    		$dataInfo->updated_by = Auth::user()->id;
    		$dataInfo->updated_at = date('Y-m-d H:i:s');

    		if($request->ad_type == 1){
    			if (!empty($request->ad_banner)) {
    				$file = $request->file('ad_banner');
    				$file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
    				$savingPath = env('UploadsFolderPath').'advertisements/';
    				Storage::disk(env('DISK'))->putFileAs($savingPath, $file, $file_name);

    				$dataInfo->ad_banner = $file_name;
    			}
    		}else{
    			$dataInfo->ad_banner = Null;
    		}

    		$dataInfo->save();
    		DB::commit();

    		return redirect()->back()->with('success_message', 'Advertisements Order has been updated successfully!.');

    	}catch(Exception $e){
    		DB::rollback();
    		return redirect()->back()->with('error_message', 'Failed to update Advertisements Order!.');
    	}
    }


    public function orderDetail($id){
    	$orderInfo = AdvertisementOrders::where('id', $id)->first();
    	return $orderInfo;
    }

}
