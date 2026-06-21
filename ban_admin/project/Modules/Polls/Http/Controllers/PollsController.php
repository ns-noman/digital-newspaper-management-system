<?php

namespace Modules\Polls\Http\Controllers;

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
use App\Models\Polls;

class PollsController extends Controller
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

      // $articles = DB::table('articles')->whereDate('created_at', '>=', '2025-08-22')->whereDate('created_at', '<=', '2025-09-07')->orderBy('created_at', 'asc')->get();
      // foreach ($articles as $key => $article) {
      //   $newCreateDate = date('Y-m-d H:i:s', strtotime('-6 Hours', strtotime($article->created_at)));

      //   $newUpdateDate = Null;
      //   if(!empty($article->updated_at)){
      //     $newUpdateDate = date('Y-m-d H:i:s', strtotime('-6 Hours', strtotime($article->updated_at)));
      //   }

      //   DB::table('articles')->where('id', $article->id)->update(['created_at' => $newCreateDate, 'updated_at' => $newUpdateDate]);
      // }

      // dd('done');


      $paginationAmount = isset($_GET['paginationAmount']) && !empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : 10;

      $data['lists'] = Polls::whereIn('status', [1,2])
      ->when(isset($_GET['question']) && !empty($_GET['question']), function ($query) {
        $query->where('question', 'like', '%'.$_GET['question'].'%');
      })
      ->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

      return view('polls::index', $data);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'poll_date' => 'required|date',
        'question' => 'required|string|between:1,2000',
        'image' => 'nullable|image',
        'status' => 'numeric|between:-1,2',
      ]);

      if ($validator->fails()) {
        return redirect()->route('Polls')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
      }

      try{
        DB::beginTransaction();

        $dataInfo = new Polls;
        $dataInfo->question = $request->question;
        $dataInfo->poll_date = $request->poll_date;
        $dataInfo->order_id = $this->orderID();
        $dataInfo->status = !empty($request->status) ? $request->status : -1;
        $dataInfo->created_by = Auth::user()->id;
        $dataInfo->created_at = date('Y-m-d H:i:s');

        if(!empty($request->image)){
          if(!is_null($request->file('image'))){
           $image = $request->file('image');
           $fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
           $savingPath = env('UploadsFolderPath').'polls/';
           Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);

           $dataInfo->image = $fileName;
         }
       }

       $dataInfo->yes_vote = $request->yes_vote ? $request->yes_vote : 0;
       $dataInfo->no_vote = $request->no_vote ? $request->no_vote : 0;
       $dataInfo->no_opinion = $request->no_opinion ? $request->no_opinion : 0;
       $dataInfo->total_vote = $dataInfo->yes_vote+$dataInfo->no_vote+$dataInfo->no_opinion;
       $dataInfo->save();

       DB::commit();

         # redis regenrate
       $cacheController = new CacheControllsController;
       $cacheController->redisRegeneratePollInfoCache();
         # redis regenrate

       return redirect()->route('Polls')->with('success_message', 'Poll has been created successfully!.');

     }catch(Exception $e){
      DB::rollback();
      return redirect()->route('Polls')->with('error_message', 'Failed to create Poll!.');
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
        'poll_date' => 'required|date',
        'question' => 'required|string|between:1,2000',
        'image' => 'nullable|image',
        'status' => 'numeric|between:-1,2',
        'id' => 'required|numeric',
      ]);

      if ($validator->fails()) {
        return redirect()->route('Polls')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
      }

      try{
        DB::beginTransaction();

        $id = $request->id;
        $dataInfo = Polls::find($id);
        $dataInfo->question = $request->question;
        $dataInfo->poll_date = $request->poll_date;
        $dataInfo->status = !empty($request->status) ? $request->status : -1;
        $dataInfo->updated_by = Auth::user()->id;
        $dataInfo->updated_at = date('Y-m-d H:i:s');

        if(!empty($request->image)){
          if(!is_null($request->file('image'))){
           $image = $request->file('image');
           $fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
           $savingPath = env('UploadsFolderPath').'polls/';
           Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);

           $dataInfo->image = $fileName;
         }
       }

       $dataInfo->yes_vote = $request->yes_vote ? $request->yes_vote : $dataInfo->yes_vote;
       $dataInfo->no_vote = $request->no_vote ? $request->no_vote : $dataInfo->no_vote;
       $dataInfo->no_opinion = $request->no_opinion ? $request->no_opinion : $dataInfo->no_opinion;
       $dataInfo->total_vote = $dataInfo->yes_vote+$dataInfo->no_vote+$dataInfo->no_opinion;
       $dataInfo->save();

       DB::commit();

         # redis regenrate
       $cacheController = new CacheControllsController;
       $cacheController->redisRegeneratePollInfoCache();
         # redis regenrate

       return redirect()->route('Polls')->with('success_message', 'Poll has been updated successfully!.');

     }catch(Exception $e){
      DB::rollback();
      return redirect()->route('Polls')->with('error_message', 'Failed to update Poll!.');
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
        $dataInfo = Polls::find($id);
        $dataInfo->status = -1;
        $dataInfo->updated_by = Auth::user()->id;
        $dataInfo->updated_at = date('Y-m-d H:i:s');
        $dataInfo->save();

            # redis regenrate
        $cacheController = new CacheControllsController;
        $cacheController->redisRegeneratePollInfoCache();
            # redis regenrate

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
            $dataInfo = Polls::find($id);
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
            $dataInfo = Polls::find($id);
            $dataInfo->status = $request->bulkStatus;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');
            $dataInfo->save();
          }
        }

        # redis regenrate
        $cacheController = new CacheControllsController;
        $cacheController->redisRegeneratePollInfoCache();
        # redis regenrate

        return redirect()->back()->with('success_message', 'Success! Action Applied Successfully.');
      }
      return redirect()->back()->with('error_message', 'Alert! Error Applying Action.');
    }


    public function orderID(){
      $orderIDInfo = Polls::orderBy('order_id', 'desc')->first();
      if(!empty($orderIDInfo)){
        $orderID = $orderIDInfo->order_id+1;
      }else{
        $orderID = 1;
      }
      return $orderID;
    }


  }
