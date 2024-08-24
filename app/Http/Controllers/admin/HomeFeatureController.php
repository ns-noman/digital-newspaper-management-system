<?php

namespace App\Http\Controllers\admin;

use App\Models\HomeFeature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;

class HomeFeatureController extends Controller
{
    public function index()
    {
        $homeFeatures = HomeFeature::orderBy('id','desc')->get();
        return view('admin.home-features.index', compact('homeFeatures'));
    }
    public function edit(HomeFeature $homeFeature)
    {
        return view('admin.home-features.edit', compact('homeFeature'));
    }
    public function update(Request $request, HomeFeature $homeFeature)
    {
        $data = $request->all();
        if(isset($data['feature_image'])){
            $fileName = 'feature-img-'. time().'.'. $data['feature_image']->getClientOriginalExtension();
            $data['feature_image']->move(public_path('uploads/home-feature'), $fileName);
            $data['feature_image'] = $fileName;
            $imagePath = public_path('uploads/home-feature/'.$homeFeature->feature_image);
            if($homeFeature->feature_image) unlink($imagePath);
        }
        $homeFeature->update($data);
        return redirect('admin/home-features')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
    }
}