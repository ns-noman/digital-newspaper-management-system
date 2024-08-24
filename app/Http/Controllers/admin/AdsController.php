<?php

namespace App\Http\Controllers\admin;

use App\Models\Ads;
use App\Models\AdsPosition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;


class AdsController extends Controller
{
    public function index()
    {
        $ads = Ads::with('position')->orderBy('id', 'desc')->get();
        return view('admin.ads.index', compact('ads'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = Ads::find($id);
        }else{
            $data['title'] = 'Create';
        }
        $data['ads_positions'] = AdsPosition::get();
        return view('admin.ads.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['UserID'] = Auth::guard('admin')->user()->id;
        Ads::create($data);
        return redirect()->route('my-ads.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $ads = Ads::find($id);
        $ads->update($data);
        return redirect()->route('my-ads.index')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy($id)
    {
        try {
            $ads = Ads::findOrFail($id);
            if (1 > 3) {
                throw new \Exception('Cannot delete Ads Position with associated post!');
            }
            $ads->delete();
            return redirect()->back()->with('alert', [
                'messageType' => 'success',
                'message' => 'Ads Position deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'messageType' => 'warning',
                'message' => $e->getMessage()
            ]);
        }
    }

}
