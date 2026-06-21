@extends('layouts.layout')
@push('meta-tag')
<title>{{$articleDetail->socialheadline}}</title>
<meta name="title" content="{{$articleDetail->socialheadline}}" />
<meta property="og:title" content="{{$articleDetail->socialheadline}}" />
<meta name="twitter:title" content="{{$articleDetail->socialheadline}}" />

@if(!empty($articleDetail->description))
<meta name="description" content="{{$articleDetail->description}}" />
<meta property="og:description" content="{{$articleDetail->description}}" />
<meta name="twitter:description" content="{{$articleDetail->description}}" />
@endif

<meta property="og:image" content="{!! $articleDetail->socialthumb !!}" />
<meta name="twitter:image" content="{!! $articleDetail->socialthumb !!}" />
<meta property="og:image:alt" content="{!! $articleDetail->headline !!}" />
<meta name="robots" content="max-image-preview:large">
<meta property="og:type" content="article" />
<meta name="robots" content="{!! !empty($articleDetail->noindex) && $articleDetail->noindex == 1 ? 'noindex, nofollow' : 'index, follow' !!}" />

@if(!empty($settingsInfo))
<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "NewsArticle",
		"url" : "{{$articleDetail->url}}",
		"mainEntityOfPage":{
		"@type":"WebPage",
		"name" : "{!! $articleDetail->socialheadline !!}",
		"@id":"{{$articleDetail->url}}"},
		"headline": "{!! $articleDetail->socialheadline !!}",
		"image": {
		"@type": "ImageObject",
		"url": "{{asset($articleDetail->socialthumb)}}"},
		"datePublished": "{{date('H:i A, d F Y, l', strtotime($articleDetail->created_at))}}",
		@if(!empty($articleDetail->updated_at))
		"dateModified": "{{date('H:i A, d F Y, l', strtotime($articleDetail->updated_at))}}",
		@endif
		"author": {
		"@type": "Person",
		"url": "{!! $settingsInfo->domain !!}",
		"name": "{!! !empty($articleDetail->reporter) ? $articleDetail->reporter : $settingsInfo->newspaper_name.' Desk' !!}"},
		"publisher": {
		"@type": "Organization",
		"name": "The Daily {!! $settingsInfo->newspaper_name !!}",
		"logo": {
		"@type": "ImageObject",
		"url": "{!! asset('uploads/settings/'.$settingsInfo->logo_1) !!}"}}
	}
</script>
@endif

@if(!empty($categoryInfo) && !empty($settingsInfo))
<script type="application/ld+json">
	{
		"@context":"http://schema.org",
		"@type":"BreadcrumbList",
		"itemListElement":[
		{
			"@type":"ListItem",
			"position":1,
			"item":{
			"@id":"{!! $settingsInfo->domain !!}",
			"name":"Home"}
		},
		{
			"@type":"ListItem",
			"position":2,
			"item":{
			"@id":"{{url($categoryInfo->title)}}",
			"name":"{!! $categoryInfo->display_name !!}"}
		},
		{
			"@type":"ListItem",
			"position":3,
			"item":{
			"name" : "{!! $articleDetail->socialheadline !!}",
			"@id":"{{$articleDetail->url}}"}
		}
		]
	}
</script>
@endif
@endpush

@push('adTags')
@endpush

@section('content')

<div class="visiblePrintDiv text-center borderC1B1 paddingB20" style="display: none;">
	<img src="{!! asset('uploads/settings/'.$settingsInfo->logo_1) !!}" alt="Logo" height="30">
</div>

<!-- desktop version start -->
<div class="bgWHite hidden-xs marginT30">
	<!-- article reached -->
	<div class="articleReached{{$detailCount}}" data-url="{{$articleDetail->url}}"></div>

	<!-- Ad Desktop Detail 1 -->
	@if(!empty($advPlacements[10]) && !empty($advPlacements[10]->activeOrder))
	<div class="container">
		<div class="adDiv borderRadius5 overflowHidden marginB20">
			@if($advPlacements[10]->activeOrder->ad_type == 2)
			{!! $advPlacements[10]->activeOrder->ad_code !!}
			@endif
			@if($advPlacements[10]->activeOrder->ad_type == 1)
			<a rel="sponsored" href="{{$advPlacements[10]->activeOrder->ad_url}}" target="_blank">
				<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[10]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
			</a>
			@endif
		</div>
	</div>
	@endif
	<!-- Ad Desktop Detail 1 -->
	

	<div class="container">
		<div class="row">

			<!-- title & time section -->
			<div class="col-md-12 col-lg-12">
				<div class="marginB20">
					@if($articleDetail->liveupdate_status == 1)
					<p class="desktopDetailCat marginB30 title11"><strong><span class="bgRed colorWhite borderRadius5 paddingTB5 paddingLR20 shadow1"><img src="{{asset('assets/images/liveicon.gif')}}" alt="Live Icon" class="liveIconGif marginT-2"> লাইভ</span></strong></p>
					@else
					<p class="desktopDetailCat marginB15"><a aria-label="{!! $articleDetail->categoryName !!}" href="{!! url($articleDetail->categoryTitle) !!}"><strong>{!! $articleDetail->categoryName !!}</strong></a></p>
					@endif
					@if(!empty($articleDetail->shoulder))
					<p class="desktopDetailShoulder marginT25">{!! $articleDetail->shoulder !!}</p>
					@endif
					<h1 class="desktopDetailHeadline marginT0" {!! !empty($articleDetail->headline_color) ? 'style="color: '.$articleDetail->headline_color.' !important"' : '' !!}><strong>{!! $articleDetail->headline !!}</strong></h1>
					@if(!empty($articleDetail->hanger))
					<p class="desktopDetailHanger">{!! $articleDetail->hanger !!}</p>
					@endif
				</div>

				<!-- time section -->
				<div class="row">
					<div class="col-sm-12 col-md-12 marginT10">

						<div class="displayInlineBlock" style="border-right: 3px solid #edebeb;padding-right: 20px;">
							<!-- multiple author -->
							@if(!empty($articleDetail->authors) && count($articleDetail->authors)>1)
							@foreach($articleDetail->authors as $key => $authorInfo)
							<p class="desktopDetailReporter borderC1-1 borderRadius5 paddingTB3 paddingLR5 marginR5 marginB5"><a href="{!! $authorInfo->url !!}" class="textDecorationNone colorBlue hoverBlack"><img src="{!! $authorInfo->author_photo_src !!}" class="img-responsive borderRadius50P displayInlineBlock" width="25" alt="{!! $authorInfo->author_name !!}"> <span class="displayInlineBlock verticalAlignMiddle">{!! $authorInfo->author_name !!}</span></a></p>
							@endforeach
							<p class="desktopDetailPTime color1 marginT5">প্রকাশ: {!! $articleDetail->publishDateTime !!}
								@if(($articleDetail->show_updatetime == 1) && !empty($articleDetail->updateDateTime))
								<span><i class="fa fa-grip-lines-vertical title1_4"></i> আপডেট: {!! $articleDetail->updateDateTime !!}</span>
								@endif
							</p>
							@if(!empty($articleDetail->news_type) && ($articleDetail->news_type == 2))
							<p class="desktopDetailPTime color1">প্রিন্ট সংস্করণ</p>
							@endif

							<!-- single author -->
							@elseif(!empty($articleDetail->authors) && count($articleDetail->authors) == 1)
							@php $authorInfo = $articleDetail->authors[0]; @endphp
							<div class="desktopDetailAuthorDiv">
								<a href="{!! $authorInfo->url !!}"><img src="{!! $authorInfo->author_photo_src !!}" class="img-responsive borderRadius50P" width="50"  alt="{!! $authorInfo->author_name !!}"></a>
							</div>
							<div class="displayInlineBlock">
								<p class="desktopDetailReporter"><a href="{!! $authorInfo->url !!}" class="textDecorationNone colorBlue hoverBlack">{!! $authorInfo->author_name !!}</a></p>
								<p class="desktopDetailPTime color1">প্রকাশ: {!! $articleDetail->publishDateTime !!}
									@if(($articleDetail->show_updatetime == 1) && !empty($articleDetail->updateDateTime))
									<span><i class="fa fa-grip-lines-vertical title1_4"></i> আপডেট: {!! $articleDetail->updateDateTime !!}</span>
									@endif
								</p>
								@if(!empty($articleDetail->news_type) && ($articleDetail->news_type == 2))
								<p class="desktopDetailPTime color1">প্রিন্ট সংস্করণ</p>
								@endif
							</div>

							<!-- no author -->
							@else
							<div class="desktopDetailAuthorDiv">
								<img src="{!! env('UploadsLink').'uploads/settings/'.$settingsInfo->icon_2 !!}" class="img-responsive borderRadius50P" width="50" alt="Icon">
							</div>
							<div class="displayInlineBlock">
								@if(!empty($articleDetail->reporter))
								<p class="desktopDetailReporter">{!! $articleDetail->reporter !!}</p>
								@endif
								<p class="desktopDetailPTime color1">প্রকাশ: {!! $articleDetail->publishDateTime !!}
									@if(($articleDetail->show_updatetime == 1) && !empty($articleDetail->updateDateTime))
									<span><i class="fa fa-grip-lines-vertical title1_4"></i> আপডেট: {!! $articleDetail->updateDateTime !!}</span>
									@endif
								</p>
								@if(!empty($articleDetail->news_type) && ($articleDetail->news_type == 2))
								<p class="desktopDetailPTime color1">প্রিন্ট সংস্করণ</p>
								@endif
							</div>
							@endif
						</div>

						<div class="hidden-print text-left displayInlineBlock" style="vertical-align: top;margin-top: 10px;margin-left: 20px;min-width: 500px">
							<!-- sharethis -->
							<div class="sharethis-inline-share-buttons st-left displayInline" style="text-align: left;" data-url="{!! $articleDetail->url !!}"></div>
							<div class="shareCustomButton displayInline">
								<span>অ <i class="fa fa-minus clickZoomOut{{$detailCount}}" font-size="2" line-height="3" title="Zoom Out"></i> <i class="fa fa-plus clickZoomIn{{$detailCount}}" font-size="2" line-height="3" title="Zoom In"></i></span>
							</div>
						</div>
					</div>
				</div>

				<p class="desktopDivider"></p>
			</div>

			<!-- news section -->
			<div class="col-md-9 col-lg-9">

				<!-- video section -->
				@if(!empty($articleDetail->video_code))
				<div class="desktopDetailVideo hidden-print">
					<div>{!! $articleDetail->video_code !!}</div>
				</div>
				@endif

				<!-- photo section -->
				@if(empty($articleDetail->video_code))
				<div class="desktopDetailPhotoDiv">
					@if(!empty($articlePhotos) && (count($articlePhotos) >= 0))
					@foreach($articlePhotos as $key => $photo)
					<div class="desktopDetailPhoto">
						@if($articleDetail->categoryTitle == 'photos')
						<span class="borderC1-1 photoCounter">{{App\Http\Controllers\CommonController::GetBangla($key+1)}} / {{App\Http\Controllers\CommonController::GetBangla(count($articlePhotos))}}</span>
						@endif
						<figure>
							<img src="{!! asset('uploads/news_photos/'.date('Y/m/d/', strtotime($articleDetail->created_at)).$photo->image) !!}" class="img-responsive w100P" alt="{!! $articleDetail->headline !!}">
						</figure>
						@if(!empty($photo->image_caption))
						<figcaption>
							<p>{!! $photo->image_caption !!}</p>
						</figcaption>
						@endif
					</div>
					@endforeach
					@endif
				</div>
				@endif

				<!-- audio code -->
				@if(!empty($articleDetail->audio_code))
				<div class="desktopDetailAudio hidden-print marginT20 marginB20 borderC1-1 padding20 borderRadius10">
					<p class="title11"><span class="leftSpan marginR3 verticalMiddle marginT-2"></span> সংবাদের অডিও শুনতে ক্লিক করুন</p>
					<div>{!! $articleDetail->audio_code !!}</div>
				</div>
				@endif

				<div class="row">
					<div class="col-md-10 col-lg-10 col-md-offset-1 paddingLR50 paddingTB5">

						<!-- follow buttons -->
						<div class="hidden-print marginB20 marginT5">
							<div class="borderC1-1 padding5 borderRadius5 shadow3">
								<span class="btn btn-danger title1_8 paddingLR20" style="width: 18%">ফলো করুন</span>
								<a href="https://whatsapp.com/channel/0029ValH92g3AzNRUPZyJB04" target="_blank" class="btn btn-default title1_8 paddingLR20 borderC1-1" style="color: rgb(64, 195, 81);width: 40%"><i class="fa fa-brands fa-whatsapp verticalAlignMiddle marginT0 title1_6"></i> {!! $settingsInfo->newspaper_name_bn !!} হোয়াটসঅ্যাপ</a>
								<a href="https://www.messenger.com/channel/bkdigital247" target="_blank" class="btn btn-default title1_8 paddingLR20 borderC1-1" style="color: #337ab7;width: 40%"><i class="fa fa-brands fa-facebook-messenger verticalAlignMiddle marginT0 title1_6"></i> {!! $settingsInfo->newspaper_name_bn !!} মেসেঞ্জার</a>
							</div>
						</div>

						<!-- news body -->
						@if(!empty($articleDetails->body))
						<div class="desktopDetailBody textBodyFont{{$detailCount}}">
							@if(($articleDetail->paidnews_status == 1 && !Auth::check()) || ($articleDetail->paidnews_status == 1 && empty($articleDetail->customerSubscribedList)))
							<div class="marginB30">
								{!! implode(' ', array_slice(explode(' ', $articleDetails->body), 0, 80)); !!}...
								<div class="text-center detailSubscribeDiv">
									<div class="padding10"><a href="{!! url('subscribe/'.$articleDetail->id) !!}" class="btn btn-danger btn-md title1_6 padding5 paddingLR20">Subscribe To Read Detail <i class="fa fa-paper-plane title1_4"></i></a></div>
								</div>
							</div>
							@else
							<div>
								{!! $articleDetails->body !!}
							</div>
							@endif
						</div>
						@endif

						<!-- liveupdate -->
						@if(!empty($articleDetail->liveupdateNews) && count($articleDetail->liveupdateNews)>0)
						<div class="marginT5 liveupdateMainDiv">
							@foreach($articleDetail->liveupdateNews as $key => $liveupdateNews)
							<div class="borderC1-1 borderRadius10 marginB30">
								<div class="bg2 padding20 borderTRadius10 borderC1B1">
									<p class="marginT10 title11 colorBrand"><span class="bgRed colorWhite paddingTB3 paddingLR15 borderRadius5"><i class="fa fa-clock title1_6"></i> {!! app\Models\Helper::GetBangla(date('d M Y, H:i A', strtotime($liveupdateNews->created_at))) !!}</span></p>
									<div><h3 class="title10 marginB0"><strong>{!! $liveupdateNews->title !!}</strong></h3></div>
								</div>
								<div class="padding20">
									@if(!empty($liveupdateNews->image))
									<div class="marginB20 desktopDetailPhotoDiv">
										<img src="{!! env('New_AssetLink').'/liveupdates/'.$liveupdateNews->image !!}" alt="{!! $liveupdateNews->title !!}" class="img-responsive borderRadius5">
										@if(!empty($liveupdateNews->image_caption))<div class="desktopDetailPhoto"><figcaption><p class="borderBRadius5 text-center">{!! $liveupdateNews->image_caption !!}</p></figcaption></div>@endif
									</div>
									@endif
									<div class="desktopDetailLiveupdate">{!! $liveupdateNews->body !!}</div>
								</div>
							</div>
							@endforeach
						</div>
						@endif

						<!-- news document -->
						@if(!empty($articleDetail->fileSrc) && (count($articleDetail->fileSrc)>0))
						<div class="desktopDetailDocument">
							@foreach($articleDetail->fileSrc as $key => $files)
							<p><a aria-label="{!! $files['fileCaption'] !!}" href="{{$files['fileSrc']}}" target="_blank"><i class="fa fa-file"></i> {!! $files['fileCaption'] !!}</a></p>
							@endforeach
						</div>
						@endif

						<!-- news tag -->
						@if(!empty($articleDetail->topics) && count($articleDetail->topics)>0)
						<div class="desktopDetailTag hidden-print marginT30">
							<p class="title11 colorBrand"><span class="leftSpan verticalAlignMiddle" style="margin-top: -3px;border-color: #017AC3"></span> প্রাসঙ্গিক সংবাদ পড়তে নিচের ট্যাগে ক্লিক করুন</p>
							<p>
								@foreach($articleDetail->topics as $key => $topic)
								@if(!empty($topic->topicInfo))
								@php $topicIds[] = $topic->topic_id; @endphp
								<a class="desktopTagItem" aria-label="{!! $topic->topicInfo->topic_title !!}" href="{{url('/news-issue/'.$topic->topicInfo->topic_slug)}}">{!! $topic->topicInfo->topic_title !!}</a>
								@endif
								@endforeach
							</p>
						</div>
						@endif

						<!-- load second detail -->
						<div class="loadAjaxDetail{{$detailCount}}"></div>


						<!-- timeline news -->
						@if(!empty($articleDetail->incident_id))
						<div class="hidden-print marginT40 timelineNewsWidgetDesktop{{$detailCount}} desktopSectionTitleSmall borderRadius5 padding10 borderC3-2" style="display: none;">
							<div>
								<p class="text-center" style="margin: 0px;margin-top: -24px;font-size: 2.4rem;"><span class="bgWhite colorBlack" style="padding: 0px 15px;" class="color3">{!! $articleDetail->incidentInfo->title !!}</span></p>
							</div>
							<div class="borderRadius5 customTimeline2 marginT10">
								<div id="timeline" class="ajaxTimelineNewsDivDesktop{{$detailCount}} marginL15 marginR15">
								</div>
							</div>
							<div class="borderC1T1 marginT20 text-center timelineLoadMoreDivDesktop{{$detailCount}}"><span class="paddingTB5 paddingLR15 fontNormal catReadMore loadMoreButton clickLoadMoreTimelineNewsDesktop{{$detailCount}} bgWHite border0" data-paginate="1">আরও পড়ুন <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span></div>
						</div>
						@endif


						<!-- youtube channel -->
						<div class="hidden-print adDiv borderRadius5 overflowHidden marginB20 marginT20">
							<a rel="sponsored" href="https://www.youtube.com/@bkdigital247" target="_blank">
								<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/youtube-970x90.jpeg'}}" border="0" alt="ad-img"/>
							</a>
						</div>
						<!-- youtube channel -->


						<!-- related news -->
						<div class="hidden-print relatedNewsWidgetDesktop{{$detailCount}} marginT40 desktopSectionTitleSmall" style="display: none;">
							<div class="desktopSectionTitleDiv2 marginT15">
								<p class="desktopSectionTitle"><span>সম্পর্কিত</span></p>
							</div>
							<div class="row marginLR-10 desktopSectionListMedia desktopFlexRow ajaxRelatedNewsDivDesktop{{$detailCount}} marginT20"></div>
						</div>

						<!-- facebook channel -->
						<div class="hidden-print adDiv borderRadius5 overflowHidden marginB20 marginT20">
							<a rel="sponsored" href="https://www.facebook.com/bkdigital247" target="_blank">
								<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/facebook-970x90.jpeg'}}" border="0" alt="ad-img"/>
							</a>
						</div>
						<!-- facebook channel -->

						<!-- video news -->
						<div class="hidden-print videoNewsWidgetDesktop{{$detailCount}} marginT40 desktopSectionTitleSmall" style="display: none;">
							<div class="desktopSectionTitleDiv2 marginT15">
								<p class="desktopSectionTitle"><a aria-label="ভিডিও" href="{!! url('videos') !!}">ভিডিও</a></p>
							</div>
							<div class="row marginLR-10 desktopSectionListMedia desktopFlexRow ajaxVideoNewsDivDesktop{{$detailCount}} marginT20"></div>
						</div>

						<!-- popular news -->
						<div class="hidden-print popularNewsWidgetDesktop{{$detailCount}} marginT40 desktopSectionTitleSmall" style="display: none;">
							<div class="desktopSectionTitleDiv2 marginT15">
								<p class="desktopSectionTitle"><span>পঠিত</span></p>
							</div>
							<div class="row marginLR-10 desktopSectionListMedia desktopFlexRow ajaxPopularNewsDivDesktop{{$detailCount}} marginT20"></div>
						</div>

						<!-- comments -->
						<div class="hidden-print marginT30 desktopSectionTitleSmall">
							<div class="desktopSectionTitleDiv2 marginT15">
								<p class="desktopSectionTitle"><span>মন্তব্য করুন</span></p>
							</div>

							<div class="commentsDiv borderC1-1 borderRadius5">
								<div class="fb-comments" data-href="{!! $articleDetail->url !!}" data-numposts="2" width="100%"></div>
							</div>
						</div>

					</div>
				</div>

			</div>


			<!-- sidebar -->
			<div class="col-md-3 col-lg-3 hidden-print">

				<!-- Ad Desktop Home 3 -->
				@if(!empty($advPlacements[13]) && !empty($advPlacements[13]->activeOrder))
				<div class="row marginT0">
					<div class="col-sm-12 col-md-12 marginB20">
						<div class="adDiv borderRadius5 overflowHidden">
							@if($advPlacements[13]->activeOrder->ad_type == 2)
							{!! $advPlacements[13]->activeOrder->ad_code !!}
							@endif
							@if($advPlacements[13]->activeOrder->ad_type == 1)
							<a rel="sponsored" href="{{$advPlacements[13]->activeOrder->ad_url}}" target="_blank">
								<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[13]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
							</a>
							@endif
						</div>
					</div>
				</div>
				@endif
				<!-- Ad Desktop Home 3 -->


				<!-- latest popular news -->
				<div class="row popularNewsWidgetDesktop marginT0">
					<div class="col-sm-12 col-md-12 marginB20">
						@include('layouts.latest-popular-tab-news')
					</div>
				</div>
				<!-- latest popular news end -->


				<!-- category news -->
				<div class="row">
					<div class="col-md-12 col-lg-12 marginB20">
						<div class="hidden-print categoryNewsWidgetDesktop{{$detailCount}} borderC1-1 padding10 marginT5 desktopSectionTitleSmall borderRadius5" style="display: none;">
							<div class="desktopSectionTitleDiv2 marginT15">
								<p class="desktopSectionTitle"><a aria-label="{!! !empty($categoryInfo) ? $categoryInfo->display_name : 'আরও পড়ুন' !!}" href="{!! url(!empty($categoryInfo) ? $categoryInfo->title : '#') !!}">{!! !empty($categoryInfo) ? $categoryInfo->display_name : 'আরও পড়ুন' !!}</a></p>
							</div>

							<div class="marginT5 desktopSectionListMedia listItemLastBB0 ajaxCategoryNewsDivDesktop{{$detailCount}}"></div>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>

	<!-- article reached -->
	<div class="articleReached{{$detailCount}}" data-url="{{$articleDetail->url}}"></div>

	<!-- append second detail -->
	<!-- <div class="appendAjaxDetail{{$detailCount}} hidden-print"><p class="text-center marginB0"><i class="fa fa-spinner"></i></p></div> -->
</div>
<!-- desktop version start end -->




<!-- mobile version start -->
<div class="bgWHite visible-xs paddingT20">
	<!-- article reached -->
	<div class="articleReached{{$detailCount}}" data-url="{{$articleDetail->url}}"></div>

	<!-- Ad Mobile Detail 1 -->
	@if(!empty($advPlacements[23]) && !empty($advPlacements[23]->activeOrder))
	<div class="container">
		<div class="adDiv borderRadius5 overflowHidden marginB20">
			@if($advPlacements[23]->activeOrder->ad_type == 2)
			{!! $advPlacements[23]->activeOrder->ad_code !!}
			@endif
			@if($advPlacements[23]->activeOrder->ad_type == 1)
			<a rel="sponsored" href="{{$advPlacements[23]->activeOrder->ad_url}}" target="_blank">
				<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[23]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
			</a>
			@endif
		</div>
	</div>
	@endif
	<!-- Ad Mobile Detail 1 -->

	<div class="container">
		<div class="row">

			<!-- title section -->
			<div class="col-sm-12 col-md-12 paddingLR20">
				<div>
					@if($articleDetail->liveupdate_status == 1)
					<p class="desktopDetailCat marginB20 title3"><strong><span class="bgRed colorWhite borderRadius5 paddingTB3 paddingLR20 shadow1"><img src="{{asset('assets/images/liveicon.gif')}}" alt="Live Icon" class="liveIconGif marginT-2"> লাইভ</span></strong></p>
					@else
					<p class="desktopDetailCat marginB15"><a aria-label="{!! $articleDetail->categoryName !!}" href="{!! url($articleDetail->categoryTitle) !!}"><strong>{!! $articleDetail->categoryName !!}</strong></a></p>
					@endif
					
					@if($articleDetail->shoulder)
					<p class="detailShoulder">{!! $articleDetail->shoulder !!}</p>
					@endif
					<h1 class="detailHeadline marginT0" {!! !empty($articleDetail->headline_color) ? 'style="color: '.$articleDetail->headline_color.' !important"' : '' !!}><strong>{!! $articleDetail->headline !!}</strong></h1>
					@if($articleDetail->hanger)
					<p class="detailHanger">{!! $articleDetail->hanger !!}</p>
					@endif
					<p class="borderC1T1 marginB0"></p>

					<div class="marginT10">
						<!-- multiple author -->
						@if(!empty($articleDetail->authors) && count($articleDetail->authors)>1)
						@foreach($articleDetail->authors as $key => $authorInfo)
						<p class="detailReporter borderC1-1 borderRadius5 paddingTB3 paddingLR5 marginR5 marginB5"><a href="{!! $authorInfo->url !!}" class="textDecorationNone colorBlue hoverBlack"><img src="{!! $authorInfo->author_photo_src !!}" class="img-responsive borderRadius50P displayInlineBlock" width="25" alt="{!! $authorInfo->author_name !!}"> <span class="displayInlineBlock verticalAlignMiddle marginT3">{!! $authorInfo->author_name !!}</span></a></p>
						@endforeach
						<p class="detailPTime color1 marginT5">প্রকাশ: {!! $articleDetail->publishDateTime !!}</p>
						@if(($articleDetail->show_updatetime == 1) && !empty($articleDetail->updateDateTime))
						<p class="detailPTime color1">আপডেট: {!! $articleDetail->updateDateTime !!}</p>
						@endif
						@if(!empty($articleDetail->news_type) && ($articleDetail->news_type == 2))
						<p class="detailPTime color1">প্রিন্ট সংস্করণ</p>
						@endif

						<!-- single author -->
						@elseif(!empty($articleDetail->authors) && count($articleDetail->authors) == 1)
						@php $authorInfo = $articleDetail->authors[0]; @endphp
						<div class="detailAuthorDiv">
							<a href="{!! $authorInfo->url !!}"><img src="{!! $authorInfo->author_photo_src !!}" class="img-responsive borderRadius50P" width="40"  alt="{!! $authorInfo->author_name !!}"></a>
						</div>
						<div class="displayInlineBlock">
							<p class="detailReporter"><a href="{!! $authorInfo->url !!}" class="textDecorationNone colorBlue hoverBlack">{!! $authorInfo->author_name !!}</a></p>
							<p class="detailPTime color1">প্রকাশ: {!! $articleDetail->publishDateTime !!}</p>
							@if(($articleDetail->show_updatetime == 1) && !empty($articleDetail->updateDateTime))
							<p class="detailPTime color1">আপডেট: {!! $articleDetail->updateDateTime !!}</p>
							@endif
							@if(!empty($articleDetail->news_type) && ($articleDetail->news_type == 2))
							<p class="detailPTime color1">প্রিন্ট সংস্করণ</p>
							@endif
						</div>

						<!-- no author -->
						@else
						<div class="detailAuthorDiv">
							<img src="{!! env('UploadsLink').'uploads/settings/'.$settingsInfo->icon_2 !!}" class="img-responsive borderRadius50P" width="40" alt="Icon">
						</div>
						<div class="displayInlineBlock">
							@if(!empty($articleDetail->reporter))
							<p class="detailReporter">{!! $articleDetail->reporter !!}</p>
							@endif
							<p class="detailPTime color1">প্রকাশ: {!! $articleDetail->publishDateTime !!}</p>
							@if(($articleDetail->show_updatetime == 1) && !empty($articleDetail->updateDateTime))
							<p class="detailPTime color1">আপডেট: {!! $articleDetail->updateDateTime !!}</p>
							@endif
							@if(!empty($articleDetail->news_type) && ($articleDetail->news_type == 2))
							<p class="detailPTime color1">প্রিন্ট সংস্করণ</p>
							@endif
						</div>
						@endif
					</div>
					<!-- sharethis -->
					<div class="marginT15 hidden-print">
						<div class="sharethis-inline-share-buttons st-left displayInline" style="text-align: left !important;" data-url="{!! $articleDetail->url !!}"></div>
						<div class="shareCustomButton displayInline">
							<span>অ <i class="fa fa-minus clickZoomOut{{$detailCount}}" font-size="2" line-height="2.9" title="Zoom Out"></i> <i class="fa fa-plus clickZoomIn{{$detailCount}}" font-size="2" line-height="2.9" title="Zoom In"></i></span>
						</div>
					</div>
				</div>
			</div>

			<!-- video section -->
			@if(!empty($articleDetail->video_code))
			<div class="col-sm-12 col-md-12 detailVideo hidden-print">
				<div>{!! $articleDetail->video_code !!}</div>
			</div>
			@endif

			<!-- photo section -->
			@if(empty($articleDetail->video_code))
			<div class="col-sm-12 col-md-12 detailPhotoDiv">
				@if(!empty($articlePhotos) && (count($articlePhotos) >= 0))
				@foreach($articlePhotos as $key => $photo)
				<div class="detailPhoto">
					@if($articleDetail->categoryTitle == 'photos')
					<span class="borderC1-1 photoCounter">{{App\Http\Controllers\CommonController::GetBangla($key+1)}} / {{App\Http\Controllers\CommonController::GetBangla(count($articlePhotos))}}</span>
					@endif
					<figure>
						<img src="{!! asset('uploads/news_photos/'.date('Y/m/d/', strtotime($articleDetail->created_at)).$photo->image) !!}" class="img-responsive" alt="{!! $articleDetail->headline !!}">
					</figure>
					@if(!empty($photo->image_caption))
					<figcaption>
						<p>{!! $photo->image_caption !!}</p>
					</figcaption>
					@endif
				</div>
				@endforeach
				@endif
			</div>
			@endif

			<!-- audio code -->
			@if(!empty($articleDetail->audio_code))
			<div class="detailAudio hidden-print marginT10 marginB20 borderC1-1 padding10 borderRadius10 marginL15 marginR15">
				<p class="title12"><span class="leftSpan marginR3 verticalMiddle marginT-2"></span> সংবাদের অডিও শুনতে ক্লিক করুন</p>
				<div>{!! $articleDetail->audio_code !!}</div>
			</div>
			@endif


			<!-- body section -->
			<div class="col-sm-12 col-md-12 paddingLR20">

				<!-- follow buttons -->
						<div class="hidden-print marginB20 marginT5">
							<div class="borderC1-1 padding5 borderRadius5 shadow3">
								<span class="btn btn-danger title1_4">ফলো করুন</span>
								<a href="https://whatsapp.com/channel/0029ValH92g3AzNRUPZyJB04" target="_blank" class="btn btn-default title1_4 borderC1-1" style="color: rgb(64, 195, 81);"><i class="fa fa-brands fa-whatsapp verticalAlignMiddle marginT0 title1_6"></i> হোয়াটসঅ্যাপ</a>
								<a href="https://www.messenger.com/channel/bkdigital247" target="_blank" class="btn btn-default title1_4 borderC1-1" style="color: #337ab7"><i class="fa fa-brands fa-facebook-messenger verticalAlignMiddle marginT0 title1_6"></i> মেসেঞ্জার</a>
							</div>
						</div>

				<!-- news body -->
				<div class="detailBody textBodyFont{{$detailCount}}">
					@if(($articleDetail->paidnews_status == 1 && !Auth::check()) || ($articleDetail->paidnews_status == 1 && empty($articleDetail->customerSubscribedList)))
					<div class="marginB30">
						{!! implode(' ', array_slice(explode(' ', $articleDetails->body), 0, 80)); !!}...
						<div class="text-center detailSubscribeDiv">
							<div class="padding10"><a href="{!! url('subscribe/'.$articleDetail->id) !!}" class="btn btn-danger btn-md title1_6 padding5 paddingLR20">Subscribe To Read Detail <i class="fa fa-paper-plane title1_4"></i></a></div>
						</div>
					</div>
					@else
					<div>
						{!! $articleDetails->body !!}
					</div>
					@endif
				</div>

				<!-- liveupdate -->
				@if(!empty($articleDetail->liveupdateNews) && count($articleDetail->liveupdateNews)>0)
				<div class="marginT5 liveupdateMainDiv">
					@foreach($articleDetail->liveupdateNews as $key => $liveupdateNews)
					<div class="borderC1-1 borderRadius10 marginB30">
						<div class="bg2 padding10 borderTRadius10 borderC1B1">
							<p class="marginT5 detailLiveupdateTime"><span><i class="fa fa-clock title1_4"></i> {!! app\Models\Helper::GetBangla(date('d M Y, H:i A', strtotime($liveupdateNews->created_at))) !!}</span></p>
							<div><h3 class="title3 marginT0"><strong>{!! $liveupdateNews->title !!}</strong></h3></div>
						</div>

						<div class="padding10">
							@if(!empty($liveupdateNews->image))
							<div class="marginB20 detailPhotoDiv">
								<img src="{!! env('New_AssetLink').'/liveupdates/'.$liveupdateNews->image !!}" alt="{!! $liveupdateNews->title !!}" class="img-responsive borderRadius5">
								@if(!empty($liveupdateNews->image_caption))<div class="detailPhoto padding0"><figcaption><p class="borderBRadius5 text-center">{!! $liveupdateNews->image_caption !!}</p></figcaption></div>@endif
							</div>
							@endif
							<div class="detailLiveupdate">{!! $liveupdateNews->body !!}</div>
						</div>
					</div>
					@endforeach
				</div>
				@endif

				<!-- news document -->
				@if(!empty($articleDetail->fileSrc) && (count($articleDetail->fileSrc)>0))
				<div class="detailDocument">
					@foreach($articleDetail->fileSrc as $key => $files)
					<p><a aria-label="{!! $files['fileCaption'] !!}" href="{{$files['fileSrc']}}" target="_blank"><i class="fa fa-file"></i> {!! $files['fileCaption'] !!}</a></p>
					@endforeach
				</div>
				@endif


				<!-- news tag -->
				@if(!empty($articleDetail->topics) && count($articleDetail->topics)>0)
				<div class="detailTag hidden-print marginT30">
					<p class="title1_8 colorBrand"><span class="leftSpan verticalAlignMiddle" style="margin-top: -3px;border-color: #017AC3"></span> প্রাসঙ্গিক সংবাদ পড়তে নিচের ট্যাগে ক্লিক করুন</p>
					<p>
						@foreach($articleDetail->topics as $key => $topic)
						@if(!empty($topic->topicInfo))
						@php $topicIdsMobile[] = $topic->topic_id; @endphp
						<a class="tagItem" aria-label="{!! $topic->topicInfo->topic_title !!}" href="{{url('/news-issue/'.$topic->topicInfo->topic_slug)}}">{!! $topic->topicInfo->topic_title !!}</a>
						@endif
						@endforeach
					</p>
				</div>
				@endif
				

				<!-- load second detail -->
				<div class="loadAjaxDetail{{$detailCount}}"></div>

			</div>


			<!-- timeline news -->
			@if(!empty($articleDetail->incident_id))
			<div class="col-sm-12 col-md-12 marginT20 paddingLR20 hidden-print timelineNewsWidgetMobile{{$detailCount}}">
				<div class="borderRadius5 padding10 borderC3-2">
					<p class="sectionTitle margin0 text-center paddingB10 marginB10"><span class="color3">{!! $articleDetail->incidentInfo->title !!}</span></p>
					<div class="borderRadius5 customTimeline2">
						<div id="timeline" class="ajaxTimelineNewsDivMobile{{$detailCount}} marginL15 marginR15">
						</div>
					</div>
					<div class="borderC1T1 marginT10 text-center timelineLoadMoreDivMobile{{$detailCount}}"><span class="catReadMore paddintTB5 paddingLR15 fontNormal loadMoreButton clickLoadMoreTimelineNewsMobile{{$detailCount}} bgWHite border0 shadowUnset" data-paginate="1">আরও পড়ুন <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span></div>
				</div>
			</div>
			@endif

			<!-- youtube channel -->
			<div class="hidden-print col-sm-12 col-md-12 borderRadius5 overflowHidden marginB20 marginT20">
				<a rel="sponsored" href="https://www.youtube.com/@bkdigital247" target="_blank">
					<img class="img-responsive marginCenter borderRadius5" src="{{env('UploadsLink').'uploads/advertisements/youtube-320x50.jpeg'}}" border="0" alt="ad-img"/>
				</a>
			</div>
			<!-- youtube channel -->

			<!-- related news -->
			<div class="col-sm-12 col-md-12 marginT40 paddingLR20 hidden-print relatedNewsWidgetMobile{{$detailCount}} desktopSectionTitleSmall" style="display: none;">
				<div class="sectionTitleDiv3 desktopSectionTitleDiv2 " style="margin-bottom: -25px;">
					<p class="sectionTitle"><span>সম্পর্কিত</span></p>
				</div>
				<div class="row desktopFlexRow paddingLR15 ajaxRelatedNewsDivMobile{{$detailCount}} sectionListMedia"></div>
			</div>

			<!-- facebook channel -->
			<div class="hidden-print col-sm-12 col-md-12 borderRadius5 overflowHidden marginB20 marginT20">
				<a rel="sponsored" href="https://www.facebook.com/bkdigital247" target="_blank">
					<img class="img-responsive marginCenter borderRadius5" src="{{env('UploadsLink').'uploads/advertisements/facebook-320x50.jpeg'}}" border="0" alt="ad-img"/>
				</a>
			</div>
			<!-- facebook channel -->

			<!-- video news -->
			<div class="col-sm-12 col-md-12 marginT40 paddingLR20 hidden-print videoNewsWidgetMobile{{$detailCount}} desktopSectionTitleSmall" style="display: none;">
				<div class="sectionTitleDiv3 desktopSectionTitleDiv2 " style="margin-bottom: -25px;">
					<p class="sectionTitle"><a href="{!! url('videos') !!}">ভিডিও</a></p>
				</div>
				<div class="row desktopFlexRow paddingLR15 ajaxVideoNewsDivMobile{{$detailCount}} sectionListMedia"></div>
			</div>

			<!-- popular news -->
			<div class="col-sm-12 col-md-12 marginT40 paddingLR20 hidden-print popularNewsWidgetMobile{{$detailCount}} desktopSectionTitleSmall" style="display: none;">
				<div class="sectionTitleDiv3 desktopSectionTitleDiv2 " style="margin-bottom: -25px;">
					<p class="sectionTitle"><span>পঠিত</a></p>
					</div>
					<div class="row desktopFlexRow paddingLR15 ajaxPopularNewsDivMobile{{$detailCount}} sectionListMedia"></div>
				</div>

				<!-- category news -->
				<div class="col-sm-12 col-md-12 marginT40 paddingLR20 hidden-print categoryNewsWidgetMobile{{$detailCount}}" style="display: none;">
					<div class="sectionTitleDiv3" style="margin-bottom: -25px;">
						<p class="sectionTitle"><a href="{!! url(!empty($categoryInfo) ? $categoryInfo->title : '#') !!}">{!! !empty($categoryInfo) ? $categoryInfo->display_name : 'আরও পড়ুন' !!} </a></p>
					</div>
					<div class="sectionListMedia ajaxCategoryNewsDivMobile{{$detailCount}}"></div>
				</div>

			</div>
		</div>

		<!-- article reached -->
		<div class="articleReached{{$detailCount}}" data-url="{{$articleDetail->url}}"></div>

		<!-- append second detail -->
		<!-- <div class="appendAjaxDetail{{$detailCount}} hidden-print"><p class="text-center marginB0"><i class="fa fa-spinner"></i></p></div> -->

	</div>
	<!-- mobile version end -->


	<!-- desktop detail popup -->
	@if(!empty($advPlacements[3]) && !empty($advPlacements[3]->activeOrder))
	<div class="modal fade popupModalAd" id="popupModalDesktop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close popupModalClose hoverBlack popupModalAdCloseButton" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					@if($advPlacements[3]->activeOrder->ad_type == 2)
					{!! $advPlacements[3]->activeOrder->ad_code !!}
					@endif
					@if($advPlacements[3]->activeOrder->ad_type == 1)
					<a href="{{$advPlacements[3]->activeOrder->ad_url}}" target="_blank">
						<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[3]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
					</a>
					@endif
				</div>
			</div>
		</div>
	</div>
	@endif

	<!-- mobile detail popup -->
	@if(!empty($advPlacements[4]) && !empty($advPlacements[4]->activeOrder))
	<div class="modal fade popupModalAd" id="popupModalMobile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close popupModalClose hoverBlack popupModalAdCloseButton" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					@if($advPlacements[4]->activeOrder->ad_type == 2)
					{!! $advPlacements[4]->activeOrder->ad_code !!}
					@endif
					@if($advPlacements[4]->activeOrder->ad_type == 1)
					<a href="{{$advPlacements[4]->activeOrder->ad_url}}" target="_blank">
						<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[4]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
					</a>
					@endif
				</div>
			</div>
		</div>
	</div>
	@endif


	<!-- Detail InArticle Ad 2 -->
	@if(!empty($advPlacements[11]) && !empty($advPlacements[11]->activeOrder))
	<div class="textBodyAd2Div" style="display: none;">
		<div class="marginB15 hidden-print text-center adDiv w300">
			@if($advPlacements[11]->activeOrder->ad_type == 2)
			{!! $advPlacements[11]->activeOrder->ad_code !!}
			@endif
			@if($advPlacements[11]->activeOrder->ad_type == 1)
			<a rel="sponsored" href="{{$advPlacements[11]->activeOrder->ad_url}}" target="_blank">
				<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[11]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
			</a>
			@endif
		</div>
	</div>
	@endif
	<!-- Detail InArticle Ad 2 -->

	@endsection

	@push('js')
	<!-- ajax news view count -->
	<script type="text/javascript">
		var url = '{{url("/")}}/ajax/store/newsView/'+'{{$articleDetail->created_at}}'+'/{{$articleDetail->id}}';
		$.get(url, function(data){
			if(data != ''){
				$('.readerCount').html(data);
			}
		})
	</script>

	@if(!empty($articleDetail->tags) || !empty($articleDetail->topics))
	<!-- desktop ajax load related news -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width >= 769){

			var topicId = '{{!empty($topicIds) ? implode(",", $topicIds) : ''}}';
			if(topicId != ''){
				var url = '{{url("ajax/load/topicnews/")}}/'+topicId+'/{{$articleDetail->id}}/3/0/0';
			}else{
				var url = '{{url("ajax/load/tagnews/")}}/{{$articleDetail->tags}}/{{$articleDetail->id}}/3/0/0';
			}

			$.get(url, function(data){
				if(data != ''){
					$.each(data, function(key, value){
						if(value.categoryTitle == 'photos'){
							var icon = '<span class="fa fa-image ppIconMedium"></span>';
						}else if(value.video_code != null){
							var icon = '<span class="fa fa-play pvIconMedium"></span>';
						}else{
							var icon = '';
						}
						var row = $('<div class="col-sm-4 col-md-4 paddingLR10 desktopSectionLead marginB20"><div class="thumbnail bgUnset shadow3 borderRadius5Imp h100P"><div class="positionRelative"><img src="'+value.thumbMedium+'" class="img-responsive borderTRadius5" alt="'+value.headline+'">'+icon+'</div><div class="caption paddingTB0 paddingLR10Imp"><p class="title11 marginT0">'+value.fullheadline+'</p></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div></div>');
						$('.ajaxRelatedNewsDivDesktop{{$detailCount}}').append(row);
					});				
					$('.relatedNewsWidgetDesktop{{$detailCount}}').show();
				}
			});
		}
	</script>

	<!-- mobile ajax load related news -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width <= 768){

			var topicId = '{{!empty($topicIdsMobile) ? implode(",", $topicIdsMobile) : ''}}';
			if(topicId != ''){
				var url = '{{url("ajax/load/topicnews/")}}/'+topicId+'/{{$articleDetail->id}}/3/0/0';
			}else{
				var url = '{{url("ajax/load/tagnews/")}}/{{$articleDetail->tags}}/{{$articleDetail->id}}/3/0/0';
			}

			$.get(url, function(data){
				if(data != ''){
					$.each(data, function(key, value){
						if(value.categoryTitle == 'photos'){
							var icon = '<span class="fa fa-image ppIconSmall"></span>';
						}else if(value.video_code != null){
							var icon = '<span class="fa fa-play pvIconSmall"></span>';
						}else{
							var icon = '';
						}
						var row = $('<div class="media positionRelative"><div class="media-left paddingL5"><div class="positionRelative"><img class="media-object borderRadius5" src="'+value.thumbSmall+'" width="140" alt="'+value.headline+'">'+icon+'</div></div><div class="media-body"><p class="xs-title">'+value.fullheadline+'</p></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div>');
						$('.ajaxRelatedNewsDivMobile{{$detailCount}}').append(row);
					});				
					$('.relatedNewsWidgetMobile{{$detailCount}}').show();
				}
			});
		}
	</script>
	@endif


	<!-- desktop ajax load video news -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width >= 769){
			var url = '{{url("ajax/load/categorynews/")}}/32/3/0/0';
			$.get(url, function(data){
				if(data != ''){
					$.each(data, function(key, value){
						if(value.categoryTitle == 'photos'){
							var icon = '<span class="fa fa-image ppIconMedium"></span>';
						}else if(value.video_code != null){
							var icon = '<span class="fa fa-play pvIconMedium"></span>';
						}else{
							var icon = '';
						}
						var row = $('<div class="col-sm-4 col-md-4 paddingLR10 desktopSectionLead marginB20"><div class="thumbnail bgUnset shadow3 borderRadius5Imp h100P"><div class="positionRelative"><img src="'+value.thumbMedium+'" class="img-responsive borderTRadius5" alt="'+value.headline+'">'+icon+'</div><div class="caption paddingTB0 paddingLR10Imp"><p class="title11 marginT0">'+value.fullheadline+'</p></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div></div>');
						$('.ajaxVideoNewsDivDesktop{{$detailCount}}').append(row);
					});				
					$('.videoNewsWidgetDesktop{{$detailCount}}').show();
				}
			});
		}
	</script>

	<!-- mobile ajax load video news -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width <= 768){
			var url = '{{url("ajax/load/categorynews/")}}/32/3/0/0';
			$.get(url, function(data){
				if(data != ''){
					$.each(data, function(key, value){
						if(value.categoryTitle == 'photos'){
							var icon = '<span class="fa fa-image ppIconSmall"></span>';
						}else if(value.video_code != null){
							var icon = '<span class="fa fa-play pvIconSmall"></span>';
						}else{
							var icon = '';
						}
						var row = $('<div class="media positionRelative"><div class="media-left paddingL5"><div class="positionRelative"><img class="media-object borderRadius5" src="'+value.thumbSmall+'" width="140" alt="'+value.headline+'">'+icon+'</div></div><div class="media-body"><p class="xs-title">'+value.fullheadline+'</p></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div>');
						$('.ajaxVideoNewsDivMobile{{$detailCount}}').append(row);
					});			
					$('.videoNewsWidgetMobile{{$detailCount}}').show();
				}
			});
		}
	</script>



	<!-- desktop ajax load popular news -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width >= 769){
			var url = '{{url("ajax/load/popularnews/")}}/3/0';
			$.get(url, function(data){
				if(data != ''){
					$.each(data, function(key, value){
						var number = englishToBangla(parseInt(key+1));
						var row = $('<div class="col-sm-4 col-md-4 paddingLR10 desktopSectionLead marginB20"><div class="thumbnail bgUnset shadow3 borderRadius5Imp h100P"><div class="positionRelative paddingT20"><div class="popularCount" style="margin: 0 auto">'+number+'</div></div><div class="caption paddingTB0 paddingLR10Imp"><p class="title11 marginT0 text-center">'+value.title+'</p></div><a aria-label="'+value.title+'" href="'+value.link+'" class="linkOverlay"></a></div></div>');
						$('.ajaxPopularNewsDivDesktop{{$detailCount}}').append(row);
					});				
					$('.popularNewsWidgetDesktop{{$detailCount}}').show();
				}
			});
		}
	</script>

	<!-- mobile ajax load popular news -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width <= 768){
			var url = '{{url("ajax/load/popularnews/")}}/3/0';
			$.get(url, function(data){
				if(data != ''){
					$.each(data, function(key, value){
						var number = englishToBangla(parseInt(key+1));
						var row = $('<div class="media positionRelative"><div class="media-left paddingL5"><div class="positionRelative"><div class="popularCount">'+number+'</div></div></div><div class="media-body"><p class="xs-title">'+value.title+'</p></div><a aria-label="'+value.title+'" href="'+value.link+'" class="linkOverlay"></a></div>');
						$('.ajaxPopularNewsDivMobile{{$detailCount}}').append(row);
					});			
					$('.popularNewsWidgetMobile{{$detailCount}}').show();
				}
			});
		}
	</script>



	@if(!empty($categoryInfo) && !empty($settingsInfo))
	<!-- desktop ajax load category news -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width >= 769){
			var url = '{{url("ajax/load/categorynews/")}}/{{$categoryInfo->id}}/5/0/0';
			$.get(url, function(data){
				if(data != ''){
					$.each(data, function(key, value){
						if(value.categoryTitle == 'photos'){
							var icon = '<span class="fa fa-image ppIconSmall"></span>';
						}else if(value.video_code != null){
							var icon = '<span class="fa fa-play pvIconSmall"></span>';
						}else{
							var icon = '';
						}
						var row = $('<div class="media positionRelative marginB5"><div class="media-body"><p class="margin0 hoverBlue title11">'+value.fullheadline+'</p></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div>');
						$('.ajaxCategoryNewsDivDesktop{{$detailCount}}').append(row);
					});			
					$('.categoryNewsWidgetDesktop{{$detailCount}}').show();
				}
			});
		}
	</script>

	<!-- mobile ajax load category news -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width <= 768){
			var url = '{{url("ajax/load/categorynews/")}}/{{$categoryInfo->id}}/3/0/0';
			$.get(url, function(data){
				if(data != ''){
					$.each(data, function(key, value){
						if(value.categoryTitle == 'photos'){
							var icon = '<span class="fa fa-image ppIconSmall"></span>';
						}else if(value.video_code != null){
							var icon = '<span class="fa fa-play pvIconSmall"></span>';
						}else{
							var icon = '';
						}
						var row = $('<div class="media positionRelative"><div class="media-left paddingL5"><div class="positionRelative"><img class="media-object borderRadius5" src="'+value.thumbSmall+'" width="140" alt="'+value.headline+'">'+icon+'</div></div><div class="media-body"><p class="xs-title">'+value.fullheadline+'</p></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div>');
						$('.ajaxCategoryNewsDivMobile{{$detailCount}}').append(row);
					});			
					$('.categoryNewsWidgetMobile{{$detailCount}}').show();
				}
			});
		}
	</script>
	@endif


	@if(!empty($articleDetail->incident_id))
	<!-- desktop ajax load timeline news -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width >= 769){
			var url = '{{url("ajax/load/timelinenews/")}}/{{$articleDetail->incident_id}}/5/0/0';
			$.get(url, function(data){
				if(data != ''){
					$.each(data, function(key, value){
						var row = $('<div class="row timeline-movement"><div class="timeline-badge"><span class="timeline-balloon-date-day"></span><span class="timeline-balloon-date-month"></span></div><div class="col-sm-3  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel credits"><ul class="timeline-panel-ul"><li class="title1_7">'+value.publishTime+'</li></ul></div></div></div></div><div class="col-sm-9  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel debits"><ul class="timeline-panel-ul"><li class="title11"><a class="colorBlue hoverBlack textDecorationNone" href="'+value.url+'">'+value.fullheadline+'</a></li></ul></div></div></div></div></div>');
						$('.ajaxTimelineNewsDivDesktop{{$detailCount}}').append(row);
					});				
					$('.timelineNewsWidgetDesktop{{$detailCount}}').show();
				}
			});
		}
	</script>

	<!-- mobile ajax load timeline news -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width <= 768){
			var url = '{{url("ajax/load/timelinenews/")}}/{{$articleDetail->incident_id}}/5/0/0';
			$.get(url, function(data){
				if(data != ''){
					$.each(data, function(key, value){
						var row = $('<div class="row timeline-movement"><div class="timeline-badge"><span class="timeline-balloon-date-day"></span><span class="timeline-balloon-date-month"></span></div><div class="col-sm-12  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel credits"><ul class="timeline-panel-ul"><li class="title1_4">'+value.publishTime+'</li></ul></div></div></div></div><div class="col-sm-12  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel debits"><ul class="timeline-panel-ul"><li class="timelineTitleM"><a class="colorBlue hoverBlack textDecorationNone" href="'+value.url+'">'+value.fullheadline+'</a></li></ul></div></div></div></div></div>');
						$('.ajaxTimelineNewsDivMobile{{$detailCount}}').append(row);
					});
					$('.timelineNewsWidgetMobile{{$detailCount}}').show();
				}
			});
		}
	</script>

	<!-- desktop ajax load read more timeline news -->
	<script type="text/javascript">
		$('.clickLoadMoreTimelineNewsDesktop{{$detailCount}}').click(function(){
			$('.loadingIcon').show();
			var paginate = $(this).data('paginate');
			$(this).data('paginate', parseInt(paginate)+1);
			var url = '{{url("ajax/load/timelinenews/")}}/{{$articleDetail->incident_id}}/5/'+paginate+'/0';
			$.get(url, function(data){
				if(data[0] != undefined){
					$('.loadingIcon').hide();
					$.each(data, function(key, value){
						$('.loaderDiv1').hide();
						var row = $('<div class="row timeline-movement"><div class="timeline-badge"><span class="timeline-balloon-date-day"></span><span class="timeline-balloon-date-month"></span></div><div class="col-sm-3  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel credits"><ul class="timeline-panel-ul"><li class="title1_7">'+value.publishTime+'</li></ul></div></div></div></div><div class="col-sm-9  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel debits"><ul class="timeline-panel-ul"><li class="title11"><a class="colorBlue hoverBlack textDecorationNone" href="'+value.url+'">'+value.fullheadline+'</a></li></ul></div></div></div></div></div>');
						$('.ajaxTimelineNewsDivDesktop{{$detailCount}}').append(row);
					});	
				}else {
					$('.timelineLoadMoreDivDesktop{{$detailCount}}').hide();
				}
			});
		});
	</script>

	<!-- mobile ajax load read more timeline news -->
	<script type="text/javascript">
		$('.clickLoadMoreTimelineNewsMobile{{$detailCount}}').click(function(){
			$('.loadingIcon').show();
			var paginate = $(this).data('paginate');
			$(this).data('paginate', parseInt(paginate)+1);
			var url = '{{url("ajax/load/timelinenews/")}}/{{$articleDetail->incident_id}}/5/'+paginate+'/0';
			$.get(url, function(data){
				if(data[0] != undefined){
					$('.loadingIcon').hide();
					$.each(data, function(key, value){
						$('.loaderDiv1').hide();
						var row = $('<div class="row timeline-movement"><div class="timeline-badge"><span class="timeline-balloon-date-day"></span><span class="timeline-balloon-date-month"></span></div><div class="col-sm-12  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel credits"><ul class="timeline-panel-ul"><li class="title1_4">'+value.publishTime+'</li></ul></div></div></div></div><div class="col-sm-12  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel debits"><ul class="timeline-panel-ul"><li class="timelineTitleM"><a class="colorBlue hoverBlack textDecorationNone" href="'+value.url+'">'+value.fullheadline+'</a></li></ul></div></div></div></div></div>');
						$('.ajaxTimelineNewsDivMobile{{$detailCount}}').append(row);
					});	
				}else {
					$('.timelineLoadMoreDivMobile{{$detailCount}}').hide();
				}
			});
		});
	</script>
	@endif


	<!-- load ajax detail -->
	{{-- <script type="text/javascript">
		jQuery(document).ready(function(){
			window.addEventListener('scroll', function(e){
				if(isOnScreen(jQuery('.articleReached{{$detailCount}}'))){ 
					var currentNewsUrl = $('.articleReached{{$detailCount}}').data('url');
					var existingUrl = $(location).attr('href');
					var existingUrlEncoded = decodeURIComponent(existingUrl);
					if(existingUrlEncoded != currentNewsUrl){
						history.pushState('{{$settingsInfo->newspaper_name}}', '{{$settingsInfo->newspaper_name}}', currentNewsUrl);
						document.title = '{{$articleDetail->headline}}';
					}
				}	
			});
		});

		jQuery(document).ready(function(){
			window.addEventListener('scroll', function(e){
				if(isOnScreen(jQuery('.loadAjaxDetail{{$detailCount}}'))){ 
					$('.loadAjaxDetail{{$detailCount}}').removeClass('loadAjaxDetail{{$detailCount}}');
					var url = '{{url("/")}}/ajax/load/detail/{{$articleDetail->id}}/{{$categoryInfo->id}}/{{$detailCount}}';
					$.get(url, function(data){
						if(data != ''){
							$('.appendAjaxDetail{{$detailCount}}').html(data);
							if (__sharethis__ && __sharethis__.config) {
								__sharethis__.init(__sharethis__.config);
							}
						}
					});
				}	
			});
		});

		function isOnScreen(elem) {
			if(elem.length == 0){return;}
			var $window = jQuery(window)
			var viewport_top = $window.scrollTop()
			var viewport_height = $window.height()
			var viewport_bottom = viewport_top + viewport_height
			var $elem = jQuery(elem)
			var top = $elem.offset().top
			var height = $elem.height()
			var bottom = top + height
			return (top >= viewport_top && top < viewport_bottom) ||
			(bottom > viewport_top && bottom <= viewport_bottom) ||
			(height > viewport_height && top <= viewport_top && bottom >= viewport_bottom)
		}
	</script> --}}

	<!-- font zoom in out -->
	<script type="text/javascript">
		$('.shareCustomButton').on('click', '.clickZoomIn{{$detailCount}}', function(){
			var fontSize = $(this).attr('font-size');
			fontSize = (parseFloat(fontSize)+.2).toFixed(2);
			$('.clickZoomIn{{$detailCount}}').attr('font-size', fontSize);
			$('.clickZoomOut{{$detailCount}}').attr('font-size', fontSize);

			var lineHeight = $(this).attr('line-height');
			lineHeight = (parseFloat(lineHeight)+.2).toFixed(2);
			$('.clickZoomIn{{$detailCount}}').attr('line-height', lineHeight);
			$('.clickZoomOut{{$detailCount}}').attr('line-height', lineHeight);

			$('.textBodyFont{{$detailCount}} p').attr('style', 'font-size: '+fontSize+'rem !important;line-height: '+lineHeight+'rem;');
		});

		$('.shareCustomButton').on('click', '.clickZoomOut{{$detailCount}}', function(){
			var fontSize = $(this).attr('font-size');
			fontSize = (parseFloat(fontSize)-.2).toFixed(2);
			$('.clickZoomIn{{$detailCount}}').attr('font-size', fontSize);
			$('.clickZoomOut{{$detailCount}}').attr('font-size', fontSize);

			var lineHeight = $(this).attr('line-height');
			lineHeight = (parseFloat(lineHeight)-.2).toFixed(2);
			$('.clickZoomIn{{$detailCount}}').attr('line-height', lineHeight);
			$('.clickZoomOut{{$detailCount}}').attr('line-height', lineHeight);

			$('.textBodyFont{{$detailCount}} p').attr('style', 'font-size: '+fontSize+'rem !important;line-height: '+lineHeight+'rem;');
		});
	</script>

	<script type="text/javascript">
		$('.updateCaret').click(function(){
			$('.togglePublishTime').toggle();
		})
	</script>

	<!-- Detail InArticle Ad 1 -->
	@if(!empty($advPlacements[5]) && !empty($advPlacements[5]->activeOrder))
	<script type="text/javascript">
		$(document).ready(function(){
			var adText = '{!! $advPlacements[5]->activeOrder->ad_type == 2 ? $advPlacements[5]->activeOrder->ad_code : '<p class="textBodyAd1Container marginB15 hidden-print text-center adDiv w300"><a rel="sponsored" target="_blank" href="'.$advPlacements[5]->activeOrder->ad_url.'"><img class="img-responsive" alt="ad-img" src="'.env('UploadsLink').'uploads/advertisements/'.$advPlacements[5]->activeOrder->ad_banner.'" /></a></p>' !!}';

			var width = $(window).width();
			if(width >= 768){
				var parentDiv = $('.desktopDetailBody');
				var i = 0;
				parentDiv.find('p').each(function() {
					i++;
					if(i == 1){
						$(this).after('<div class="textBodyAd1Container">'+adText+'</div>');
					}
				});
			}else{
				var parentDiv = $('.detailBody');
				var i = 0;
				parentDiv.find('p').each(function() {
					i++;
					if(i == 1){
						$(this).after('<div class="textBodyAd1Container">'+adText+'</div>');
					}
				});
			}
		});
	</script>
	@endif
	<!-- Detail InArticle Ad 1 -->


	<!-- Detail InArticle Ad 2 -->
	@if(!empty($advPlacements[11]) && !empty($advPlacements[11]->activeOrder))
	<script type="text/javascript">
		$(document).ready(function(){
			var width = $(window).width();
			setTimeout(function () {
				var adText = $('.textBodyAd2Div').html();
				if(width >= 768){
					var parentDiv = $('.desktopDetailBody');
					var i = 0;
					parentDiv.find('p').each(function() {
						i++;
						if(i == 4){
							$(this).after(adText);
						}
					});
				}else{
					var parentDiv = $('.detailBody');
					var i = 0;
					parentDiv.find('p').each(function() {
						i++;
						if(i == 4){
							$(this).after(adText);
						}
					});
				}
				$('.textBodyAd2Div').empty();
			},500);
		});
	</script>
	@endif
	<!-- Detail InArticle Ad 2 -->

	@endpush