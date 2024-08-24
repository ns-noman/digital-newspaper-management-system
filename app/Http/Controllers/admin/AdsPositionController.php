<?php

namespace App\Http\Controllers\admin;

use App\Models\AdsPosition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;


class AdsPositionController extends Controller
{
    public function index()
    {
        $adspositions = AdsPosition::orderBy('id', 'desc')->get();
        return view('admin.ads-positions.index', compact('adspositions'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = AdsPosition::find($id);
        }else{
            $data['title'] = 'Create';
        }
        return view('admin.ads-positions.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['UserID'] = Auth::guard('admin')->user()->id;
        AdsPosition::create($data);
        return redirect()->route('ads-positions.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $adsposition = AdsPosition::find($id);
        $adsposition->update($data);
        return redirect()->route('ads-positions.index')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy($id)
    {
        try {
            $adsposition = AdsPosition::findOrFail($id);
            if (1 > 3) {
                throw new \Exception('Cannot delete Ads Position with associated post!');
            }
            $adsposition->delete();
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
