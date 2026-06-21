<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Auth;
use DB;

class Helper extends Model
{
	use HasFactory;


	static function processArticleShortly($articleData, $summaryWordCount=Null, $headlineCount = 200){
		$articleInfo = new \stdClass();
		$articleInfo->id = $articleData->id;
		$articleInfo->shoulder = $articleData->shoulder;
		$articleInfo->hanger = $articleData->hanger;
		$articleInfo->headline = $articleData->headline;
		$articleInfo->headline2 = ($articleData->liveupdate_status == 1 ? '<span class="shoulder"><img src="'.asset('assets/images/liveicon.gif').'" alt="Live Icon" class="liveIconGif"> লাইভ <i class="fa fa-circle dot"></i> </span>' : '').mb_strimwidth($articleData->headline, 0, $headlineCount, '..');
		$articleInfo->fullheadline = ($articleData->liveupdate_status == 1 ? '<span class="shoulder"><img src="'.asset('assets/images/liveicon.gif').'" alt="Live Icon" class="liveIconGif"> লাইভ <i class="fa fa-circle dot"></i> </span>' : '').($articleData->shoulder ? '<span class="shoulder">'.$articleData->shoulder.'</span> <i class="fa fa-circle dot"></i> ' : '').$articleData->headline;
		$articleInfo->fullheadline2 = ($articleData->liveupdate_status == 1 ? '<span class="shoulder"><img src="'.asset('assets/images/liveicon.gif').'" alt="Live Icon" class="liveIconGif"> লাইভ <i class="fa fa-circle dot"></i> </span>' : '').($articleData->shoulder ? '<span class="shoulder">'.$articleData->shoulder.'</span> <i class="fa fa-circle dot"></i> ' : '').mb_strimwidth($articleData->headline, 0, $headlineCount-mb_strlen($articleData->shoulder, 'UTF-8'), '..');

		$articleInfo->headline_color = $articleData->headline_color;
		if(!empty($articleData->headline_color)){
			$articleInfo->headline2 = '<span style="color:'.$articleData->headline_color.' !important">'.$articleInfo->headline2.'</span>';
			$articleInfo->fullheadline = '<span style="color:'.$articleData->headline_color.' !important">'.$articleInfo->fullheadline.'</span>';
			$articleInfo->fullheadline2 = '<span style="color:'.$articleData->headline_color.' !important">'.$articleInfo->fullheadline2.'</span>';
		}

		$articleInfo->keywords = !empty($articleData->keywords) ? $articleData->keywords : Null;
		$articleInfo->reporter = $articleData->reporter;
		$articleInfo->video_code = $articleData->video_code;
		$articleInfo->excerpt = $articleData->excerpt;
		$articleInfo->news_type = $articleData->news_type;
		$articleInfo->liveupdate_status = $articleData->liveupdate_status;
		$articleInfo->assetLink = $articleData->id <= env('Old_NewsId') ? env('Old_AssetLink').date('/Y/m/d/', strtotime($articleData->created_at)) : env('New_AssetLink').date('/Y/m/d/', strtotime($articleData->created_at));

		# time
		$articleInfo->created_at = $articleData->created_at;
		$articleInfo->updated_at = $articleData->updated_at;
		// $articleInfo->publishTime = \App\Http\Controllers\CommonController::getTimeDifference(date('Y-m-d H:i:s', strtotime($articleData->created_at)));
		$articleInfo->publishTime = \App\Http\Controllers\CommonController::GetBangla(date('d M Y, H:i', strtotime($articleData->created_at)));
		$articleInfo->publishDateTime = \App\Http\Controllers\CommonController::GetBangla(date('d M Y, H:i', strtotime($articleData->created_at)));
		if(!empty($articleData->updated_at)){
			$articleInfo->updateTime = \App\Http\Controllers\CommonController::getTimeDifference(date('Y-m-d, H:i:s', strtotime($articleData->updated_at)));
			$articleInfo->updateDateTime = \App\Http\Controllers\CommonController::GetBangla(date('d M Y, H:i', strtotime($articleData->updated_at)));
		}

		# category info
		$articleInfo->categoryIcon = !empty($articleData->icon) ? $articleData->icon : Null;
		$articleInfo->categoryName = $articleData->display_name;
		$articleInfo->categoryTitle = $articleData->title;

		# article url
		$articleInfo->url = !empty($articleData->urlCategoryTitle) ? url($articleData->urlCategoryTitle.'/'.$articleData->id) : '#';

		# summary
		if($summaryWordCount != 0){
			$pieces = explode(" ", strip_tags($articleData->excerpt), $summaryWordCount+1); 
			$articleInfo->summary = implode(" ", array_splice($pieces, 0, $summaryWordCount))." ...";
		}

		#thumbnail
		$articleInfo->thumb = env('UploadsLink').'uploads/settings/thumbnail.jpg';
		$articleInfo->thumbMedium = env('UploadsLink').'uploads/settings/thumbnailmedium.jpg';
		$articleInfo->thumbSmall = env('UploadsLink').'uploads/settings/thumbnailsmall.jpg';
		if(!empty($articleData->thumbnail)){
			$articleInfo->thumb = $articleInfo->assetLink.$articleData->thumbnail;
			$articleInfo->thumbMedium = $articleInfo->thumb;
			$articleInfo->thumbSmall = $articleInfo->thumb;
			if($articleData->id > env('Old_NewsId')){
				$articleInfo->thumbMedium = $articleInfo->assetLink.'medium/'.$articleData->thumbnail;
				$articleInfo->thumbSmall = $articleInfo->assetLink.'small/'.$articleData->thumbnail;
			}
		}

		#thumbnail2
		$articleInfo->thumb2 = Null;
		if(!empty($articleData->thumbnail2)){
			$articleInfo->thumb2 = $articleInfo->assetLink.$articleData->thumbnail2;
		}

		return $articleInfo;
	}



	static function processArticle($articleData, $summaryWordCount=Null, $headlineCount = 200){

		$articleInfo = new \stdClass();
		$articleInfo->id = $articleData->id;
		$articleInfo->shoulder = $articleData->shoulder;
		$articleInfo->hanger = $articleData->hanger;
		$articleInfo->headline = $articleData->headline;
		$articleInfo->headline2 = ($articleData->liveupdate_status == 1 ? '<span class="shoulder"><img src="'.asset('assets/images/liveicon.gif').'" alt="Live Icon" class="liveIconGif"> লাইভ <i class="fa fa-circle dot"></i> </span>' : '').mb_strimwidth($articleData->headline, 0, $headlineCount, '..');
		$articleInfo->fullheadline = ($articleData->liveupdate_status == 1 ? '<span class="shoulder"><img src="'.asset('assets/images/liveicon.gif').'" alt="Live Icon" class="liveIconGif"> লাইভ <i class="fa fa-circle dot"></i> </span>' : '').($articleData->shoulder ? '<span class="shoulder">'.$articleData->shoulder.'</span> <i class="fa fa-circle dot"></i> ' : '').$articleData->headline;
		$articleInfo->fullheadline2 = ($articleData->liveupdate_status == 1 ? '<span class="shoulder"><img src="'.asset('assets/images/liveicon.gif').'" alt="Live Icon" class="liveIconGif"> লাইভ <i class="fa fa-circle dot"></i> </span>' : '').($articleData->shoulder ? '<span class="shoulder">'.$articleData->shoulder.'</span> <i class="fa fa-circle dot"></i> ' : '').mb_strimwidth($articleData->headline, 0, $headlineCount-mb_strlen($articleData->shoulder, 'UTF-8'), '..');

		$articleInfo->headline_color = $articleData->headline_color;
		if(!empty($articleData->headline_color)){
			$articleInfo->headline2 = '<span style="color:'.$articleData->headline_color.' !important">'.$articleInfo->headline2.'</span>';
			$articleInfo->fullheadline = '<span style="color:'.$articleData->headline_color.' !important">'.$articleInfo->fullheadline.'</span>';
			$articleInfo->fullheadline2 = '<span style="color:'.$articleData->headline_color.' !important">'.$articleInfo->fullheadline2.'</span>';
		}

		$articleInfo->noindex = $articleData->noindex;
		$articleInfo->reporter = $articleData->reporter;
		$articleInfo->video_code = $articleData->video_code;
		$articleInfo->audio_code = $articleData->audio_code;
		$articleInfo->excerpt = $articleData->excerpt;
		$articleInfo->description = $articleData->description;
		$articleInfo->socialheadline = $articleData->headline2 ? $articleData->headline2 : $articleData->headline;
		$articleInfo->keywords = $articleData->keywords;
		$articleInfo->tags = $articleData->tags;
		$articleInfo->news_type = $articleData->news_type;
		$articleInfo->assetLink = $articleData->id <= env('Old_NewsId') ? env('Old_AssetLink').date('/Y/m/d/', strtotime($articleData->created_at)) : env('New_AssetLink').date('/Y/m/d/', strtotime($articleData->created_at));

		# time
		$articleInfo->show_updatetime = $articleData->show_updatetime;
		$articleInfo->created_at = $articleData->created_at;
		$articleInfo->updated_at = $articleData->updated_at;
		$articleInfo->publishTime = \App\Http\Controllers\CommonController::getTimeDifference(date('Y-m-d H:i:s', strtotime($articleData->created_at)));
		$articleInfo->publishDateTime = \App\Http\Controllers\CommonController::GetBangla(date('d M Y, H:i', strtotime($articleData->created_at)));
		if(!empty($articleData->updated_at)){
			$articleInfo->updateTime = \App\Http\Controllers\CommonController::getTimeDifference(date('Y-m-d, H:i:s', strtotime($articleData->updated_at)));
			$articleInfo->updateDateTime = \App\Http\Controllers\CommonController::GetBangla(date('d M Y, H:i', strtotime($articleData->updated_at)));
		}

		# category info
		$articleInfo->categoryIcon = !empty($articleData->articleUrlCategory) ? $articleData->articleUrlCategory->icon : Null;
		$articleInfo->categoryName = !empty($articleData->articleUrlCategory) ? $articleData->articleUrlCategory->display_name : Null;
		$articleInfo->categoryTitle = !empty($articleData->articleUrlCategory) ? $articleData->articleUrlCategory->title : Null;

		# article url
		$articleInfo->url = !empty($articleInfo->categoryTitle) ? url($articleInfo->categoryTitle.'/'.$articleData->id) : '#';

		# summary
		if($summaryWordCount != 0){
			$pieces = explode(" ", strip_tags($articleData->excerpt), $summaryWordCount+1); 
			$articleInfo->summary = implode(" ", array_splice($pieces, 0, $summaryWordCount))." ...";
		}

		#thumbnail
		$articleInfo->thumb = env('UploadsLink').'uploads/settings/thumbnail.jpg';
		$articleInfo->thumbMedium = env('UploadsLink').'uploads/settings/thumbnailmedium.jpg';
		$articleInfo->thumbSmall = env('UploadsLink').'uploads/settings/thumbnailsmall.jpg';
		if(!empty($articleData->thumbnail)){
			$articleInfo->thumb = $articleInfo->assetLink.$articleData->thumbnail;
			$articleInfo->thumbMedium = $articleInfo->thumb;
			$articleInfo->thumbSmall = $articleInfo->thumb;
			if($articleData->id > env('Old_NewsId')){
				$articleInfo->thumbMedium = $articleInfo->assetLink.'medium/'.$articleData->thumbnail;
				$articleInfo->thumbSmall = $articleInfo->assetLink.'small/'.$articleData->thumbnail;
			}
		}

		#socialthumb
		$articleInfo->socialthumb = $articleInfo->thumb;
		if(!empty($articleData->social_thumbnail)){
			$articleInfo->socialthumb = $articleInfo->assetLink.'social-thumbnail/'.$articleData->thumbnail;
		}

		#thumbnail2
		$articleInfo->thumb2 = Null;
		if(!empty($articleData->thumbnail2)){
			$articleInfo->thumb2 = $articleInfo->assetLink.$articleData->thumbnail2;
		}

		#documents
		if(isset($articleData->document_file)){
			$files = unserialize($articleData->document_file);
			$fileSrc = Null;
			if (!empty($files) && (count($files)>0)) {
				foreach ($files as $key => $file) {
					$fileLoc = $articleInfo->assetLink.'files/'.$file['document_file'];
					$fileSrc[] = [
						'fileSrc' => $fileLoc,
						'fileCaption' => $file['filecaption'],
					];
				}
			}
			$articleInfo->fileSrc = $fileSrc;
		}
		
		#author
		$articleInfo->authors = Null;
		$articleAuthors = ArticleAuthors::where('article_id', $articleData->id)->get();
		if(!empty($articleAuthors) && count($articleAuthors)>0){
			foreach ($articleAuthors as $key => $articleAuthor) {
				$articleInfo->authors[] = \App\Models\Helper::processAuthor($articleAuthor->authorInfo);
			}
		}

		#incident
		$articleInfo->incidentInfo = Null;
		$articleInfo->incident_id = $articleData->incident_id;
		if(!empty($articleData->incident_id)){
			$articleInfo->incidentInfo = $articleData->incidentInfo;
		}

		#liveupdate
		$articleInfo->liveupdateNews = Null;
		$articleInfo->liveupdate_status = $articleData->liveupdate_status;
		if(!empty($articleData->liveupdate_status)){
			$articleInfo->liveupdateNews = $articleData->liveupdateNews;
		}

		#paid news
		$articleInfo->customerSubscribedList = Null;
		$articleInfo->paidnews_status = $articleData->paidnews_status;
		if($articleInfo->paidnews_status == 1 && Auth::check()){
			$articleInfo->customerSubscribedList = DB::table('customer_subscribed_news')->where('article_id', $articleInfo->id)->where('customer_id', Auth::user()->id)->first();
		}

		#news topic
		$articleInfo->topics = $articleData->articleTopics;

		return $articleInfo;
	}


	static function processAuthor($authorData){
		$authorInfo = new \stdClass();
		$authorInfo->id = $authorData->id;
		$authorInfo->author_name = $authorData->author_name;
		$authorInfo->author_name_en = $authorData->author_name_en;
		$authorInfo->author_slug = $authorData->author_slug;
		$authorInfo->author_photo = $authorData->author_photo;
		$authorInfo->author_photo_src = !empty($authorData->author_photo) ? env('UploadsLink').'uploads/authors/'.$authorData->author_photo : env('UploadsLink').'uploads/settings/default-icon.jpg';
		$authorInfo->author_email = $authorData->author_email;
		$authorInfo->author_phone = $authorData->author_phone;
		$authorInfo->author_address = $authorData->author_address;
		$authorInfo->author_about = $authorData->author_about;
		$authorInfo->type = $authorData->type;
		$authorInfo->url = url('author/'.$authorData->id.'/'.$authorData->author_slug);
		return $authorInfo;
	}


	static function processPoll($pollData){
		$pollInfo = new \stdClass();
		$pollInfo->id = $pollData->id;
		$pollInfo->image = $pollData->image;
		$pollInfo->question = $pollData->question;
		$pollInfo->url = url('poll/'.$pollInfo->id);

		$pollInfo->total_vote = $pollData->total_vote;
		$pollInfo->yes_vote = $pollData->yes_vote;
		$pollInfo->no_vote = $pollData->no_vote;
		$pollInfo->no_opinion = $pollData->no_opinion;
		$pollInfo->poll_date = $pollData->poll_date;
		$pollInfo->created_at = $pollData->created_at;
		$pollInfo->yes_vote_percent = $pollInfo->yes_vote != 0 ? number_format((($pollInfo->yes_vote * 100) / $pollInfo->total_vote), 0, '.', '') : 0;
		$pollInfo->no_vote_percent =  $pollInfo->no_vote != 0 ? number_format((($pollInfo->no_vote * 100) / $pollInfo->total_vote), 0, '.', '') :0;
		$pollInfo->no_opinion_vote_percent = $pollInfo->no_opinion != 0 ? number_format((($pollInfo->no_opinion * 100) / $pollInfo->total_vote), 0, '.', '') : 0;

		$pollInfo->total_vote_bangla = \App\Http\Controllers\CommonController::GetBangla($pollInfo->total_vote);
		$pollInfo->yes_vote_bangla = \App\Http\Controllers\CommonController::GetBangla($pollInfo->yes_vote);
		$pollInfo->no_vote_bangla = \App\Http\Controllers\CommonController::GetBangla($pollInfo->no_vote);
		$pollInfo->no_opinion_bangla = \App\Http\Controllers\CommonController::GetBangla($pollInfo->no_opinion);
		$pollInfo->poll_date_bangla = \App\Http\Controllers\CommonController::GetBangla(date('d M Y', strtotime($pollInfo->poll_date)));

		$pollInfo->yes_vote_percent_bangla = \App\Http\Controllers\CommonController::GetBangla($pollInfo->yes_vote_percent);
		$pollInfo->no_vote_percent_bangla = \App\Http\Controllers\CommonController::GetBangla($pollInfo->no_vote_percent);
		$pollInfo->no_opinion_vote_percent_bangla = \App\Http\Controllers\CommonController::GetBangla($pollInfo->no_opinion_vote_percent);

		return $pollInfo;
	}

	static function processPhotos($rowData){
		$newData = new \stdClass();
		$newData->id = $rowData->id;
		$newData->article_id = $rowData->article_id;
		$newData->image = $rowData->image;
		$newData->image_caption = !empty($rowData->image_caption) ? $rowData->image_caption : '';
		$newData->created_at = $rowData->created_at;
		$newData->publishDateTime = \App\Http\Controllers\CommonController::GetBangla(date('d M Y', strtotime($rowData->created_at)));
		$newData->photoLink = env('New_AssetLink').date('/Y/m/d/', strtotime($newData->created_at)).$newData->image;
		return $newData;
	}


	static function processPageInfo($settingsPageInfo){
		$pageInfo = new \stdClass();
		$pageInfo->id = $settingsPageInfo->id;
		$pageInfo->title = $settingsPageInfo->title;
		$pageInfo->meta_title = $settingsPageInfo->meta_title;
		$pageInfo->meta_descriptions = $settingsPageInfo->meta_descriptions;
		$pageInfo->meta_keywords = $settingsPageInfo->meta_keywords;
		$pageInfo->meta_image = $settingsPageInfo->meta_image;
		$pageInfo->meta_image_src = !empty($settingsPageInfo->meta_image) ? env('UploadsLink').'uploads/pages/'.$settingsPageInfo->meta_image : env('UploadsLink').'uploads/settings/thumbnail.jpg';
		$pageInfo->header_code = $settingsPageInfo->header_code;
		return $pageInfo;
	}


	static function GetBangla($text){
		$search_array= array("Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", ":", ",", "PM", "AM");
		$replace_array= array("শনিবার", "রবিবার", "সোমবার", "মঙ্গলবার", "বুধবার", "বৃহস্পতিবার", "শুক্রবার", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "জানুয়ারি", "ফেব্রুয়ারি", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", ":", ",", "পিএম", "এএম");
		$text = str_replace($search_array, $replace_array,$text);
		return $text;
	}


}
