<?php

namespace Modules\ImportantLinkCategories\Http\Controllers;

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

class ImportantLinkCategoriesController extends Controller
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

        $data['lists'] = ImportantLinkCategories::whereIn('status', [1,2])
        ->when(isset($_GET['title']) && !empty($_GET['title']), function ($query) {
            $query->where('title', 'like', '%'.$_GET['title'].'%');
        })
        ->when(isset($_GET['slug']) && !empty($_GET['slug']), function ($query) {
            $query->where('slug', $_GET['slug']);
        })
        ->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

        return view('importantlinkcategories::index', $data);
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
            'slug' => 'required|string|unique:important_link_categories,slug',
            'link' => 'string|nullable',
            'menubar' => 'numeric|nullable',
            'status' => 'numeric|between:-1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->route('ImportantLinkCategories')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $dataInfo = new ImportantLinkCategories;
            $dataInfo->title = $request->title;
            $dataInfo->slug = $request->slug;
            $dataInfo->link = $request->link;
            $dataInfo->description = $request->description;
            $dataInfo->menubar = !empty($request->menubar) ? $request->menubar : Null;
            $dataInfo->order_id = $this->orderID();
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->created_by = Auth::user()->id;
            $dataInfo->created_at = date('Y-m-d H:i:s');
            $dataInfo->save();
            DB::commit();

            return redirect()->route('ImportantLinkCategories')->with('success_message', 'Important Link Category has been created successfully!.');

        }catch(Exception $e){
            DB::rollback();
            return redirect()->route('ImportantLinkCategories')->with('error_message', 'Failed to create Important Link Category!.');
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
            'slug' => 'required|string|unique:important_link_categories,slug,'.$request->id,
            'link' => 'string|nullable',
            'menubar' => 'numeric|nullable',
            'status' => 'numeric|between:-1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->route('ImportantLinkCategories')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $dataInfo = ImportantLinkCategories::find($request->id);
            $dataInfo->title = $request->title;
            $dataInfo->slug = $request->slug;
            $dataInfo->link = $request->link;
            $dataInfo->description = $request->description;
            $dataInfo->menubar = !empty($request->menubar) ? $request->menubar : Null;
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');
            $dataInfo->save();
            DB::commit();

            return redirect()->route('ImportantLinkCategories')->with('success_message', 'Important Link Category has been updated successfully!.');

        }catch(Exception $e){
            DB::rollback();
            return redirect()->route('ImportantLinkCategories')->with('error_message', 'Failed to update Important Link Category!.');
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
            $dataInfo = ImportantLinkCategories::find($id);
            $dataInfo->status = -1;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');
            $dataInfo->save();
            return redirect()->route('ImportantLinkCategories')->with('success_message', 'Success! Deleted Successfully.');
        }
        return redirect()->route('ImportantLinkCategories')->with('error_message', 'Alert! Error Deleting Data.');
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
                    $dataInfo = ImportantLinkCategories::find($id);
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
                    $dataInfo = ImportantLinkCategories::find($id);
                    $dataInfo->status = $request->bulkStatus;
                    $dataInfo->updated_by = Auth::user()->id;
                    $dataInfo->updated_at = date('Y-m-d H:i:s');
                    $dataInfo->save();
                }
            }

            return redirect()->route('ImportantLinkCategories')->with('success_message', 'Success! Action Applied Successfully.');
        }
        return redirect()->route('ImportantLinkCategories')->with('error_message', 'Alert! Error Applying Action.');
    }


    public function orderID()
    {
      $orderIDInfo = ImportantLinkCategories::orderBy('order_id', 'desc')->first();
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
