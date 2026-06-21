<?php

namespace Modules\ElectionResults\Http\Controllers;

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
use App\Models\ElectionResults;

class ElectionsController extends Controller
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

        $data['lists'] = ElectionResults::whereIn('status', [1,2])
        ->when(isset($_GET['title']) && !empty($_GET['title']), function ($query) {
            $query->where('title', 'like', '%'.$_GET['title'].'%');
        })
        ->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

        return view('electionresults::elections', $data);
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
            'date' => 'required|date',
            'male_voter' => 'nullable|numeric',
            'female_voter' => 'nullable|numeric',
            'other_voter' => 'nullable|numeric',
            'total_voter' => 'nullable|numeric',
            'total_center' => 'nullable|numeric',
            'published_center' => 'nullable|numeric',
            'small_banner' => 'nullable|image',
            'large_banner' => 'nullable|image',
            'status' => 'numeric|between:-1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->route('Elections')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $dataInfo = new ElectionResults;
            $dataInfo->title = $request->title;
            $dataInfo->date = $request->date;
            $dataInfo->male_voter = $request->male_voter;
            $dataInfo->female_voter = $request->female_voter;
            $dataInfo->other_voter = $request->other_voter;
            $dataInfo->total_voter = $request->total_voter;
            $dataInfo->total_center = $request->total_center;
            $dataInfo->published_center = $request->published_center;
            $dataInfo->order_id = $this->orderID();
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->created_by = Auth::user()->id;
            $dataInfo->created_at = date('Y-m-d H:i:s');

            if(!empty($request->small_banner)){
                if(!is_null($request->file('small_banner'))){
                    $image = $request->file('small_banner');
                    $fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
                    $savingPath = env('UploadsFolderPath').'elections/';
                    Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);
                    $dataInfo->small_banner = $fileName;
                }
            }

            if(!empty($request->large_banner)){
                if(!is_null($request->file('large_banner'))){
                    $image = $request->file('large_banner');
                    $fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
                    $savingPath = env('UploadsFolderPath').'elections/';
                    Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);
                    $dataInfo->large_banner = $fileName;
                }
            }

            $dataInfo->save();

            DB::commit();

            return redirect()->route('Elections')->with('success_message', 'Election has been created successfully!.');

        }catch(Exception $e){
            DB::rollback();
            return redirect()->route('Elections')->with('error_message', 'Failed to create Election!.');
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
            'date' => 'required|date',
            'male_voter' => 'nullable|numeric',
            'female_voter' => 'nullable|numeric',
            'other_voter' => 'nullable|numeric',
            'total_voter' => 'nullable|numeric',
            'total_center' => 'nullable|numeric',
            'published_center' => 'nullable|numeric',
            'small_banner' => 'nullable|image',
            'large_banner' => 'nullable|image',
            'status' => 'numeric|between:-1,2',
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('Elections')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $dataInfo = ElectionResults::find($request->id);
            $dataInfo->title = $request->title;
            $dataInfo->date = $request->date;
            $dataInfo->male_voter = $request->male_voter;
            $dataInfo->female_voter = $request->female_voter;
            $dataInfo->other_voter = $request->other_voter;
            $dataInfo->total_voter = $request->total_voter;
            $dataInfo->total_center = $request->total_center;
            $dataInfo->published_center = $request->published_center;
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');

            if(!empty($request->small_banner)){
                if(!is_null($request->file('small_banner'))){
                    $image = $request->file('small_banner');
                    $fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
                    $savingPath = env('UploadsFolderPath').'elections/';
                    Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);
                    $dataInfo->small_banner = $fileName;
                }
            }

            if(!empty($request->large_banner)){
                if(!is_null($request->file('large_banner'))){
                    $image = $request->file('large_banner');
                    $fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
                    $savingPath = env('UploadsFolderPath').'elections/';
                    Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);
                    $dataInfo->large_banner = $fileName;
                }
            }

            $dataInfo->save();

            DB::commit();

            return redirect()->route('Elections')->with('success_message', 'Election has been updated successfully!.');

        }catch(Exception $e){
            DB::rollback();
            return redirect()->route('Elections')->with('error_message', 'Failed to update Election!.');
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
            $dataInfo = ElectionResults::find($id);
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
                    $dataInfo = ElectionResults::find($id);
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
                    $dataInfo = ElectionResults::find($id);
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
        $orderIDInfo = ElectionResults::orderBy('order_id', 'desc')->first();
        if(!empty($orderIDInfo)){
            $orderID = $orderIDInfo->order_id+1;
        }else{
            $orderID = 1;
        }
        return $orderID;
    }

}
