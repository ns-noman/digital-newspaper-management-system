<?php

namespace App\Http\Controllers\admin;

use App\Models\BasicInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class BasicInfoController extends Controller
{
    public function index()
    {
        $basicInfo = BasicInfo::first();
        return view('admin.basic-infos.index', compact('basicInfo'));
    }

    public function edit($id)
    {
        $basicInfo = BasicInfo::find($id);
        return view('admin.basic-infos.edit', compact('basicInfo'));
    }

    public function update(Request $request, $id)
    {
        $basicInfo = BasicInfo::find($id);
        $data = $request->all();
        if(isset($data['Logo'])){
            $fileName = 'logo-'. time().'.'. $data['Logo']->getClientOriginalExtension();
            $data['Logo']->move(public_path('uploads/basic-info'), $fileName);
            $data['Logo'] = $fileName;

            $imagePath = public_path('uploads/basic-info/'.$basicInfo->logo);
            if($basicInfo->logo) unlink($imagePath);

        }else unset($data['Logo']);

        if(isset($data['FavIcon'])){
            $fileName = 'favIcon-'. time().'.'. $data['FavIcon']->getClientOriginalExtension();
            $data['FavIcon']->move(public_path('uploads/basic-info/'), $fileName);
            $data['FavIcon'] = $fileName;

            $imagePath = public_path('uploads/basic-info/'.$basicInfo->favIcon);
            if($basicInfo->favIcon) unlink($imagePath);

        }else unset($data['FavIcon']);

        if(isset($data['SiteBanner'])){
            $fileName = 'sb-'. time().'.'. $data['SiteBanner']->getClientOriginalExtension();
            $data['SiteBanner']->move(public_path('uploads/basic-info'), $fileName);
            $data['SiteBanner'] = $fileName;

            $imagePath = public_path('uploads/basic-info/'.$basicInfo->SiteBanner);
            if($basicInfo->SiteBanner) unlink($imagePath);

        }else unset($data['SiteBanner']);

        $basicInfo->update($data);
        return redirect()->route('basic-infos.index')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);

    }

}