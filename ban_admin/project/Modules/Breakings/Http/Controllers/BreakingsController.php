<?php

namespace Modules\Breakings\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\CacheControlls\Http\Controllers\CacheControllsController;
use DB;
use Auth;
use Session;
use Validator;
use App\Models\Breakings;

class BreakingsController extends Controller
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

        $data['lists'] = Breakings::whereIn('status', [1,2])
        ->when(isset($_GET['title']) && !empty($_GET['title']), function ($query) {
            $query->where('title', 'like', '%'.$_GET['title'].'%');
        })
        ->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

        return view('breakings::index', $data);
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
            'url' => 'nullable|string',
            'breaking_time' => 'required|string',
            'type' => 'numeric|between:1,2',
            'status' => 'numeric|between:-1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->route('Breakings')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $dataInfo = new Breakings;
            $dataInfo->title = $request->title;
            $dataInfo->url = $request->url;
            $dataInfo->breaking_time = $request->breaking_time;
            $dataInfo->type = $request->type;
            $dataInfo->order_id = $this->orderID();
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->created_by = Auth::user()->id;
            $dataInfo->created_at = date('Y-m-d H:i:s');
            $dataInfo->save();

            DB::commit();

            # redis regenrate
            $cacheController = new CacheControllsController;
            if($dataInfo->type == 1){
                $cacheController->redisRegenerateBreakings();
            }elseif($dataInfo->type == 2){
                $cacheController->redisRegenerateJustnow();
            }
            # redis regenrate

            return redirect()->route('Breakings')->with('success_message', 'Breaking has been created successfully!.');

        }catch(Exception $e){
          DB::rollback();
          return redirect()->route('Breakings')->with('error_message', 'Failed to create Breaking!.');
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
            'url' => 'nullable|string',
            'breaking_time' => 'required|string',
            'type' => 'numeric|between:1,2',
            'status' => 'numeric|between:-1,2',
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('Breakings')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $id = $request->id;
            $dataInfo = Breakings::find($id);
            $dataInfo->title = $request->title;
            $dataInfo->url = $request->url;
            $dataInfo->breaking_time = $request->breaking_time;
            $dataInfo->type = $request->type;
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');
            $dataInfo->save();

            DB::commit();

            # redis regenrate
            $cacheController = new CacheControllsController;
            $cacheController->redisRegenerateBreakings();
            $cacheController->redisRegenerateJustnow();
            # redis regenrate

            return redirect()->route('Breakings')->with('success_message', 'Breaking has been updated successfully!.');

        }catch(Exception $e){
          DB::rollback();
          return redirect()->route('Breakings')->with('error_message', 'Failed to update Breaking!.');
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
            $dataInfo = Breakings::find($id);
            $dataInfo->status = -1;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');
            $dataInfo->save();

            # redis regenrate
            $cacheController = new CacheControllsController;
            if($dataInfo->type == 1){
                $cacheController->redisRegenerateBreakings();
            }elseif($dataInfo->type == 2){
                $cacheController->redisRegenerateJustnow();
            }
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
                    $dataInfo = Breakings::find($id);
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
                    $dataInfo = Breakings::find($id);
                    $dataInfo->status = $request->bulkStatus;
                    $dataInfo->updated_by = Auth::user()->id;
                    $dataInfo->updated_at = date('Y-m-d H:i:s');
                    $dataInfo->save();
                }
            }

            # redis regenrate
            $cacheController = new CacheControllsController;
            $cacheController->redisRegenerateBreakings();
            $cacheController->redisRegenerateJustnow();
            # redis regenrate

            return redirect()->back()->with('success_message', 'Success! Action Applied Successfully.');
        }
        return redirect()->back()->with('error_message', 'Alert! Error Applying Action.');
    }


    public function orderID(){
        $orderIDInfo = Breakings::orderBy('order_id', 'desc')->first();
        if(!empty($orderIDInfo)){
            $orderID = $orderIDInfo->order_id+1;
        }else{
            $orderID = 1;
        }
        return $orderID;
    }


}
