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

class AdvertisementsPlacementsController extends Controller
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

        $data['lists'] = AdvertisementPlacements::whereIn('status', [1,2])
        ->when(isset($_GET['placement_name']) && !empty($_GET['placement_name']), function ($query) {
            $query->where('placement_name', 'like', '%'.$_GET['placement_name'].'%');
        })
        ->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

        return view('advertisements::placements', $data);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'placement_name' => 'required|string',
            'placement_size' => 'nullable|string',
            'placement_photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'numeric|between:-1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->route('Advertisements Placements')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $dataInfo = new AdvertisementPlacements;
            $dataInfo->placement_name = $request->placement_name;
            $dataInfo->placement_size = $request->placement_size;
            $dataInfo->order_id = $this->orderID();
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->created_by = Auth::user()->id;
            $dataInfo->created_at = date('Y-m-d H:i:s');

            if (!empty($request->placement_photo)) {
                $file = $request->file('placement_photo');
                $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
                $savingPath = env('UploadsFolderPath').'advertisements/';
                Storage::disk(env('DISK'))->putFileAs($savingPath, $file, $file_name);

                $dataInfo->placement_photo = $file_name;
            }

            $dataInfo->save();
            DB::commit();

            return redirect()->route('Advertisements Placements')->with('success_message', 'Advertisements Placement has been created successfully!.');

        }catch(Exception $e){
            DB::rollback();
            return redirect()->route('Advertisements Placements')->with('error_message', 'Failed to create Advertisements Placement!.');
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
            'placement_name' => 'required|string',
            'placement_size' => 'nullable|string',
            'placement_photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'numeric|between:-1,2',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('Advertisements Placements')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $dataInfo = AdvertisementPlacements::find($request->id);
            $dataInfo->placement_name = $request->placement_name;
            $dataInfo->placement_size = $request->placement_size;
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');

            if (!empty($request->placement_photo)) {
                $file = $request->file('placement_photo');
                $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
                $savingPath = env('UploadsFolderPath').'advertisements/';
                Storage::disk(env('DISK'))->putFileAs($savingPath, $file, $file_name);

                $dataInfo->placement_photo = $file_name;
            }

            $dataInfo->save();
            DB::commit();

            return redirect()->route('Advertisements Placements')->with('success_message', 'Advertisements Placement has been updated successfully!.');

        }catch(Exception $e){
            DB::rollback();
            return redirect()->route('Advertisements Placements')->with('error_message', 'Failed to update Advertisements Placement!.');
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
            $dataInfo = AdvertisementPlacements::find($id);
            $dataInfo->status = -1;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');
            $dataInfo->save();
            return redirect()->route('Advertisements Placements')->with('success_message', 'Success! Deleted Successfully.');
        }
        return redirect()->route('Advertisements Placements')->with('error_message', 'Alert! Error Deleting Data.');
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
                    $dataInfo = AdvertisementPlacements::find($id);
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
                    $dataInfo = AdvertisementPlacements::find($id);
                    $dataInfo->status = $request->bulkStatus;
                    $dataInfo->updated_by = Auth::user()->id;
                    $dataInfo->updated_at = date('Y-m-d H:i:s');
                    $dataInfo->save();
                }
            }

            return redirect()->route('Advertisements Placements')->with('success_message', 'Success! Action Applied Successfully.');
        }
        return redirect()->route('Advertisements Placements')->with('error_message', 'Alert! Error Applying Action.');
    }


    public function orderID()
    {
      $orderIDInfo = AdvertisementPlacements::orderBy('order_id', 'desc')->first();
      if(!empty($orderIDInfo)){
        $orderID = $orderIDInfo->order_id+1;
    }else{
        $orderID = 1;
    }
    return $orderID;
}

}
