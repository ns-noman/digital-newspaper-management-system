<?php

namespace Modules\Users\Http\Controllers;

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
use App\Models\User;

class UsersController extends Controller
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

      $data['lists'] = User::whereIn('status', [1,2])
      ->when(isset($_GET['name']) && !empty($_GET['name']), function ($query) {
        $query->where('name', 'like', '%'.$_GET['name'].'%');
      })
      ->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

      return view('users::index', $data);
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
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string',
        'designation' => 'nullable|string',
        'department' => 'nullable|string',
        'mobile' => 'nullable|string',
        'joining_date' => 'nullable|date',
        'role' => 'required|string',
        'image' => 'nullable|image',
        'status' => 'numeric|between:-1,2',
      ]);

      if ($validator->fails()) {
        return redirect()->route('Users')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
      }

      try{
        DB::beginTransaction();

        $dataInfo = new User;
        $dataInfo->name = $request->name;
        $dataInfo->email = $request->email;
        $dataInfo->password = \Hash::make($request->password);
        $dataInfo->role = $request->role;
        $dataInfo->publish_permission = 1;
        $dataInfo->mobile = $request->mobile;
        $dataInfo->designation = $request->designation;
        $dataInfo->department = $request->department;
        $dataInfo->joining_date = $request->joining_date;
        $dataInfo->order_id = $this->orderID();
        $dataInfo->status = !empty($request->status) ? $request->status : -1;
        $dataInfo->created_by = Auth::user()->id;
        $dataInfo->created_at = date('Y-m-d H:i:s');

        if(!empty($request->image)){
          if(!is_null($request->file('image'))){
           $image = $request->file('image');
           $fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
           $savingPath = env('UploadsFolderPath').'users/';
           Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);

           $dataInfo->image = $fileName;
         }
       }

       $dataInfo->save();

       DB::commit();

       return redirect()->route('Users')->with('success_message', 'User has been created successfully!.');

     }catch(Exception $e){
      DB::rollback();
      return redirect()->route('Users')->with('error_message', 'Failed to create User!.');
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
        'email' => 'required|email|unique:users,email,'.$request->id,
        'password' => 'nullable|string',
        'designation' => 'nullable|string',
        'department' => 'nullable|string',
        'mobile' => 'nullable|string',
        'joining_date' => 'nullable|date',
        'role' => 'required|string',
        'image' => 'nullable|image',
        'status' => 'numeric|between:-1,2',
        'id' => 'required|numeric',
      ]);

      if ($validator->fails()) {
        return redirect()->route('Users')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
      }


      try{
        DB::beginTransaction();

        $dataInfo = User::find($request->id);
        $dataInfo->name = $request->name;
        $dataInfo->email = $request->email;
        if(!empty($request->password)){
          $dataInfo->password = \Hash::make($request->password);
        }
        $dataInfo->role = $request->role;
        $dataInfo->mobile = $request->mobile;
        $dataInfo->designation = $request->designation;
        $dataInfo->department = $request->department;
        $dataInfo->joining_date = $request->joining_date;
        $dataInfo->status = !empty($request->status) ? $request->status : -1;
        $dataInfo->updated_by = Auth::user()->id;
        $dataInfo->updated_at = date('Y-m-d H:i:s');

        if(!empty($request->image)){
          if(!is_null($request->file('image'))){
           $image = $request->file('image');
           $fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
           $savingPath = env('UploadsFolderPath').'users/';
           Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);

           $dataInfo->image = $fileName;
         }
       }

       $dataInfo->save();

       DB::commit();

       return redirect()->route('Users')->with('success_message', 'User has been updated successfully!.');

     }catch(Exception $e){
      DB::rollback();
      return redirect()->route('Users')->with('error_message', 'Failed to update User!.');
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
        $dataInfo = User::find($id);
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
            $dataInfo = User::find($id);
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
            $dataInfo = User::find($id);
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


    public function orderID()
    {
      $orderIDInfo = User::orderBy('order_id', 'desc')->first();
      if(!empty($orderIDInfo)){
        $orderID = $orderIDInfo->order_id+1;
      }else{
        $orderID = 1;
      }
      return $orderID;
    }


    public static function loggedinUserInfo()
    {
      $loggedinUserInfo = DB::table('users')->where('users.id', Auth::user()->id)->select('users.name', 'users.id', 'users.email','users.role', 'users.image', 'users.designation')->first();
      return $loggedinUserInfo;

    }


  }
