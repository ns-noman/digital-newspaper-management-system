<?php

namespace Modules\Settings\Http\Controllers;

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
use App\Models\SettingsPage;

class SettingsPageController extends Controller
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
    
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
    	$paginationAmount = isset($_GET['paginationAmount']) && !empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : 10;

    	$data['lists'] = SettingsPage::whereIn('status', [1,2])
    	->when(isset($_GET['title']) && !empty($_GET['title']), function ($query) {
    		$query->where('title', 'like', '%'.$_GET['title'].'%');
    	})
        ->when(isset($_GET['slug']) && !empty($_GET['slug']), function ($query) {
            $query->where('slug', 'like', '%'.$_GET['slug'].'%');
        })
    	->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

    	return view('settings::settings-page', $data);
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
    		'slug' => 'required|string|unique:settings_pages,slug',
    		'meta_title' => 'nullable|string',
    		'meta_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
    		'meta_descriptions' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
    		'header_code' => 'nullable|string',
    		'status' => 'numeric|between:-1,2',
    	]);

    	if ($validator->fails()) {
    		return redirect()->route('Settings Page')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

    		$dataInfo = new SettingsPage;
            $dataInfo->title = $request->title;
    		$dataInfo->slug = $request->slug;
    		$dataInfo->meta_title = $request->meta_title;
    		$dataInfo->meta_descriptions = $request->meta_descriptions;
            $dataInfo->meta_keywords = $request->meta_keywords;
    		$dataInfo->header_code = $request->header_code;
    		$dataInfo->order_id = $this->orderID();
    		$dataInfo->status = !empty($request->status) ? $request->status : -1;
    		$dataInfo->created_by = Auth::user()->id;
    		$dataInfo->created_at = date('Y-m-d H:i:s');

    		if (!empty($request->meta_image)) {
    			$file = $request->file('meta_image');
    			$file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
    			$savingPath = env('UploadsFolderPath').'pages/';
    			Storage::disk(env('DISK'))->putFileAs($savingPath, $file, $file_name);
    			$dataInfo->meta_image = $file_name;
    		}

    		$dataInfo->save();
    		DB::commit();

    		return redirect()->route('Settings Page')->with('success_message', 'Page Settings has been created successfully!.');

    	}catch(Exception $e){
    		DB::rollback();
    		return redirect()->route('Settings Page')->with('error_message', 'Failed to create Page Settings.');
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
            'slug' => 'required|string|unique:settings_pages,slug,'.$request->id,
    		'meta_title' => 'nullable|string',
    		'meta_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
    		'meta_descriptions' => 'nullable|string',
    		'meta_keywords' => 'nullable|string',
            'header_code' => 'nullable|string',
    		'status' => 'numeric|between:-1,2',
    		'id' => 'required|numeric',
    	]);

    	if ($validator->fails()) {
    		return redirect()->route('Settings Page')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

    		$dataInfo = SettingsPage::find($request->id);
            $dataInfo->title = $request->title;
    		$dataInfo->slug = $request->slug;
    		$dataInfo->meta_title = $request->meta_title;
    		$dataInfo->meta_descriptions = $request->meta_descriptions;
            $dataInfo->meta_keywords = $request->meta_keywords;
    		$dataInfo->header_code = $request->header_code;
    		$dataInfo->status = !empty($request->status) ? $request->status : -1;
    		$dataInfo->updated_by = Auth::user()->id;
    		$dataInfo->updated_at = date('Y-m-d H:i:s');

    		if (!empty($request->meta_image)) {
    			$file = $request->file('meta_image');
    			$file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
    			$savingPath = env('UploadsFolderPath').'pages/';
    			Storage::disk(env('DISK'))->putFileAs($savingPath, $file, $file_name);
    			$dataInfo->meta_image = $file_name;
    		}

    		$dataInfo->save();
    		DB::commit();

    		return redirect()->route('Settings Page')->with('success_message', 'Page Settings has been updated successfully.');

    	}catch(Exception $e){
    		DB::rollback();
    		return redirect()->route('Settings Page')->with('error_message', 'Failed to update Page Settings.');
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
    		$dataInfo = SettingsPage::find($id);
    		$dataInfo->status = -1;
    		$dataInfo->updated_by = Auth::user()->id;
    		$dataInfo->updated_at = date('Y-m-d H:i:s');
    		$dataInfo->save();
    		return redirect()->route('Settings Page')->with('success_message', 'Success! Deleted Successfully.');
    	}
    	return redirect()->route('Settings Page')->with('error_message', 'Alert! Error Deleting Data.');
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
    				$dataInfo = SettingsPage::find($id);
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
    				$dataInfo = SettingsPage::find($id);
    				$dataInfo->status = $request->bulkStatus;
    				$dataInfo->updated_by = Auth::user()->id;
    				$dataInfo->updated_at = date('Y-m-d H:i:s');
    				$dataInfo->save();
    			}
    		}

    		return redirect()->route('Settings Page')->with('success_message', 'Success! Action Applied Successfully.');
    	}
    	return redirect()->route('Settings Page')->with('error_message', 'Alert! Error Applying Action.');
    }


    public function orderID()
    {
    	$orderIDInfo = SettingsPage::orderBy('order_id', 'desc')->first();
    	if(!empty($orderIDInfo)){
    		$orderID = $orderIDInfo->order_id+1;
    	}else{
    		$orderID = 1;
    	}
    	return $orderID;
    }


}
