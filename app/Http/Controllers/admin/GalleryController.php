<?php

namespace App\Http\Controllers\admin;

use App\Models\Gallery;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('id', 'desc')->get();
        return view('admin.galleries.index', compact('galleries'));
        // foreach ($galleries as $key => $gallery) {
        //     $oldImage = $gallery->Image;
        //     // $newImage = str_replace("img/","", $oldImage);
        //     $newImage = substr($oldImage, 14);
        //     // if($oldImage=="blank_face.png") $newImage = null;
        //     $gallery->update(["Image"=> $newImage]);
        // }
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = Gallery::find($id);
        }else{
            $data['title'] = 'Create';
        }
        $data['categories'] = Category::where('ParentID', 0)->orderBy('Caption','asc')->get();
        return view('admin.galleries.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $images = $this->processImage($data['Image']);
        $data['Image'] = $images['Image'];
        $data['MediumImage'] = $images['MediumImage'];
        $data['Thumbimage'] = $images['Thumbimage'];
        $data['CategoryName'] = Category::find($data['ParentCategoryID'])->Caption;

        $data['EntryDate'] = Date('Y-m-d h:i:s');
        if ($data['SubCategoryID']) {
            $data['NewsCategoryID'] = $data['SubCategoryID'];
        } else {
            $data['NewsCategoryID'] = $data['ParentCategoryID'];
        }
        $data['UserID'] = Auth::guard('admin')->user()->id;
        Gallery::create($data);
        return redirect()->route('galleries.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $gallery = Gallery::find($id);
        if($data['Image']){
            $images = $this->processImage($data['Image']);
            $data['Image'] = $images['Image'];
            $data['MediumImage'] = $images['MediumImage'];
            $data['Thumbimage'] = $images['Thumbimage'];
            unlink(public_path('uploads/galleries/'.$gallery->Image));
            unlink(public_path('uploads/galleries/'.$gallery->MediumImage));
            unlink(public_path('uploads/galleries/'.$gallery->Thumbimage));
        }
        $gallery->update($data);
        return redirect()->route('galleries.index')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);
            if (1 > 3) {
                throw new \Exception('Cannot delete galleries with associated post!');
            }
            if($gallery->Image) unlink(public_path('uploads/galleries/'.$gallery->Image));
            if($gallery->MediumImage) unlink(public_path('uploads/galleries/'.$gallery->MediumImage));
            if($gallery->Thumbimage) unlink(public_path('uploads/galleries/'.$gallery->Thumbimage));
            $gallery->delete();
            return redirect()->back()->with('alert', [
                'messageType' => 'success',
                'message' => 'galleries deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'messageType' => 'warning',
                'message' => $e->getMessage()
            ]);
        }
    }
    public function loadSubcategories($id)
    {
        $subcategories = Category::where('ParentID',$id)->orderBy('Caption','asc')->get();
        return response()->json($subcategories, 200);
    }

    function processImage($imageFile)
    {
        $fileName = 'glr-img-' . time() . '.' . $imageFile->getClientOriginalExtension();
        $thumbFileName = 'glr-thumb-' . time() . '.' . $imageFile->getClientOriginalExtension();
        $mediumFileName = 'glr-medium-' . time() . '.' . $imageFile->getClientOriginalExtension();

        $dst = public_path('uploads/galleries');//Destination

        // Move the original file to the destination directory
        $imageFile->move($dst, $fileName);

        // Resize and crop the images using Spatie Image

        // 1. Resize and crop the original image (620x415)
        Image::load($dst . '/' . $fileName)
            ->width(620)
            ->height(415)
            ->crop(Manipulations::CROP_CENTER, 620, 415)
            ->save($dst . '/' . $fileName);

        // 2. Create and save a thumbnail (100x70)
        Image::load($dst . '/' . $fileName)
            ->width(100)
            ->height(70)
            ->crop(Manipulations::CROP_CENTER, 100, 70)
            ->save($dst . '/' . $thumbFileName);

        // 3. Create and save a medium-sized image (400x276)
        Image::load($dst . '/' . $fileName)
            ->width(400)
            ->height(276)
            ->crop(Manipulations::CROP_CENTER, 400, 276)
            ->save($dst . '/' . $mediumFileName);

        // Return file names for further processing or database storage
        return [
            'Image' => $fileName,
            'MediumImage' => $mediumFileName,
            'Thumbimage' => $thumbFileName,
        ];
    }


}
