<?php

namespace Modules\ImportantLinks\Http\Controllers;

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
use App\Models\ImportantLinks;
use App\Models\ImportantLinkCategories;

class ImportantLinksController extends Controller
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

        $data['lists'] = ImportantLinks::whereIn('status', [1,2])
        ->when(isset($_GET['title']) && !empty($_GET['title']), function ($query) {
            $query->where('title', 'like', '%'.$_GET['title'].'%');
        })
        ->when(isset($_GET['slug']) && !empty($_GET['slug']), function ($query) {
            $query->where('slug', $_GET['slug']);
        })
        ->when(isset($_GET['important_link_category_id']) && !empty($_GET['important_link_category_id']), function ($query) {
            $query->where('important_link_category_id', $_GET['important_link_category_id']);
        })
        ->when(isset($_GET['type']) && !empty($_GET['type']), function ($query) {
            $query->where('type', $_GET['type']);
        })
        ->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

        $data['linkCategories'] = ImportantLinkCategories::where('status', 1)->orderBy('order_id', 'desc')->get();

        return view('importantlinks::index', $data);
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
            'link' => 'required',
            'photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'important_link_category_id' => 'numeric|nullable|exists:important_link_categories,id',
            'type' => 'numeric|nullable|between:1,2',
            'menubar' => 'numeric|nullable|between:1,2',
            'status' => 'numeric|between:-1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->route('ImportantLinks')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $dataInfo = new ImportantLinks;
            $dataInfo->title = $request->title;
            $dataInfo->link = $request->link;
            $dataInfo->slug = $this->getSlug($request->title);
            $dataInfo->important_link_category_id = $request->important_link_category_id;
            $dataInfo->order_id = $this->orderID();
            $dataInfo->type = $request->type;
            $dataInfo->menubar = $request->menubar;
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->created_by = Auth::user()->id;
            $dataInfo->created_at = date('Y-m-d H:i:s');

            if (!empty($request->photo)) {
                $file = $request->file('photo');
                $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
                $savingPath = env('UploadsFolderPath').'links/';
                Storage::disk(env('DISK'))->putFileAs($savingPath, $file, $file_name);

                $dataInfo->photo = $file_name;
            }

            $dataInfo->save();
            DB::commit();

            return redirect()->route('ImportantLinks')->with('success_message', 'ImportantLinks has been created successfully!.');

        }catch(Exception $e){
            DB::rollback();
            return redirect()->route('ImportantLinks')->with('error_message', 'Failed to create ImportantLinks!.');
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
            'id' => 'required',
            'title' => 'required|string',
            'link' => 'required',
            'photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'important_link_category_id' => 'numeric|nullable|exists:important_link_categories,id',
            'type' => 'numeric|nullable|between:1,2',
            'menubar' => 'numeric|nullable|between:1,2',
            'status' => 'numeric|between:-1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->route('ImportantLinks')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $dataInfo = ImportantLinks::find($request->id);
            $dataInfo->title = $request->title;
            $dataInfo->link = $request->link;
            $dataInfo->slug = $this->getSlug($request->title);
            $dataInfo->important_link_category_id = $request->important_link_category_id;
            $dataInfo->type = $request->type;
            $dataInfo->menubar = $request->menubar;
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');

            if (!empty($request->photo)) {
                $file = $request->file('photo');
                $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
                $savingPath = env('UploadsFolderPath').'links/';
                Storage::disk(env('DISK'))->putFileAs($savingPath, $file, $file_name);

                $dataInfo->photo = $file_name;
            }

            $dataInfo->save();
            DB::commit();

            return redirect()->route('ImportantLinks')->with('success_message', 'ImportantLinks has been updated successfully!.');

        }catch(Exception $e){
            DB::rollback();
            return redirect()->route('ImportantLinks')->with('error_message', 'Failed to update ImportantLinks!.');
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
            $dataInfo = ImportantLinks::find($id);
            $dataInfo->status = -1;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');
            $dataInfo->save();
            return redirect()->route('ImportantLinks')->with('success_message', 'Success! Deleted Successfully.');
        }
        return redirect()->route('ImportantLinks')->with('error_message', 'Alert! Error Deleting Data.');
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
                    $dataInfo = ImportantLinks::find($id);
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
                    $dataInfo = ImportantLinks::find($id);
                    $dataInfo->status = $request->bulkStatus;
                    $dataInfo->updated_by = Auth::user()->id;
                    $dataInfo->updated_at = date('Y-m-d H:i:s');
                    $dataInfo->save();
                }
            }

            return redirect()->route('ImportantLinks')->with('success_message', 'Success! Action Applied Successfully.');
        }
        return redirect()->route('ImportantLinks')->with('error_message', 'Alert! Error Applying Action.');
    }


    public function orderID()
    {
      $orderIDInfo = ImportantLinks::orderBy('order_id', 'desc')->first();
      if(!empty($orderIDInfo)){
        $orderID = $orderIDInfo->order_id+1;
    }else{
        $orderID = 1;
    }
    return $orderID;
}


public function getSlug($title)
{
    $slug = str_replace(" ", "-", trim(strip_tags(strtolower($title))));
    $slug = str_replace("‘", "", $slug);
    $slug = str_replace("’", "", $slug);
    $slug = str_replace("---", "-", $slug);
    $slug = str_replace("--", "-", $slug);
    return $slug;
}

}
