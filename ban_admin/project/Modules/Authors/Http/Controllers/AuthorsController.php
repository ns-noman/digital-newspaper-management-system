<?php

namespace Modules\Authors\Http\Controllers;

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
use App\Models\Authors;
use App\Models\Departments;

class AuthorsController extends Controller
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

        $data['lists'] = Authors::whereIn('status', [1,2])
        ->when(isset($_GET['author_name']) && !empty($_GET['author_name']), function ($query) {
            $query->where('author_name', 'like', '%'.$_GET['author_name'].'%');
        })
        ->when(isset($_GET['author_phone']) && !empty($_GET['author_phone']), function ($query) {
            $query->where('author_phone', $_GET['author_phone']);
        })
        ->when(isset($_GET['author_email']) && !empty($_GET['author_email']), function ($query) {
            $query->where('author_email', $_GET['author_email']);
        })
        ->when(isset($_GET['department_id']) && !empty($_GET['department_id']), function ($query) {
            $query->where('department_id', $_GET['department_id']);
        })
        ->when(isset($_GET['type']) && !empty($_GET['type']), function ($query) {
            $query->where('type', $_GET['type']);
        })
        ->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

        $data['departments'] = Departments::where('status', 1)->orderBy('order_id', 'desc')->get();

        return view('authors::index', $data);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'author_name' => 'required',
            'author_name_en' => 'required',
            'author_photo' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'author_about' => 'string|nullable',
            'author_email' => 'email|max:255|nullable',
            'author_phone' => 'string|nullable',
            'author_address' => 'string|nullable',
            'facebook' => 'string|nullable',
            'twitter' => 'string|nullable',
            'linkedin' => 'string|nullable',
            'department_id' => 'numeric|nullable',
            'type' => 'numeric|between:1,2',
            'status' => 'numeric|between:-1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->route('Authors')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $dataInfo = new Authors;
            $dataInfo->author_name = $request->author_name;
            $dataInfo->author_name_en = $request->author_name_en;
            $dataInfo->author_slug = $this->getSlug($request->author_name_en);
            $dataInfo->author_email = $request->author_email;
            $dataInfo->author_phone = $request->author_phone;
            $dataInfo->author_address = $request->author_address;
            $dataInfo->author_about = $request->author_about;
            $dataInfo->facebook = $request->facebook;
            $dataInfo->twitter = $request->twitter;
            $dataInfo->linkedin = $request->linkedin;
            $dataInfo->order_id = $this->orderID();
            $dataInfo->department_id = $request->type == 1 ? $request->department_id : Null;
            $dataInfo->type = $request->type;
            $dataInfo->status = !empty($request->status) ? $request->status : -1;
            $dataInfo->created_by = Auth::user()->id;
            $dataInfo->created_at = date('Y-m-d H:i:s');

            if (!empty($request->author_photo)) {
                $file = $request->file('author_photo');
                $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
                $savingPath = env('UploadsFolderPath').'authors/';
                Storage::disk(env('DISK'))->putFileAs($savingPath, $file, $file_name);

                $dataInfo->author_photo = $file_name;
            }

            $dataInfo->save();
            DB::commit();

            return redirect()->route('Authors')->with('success_message', 'Authors has been created successfully!.');

        }catch(Exception $e){
            DB::rollback();
            return redirect()->route('Authors')->with('error_message', 'Failed to create authors!.');
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
            'author_name' => 'required',
            'author_name_en' => 'required',
            'author_photo' => 'mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
            'author_about' => 'string|nullable',
            'author_email' => 'email|max:255|nullable',
            'author_phone' => 'string|nullable',
            'author_address' => 'string|nullable',
            'facebook' => 'string|nullable',
            'twitter' => 'string|nullable',
            'linkedin' => 'string|nullable',
            'department_id' => 'numeric|nullable',
            'type' => 'numeric|between:1,2',
            'status' => 'numeric|between:-1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->route('Authors')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $dataInfo = Authors::find($request->id);
            $dataInfo->author_name = $request->author_name;
            $dataInfo->author_name_en = $request->author_name_en;
            $dataInfo->author_slug = $this->getSlug($request->author_name_en);
            $dataInfo->author_email = $request->author_email;
            $dataInfo->author_phone = $request->author_phone;
            $dataInfo->author_address = $request->author_address;
            $dataInfo->author_about = $request->author_about;
            $dataInfo->facebook = $request->facebook;
            $dataInfo->twitter = $request->twitter;
            $dataInfo->linkedin = $request->linkedin;
            $dataInfo->department_id = $request->type == 1 ? $request->department_id : Null;
            $dataInfo->type = $request->type;
            $dataInfo->status = $request->status;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');

            if (!empty($request->author_photo)) {
                $file = $request->file('author_photo');
                $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
                $savingPath = env('UploadsFolderPath').'authors/';
                Storage::disk(env('DISK'))->putFileAs($savingPath, $file, $file_name);

                $dataInfo->author_photo = $file_name;
            }

            $dataInfo->save();
            DB::commit();

            return redirect()->route('Authors')->with('success_message', 'Authors has been updated successfully!.');

        }catch(Exception $e){
            DB::rollback();
            return redirect()->route('Authors')->with('error_message', 'Failed to update authors!.');
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
            $dataInfo = Authors::find($id);
            $dataInfo->status = -1;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');
            $dataInfo->save();
            return redirect()->route('Authors')->with('success_message', 'Success! Deleted Successfully.');
        }
        return redirect()->route('Authors')->with('error_message', 'Alert! Error Deleting Data.');
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
                    $dataInfo = Authors::find($id);
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
                    $dataInfo = Authors::find($id);
                    $dataInfo->status = $request->bulkStatus;
                    $dataInfo->updated_by = Auth::user()->id;
                    $dataInfo->updated_at = date('Y-m-d H:i:s');
                    $dataInfo->save();
                }
            }

            return redirect()->route('Authors')->with('success_message', 'Success! Action Applied Successfully.');
        }
        return redirect()->route('Authors')->with('error_message', 'Alert! Error Applying Action.');
    }


    public function orderID()
    {
      $orderIDInfo = Authors::orderBy('order_id', 'desc')->first();
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
