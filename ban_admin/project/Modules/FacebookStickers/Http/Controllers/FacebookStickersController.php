<?php

namespace Modules\FacebookStickers\Http\Controllers;

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
use App\Models\FacebookStickers;

class FacebookStickersController extends Controller
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
    public function index()
    {
      $paginationAmount = isset($_GET['paginationAmount']) && !empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : 10;

      $data['lists'] = FacebookStickers::whereIn('status', [1,2])
      ->when(isset($_GET['title']) && !empty($_GET['title']), function ($query) {
        $query->where('title', 'like', '%'.$_GET['title'].'%');
    })
      ->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

      return view('facebookstickers::index', $data);
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
        'sticker' => 'required|image',
        'date_from' => 'required|date',
        'date_to' => 'required|date',
        'status' => 'numeric|between:-1,2',
    ]);

      if ($validator->fails()) {
        return redirect()->route('FacebookStickers')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    }

    try{
        DB::beginTransaction();

        $dataInfo = new FacebookStickers;
        $dataInfo->title = $request->title;
        $dataInfo->date_from = $request->date_from;
        $dataInfo->date_to = $request->date_to;
        $dataInfo->order_id = $this->orderID();
        $dataInfo->status = !empty($request->status) ? $request->status : -1;
        $dataInfo->created_by = Auth::user()->id;
        $dataInfo->created_at = date('Y-m-d H:i:s');

        if(!empty($request->sticker)){
          if(!is_null($request->file('sticker'))){
           $image = $request->file('sticker');
           $fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
           $savingPath = env('UploadsFolderPath').'fbstickers/';
           Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);

           $dataInfo->sticker = $fileName;
       }
   }

   $dataInfo->save();

   DB::commit();

   return redirect()->route('FacebookStickers')->with('success_message', 'FacebookSticker has been created successfully!.');

}catch(Exception $e){
  DB::rollback();
  return redirect()->route('FacebookStickers')->with('error_message', 'Failed to create FacebookSticker!.');
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
        'sticker' => 'required|image',
        'date_from' => 'required|date',
        'date_to' => 'required|date',
        'status' => 'numeric|between:-1,2',
        'id' => 'required|numeric',
    ]);

      if ($validator->fails()) {
        return redirect()->route('FacebookStickers')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    }

    try{
        DB::beginTransaction();

        $id = $request->id;
        $dataInfo = FacebookStickers::find($id);
        $dataInfo->title = $request->title;
        $dataInfo->date_from = $request->date_from;
        $dataInfo->date_to = $request->date_to;
        $dataInfo->status = !empty($request->status) ? $request->status : -1;
        $dataInfo->updated_by = Auth::user()->id;
        $dataInfo->updated_at = date('Y-m-d H:i:s');

        if(!empty($request->sticker)){
          if(!is_null($request->file('sticker'))){
           $image = $request->file('sticker');
           $fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
           $savingPath = env('UploadsFolderPath').'fbstickers/';
           Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);

           $dataInfo->sticker = $fileName;
       }
   }

   $dataInfo->save();

   DB::commit();

   return redirect()->route('FacebookStickers')->with('success_message', 'FacebookSticker has been updated successfully!.');

}catch(Exception $e){
  DB::rollback();
  return redirect()->route('FacebookStickers')->with('error_message', 'Failed to update FacebookSticker!.');
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
        $dataInfo = FacebookStickers::find($id);
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
        $dataInfo = FacebookStickers::find($id);
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
    $dataInfo = FacebookStickers::find($id);
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


public function orderID(){
  $orderIDInfo = FacebookStickers::orderBy('order_id', 'desc')->first();
  if(!empty($orderIDInfo)){
    $orderID = $orderIDInfo->order_id+1;
}else{
    $orderID = 1;
}
return $orderID;
}


}
