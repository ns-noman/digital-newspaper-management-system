<?php

namespace Modules\Location\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\CacheControlls\Http\Controllers\CacheControllsController;
use DB;
use Auth;
use Session;
use Validator;
use App\Models\Locations;

class LocationController extends Controller
{

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

        $data['lists'] = Locations::whereIn('status', [1,2])
        ->when(isset($_GET['title']) && !empty($_GET['title']), function ($query) {
            $query->where('title', 'like', '%'.$_GET['title'].'%');
        })
        ->orderBy('id', 'asc')->simplePaginate($paginationAmount);

        $data['divisions'] = Locations::where([['type','division'],['status', 1]])->orderBy('id', 'asc')->get();

        return view('location::index', $data);
    }

    # districts by division
    public function ajaxGetDistricts($division)
    {
        $districts = DB::table('locations')->where('type', 'district')->where('division', $division)->where('status', 1)->orderBy('title', 'asc')->get();
        return $districts;
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'display_name' => 'required',
            'division_id' => 'numeric|nullable',
            'district_id' => 'numeric|nullable',
            'type' => 'numeric|between:1,3',
            'status' => 'numeric|between:-1,2',
        ]);


        if ($validator->fails()) {
            return redirect()->route('Location')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{

            if($request->type == 1) { $location_type = 'division';} elseif($request->type == 2){ $location_type = 'district';} elseif($request->type == 3){$location_type = 'upazila';} else{$location_type = Null;}


            DB::beginTransaction();

            $dataInfo = new Locations;
            $dataInfo->title = $request->title;
            $dataInfo->display_name = $request->display_name;
            $dataInfo->type = $location_type;
            $dataInfo->division = ($request->type == 2) ? $request->division_id : (($request->type == 3)  ? $request->division_id : Null);
            $dataInfo->district = $request->type == 3 ?  $request->district_id :Null;
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->created_by = Auth::user()->id;
            $dataInfo->created_at = date('Y-m-d H:i:s');
            $dataInfo->save();

            DB::commit();

            return redirect()->route('Location')->with('success_message', 'Location has been created successfully!.');

        }catch(Exception $e){
            DB::rollback();
            return redirect()->route('Location')->with('error_message', 'Failed to create Location!.');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'display_name' => 'required',
            'division_id' => 'numeric|nullable',
            'district_id' => 'numeric|nullable',
            'type' => 'numeric|between:1,3',
            'status' => 'numeric|between:-1,2',
        ]);


        if ($validator->fails()) {
            return redirect()->route('Location')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{

            if($request->type == 1) { $location_type = 'division';} elseif($request->type == 2){ $location_type = 'district';} elseif($request->type == 3){$location_type = 'upazila';} else{$location_type = Null;}


            DB::beginTransaction();

            $dataInfo = Locations::find($request->id);
            $dataInfo->title = $request->title;
            $dataInfo->display_name = $request->display_name;
            $dataInfo->type = $location_type;
            $dataInfo->division = ($request->type == 2) ? $request->division_id : (($request->type == 3)  ? $request->division_id : Null);
            $dataInfo->district = $request->type == 3 ?  $request->district_id :Null;
            $dataInfo->status = $request->status;
            $dataInfo->created_by = Auth::user()->id;
            $dataInfo->created_at = date('Y-m-d H:i:s');
            $dataInfo->save();

            DB::commit();

            return redirect()->route('Location')->with('success_message', 'Authors has been updated successfully!.');

        }catch(Exception $e){
            DB::rollback();
            return redirect()->route('Location')->with('error_message', 'Failed to update authors!.');
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
            $dataInfo = Locations::find($id);
            $dataInfo->status = -1;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');
            $dataInfo->save();
            return redirect()->route('Location')->with('success_message', 'Success! Deleted Successfully.');
        }
        return redirect()->route('Location')->with('error_message', 'Alert! Error Deleting Data.');
    }

    public function bulkUpdate(Request $request)
    {
        if (isset($request->bulkStatus) && !empty($request->ids) && (count($request->ids)>0)) {

            foreach($request->ids as $key => $ids){
                $explode = explode(',', $ids);
                $id = $explode[0];
                $dataInfo = Locations::find($id);
                $dataInfo->status = $request->bulkStatus;
                $dataInfo->updated_by = Auth::user()->id;
                $dataInfo->updated_at = date('Y-m-d H:i:s');
                $dataInfo->save();

            }

            return redirect()->route('Location')->with('success_message', 'Success! Action Applied Successfully.');
        }
        return redirect()->route('Location')->with('error_message', 'Alert! Error Applying Action.');
    }


}
