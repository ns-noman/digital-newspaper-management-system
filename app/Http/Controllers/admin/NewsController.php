<?php

namespace App\Http\Controllers\admin;

use App\Models\News;
use App\Models\NewsDetails;
use App\Models\NewsInfo;
use App\Models\Category;
use App\Models\Reporter;
use App\Models\Writer;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Auth;


class NewsController extends Controller
{
    public function index()
    {
        $news = News::select(['id','NewsTitle','Date','ReporterName'])->with(['category','admin'])->orderBy('id','desc')->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = News::find($id);
        }else{
            $data['title'] = 'Create';
        }
        $data['categories'] = Category::where('ParentID', 0)->orderBy('Caption','asc')->get();
        $data['todaylist'] = Category::where('ParentID', 1)->orderBy('Priority','asc')->get();
        $data['tags'] = Tag::orderBy('Caption','asc')->get();
        $data['reporters'] = Reporter::where('IsActive', 1)->orderBy('ReporterName','asc')->get();
        $data['writers'] = Writer::where('IsActive', 1)->orderBy('WriterName','asc')->get();
        return view('admin.news.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['UserID'] = Auth::guard('admin')->user()->id;
        $data['NewsCategoryID'] =  $data['SubCategoryID'] ? $data['SubCategoryID'] : $data['ParentCategoryID'];
        $data['TileUrl'] = $data['NewsTitle'];
        $data['CategoryName'] = Category::find($data['NewsCategoryID'])->SEOCaption;
        $data['CategoryBngName'] = Category::find($data['NewsCategoryID'])->Caption;
        $data['RelatedNews'] =  (isset($_POST["RelatedNews"]) && !empty($_POST["RelatedNews"])) ?  implode(",", $_POST["RelatedNews"]) : "";
        $data["Priority"] = $data["IsTop"] == 1 ? $request->Priority : 15;
        $data["DivisionID"] = empty($data["DivisionID"]) ? 0 : $data["DivisionID"];
        $data["WriterID"] = empty($data["WriterID"]) ? 0 : $data["WriterID"];
        $data["SelectedPriority"] = $data["IsSeleted"] == 1 ? $request->SelectedPriority : 13;
        $data["EditorChoicePriority"] = $data["IsEditorChoice"] == 1 ? $request->EditorChoicePriority : 13;
        $data['TagWord'] = (isset($_POST["TagWord"]) && !empty($_POST["TagWord"])) ?  implode(",", $_POST["TagWord"]) : "";

        if (strlen(trim($data["NewsSummary"])) < 1) $data["NewsSummary"] = (strlen(trim($data['DetailNews'])) > 1) ?  Str::words(strip_tags($data['DetailNews']),25,'...') : "";

        $images = $this->processImage($data['Image']);
        $data['Image'] = $images['Image'];
        $data['MediumImage'] = $images['MediumImage'];
        $data['Thumbimage'] = $images['Thumbimage'];

        $news = News::create($data);
        $newsDetails = ["NewsID" => $news->id, "Detail" => $data['DetailNews']];
        NewsDetails::create($newsDetails);
        $newsInfo = ["NewsID" => $news->id, 'Date' => $data['Date'], "NewsCategoryID" => $data['NewsCategoryID'], "NewsTitle" => $data['NewsTitle'], "TileUrl" => $data['TileUrl']];
        NewsInfo::create($newsInfo);
        return redirect()->route('news.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, $id)
    {
        $news = News::find($id);
        $data = $request->all();
        $data['UserID'] = Auth::guard('admin')->user()->id;
        $data['NewsCategoryID'] =  $data['SubCategoryID'] ? $data['SubCategoryID'] : $data['ParentCategoryID'];
        $data['TileUrl'] = $data['NewsTitle'];
        $data['CategoryName'] = Category::find($data['NewsCategoryID'])->SEOCaption;
        $data['CategoryBngName'] = Category::find($data['NewsCategoryID'])->Caption;
        $data['RelatedNews'] =  (isset($_POST["RelatedNews"]) && !empty($_POST["RelatedNews"])) ?  implode(",", $_POST["RelatedNews"]) : "";
        $data["Priority"] = $data["IsTop"] == 1 ? $request->Priority : 15;
        $data["DivisionID"] = empty($data["DivisionID"]) ? 0 : $data["DivisionID"];
        $data["WriterID"] = empty($data["WriterID"]) ? 0 : $data["WriterID"];
        $data["SelectedPriority"] = $data["IsSeleted"] == 1 ? $request->SelectedPriority : 13;
        $data["EditorChoicePriority"] = $data["IsEditorChoice"] == 1 ? $request->EditorChoicePriority : 13;
        $data['TagWord'] = (isset($_POST["TagWord"]) && !empty($_POST["TagWord"])) ?  implode(",", $_POST["TagWord"]) : "";
        if (strlen(trim($data["NewsSummary"])) < 1) $data["NewsSummary"] = (strlen(trim($data['DetailNews'])) > 1) ?  Str::words(strip_tags($data['DetailNews']),25,'...') : "";
        if(isset($data['Image'])){
            unlink(public_path('uploads/news/'.$news->Image));
            unlink(public_path('uploads/news/'.$news->MediumImage));
            unlink(public_path('uploads/news/'.$news->Thumbimage));
            $images = $this->processImage($data['Image']);
            $data['Image'] = $images['Image'];
            $data['MediumImage'] = $images['MediumImage'];
            $data['Thumbimage'] = $images['Thumbimage'];
        }
        $news->update($data);
        $newsDetails = ["Detail" => $data['DetailNews']];
        NewsDetails::where(["NewsID" => $news->id])->update($newsDetails);
        $newsInfo = ['Date' => $data['Date'], "NewsCategoryID" => $data['NewsCategoryID'], "NewsTitle" => $data['NewsTitle'], "TileUrl" => $data['TileUrl']];
        NewsInfo::where(["NewsID" => $news->id])->update($newsInfo);
        return redirect()->route('news.index')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy($id)
    {
        // try {
        //     $news = News::findOrFail($id);
        //     if (1 > 3) {
        //         throw new \Exception('Cannot delete news with associated post!');
        //     }
        //     if($news->Image){
        //         unlink(public_path('uploads/news/'.$news->Image));
        //         unlink(public_path('uploads/news/'.$news->MediumImage));
        //         unlink(public_path('uploads/news/'.$news->Thumbimage));
        //     }
        //     $news->delete();
        //     NewsDetails::where(["NewsID" => $news->id])->delete();
        //     NewsInfo::where(["NewsID" => $news->id])->delete();
        //     return redirect()->back()->with('alert', [
        //         'messageType' => 'success',
        //         'message' => 'News Deleted Successfully!'
        //     ]);
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('alert', [
        //         'messageType' => 'warning',
        //         'message' => $e->getMessage()
        //     ]);
        // }
    }
    public function relatedNews(Request $request)
    {
        $query = News::where('NewsTitle', 'LIKE', "%{$request->search}%")->select(['id', 'NewsTitle as text', 'Thumbimage as thumbimage', 'Date as date'])->paginate(10, ['*'], 'page', $request->page);
        return response()->json(['items' => $query->items(),'pagination' => ['more' => $query->hasMorePages()]]);
    }
    function processImage($originalImage)
    {
        $folder = date("Ym");
        $image = time() . '1.' . $originalImage->getClientOriginalExtension();
        $mediumFileName = time() . '2.' . $originalImage->getClientOriginalExtension();
        $thumbFileName = time() . '3.' . $originalImage->getClientOriginalExtension();
        $dst = public_path('uploads/news/img/article/'.$folder);
        $srcImage = $dst.'/'.$image;

        $dstImage = $dst.'/'.$image;
        $dstMedium = $dst.'/'.$mediumFileName;
        $dstThumb = $dst.'/'.$thumbFileName;

        $ImageName = 'img/article/'.$folder.'/'.$image;
        $MediumName = 'img/article/'.$folder.'/'.$mediumFileName;
        $ThumbName = 'img/article/'.$folder.'/'.$thumbFileName;

        $originalImage->move($dst, $image);
        Image::load($srcImage)
            ->width(840)
            ->height(650)
            ->crop(Manipulations::CROP_CENTER, 840, 650)
            ->save($dstImage);
        
        Image::load($srcImage)
            ->width(600)
            ->height(400)
            ->crop(Manipulations::CROP_CENTER, 600, 400)
            ->save($dstMedium);
          
        Image::load($srcImage)
            ->width(300)
            ->height(200)
            ->crop(Manipulations::CROP_CENTER, 300, 200)
            ->save($dstThumb);

        return [
            'Image' => $ImageName,
            'MediumImage' => $MediumName,
            'Thumbimage' => $ThumbName,
        ];
    }

}
