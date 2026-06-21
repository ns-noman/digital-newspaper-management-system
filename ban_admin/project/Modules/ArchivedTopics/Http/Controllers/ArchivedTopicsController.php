<?php

namespace Modules\ArchivedTopics\Http\Controllers;

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
use App\Models\ArchivedTopics;

class ArchivedTopicsController extends Controller
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

    	$data['lists'] = ArchivedTopics::whereIn('status', [1,2])
    	->when(isset($_GET['topic_title']) && !empty($_GET['topic_title']), function ($query) {
    		$query->where('topic_title', 'like', '%'.$_GET['topic_title'].'%');
    	})
        ->when(isset($_GET['topic_alternate_title']) && !empty($_GET['topic_alternate_title']), function ($query) {
            $query->where('topic_alternate_title', 'like', '%'.$_GET['topic_alternate_title'].'%');
        })
    	->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

    	return view('archivedtopics::index', $data);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'topic_title' => 'required|string',
            'topic_alternate_title' => 'nullable|string',
    		'topic_slug' => 'required|string|unique:archived_topics,topic_slug',
    		'topic_photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
    		'topic_descriptions' => 'nullable|string',
    		'meta_title' => 'nullable|string',
    		'meta_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
    		'meta_descriptions' => 'nullable|string',
    		'meta_keywords' => 'nullable|string',
            'noindex' => 'nullable|numeric',
            'exclude_xml' => 'nullable|numeric',
    		'status' => 'numeric|between:-1,2',
    	]);

    	if ($validator->fails()) {
    		return redirect()->route('ArchivedTopics')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

    		$dataInfo = new ArchivedTopics;
            $dataInfo->topic_title = $request->topic_title;
            $dataInfo->topic_alternate_title = $request->topic_alternate_title;
    		$dataInfo->topic_slug = $request->topic_slug;
    		$dataInfo->topic_descriptions = $request->topic_descriptions;
    		$dataInfo->meta_title = $request->meta_title;
    		$dataInfo->meta_descriptions = $request->meta_descriptions;
    		$dataInfo->meta_keywords = $request->meta_keywords;
    		$dataInfo->order_id = $this->orderID();
            $dataInfo->noindex = !empty($request->noindex) ? $request->noindex : Null;
            $dataInfo->exclude_xml = !empty($request->exclude_xml) ? $request->exclude_xml : Null;
    		$dataInfo->status = !empty($request->status) ? $request->status : -1;
    		$dataInfo->created_by = Auth::user()->id;
    		$dataInfo->created_at = date('Y-m-d H:i:s');

    		if (!empty($request->topic_photo)) {
    			$file = $request->file('topic_photo');
    			$file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
    			$savingPath = env('UploadsFolderPath').'topics/';
    			Storage::disk(env('DISK'))->putFileAs($savingPath, $file, $file_name);
    			$dataInfo->topic_photo = $file_name;
    		}

    		if (!empty($request->meta_image)) {
    			$file = $request->file('meta_image');
    			$file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
    			$savingPath = env('UploadsFolderPath').'topics/';
    			Storage::disk(env('DISK'))->putFileAs($savingPath, $file, $file_name);
    			$dataInfo->meta_image = $file_name;
    		}

    		$dataInfo->save();
    		DB::commit();

    		return redirect()->route('ArchivedTopics')->with('success_message', 'Archived Topic has been created successfully!.');

    	}catch(Exception $e){
    		DB::rollback();
    		return redirect()->route('ArchivedTopics')->with('error_message', 'Failed to create Archived Topic.');
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
            'topic_title' => 'required|string',
            'topic_alternate_title' => 'nullable|string',
    		'topic_slug' => 'required|string|unique:archived_topics,topic_slug,'.$request->id,
    		'topic_photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
    		'topic_descriptions' => 'nullable|string',
    		'meta_title' => 'nullable|string',
    		'meta_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
    		'meta_descriptions' => 'nullable|string',
    		'meta_keywords' => 'nullable|string',
            'noindex' => 'nullable|numeric',
            'exclude_xml' => 'nullable|numeric',
    		'status' => 'numeric|between:-1,2',
    		'id' => 'required|numeric',
    	]);

    	if ($validator->fails()) {
    		return redirect()->route('ArchivedTopics')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

    		$dataInfo = ArchivedTopics::find($request->id);
            $dataInfo->topic_title = $request->topic_title;
            $dataInfo->topic_alternate_title = $request->topic_alternate_title;
    		$dataInfo->topic_slug = $request->topic_slug;
    		$dataInfo->topic_descriptions = $request->topic_descriptions;
    		$dataInfo->meta_title = $request->meta_title;
    		$dataInfo->meta_descriptions = $request->meta_descriptions;
    		$dataInfo->meta_keywords = $request->meta_keywords;
            $dataInfo->noindex = !empty($request->noindex) ? $request->noindex : Null;
            $dataInfo->exclude_xml = !empty($request->exclude_xml) ? $request->exclude_xml : Null;
    		$dataInfo->status = !empty($request->status) ? $request->status : -1;
    		$dataInfo->updated_by = Auth::user()->id;
    		$dataInfo->updated_at = date('Y-m-d H:i:s');

    		if (!empty($request->topic_photo)) {
    			$file = $request->file('topic_photo');
    			$file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
    			$savingPath = env('UploadsFolderPath').'topics/';
    			Storage::disk(env('DISK'))->putFileAs($savingPath, $file, $file_name);
    			$dataInfo->topic_photo = $file_name;
    		}

    		if (!empty($request->meta_image)) {
    			$file = $request->file('meta_image');
    			$file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
    			$savingPath = env('UploadsFolderPath').'topics/';
    			Storage::disk(env('DISK'))->putFileAs($savingPath, $file, $file_name);
    			$dataInfo->meta_image = $file_name;
    		}

    		$dataInfo->save();
    		DB::commit();

    		return redirect()->route('ArchivedTopics')->with('success_message', 'Archived Topic has been updated successfully.');

    	}catch(Exception $e){
    		DB::rollback();
    		return redirect()->route('ArchivedTopics')->with('error_message', 'Failed to update Archived Topic.');
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
    		$dataInfo = ArchivedTopics::find($id);
    		$dataInfo->status = -1;
    		$dataInfo->updated_by = Auth::user()->id;
    		$dataInfo->updated_at = date('Y-m-d H:i:s');
    		$dataInfo->save();
    		return redirect()->route('ArchivedTopics')->with('success_message', 'Success! Deleted Successfully.');
    	}
    	return redirect()->route('ArchivedTopics')->with('error_message', 'Alert! Error Deleting Data.');
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
    				$dataInfo = ArchivedTopics::find($id);
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
    				$dataInfo = ArchivedTopics::find($id);
    				$dataInfo->status = $request->bulkStatus;
    				$dataInfo->updated_by = Auth::user()->id;
    				$dataInfo->updated_at = date('Y-m-d H:i:s');
    				$dataInfo->save();
    			}
    		}

    		return redirect()->route('ArchivedTopics')->with('success_message', 'Success! Action Applied Successfully.');
    	}
    	return redirect()->route('ArchivedTopics')->with('error_message', 'Alert! Error Applying Action.');
    }


    public function orderID()
    {
    	$orderIDInfo = ArchivedTopics::orderBy('order_id', 'desc')->first();
    	if(!empty($orderIDInfo)){
    		$orderID = $orderIDInfo->order_id+1;
    	}else{
    		$orderID = 1;
    	}
    	return $orderID;
    }


}
