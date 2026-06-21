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
use App\Models\ElectionResultFigures;

class ElectionsFiguresController extends Controller
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
    public function index($electionId)
    {
        $paginationAmount = isset($_GET['paginationAmount']) && !empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : 10;

        $data['lists'] = ElectionResultFigures::whereIn('status', [1,2])->where('election_result_id', $electionId)
        ->when(isset($_GET['figure_name']) && !empty($_GET['figure_name']), function ($query) {
            $query->where('figure_name', 'like', '%'.$_GET['figure_name'].'%');
        })
        ->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

        $data['electionInfo'] = ElectionResults::where('id', $electionId)->orderBy('order_id', 'desc')->first();

        return view('electionresults::figures', $data);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'election_result_id' => 'required|numeric',
            'figure_name' => 'required|string',
            'symbol_name' => 'required|string',
            'total_vote' => 'nullable|numeric',
            'total_leads' => 'nullable|numeric',
            'total_wins' => 'nullable|numeric',
            'display_result' => 'nullable|numeric',
            'figure_photo' => 'nullable|image',
            'symbol_logo' => 'nullable|image',
            'status' => 'numeric|between:-1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $dataInfo = new ElectionResultFigures;
            $dataInfo->election_result_id = $request->election_result_id;
            $dataInfo->figure_name = $request->figure_name;
            $dataInfo->symbol_name = $request->symbol_name;
            $dataInfo->total_vote = $request->total_vote;
            $dataInfo->total_leads = $request->total_leads;
            $dataInfo->total_wins = $request->total_wins;
            $dataInfo->display_result = $request->display_result;
            $dataInfo->order_id = $this->orderID();
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->created_by = Auth::user()->id;
            $dataInfo->created_at = date('Y-m-d H:i:s');

            if(!empty($request->figure_photo)){
                if(!is_null($request->file('figure_photo'))){
                    $image = $request->file('figure_photo');
                    $fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
                    $savingPath = env('UploadsFolderPath').'elections/';
                    Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);
                    $dataInfo->figure_photo = $fileName;
                }
            }

            if(!empty($request->symbol_logo)){
                if(!is_null($request->file('symbol_logo'))){
                    $image = $request->file('symbol_logo');
                    $fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
                    $savingPath = env('UploadsFolderPath').'elections/';
                    Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);
                    $dataInfo->symbol_logo = $fileName;
                }
            }

            $dataInfo->save();

            DB::commit();

            return redirect()->back()->with('success_message', 'Election Figure has been created successfully!.');

        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error_message', 'Failed to create Election Figure!.');
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
            'election_result_id' => 'required|numeric',
            'figure_name' => 'required|string',
            'symbol_name' => 'required|string',
            'total_vote' => 'nullable|numeric',
            'total_leads' => 'nullable|numeric',
            'total_wins' => 'nullable|numeric',
            'display_result' => 'nullable|numeric',
            'figure_photo' => 'nullable|image',
            'symbol_logo' => 'nullable|image',
            'status' => 'numeric|between:-1,2',
            'id' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $dataInfo = ElectionResultFigures::find($request->id);
            $dataInfo->election_result_id = $request->election_result_id;
            $dataInfo->figure_name = $request->figure_name;
            $dataInfo->symbol_name = $request->symbol_name;
            $dataInfo->total_vote = $request->total_vote;
            $dataInfo->total_leads = $request->total_leads;
            $dataInfo->total_wins = $request->total_wins;
            $dataInfo->display_result = $request->display_result;
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');

            if(!empty($request->figure_photo)){
                if(!is_null($request->file('figure_photo'))){
                    $image = $request->file('figure_photo');
                    $fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
                    $savingPath = env('UploadsFolderPath').'elections/';
                    Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);
                    $dataInfo->figure_photo = $fileName;
                }
            }

            if(!empty($request->symbol_logo)){
                if(!is_null($request->file('symbol_logo'))){
                    $image = $request->file('symbol_logo');
                    $fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
                    $savingPath = env('UploadsFolderPath').'elections/';
                    Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);
                    $dataInfo->symbol_logo = $fileName;
                }
            }

            $dataInfo->save();

            DB::commit();

            return redirect()->back()->with('success_message', 'Election Figure has been updated successfully!.');

        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error_message', 'Failed to update Election Figure!.');
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
            $dataInfo = ElectionResultFigures::find($id);
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
                    $dataInfo = ElectionResultFigures::find($id);
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
                    $dataInfo = ElectionResultFigures::find($id);
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
        $orderIDInfo = ElectionResultFigures::orderBy('order_id', 'desc')->first();
        if(!empty($orderIDInfo)){
            $orderID = $orderIDInfo->order_id+1;
        }else{
            $orderID = 1;
        }
        return $orderID;
    }

}
