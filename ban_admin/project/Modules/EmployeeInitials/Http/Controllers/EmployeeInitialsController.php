<?php

namespace Modules\EmployeeInitials\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\CacheControlls\Http\Controllers\CacheControllsController;
use DB;
use Auth;
use Session;
use Validator;
use App\Models\EmployeeInitials;
use App\Models\EmployeeInitialsType;

class EmployeeInitialsController extends Controller
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

        $data['lists'] = EmployeeInitials::whereIn('status', [1,2])
        ->when(isset($_GET['name']) && !empty($_GET['name']), function ($query) {
            $query->where('name', 'like', '%'.$_GET['name'].'%');
        })
        ->when(isset($_GET['inital']) && !empty($_GET['inital']), function ($query) {
            $query->where('inital', 'like', '%'.$_GET['inital'].'%');
        })
        ->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

        $data['types'] = EmployeeInitialsType::whereIn('status', [1,2])->orderBy('order_id', 'desc')->get();

        return view('employeeinitials::index', $data);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'initial' => 'required|string|unique:employee_initials,initial',
            'status' => 'numeric|between:-1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->route('EmployeeInitials')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $dataInfo = new EmployeeInitials;
            $dataInfo->name = $request->name;
            $dataInfo->initial = $request->initial;
            $dataInfo->order_id = $this->orderID();
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->created_by = Auth::user()->id;
            $dataInfo->created_at = date('Y-m-d H:i:s');
            $dataInfo->save();

            DB::commit();

            return redirect()->route('EmployeeInitials')->with('success_message', 'EmployeeInitial has been created successfully!.');

        }catch(Exception $e){
          DB::rollback();
          return redirect()->route('EmployeeInitials')->with('error_message', 'Failed to create EmployeeInitial!.');
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
            'name' => 'required|string',
            'initial' => 'required|string|unique:employee_initials,initial,'.$request->id,
            'status' => 'numeric|between:-1,2',
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('EmployeeInitials')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $id = $request->id;
            $dataInfo = EmployeeInitials::find($id);
            $dataInfo->name = $request->name;
            $dataInfo->initial = $request->initial;
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');
            $dataInfo->save();

            DB::commit();

            return redirect()->route('EmployeeInitials')->with('success_message', 'EmployeeInitial has been updated successfully!.');

        }catch(Exception $e){
          DB::rollback();
          return redirect()->route('EmployeeInitials')->with('error_message', 'Failed to update EmployeeInitial!.');
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
            $dataInfo = EmployeeInitials::find($id);
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
                    $dataInfo = EmployeeInitials::find($id);
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
                    $dataInfo = EmployeeInitials::find($id);
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
      $orderIDInfo = EmployeeInitials::orderBy('order_id', 'desc')->first();
      if(!empty($orderIDInfo)){
        $orderID = $orderIDInfo->order_id+1;
    }else{
        $orderID = 1;
    }
    return $orderID;
}

}
