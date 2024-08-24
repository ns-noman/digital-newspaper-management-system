<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicInfo extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'SiteName',
        'HomePageTitle',
        'MetaTag',
        'MetaDescription',
        'SiteBanner',
        'GoogleAnalytics',
        'Logo',
        'FavIcon',
        'SiteContact',
        'SiteEmail',
        'SiteFaceBook',
        'SiteTwitter',
        'SiteGooglePlus',
        'SiteYouTube',
        'Currency',
        'Address',
        'GoogleMap',
        'DefaultImage',
        'SiteLinkdin',
    ];
}
