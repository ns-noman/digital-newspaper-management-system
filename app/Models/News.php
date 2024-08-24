<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'NewsTitle',
        'TileUrl',
        'HomepageTitle',
        'ShareTitle',
        'DetailNews',
        'NewsShoulder',
        'NewsHanger',
        'NewsSummary',
        'Image',
        'MediumImage',
        'Thumbimage',
        'Image2',
        'MediumImage2',
        'Thumbimage2',
        'ImageTitle',
        'EntryDate',
        'Date',
        'UpdateTime',
        'IsActive',
        'UserID',
        'NewsCategoryID',
        'ParentCategoryID',
        'SubCategoryID',
        'Priority',
        'CategoryPriority',
        'SubCategoryPriority',
        'SelectedPriority',
        'IsEditorChoice',
        'EditorChoicePriority',
        'TopRightPriority',
        'CategoryName',
        'CategoryBngName',
        'NewsSource',
        'HasVideo',
        'TVID',
        'WriterID',
        'TagWord',
        'IsBreaking',
        'BreakingTime',
        'IsSeleted',
        'IsTop',
        'RelatedNews',
        'ImageShow',
        'ImageHomePage',
        'ReporterName',
        'ImageTag',
        'CaptionHeading',
        'DivisionID',
        'IsRecent',
        'TodaysCategory',
        'IsScroll',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'NewsCategoryID')->select('id','Caption','SEOCaption');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'UserID')->select('id','name');
    }
}
