@extends('layouts.layout')
@push('meta-tag')
<title>{!! $settingsInfo->title !!}</title>
<meta property="og:title" content="{!! $settingsInfo->title !!}" />
<meta property="og:description" content="{!! $settingsInfo->description !!}" />
<meta name="description" content="{!! $settingsInfo->description !!}" />
<meta name="twitter:title" content="{!! $settingsInfo->title !!}" />
<meta name="twitter:description" content="{!! $settingsInfo->description !!}" />
<meta name="keywords" content="{!! $settingsInfo->keywords !!}" />
@if(!empty($settingsInfo->refresh))
<meta http-equiv="refresh" content="{!! $settingsInfo->refresh !!}">
@endif
<meta property="og:image" content="{{asset('uploads/settings/'.$settingsInfo->default_img_1)}}" />
<meta name="twitter:image" content="{{asset('uploads/settings/'.$settingsInfo->default_img_1)}}" />
<meta property="og:type" content="website" />
<meta name="robots" content="index, follow" />

<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "Organization",
		"url": "{!! $settingsInfo->domain !!}",
		"logo": "{!! asset('uploads/settings/'.$settingsInfo->logo_1) !!}",
		"contactPoint" : [
		{
			"@type" : "ContactPoint",
			"email" : "{!! $settingsInfo->email !!}",
			"contactType" : "customer service"
		}
		],
		"sameAs" : [
		"{!! $settingsInfo->facebook !!}",
		"{!! $settingsInfo->twitter !!}",
		"{!! $settingsInfo->instagram !!}",
		"{!! $settingsInfo->linkedin !!}",
		"{!! $settingsInfo->youtube !!}"
		]
	}
</script>
<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "WebSite",
		"url": "{!! $settingsInfo->domain !!}",
		"description": "{!! $settingsInfo->description !!}",
		"publisher": "{!! $settingsInfo->newspaper_name !!}",
		"creator": [],
		"keywords": [{!! $settingsInfo->keywords !!}],
		"potentialAction": {
		"@type": "SearchAction",
		"target": "{{$settingsInfo->domain ? $settingsInfo->domain : '#'}}search?q={search_term_string}",
		"query-input": "required name=search_term_string"
	}
}
</script>
@endpush
@section('content')

<!-- desktop version start -->
<div data-nosnippet>
	<div class="bgWHite hidden-xs">

		<!-- featured lead news -->
		@if(!empty($fleadArticle))
		@php $article = \App\Models\Helper::processArticleShortly($fleadArticle, 0); @endphp
		<div class="marginB20 padding40 bgRed marginT-30">
			<div class="container">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-md-offset-2 paddingLR0 desktopSectionLead">
					<div class="thumbnail bgBlack">
						<div class="positionRelative">
							@if(!empty($article->video_code))
							<div class="fleadVideo">{!! $article->video_code !!}</div>
							@else
							<a href="{!! $article->url !!}" class=""><img src="{!! $article->thumb !!}" class="img-responsive borderTRadius5" alt="{!! $article->headline !!}"></a>
							@if($article->categoryTitle == 'photos')
							<span class="fa fa-image ppIconLarge"></span>
							@endif
							@endif
						</div>
						<div class="caption text-center flead">
							<p class="title8 marginT5 marginB5"><strong><a class="textDecorationNone colorWhite hoverBlue" href="{!! $article->url !!}" class="">{!! $article->fullheadline !!}</a></strong></p>
							@if(!empty($article->summary))
							<p class="desktopSummary marginB5 colorWhite">{!! $article->summary !!}</p>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
		<!-- featured lead news -->


		<!-- justnow news -->
		@if(!empty($justnowArticles) && (count($justnowArticles)>0))
		<div class="container marginB10">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingL8 paddingR8">
					<div class="newHeadlines">
						<div class="borderRadius5 borderC1-1">
							<table class="bd-color borderRadius5 justnowTable">
								<tbody>
									<tr>
										<td class="headlineNamingTd borderLRadius5 titleTd"><div class="bn-title">এইমাত্র<span></span></div></td>
										<td class="headlineContentTd">
											<marquee class="marquee" onmouseover="this.stop()" onmouseout="this.start()" scrollamount="6">
												@foreach($justnowArticles as $key => $list)
												@if(!empty($list->url))
												<a href="{!! $list->url !!}" class="textDecorationNone title11 paddingR25 hoverBlue color4"><i class="fa fa-circle circleIcon"></i> {!! $list->title !!}</a>
												@else
												<span class="textDecorationNone title11 paddingR25 color4"><i class="fa fa-circle circleIcon"></i> {!! $list->title !!}</span>
												@endif
												@endforeach
											</marquee>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		@else

		<!-- breaking news -->
		@if(!empty($breakingArticles) && (count($breakingArticles)>0))
		<div class="container marginB10">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingL8 paddingR8">
					<div class="newHeadlines">
						<div class="borderRadius5 borderC1-1">
							<table class="bd-color borderRadius5 justnowTable">
								<tbody>
									<tr>
										<td class="headlineNamingTd borderLRadius5 titleTd"><div class="bn-title">ব্রেকিং<span></span></div></td>
										<td class="headlineContentTd">
											<marquee class="marquee" onmouseover="this.stop()" onmouseout="this.start()" scrollamount="6">
												@foreach($breakingArticles as $key => $list)
												@if(!empty($list->url))
												<a href="{!! $list->url !!}" class="textDecorationNone title11 paddingR25 hoverBlue color4"><i class="fa fa-circle circleIcon"></i> {!! $list->title !!}</a>
												@else
												<span class="textDecorationNone title11 paddingR25 color4"><i class="fa fa-circle circleIcon"></i> {!! $list->title !!}</span>
												@endif
												@endforeach
											</marquee>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
		@endif


		<!-- election result -->
		@if(!empty($electionInfo) && (count($electionInfo)>0))
		<div class="container">
			<div class="row marginT10 marginB20">
				@foreach($electionInfo as $key => $electionInfoItem)
				@if(!empty($electionInfoItem))
				@php $totalResultItem = !empty($electionInfoItem->figuresShow) ? count($electionInfoItem->figuresShow) : 0; @endphp
				<div class="col-md-{{12/count($electionInfo)}}">
					<div class="borderRadius5 padding10" style="background-color: #eaf3e9 !important">
						<table class="table marginB0">
							<tbody>
								<tr class="bgBrandRed">
									<td colspan="{!! $totalResultItem*2 !!}" class="text-center title10 padding15 fontBold">{{$electionInfoItem->title}}</td>
								</tr>
								<tr>
									@if(!empty($electionInfoItem->figuresShow) && (count($electionInfoItem->figuresShow)>0))
									@foreach($electionInfoItem->figuresShow as $figureResult)
									@if(!empty($figureResult->figure_photo))
									<td class="xs-width50 hidden-xs bgAshLight width5P" style="vertical-align: middle;">
										<img class="xs-width50 borderRadius50P width70" src="{{env('UploadsLink').'uploads/elections/'.$figureResult->figure_photo}}" alt="{{$figureResult->figure_name}}" width="70">
									</td>
									@endif
									<td class="text-left bgAsh" style="padding-top: 20px;width: {!! (100-($totalResultItem*5))/$totalResultItem !!}%">
										<p class="fontSize22-0-991 marginB0 title3 colorBlack fontBold" style="font-size: 20px !important">{!! $figureResult->figure_name !!}</p>
										<table class="table marginT5 marginB0">
											<tr>
												<td class="title2 padding5 verticleAlignMiddle width50P fontBold" style="font-size: 18px !important;vertical-align: middle;">প্রাপ্ত আসন</td>
												<td class="title2 padding5 verticleAlignMiddle fontBold width50P" style="font-size: 18px !important;vertical-align: middle;">{{App\Http\Controllers\CommonController::GetBangla(number_format($figureResult->total_wins))}}</td>
											</tr>
											<tr>
												<td class="title2 padding5 verticleAlignMiddle fontBold width58P" style="font-size: 18px !important">প্রতীক</td>
												<td class="padding5 verticleAlignMiddle">
													@if(!empty($figureResult->symbol_logo))
													<img src="{{env('UploadsLink').'uploads/elections/'.$figureResult->symbol_logo}}" alt="{{$figureResult->symbol_name}}" class="borderRadius50P" width="20">
													@endif
												</td>
											</tr>
										</table>
									</td>
									@endforeach
									@endif
								</tr>
								<tr class="bgAsh">
									<td colspan="{!! $totalResultItem*2 !!}" class="text-center title2 padding15 colorBlack" style="font-size: 18px !important;padding: 10px;"><span style="background-color: #f1dcc4;padding: 7px 10px;border-radius: 5px;font-size: 16px;font-weight: bold;color: #333;">মোট ভোটার: {{App\Http\Controllers\CommonController::GetBangla(number_format($electionInfoItem->total_voter))}}</span> । <span style="background-color: #f1dcc4;padding: 7px 10px;border-radius: 5px;font-size: 16px;font-weight: bold;color: #333;">আসন: {{App\Http\Controllers\CommonController::GetBangla($electionInfoItem->total_center)}}</span> । <span style="background-color: #f1dcc4;padding: 7px 10px;border-radius: 5px;font-size: 16px;font-weight: bold;color: #333;">ঘোষিত আসন: {{App\Http\Controllers\CommonController::GetBangla($electionInfoItem->published_center)}}</span></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				@endif
				@endforeach
			</div>
		</div>
		@endif


		<!-- main event -->
		@if(!empty($mainEventArticles) && (count($mainEventArticles)>0))
		<div class="bg1">

			@if(empty($mainEventInfo->large_banner))
			<div class="row marginLR0">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingLR0">
					<p class="marginB0 text-center title9 padding20 bg3" style="padding-bottom: 30px !important;"><a aria-label="{!! $mainEventInfo->title !!}" href="{!! url('news-issue/'.$mainEventInfo->slug) !!}" class="textDecorationNone colorWhite hoverOrange fontUpperCase lineHeight35">{!! $mainEventInfo->title !!}</a></p>
				</div>
			</div>
			@endif

			<div class="container marginB30">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marginB20">
						<div class="borderC1-1 borderRadius5 paddingB5 bg1 shadow1 {!! empty($mainEventInfo->large_banner) ? 'marginT-20' : 'marginT20' !!}">
							@if(!empty($mainEventInfo->large_banner))
							<div class="row marginLR-10">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingLR10">
									<p class="marginB0"><a aria-label="{!! $mainEventInfo->title !!}" href="{!! url('news-issue/'.$mainEventInfo->slug) !!}" class="textDecorationNone colorWhite hoverOrange fontUpperCase lineHeight35"><img src="{{asset('uploads/events/'.$mainEventInfo->large_banner)}}" alt="{!! $mainEventInfo->title !!}" title="{!! $mainEventInfo->title !!}" class="img-responsive borderTRadius5"></a></p>
								</div>
							</div>
							@endif

							<div class="row marginLR-10 desktopFlexRow paddingLR20 marginT20">
								<div class="col-md-3">
									<div class="row">
										@for($i=1; $i<=2; $i++)
										@if(!empty($mainEventArticles[$i]))
										@php $article = \App\Models\Helper::processArticleShortly($mainEventArticles[$i], 0); @endphp
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingLR10 desktopSectionLead">
											<div class="thumbnail marginB15 h100P positionRelative">
												<div class="positionRelative">
													<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
													@if($article->categoryTitle == 'photos')
													<span class="fa fa-image ppIconMedium"></span>
													@elseif(!empty($article->video_code))
													<span class="fa fa-play pvIconMedium"></span>
													@endif
												</div>
												<div class="caption paddingLR10Imp borderBRadius5 text-center" style="position: absolute;background-color: #00000080;width: 100%;bottom: 0">
													<p class="title11 marginT0 colorWhite hoverBlue borderBRadius5 marginB0">{!! $article->fullheadline !!}</p>
													@if(!empty($article->summary))
													<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
													@endif
													<a href="{!! $article->url !!}" class="linkOverlay"></a>
												</div>
												<a href="{!! $article->url !!}" class="linkOverlay"></a>
											</div>
										</div>
										@endif
										@endfor
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										@for($i=0; $i<=0; $i++)
										@if(!empty($mainEventArticles[$i]))
										@php $article = \App\Models\Helper::processArticleShortly($mainEventArticles[$i], 0); @endphp
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingLR10 desktopSectionLead">
											<div class="thumbnail marginB0 h100P positionRelative">
												<div class="positionRelative">
													<img src="{!! $article->thumb !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
													@if($article->categoryTitle == 'photos')
													<span class="fa fa-image ppIconMedium"></span>
													@elseif(!empty($article->video_code))
													<span class="fa fa-play pvIconMedium"></span>
													@endif
												</div>
												<div class="caption paddingLR10Imp borderBRadius5 text-center" style="position: absolute;background-color: #00000080;width: 100%;bottom: 0">
													<p class="title10 marginT0 colorWhite hoverBlue borderBRadius5 marginB0">{!! $article->fullheadline !!}</p>
													@if(!empty($article->summary))
													<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
													@endif
													<a href="{!! $article->url !!}" class="linkOverlay"></a>
												</div>
												<a href="{!! $article->url !!}" class="linkOverlay"></a>
											</div>
										</div>
										@endif
										@endfor
									</div>
								</div>

								<div class="col-md-3">
									<div class="row">
										@for($i=3; $i<=4; $i++)
										@if(!empty($mainEventArticles[$i]))
										@php $article = \App\Models\Helper::processArticleShortly($mainEventArticles[$i], 0); @endphp
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingLR10 desktopSectionLead positionRelative">
											<div class="thumbnail marginB15 h100P positionRelative">
												<div class="positionRelative">
													<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
													@if($article->categoryTitle == 'photos')
													<span class="fa fa-image ppIconMedium"></span>
													@elseif(!empty($article->video_code))
													<span class="fa fa-play pvIconMedium"></span>
													@endif
												</div>
												<div class="caption paddingLR10Imp borderBRadius5 text-center" style="position: absolute;background-color: #00000080;width: 100%;bottom: 0">
													<p class="title11 marginT0 colorWhite hoverBlue borderBRadius5 marginB0">{!! $article->fullheadline !!}</p>
													@if(!empty($article->summary))
													<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
													@endif
													<a href="{!! $article->url !!}" class="linkOverlay"></a>
												</div>
												<a href="{!! $article->url !!}" class="linkOverlay"></a>
											</div>
										</div>
										@endif
										@endfor
									</div>
								</div>

								@if(!empty($mainEventArticles[5]))
								<div class="col-md-12">
									<div class="row">
										@for($i=5; $i<=8; $i++)
										@if(!empty($mainEventArticles[$i]))
										@php $article = \App\Models\Helper::processArticleShortly($mainEventArticles[$i], 0); @endphp
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 paddingLR10 desktopSectionLead positionRelative">
											<div class="thumbnail marginB15 h100P positionRelative">
												<div class="positionRelative">
													<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
													@if($article->categoryTitle == 'photos')
													<span class="fa fa-image ppIconMedium"></span>
													@elseif(!empty($article->video_code))
													<span class="fa fa-play pvIconMedium"></span>
													@endif
												</div>
												<div class="caption paddingLR10Imp borderBRadius5 text-center" style="position: absolute;background-color: #00000080;width: 100%;bottom: 0">
													<p class="title11 marginT0 colorWhite hoverBlue borderBRadius5 marginB0">{!! $article->fullheadline !!}</p>
													@if(!empty($article->summary))
													<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
													@endif
													<a href="{!! $article->url !!}" class="linkOverlay"></a>
												</div>
												<a href="{!! $article->url !!}" class="linkOverlay"></a>
											</div>
										</div>
										@endif
										@endfor
									</div>
								</div>
								@endif
							</div>

						</div>	
					</div>
				</div>	
			</div>
		</div>
		@endif
		<!-- main event end -->


		<!-- trending topics -->
		@if(!empty($trendingTopics) && (count($trendingTopics)>0))
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="marginT-15 hidden-print">
						<p>
							<span class="desktopTrendingTopicItem desktopTrendingTopicItemActive colorWhite">ট্রেন্ডিং</span>
							@foreach($trendingTopics as $key => $trendingTopic)
							<a class="desktopTrendingTopicItem" aria-label="{!! $trendingTopic->title !!}" href="{{url('/news-issue/'.$trendingTopic->slug)}}">{!! $trendingTopic->title !!} <i class="fa fa-angle-right title1_4"></i></a>
							@endforeach
						</p>
					</div>
				</div>
			</div>
		</div>
		@endif
		<!-- trending topics end -->


		<div class="container marginT20">
			<div class="row">
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 borderC1R1">
					<div class="row desktopFlexRow">

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 borderC1R1 desktopSectionTitleSmall">

							<!-- selected news -->
							@if(!empty($selectednews) && (count($selectednews)>0))
							<div class="desktopSectionTitleDiv2"><p class="desktopSectionTitle"><a aria-label="নির্বাচিত" href="{!! url('selected') !!}">নির্বাচিত</a></p></div>
							<div class="desktopSectionListMedia borderLastItemNone marginB15 borderC1B1">
								@for($i=0; $i<=3; $i++)
								@if(!empty($selectednews[$i]))
								@php $article = \App\Models\Helper::processArticleShortly($selectednews[$i], 0, 30); @endphp
								<div class="media positionRelative lastItemBorderNone">
									<div class="media-left">
										<div class="positionRelative">
											<img class="media-object borderRadius5" src="{!! $article->thumbSmall !!}" width="120" alt="{!! $article->headline !!}">
											@if($article->categoryTitle == 'photos')
											<span class="fa fa-image ppIconSmall"></span>
											@elseif(!empty($article->video_code))
											<span class="fa fa-play pvIconSmall"></span>
											@endif
										</div>
									</div>
									<div class="media-body">
										<p class="title11">{!! $article->headline2 !!}</p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginT10">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
								@endif
								@endfor
							</div>
							@endif

							<!-- Ad Desktop Home 2 -->
							@if(!empty($advPlacements[8]) && !empty($advPlacements[8]->activeOrder))
							<div class="adDiv borderRadius5 overflowHidden marginT15">
								@if($advPlacements[8]->activeOrder->ad_type == 2)
								{!! $advPlacements[8]->activeOrder->ad_code !!}
								@endif
								@if($advPlacements[8]->activeOrder->ad_type == 1)
								<a rel="sponsored" href="{{$advPlacements[8]->activeOrder->ad_url}}" target="_blank">
									<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[8]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
								</a>
								@endif
							</div>
							@endif
							<!-- Ad Desktop Home 2 -->
						</div>

						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="desktopSectionLead">
								@if(!empty($leadArticle))
								@php $article = \App\Models\Helper::processArticleShortly($leadArticle, 10); @endphp
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<img src="{!! $article->thumb !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption text-center">
										<p class="title8 marginT10 marginB10"><strong>{!! $article->fullheadline !!}</strong></p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
										<!-- <p class="desktopTime color1 marginB10 marginT15"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p> -->
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
								@endif
							</div>

							<p class="desktopDivider marginT0 marginB15"></p>

							<div class="row desktopFlexRow topThumbNews">
								@for($i=0; $i<=1; $i++)
								@if(!empty($topArticles[$i]))
								@php $article = \App\Models\Helper::processArticleShortly($topArticles[$i], 0); @endphp
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 paddingLR15 borderItem borderC1R1 desktopSectionLead">
									<div class="thumbnail marginB0">
										<div class="positionRelative">
											<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
											@if($article->categoryTitle == 'photos')
											<span class="fa fa-image ppIconMedium"></span>
											@elseif(!empty($article->video_code))
											<span class="fa fa-play pvIconMedium"></span>
											@endif
										</div>
										<div class="caption paddingB0">
											<p class="title11 marginT0">{!! $article->fullheadline !!}</p>
											@if(!empty($article->summary))
											<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
											@endif
										</div>
										<a href="{!! $article->url !!}" class="linkOverlay"></a>
									</div>
								</div>
								@endif
								@endfor
							</div>

							<p class="desktopDivider marginT15 marginB15"></p>
							<div class="row desktopFlexRow desktopSectionListMedia customTopArticles2">
								@for($i=2; $i<=3; $i++)
								@if(!empty($topArticles[$i]))
								@php $article = \App\Models\Helper::processArticleShortly($topArticles[$i], 0); @endphp
								<div class="col-md-6 borderC1R1 borderItem customTopArticleItems">
									<div class="media positionRelative h100P border0 padding0">
										<div class="media-body">
											<p class="title11"><strong>{!! $article->fullheadline !!}</strong></p>
											@if(!empty($article->summary))
											<p class="desktopSummary marginT10">{!! $article->summary !!}</p>
											@endif
										</div>
										<a href="{!! $article->url !!}" class="linkOverlay"></a>
									</div>
								</div>
								@endif
								@endfor
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marginT10">
							<p class="desktopDivider marginT0 marginB15"></p>
							<div class="row marginLR-10 desktopFlexRow topThumbNews customTopArticles">
								@for($i=4; $i < env('topnews'); $i++)
								@if(!empty($topArticles[$i]))
								@php $article = \App\Models\Helper::processArticleShortly($topArticles[$i], 0); @endphp
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 paddingLR10 borderItem borderC1R1 desktopSectionLead marginB20 customTopArticleItems">
									<div class="thumbnail marginB0">
										<div class="positionRelative">
											<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
											@if($article->categoryTitle == 'photos')
											<span class="fa fa-image ppIconMedium"></span>
											@elseif(!empty($article->video_code))
											<span class="fa fa-play pvIconMedium"></span>
											@endif
										</div>
										<div class="caption paddingB0">
											<p class="title11 marginT0">{!! $article->fullheadline !!}</p>
											@if(!empty($article->summary))
											<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
											@endif
										</div>
										<a href="{!! $article->url !!}" class="linkOverlay"></a>
									</div>
								</div>
								@endif
								@endfor
							</div>
						</div>

						@if(!empty($selected2news) && count($selected2news)>0)
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marginT10">
							<p class="desktopDivider marginT0 marginB15"></p>
							<div class="row marginLR-10 desktopFlexRow topThumbNews customTopArticles">
								@for($i = 0; $i <= 2; $i++)
								@if(!empty($selected2news[$i]))
								@php $article = \App\Models\Helper::processArticleShortly($selected2news[$i], 0); @endphp
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 paddingLR10 borderItem borderC1R1 desktopSectionLead marginB0 customTopArticleItems">
									<div class="thumbnail marginB0">
										<div class="positionRelative">
											<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
											@if($article->categoryTitle == 'photos')
											<span class="fa fa-image ppIconMedium"></span>
											@elseif(!empty($article->video_code))
											<span class="fa fa-play pvIconMedium"></span>
											@endif
										</div>
										<div class="caption paddingB0">
											<p class="title11 marginT0">{!! $article->fullheadline !!}</p>
											@if(!empty($article->summary))
											<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
											@endif
										</div>
										<a href="{!! $article->url !!}" class="linkOverlay"></a>
									</div>
								</div>
								@endif
								@endfor
							</div>
						</div>
						@endif

					</div>
				</div>

				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

					<!-- Ad Desktop Home 3 -->
					@if(!empty($advPlacements[12]) && !empty($advPlacements[12]->activeOrder))
					<div class="row marginT0">
						<div class="col-sm-12 col-md-12 marginB20">
							<div class="adDiv borderRadius5 overflowHidden">
								@if($advPlacements[12]->activeOrder->ad_type == 2)
								{!! $advPlacements[12]->activeOrder->ad_code !!}
								@endif
								@if($advPlacements[12]->activeOrder->ad_type == 1)
								<a rel="sponsored" href="{{$advPlacements[12]->activeOrder->ad_url}}" target="_blank">
									<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[12]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
								</a>
								@endif
							</div>
						</div>
					</div>
					@endif
					<!-- Ad Desktop Home 3 -->

					<!-- Ad Desktop Home 1 -->
					@if(!empty($advPlacements[6]) && !empty($advPlacements[6]->activeOrder))
					<div class="row marginT0">
						<div class="col-sm-12 col-md-12 marginB20">
							<div class="adDiv borderRadius5 overflowHidden">
								@if($advPlacements[6]->activeOrder->ad_type == 2)
								{!! $advPlacements[6]->activeOrder->ad_code !!}
								@endif
								@if($advPlacements[6]->activeOrder->ad_type == 1)
								<a rel="sponsored" href="{{$advPlacements[6]->activeOrder->ad_url}}" target="_blank">
									<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[6]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
								</a>
								@endif
							</div>
						</div>
					</div>
					@endif
					<!-- Ad Desktop Home 1 -->


					<!-- Ad Desktop Home 5 -->
					@if(!empty($advPlacements[16]) && !empty($advPlacements[16]->activeOrder))
					<div class="row">
						<div class="col-sm-12 col-md-12 marginB30">
							<div class="adDiv borderRadius5 overflowHidden">
								@if($advPlacements[16]->activeOrder->ad_type == 2)
								{!! $advPlacements[16]->activeOrder->ad_code !!}
								@endif
								@if($advPlacements[16]->activeOrder->ad_type == 1)
								<a rel="sponsored" href="{{$advPlacements[16]->activeOrder->ad_url}}" target="_blank">
									<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[16]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
								</a>
								@endif
							</div>
						</div>
					</div>
					@endif
					<!-- Ad Desktop Home 5 -->


					<!-- liveNews -->
					@if(!empty($liveNews) && (count($liveNews)>0))
					<div class="row marginB20">
						<div class="col-sm-12 col-md-12">
							<div class="borderRadius5 padding10 paddingB0" style="border: 2px dashed #017ac3 !important;">
								<p class="bgBrand text-center padding5 colorWhite title3 borderRadius5"><a class="colorWhite textDecorationNone" aria-label="{!! $liveNews[0]->display_name !!}" href="{!! url($liveNews[0]->title) !!}"><img src="{!! asset('uploads/settings/liveicon.gif') !!}" class="borderRadius50P verticalAlignMiddle marginT-2" style="height: 17px" /> {!! $liveNews[0]->display_name !!}</a></p>
								<div class="desktopSectionLead positionRelative">
									@if(!empty($liveNews[0]))
									@php $article = \App\Models\Helper::processArticleShortly($liveNews[0], 0); @endphp
									<div class="thumbnail marginB0">
										<div class="positionRelative">
											<img src="{!! $article->thumb !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
											@if($article->categoryTitle == 'photos')
											<span class="fa fa-image ppIconMedium"></span>
											@elseif(!empty($article->video_code))
											<span class="fa fa-play pvIconMedium"></span>
											@endif
										</div>
										<div class="caption text-center">
											<p class="title11 marginT0 marginB0">{!! $article->fullheadline !!}</p>
											@if(!empty($article->summary))
											<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
											@endif
										</div>
										<a href="{!! $article->url !!}" class="linkOverlay"></a>
									</div>
									@endif
								</div>
							</div>
						</div>
					</div>
					@endif
					<!-- liveNews end -->

					<!-- ramadan timings -->
					@if(date('Y-m-d') <= '2025-03-31')
					@if(!empty($ramadanTimings) && (count($ramadanTimings)>0))
					<div class="row">
						<div class="col-md-12 paddingR8 marginB30">
							<div>
								<div class="text-center cursorPointer positionRelative" style="margin-bottom: 0px;">
									<table class="table text-center" style="margin-bottom: 0px;">
										<thead>
											<tr style="background-color: #6F1818;color: white;font-size: 18px">
												<td style="padding: 5px 2px;border:none;font-size: 20px !important" colspan="4" class="text-center">সেহরি ও ইফতারের সময়সূচি</td>
											</tr>
											<tr>
												<th style="padding: 3px;font-size: 18px !important;background-color: #b8e365" class="text-center">তারিখ</th>
												<th style="padding: 3px;font-size: 18px !important;background-color: #62cf84" class="text-center">রমজান</th>
												<th style="padding: 3px;font-size: 18px !important;background-color: #57e182" class="text-center">সেহরি</th>
												<th style="padding: 3px;font-size: 18px !important;background-color: #40c068" class="text-center">ইফতার</th>
											</tr>
										</thead>
										<tbody>
											@foreach($ramadanTimings as $key => $ramadanTiming)
											<tr>
												<td style="padding: 3px;font-size: 18px !important;background-color: #b8e365">@php $ramadanDate = \App\Http\Controllers\CommonController::getBangla(date("d M Y", strtotime($ramadanTiming->date))); @endphp {{$ramadanDate}}</td>
												<td style="padding: 3px;font-size: 18px !important;background-color: #62cf84">{{$ramadanTiming->ramadan_no}}</td>
												<td style="padding: 3px;font-size: 18px !important;background-color: #57e182">{{$ramadanTiming->sahri}}</td>
												<td style="padding: 3px;font-size: 18px !important;background-color: #40c068">{{$ramadanTiming->iftar}}</td>
											</tr>
											@endforeach
											<tr style="background-color: #9fd179">
												<td colspan="4" style="padding: 3px;line-height: 16px;font-size: 14px">
													*ঢাকা ও আশেপাশের এলাকার জন্য প্রযোজ্য<br>
												সূত্র: ইসলামিক ফাউন্ডেশন বাংলাদেশ</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					@endif
					@endif


					<!-- category 1 -->
					@if(!empty($category_1) && (count($category_1)>0))
					<div class="marginB20 borderRadius5 padding15 paddingB0 borderC3-2">
						<div><p class="desktopSectionTitle" style="margin-bottom: -35px;font-size: 2.4rem"><a aria-label="{!! $category_1[0]->display_name !!}" href="{!! url($category_1[0]->title) !!}" style="margin-top: -66px;">{!! $category_1[0]->display_name !!}</a></p></div>
						<div class="desktopSectionListMedia borderLastItemNone">
							@for($i=0; $i<=1; $i++)
							@if(!empty($category_1[$i]))
							@php $article = \App\Models\Helper::processArticle($category_1[$i], 0); @endphp
							<div class="media positionRelative lastItemBorderNone">
								<div class="media-left">
									@if(!empty($article->authorInfo))
									<div class="positionRelative">
										<img width="70" class="media-object borderRadius50P" src="{!! asset('uploads/authors/'.$article->authorInfo->author_photo) !!}" alt="{!! $article->authorInfo->author_name !!}">
									</div>
									@else
									<div class="positionRelative borderRadius50P" style="width: 70px !important;height: 70px;overflow: hidden;">
										<img class="media-object" src="{!! $article->thumbSmall !!}" alt="{!! $article->headline !!}" style="object-fit: cover;transform: translate(-25%, 0);margin-top: 0px !important">
									</div>
									@endif
								</div>
								<div class="media-body">
									<p class="title11">{!! $article->fullheadline !!}</p>
									@if(!empty($article->summary))
									<p class="desktopSummary marginT10">{!! $article->summary !!}</p>
									@endif
									<p class="desktopTime marginT10"><i class="fa fa-pen"></i> {!! !empty($article->authorInfo) ? $article->authorInfo->author_name : $article->reporter !!}</p>
								</div>
								<a href="{!! $article->url !!}" class="linkOverlay"></a>
							</div>
							@endif
							@endfor
						</div>
					</div>
					@endif
					<!-- category 1 end -->


					<!-- latest popular news -->
					<div class="row popularNewsWidgetDesktop">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marginB20">
							@include('layouts.latest-popular-tab-news')
						</div>
					</div>
					<!-- latest popular news end -->


					<!-- Ad Desktop Home 4 -->
					@if(!empty($advPlacements[15]) && !empty($advPlacements[15]->activeOrder))
					<div class="row">
						<div class="col-sm-12 col-md-12 marginB20">
							<div class="adDiv borderRadius5 overflowHidden">
								@if($advPlacements[15]->activeOrder->ad_type == 2)
								{!! $advPlacements[15]->activeOrder->ad_code !!}
								@endif
								@if($advPlacements[15]->activeOrder->ad_type == 1)
								<a rel="sponsored" href="{{$advPlacements[15]->activeOrder->ad_url}}" target="_blank">
									<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[15]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
								</a>
								@endif
							</div>
						</div>
					</div>
					@endif
					<!-- Ad Desktop Home 4 -->
					
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<p class="desktopDivider marginT15 marginB0"></p>
				</div>

			</div>
		</div>


		<!-- category 2 -->
		@if(!empty($category_2) && (count($category_2)>0))
		<div class="container marginT70">
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<div class="desktopSectionTitleDiv2">
						<p class="desktopSectionTitle"><a aria-label="{!! $category_2[0]->display_name !!}" href="{!! url($category_2[0]->title) !!}">{!! $category_2[0]->display_name !!}</a></p>
					</div>
				</div>

				@if(!empty($category_2[0]))
				@php $article = \App\Models\Helper::processArticleShortly($category_2[0], 28); @endphp
				<div class="col-sm-5 col-md-5 desktopSectionLead">
					<div class="thumbnail bgUnset">
						<div class="positionRelative">
							<img src="{!! $article->thumb !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
							@if($article->categoryTitle == 'photos')
							<span class="fa fa-image ppIconLarge"></span>
							@elseif(!empty($article->video_code))
							<span class="fa fa-play pvIconLarge"></span>
							@endif
						</div>
						<div class="caption paddingB0">
							<p class="title10 marginT0"><strong>{!! $article->fullheadline !!}</strong></p>
							@if(!empty($article->summary))
							<p class="desktopSummary marginB5 marginT10">{!! $article->summary !!}</p>
							@endif
						</div>
						<a href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>
				</div>
				@endif

				<div class="col-sm-7 col-md-7">
					<div class="row marginLR-10 desktopFlexRow">
						@for($i=1; $i<=3; $i++)
						@if(!empty($category_2[$i]))
						@php $article = \App\Models\Helper::processArticleShortly($category_2[$i], 0, 45); @endphp
						<div class="col-sm-4 col-md-4 paddingLR10 desktopSectionLead">
							<div class="thumbnail bgUnset">
								<div class="positionRelative">
									<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
									@if($article->categoryTitle == 'photos')
									<span class="fa fa-image ppIconMedium"></span>
									@elseif(!empty($article->video_code))
									<span class="fa fa-play pvIconMedium"></span>
									@endif
								</div>
								<div class="caption paddingB0">
									<p class="title11 marginT0">{!! $article->fullheadline2 !!}</p>
									@if(!empty($article->summary))
									<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
									@endif
								</div>
								<a href="{!! $article->url !!}" class="linkOverlay"></a>
							</div>
						</div>
						@endif
						@endfor
					</div>

					<p class="desktopDivider marginT10 marginB15"></p>

					<div class="row marginLR-10 desktopFlexRow">
						@for($i=4; $i<=6; $i++)
						@if(!empty($category_2[$i]))
						@php $article = \App\Models\Helper::processArticleShortly($category_2[$i], 0, 45); @endphp
						<div class="col-sm-4 col-md-4 paddingLR10 desktopSectionLead">
							<div class="thumbnail bgUnset">
								<div class="positionRelative">
									<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
									@if($article->categoryTitle == 'photos')
									<span class="fa fa-image ppIconMedium"></span>
									@elseif(!empty($article->video_code))
									<span class="fa fa-play pvIconMedium"></span>
									@endif
								</div>
								<div class="caption paddingB0">
									<p class="title11 marginT0">{!! $article->fullheadline2 !!}</p>
									@if(!empty($article->summary))
									<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
									@endif
								</div>
								<a href="{!! $article->url !!}" class="linkOverlay"></a>
							</div>
						</div>
						@endif
						@endfor
					</div>
				</div>
				<div class="col-sm-12 col-md-12">
					<p class="desktopDivider marginT10 marginB15"></p>
				</div>
			</div>
		</div>
		@endif
		<!-- category 2 end -->


		<!-- videos -->
		<div class="bgVideo marginT70 paddingT60 paddingB40">
			<div class="container">
				<div class="row">
					@if(!empty($videoGalleries) && (count($videoGalleries)>0))
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="desktopSectionTitleDiv2">
									<p class="desktopSectionTitle"><a class="bgVideo colorWhite hoverBlack" aria-label="{!! $videoGalleries[0]->display_name !!}" href="{!! url($videoGalleries[0]->title) !!}">{!! $videoGalleries[0]->display_name !!}</a></p>
								</div>
							</div>
						</div>
						<div class="row marginLR-10">
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 paddingLR10">
								<div class="row marginLR-10 desktopFlexRow">
									@for($i=1; $i<=2; $i++)
									@if(!empty($videoGalleries[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($videoGalleries[$i], 0); @endphp
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingLR10 desktopSectionLead">
										<div class="thumbnail marginB15">
											<div class="positionRelative">
												<img src="{!! !empty($article->thumb2) ? $article->thumb2 : $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
												<span class="fa fa-play pvIconMedium"></span>
											</div>
											<a href="{!! $article->url !!}" class="linkOverlay"></a>
										</div>
									</div>
									@endif
									@endfor
								</div>
							</div>

							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 paddingLR10">
								<div class="row desktopFlexRow">
									@if(!empty($videoGalleries[0]))
									@php $article = \App\Models\Helper::processArticleShortly($videoGalleries[0], 30); @endphp
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 desktopSectionLead">
										<div class="thumbnail marginB0">
											<div class="positionRelative">
												<img src="{!! !empty($article->thumb2) ? $article->thumb2 : $article->thumb !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
												<span class="fa fa-play pvIconLarge"></span>
											</div>
									<!-- <div class="caption">
										<p class="title10 marginT0"><strong>{!! $article->fullheadline !!}</strong></p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div> -->
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif
						</div>
					</div>

					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 paddingLR10">
						<div class="row marginLR-10 desktopFlexRow">
							@for($i=3; $i<=4; $i++)
							@if(!empty($videoGalleries[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($videoGalleries[$i], 0); @endphp
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingLR10 desktopSectionLead">
								<div class="thumbnail marginB15">
									<div class="positionRelative">
										<img src="{!! !empty($article->thumb2) ? $article->thumb2 : $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										<span class="fa fa-play pvIconMedium"></span>
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif
							@endfor
						</div>
					</div>
				</div>

				<div class="row marginLR-10 desktopFlexRow">
					@for($i=5; $i<=8; $i++)
					@if(!empty($videoGalleries[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($videoGalleries[$i], 0); @endphp
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 paddingLR10 desktopSectionLead">
						<div class="thumbnail marginB15">
							<div class="positionRelative">
								<img src="{!! !empty($article->thumb2) ? $article->thumb2 : $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
								<span class="fa fa-play pvIconMedium"></span>
							</div>
							<a href="{!! $article->url !!}" class="linkOverlay"></a>
						</div>
					</div>
					@endif
					@endfor
				</div>

			</div>
			@endif
		</div>
	</div>
</div>
<!-- videos end -->


<div class="container marginT70">
	<div class="row">
		<!-- category 4 -->
		@if(!empty($category_4) && (count($category_4)>0))
		<div class="col-sm-6 col-md-6 borderC1R1">
			<div class="row marginLR-10">
				<div class="col-sm-12 col-md-12 marginLR-5">
					<div class="desktopSectionTitleDiv2">
						<p class="desktopSectionTitle"><a aria-label="{!! $category_4[0]->display_name !!}" href="{!! url($category_4[0]->title) !!}">{!! $category_4[0]->display_name !!}</a></p>
					</div>
				</div>

				@if(!empty($category_4[0]))
				@php $article = \App\Models\Helper::processArticleShortly($category_4[0], 20); @endphp
				<div class="col-sm-12 col-md-12 paddingLR10">
					<div class="row desktopSectionLead">
						<div class="col-sm-6 col-md-6">
							<div class="thumbnail">
								<div class="positionRelative">
									<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
									@if($article->categoryTitle == 'photos')
									<span class="fa fa-image ppIconLarge"></span>
									@elseif(!empty($article->video_code))
									<span class="fa fa-play pvIconLarge"></span>
									@endif
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 paddingL0">
							<div class="caption">
								<p class="title10 marginT-5 marginB5"><strong>{!! $article->fullheadline !!}</strong></p>
								@if(!empty($article->summary))
								<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
								@endif
							</div>
						</div>
						<a href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>
				</div>
				@endif

				<div class="col-sm-12 col-md-12 paddingLR10"><p class="desktopDivider marginT15 marginB5"></p></div>
				<div class="col-sm-12 col-md-12 paddingLR10 marginT10">
					<div class="row marginLR-10 desktopFlexRow">
						@for($i=1; $i<=3; $i++)
						@if(!empty($category_4[$i]))
						@php $article = \App\Models\Helper::processArticleShortly($category_4[$i], 0, 45); @endphp
						<div class="col-sm-4 col-md-4 paddingLR10 desktopSectionLead">
							<div class="thumbnail marginB0">
								<div class="positionRelative">
									<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
									@if($article->categoryTitle == 'photos')
									<span class="fa fa-image ppIconMedium"></span>
									@elseif(!empty($article->video_code))
									<span class="fa fa-play pvIconMedium"></span>
									@endif
								</div>
								<div class="caption">
									<p class="title11 marginT0">{!! $article->fullheadline2 !!}</p>
									@if(!empty($article->summary))
									<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
									@endif
								</div>
								<a href="{!! $article->url !!}" class="linkOverlay"></a>
							</div>
						</div>
						@endif
						@endfor
					</div>
				</div>
				<div class="col-sm-12 col-md-12 paddingLR10"><p class="desktopDivider marginT0 marginB0"></p></div>
			</div>
		</div>
		@endif


		<!-- category 5 -->
		@if(!empty($category_5) && (count($category_5)>0))
		<div class="col-sm-6 col-md-6">
			<div class="row marginLR-10">
				<div class="col-sm-12 col-md-12 marginLR-5">
					<div class="desktopSectionTitleDiv2">
						<p class="desktopSectionTitle"><a aria-label="{!! $category_5[0]->display_name !!}" href="{!! url($category_5[0]->title) !!}">{!! $category_5[0]->display_name !!}</a></p>
					</div>
				</div>

				@if(!empty($category_5[0]))
				@php $article = \App\Models\Helper::processArticleShortly($category_5[0], 20); @endphp
				<div class="col-sm-12 col-md-12 paddingLR10">
					<div class="row desktopSectionLead">
						<div class="col-sm-6 col-md-6">
							<div class="thumbnail">
								<div class="positionRelative">
									<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
									@if($article->categoryTitle == 'photos')
									<span class="fa fa-image ppIconLarge"></span>
									@elseif(!empty($article->video_code))
									<span class="fa fa-play pvIconLarge"></span>
									@endif
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 paddingL0">
							<div class="caption">
								<p class="title10 marginT-5 marginB5"><strong>{!! $article->fullheadline !!}</strong></p>
								@if(!empty($article->summary))
								<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
								@endif
							</div>
						</div>
						<a href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>
				</div>
				@endif

				<div class="col-sm-12 col-md-12 paddingLR10"><p class="desktopDivider marginT15 marginB5"></p></div>
				<div class="col-sm-12 col-md-12 paddingLR10 marginT10">
					<div class="row marginLR-10 desktopFlexRow">
						@for($i=1; $i<=3; $i++)
						@if(!empty($category_5[$i]))
						@php $article = \App\Models\Helper::processArticleShortly($category_5[$i], 0, 45); @endphp
						<div class="col-sm-4 col-md-4 paddingLR10 desktopSectionLead">
							<div class="thumbnail marginB0">
								<div class="positionRelative">
									<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
									@if($article->categoryTitle == 'photos')
									<span class="fa fa-image ppIconMedium"></span>
									@elseif(!empty($article->video_code))
									<span class="fa fa-play pvIconMedium"></span>
									@endif
								</div>
								<div class="caption">
									<p class="title11 marginT0">{!! $article->fullheadline2 !!}</p>
									@if(!empty($article->summary))
									<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
									@endif
								</div>
								<a href="{!! $article->url !!}" class="linkOverlay"></a>
							</div>
						</div>
						@endif
						@endfor
					</div>
				</div>
				<div class="col-sm-12 col-md-12 paddingLR10"><p class="desktopDivider marginT0 marginB0"></p></div>
			</div>
		</div>
		@endif

	</div>
</div>


<div class="container marginT70">
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<div class="adDiv">
				<img src="{!! env('UploadsLink').'uploads/advertisements/ad-1.jpg' !!}" class="img-responsive w100P" alt="ad">
			</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<div class="adDiv">
				<img src="{!! env('UploadsLink').'uploads/advertisements/ad-2.jpg' !!}" class="img-responsive w100P" alt="ad">
			</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<div class="adDiv">
				<img src="{!! env('UploadsLink').'uploads/advertisements/ad-3.jpg' !!}" class="img-responsive w100P" alt="ad">
			</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<div class="adDiv">
				<img src="{!! env('UploadsLink').'uploads/advertisements/ad-4.jpg' !!}" class="img-responsive w100P" alt="ad">
			</div>
		</div>
	</div>
</div>


<div class="container marginT70">
	<div class="row">
		<!-- category 6 -->
		@if(!empty($category_6) && (count($category_6)>0))
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="desktopSectionTitleDiv2">
						<p class="desktopSectionTitle"><a aria-label="{!! $category_6[0]->display_name !!}" href="{!! url($category_6[0]->title) !!}">{!! $category_6[0]->display_name !!}</a></p>
					</div>
				</div>
			</div>
			<div class="row marginLR-10">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 paddingLR10">
					<div class="row marginLR-10 desktopFlexRow">
						@for($i=1; $i<=2; $i++)
						@if(!empty($category_6[$i]))
						@php $article = \App\Models\Helper::processArticleShortly($category_6[$i], 0); @endphp
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingLR10 desktopSectionLead">
							<div class="thumbnail marginB0">
								<div class="positionRelative">
									<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
									@if($article->categoryTitle == 'photos')
									<span class="fa fa-image ppIconMedium"></span>
									@elseif(!empty($article->video_code))
									<span class="fa fa-play pvIconMedium"></span>
									@endif
								</div>
								<div class="caption">
									<p class="title11 marginT0">{!! $article->fullheadline !!}</p>
									@if(!empty($article->summary))
									<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
									@endif
								</div>
								<a href="{!! $article->url !!}" class="linkOverlay"></a>
							</div>
						</div>
						@endif
						@endfor
					</div>
				</div>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 paddingLR10">
					<div class="row desktopFlexRow">
						@if(!empty($category_6[0]))
						@php $article = \App\Models\Helper::processArticleShortly($category_6[0], 30, 60); @endphp
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 desktopSectionLead">
							<div class="thumbnail marginB0">
								<div class="positionRelative">
									<img src="{!! $article->thumb !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
									@if($article->categoryTitle == 'photos')
									<span class="fa fa-image ppIconMedium"></span>
									@elseif(!empty($article->video_code))
									<span class="fa fa-play pvIconMedium"></span>
									@endif
								</div>
								<div class="caption text-center">
									<p class="title10 marginT0"><strong>{!! $article->fullheadline2 !!}</strong></p>
									@if(!empty($article->summary))
									<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
									@endif
								</div>
								<a href="{!! $article->url !!}" class="linkOverlay"></a>
							</div>
						</div>
						@endif
					</div>
				</div>

				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 paddingLR10">
					<div class="row marginLR-10 desktopFlexRow">
						@for($i=3; $i<=4; $i++)
						@if(!empty($category_6[$i]))
						@php $article = \App\Models\Helper::processArticleShortly($category_6[$i], 0); @endphp
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingLR10 desktopSectionLead">
							<div class="thumbnail marginB0">
								<div class="positionRelative">
									<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
									@if($article->categoryTitle == 'photos')
									<span class="fa fa-image ppIconMedium"></span>
									@elseif(!empty($article->video_code))
									<span class="fa fa-play pvIconMedium"></span>
									@endif
								</div>
								<div class="caption">
									<p class="title11 marginT0">{!! $article->fullheadline !!}</p>
									@if(!empty($article->summary))
									<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
									@endif
								</div>
								<a href="{!! $article->url !!}" class="linkOverlay"></a>
							</div>
						</div>
						@endif
						@endfor
					</div>
				</div>
			</div>
		</div>
		@endif
		<!-- category 6 end -->
	</div>

	<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><p class="desktopDivider marginT0 marginB10"></p></div></div>
</div>



{{-- <div class="container marginT70">
	<div class="row">
		<!-- category 6 -->
		@if(!empty($category_6) && (count($category_6)>0))
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="desktopSectionTitleDiv2">
						<p class="desktopSectionTitle"><a aria-label="{!! $category_6[0]->display_name !!}" href="{!! url($category_6[0]->title) !!}">{!! $category_6[0]->display_name !!}</a></p>
					</div>
				</div>
			</div>
			<div class="row marginLR-10">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 paddingLR10">
					<div class="row marginLR-10 desktopFlexRow">
						@for($i=1; $i<=4; $i++)
						@if(!empty($category_6[$i]))
						@php $article = \App\Models\Helper::processArticleShortly($category_6[$i], 0); @endphp
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 paddingLR10 desktopSectionLead">
							<div class="thumbnail marginB0">
								<div class="positionRelative">
									<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
									@if($article->categoryTitle == 'photos')
									<span class="fa fa-image ppIconMedium"></span>
									@elseif(!empty($article->video_code))
									<span class="fa fa-play pvIconMedium"></span>
									@endif
								</div>
								<div class="caption">
									<p class="title11 marginT0">{!! $article->fullheadline !!}</p>
									@if(!empty($article->summary))
									<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
									@endif
								</div>
								<a href="{!! $article->url !!}" class="linkOverlay"></a>
							</div>
						</div>
						@endif
						@endfor
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 paddingLR10">
					<div class="row desktopFlexRow">
						@if(!empty($category_6[0]))
						@php $article = \App\Models\Helper::processArticleShortly($category_6[0], 30); @endphp
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 desktopSectionLead">
							<div class="thumbnail marginB0">
								<div class="positionRelative">
									<img src="{!! $article->thumb !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
									@if($article->categoryTitle == 'photos')
									<span class="fa fa-image ppIconMedium"></span>
									@elseif(!empty($article->video_code))
									<span class="fa fa-play pvIconMedium"></span>
									@endif
								</div>
								<div class="caption">
									<p class="title10 marginT0"><strong>{!! $article->fullheadline !!}</strong></p>
									@if(!empty($article->summary))
									<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
									@endif
								</div>
								<a href="{!! $article->url !!}" class="linkOverlay"></a>
							</div>
						</div>
						@endif
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 paddingLR10">
					<div class="row marginLR-10 desktopFlexRow">
						@for($i=5; $i<=8; $i++)
						@if(!empty($category_6[$i]))
						@php $article = \App\Models\Helper::processArticleShortly($category_6[$i], 0); @endphp
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 paddingLR10 desktopSectionLead">
							<div class="thumbnail marginB0">
								<div class="positionRelative">
									<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
									@if($article->categoryTitle == 'photos')
									<span class="fa fa-image ppIconMedium"></span>
									@elseif(!empty($article->video_code))
									<span class="fa fa-play pvIconMedium"></span>
									@endif
								</div>
								<div class="caption">
									<p class="title11 marginT0">{!! $article->fullheadline !!}</p>
									@if(!empty($article->summary))
									<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
									@endif
								</div>
								<a href="{!! $article->url !!}" class="linkOverlay"></a>
							</div>
						</div>
						@endif
						@endfor
					</div>
				</div>
			</div>
		</div>
		@endif
		<!-- category 6 end -->
	</div>

	<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><p class="desktopDivider marginT0 marginB10"></p></div></div>
</div> --}}



<!-- category 3 -->
@if(!empty($category_3) && (count($category_3)>0))
<div class="container marginT40">
	<!-- location search -->
		<!-- <div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="desktopSectionTitleDiv2">
					<p class="desktopSectionTitle marginT0 marginB20"><a>আপনার এলাকার খবর</a></p>
				</div>
			</div>

			<div class="col-sm-12 col-md-12">
				<div class="desktopLocationDiv marginB20 paddingTB0 paddingLR10">
					<div class="row">
						<div class="col-sm-12 col-md-12 searchMessageDiv paddingLR5" style="display: none;">
							<div class="alert alert-warning alert-dismissible fade in marginB15 text-center title12" role="alert"> <button type="button" class="close colorBlack bgUnset" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> <strong>প্রিয় পাঠক!</strong> বিভাগ, জেলা ও উপজেলা সঠিকভাবে পছন্দ করে অনুসন্ধান করুন। ধন্যবাদ।</div>
						</div>
						<div class="col-sm-3 col-md-3 paddingLR5">
							<div>
								<select class="form-control selectDivision" name="division">
									<option value="">বিভাগ</option>
									@if(!empty($divisions) && (count($divisions)>0))
									@foreach($divisions as $key => $division)
									<option data-division="{!! $division->title !!}" value="{!! $division->id !!}">{!! $division->display_name !!}</option>
									@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="col-sm-3 col-md-3 paddingLR5">
							<div>
								<select class="form-control selectDistrict" name="district">
									<option value="">জেলা</option>
								</select>
							</div>
						</div>
						<div class="col-sm-3 col-md-3 paddingLR5">
							<div>
								<select class="form-control selectUpazila" name="upazila">
									<option value="">উপজেলা</option>
								</select>
							</div>
						</div>
						<div class="col-sm-3 col-md-3 paddingLR5">
							<div>
								<button type="button" class="btn btn-block clickSearchButton bgRed">অনুসন্ধান</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> -->
		<!-- location search end -->


		<div class="row marginT30">
			<div class="col-sm-12 col-md-12">
				<div class="desktopSectionTitleDiv2">
					<p class="desktopSectionTitle"><a aria-label="{!! $category_3[0]->display_name !!}" href="{!! url($category_3[0]->title) !!}">{!! $category_3[0]->display_name !!}</a></p>
				</div>
			</div>

			<div class="col-sm-8 col-md-8 borderC1R1">
				<div class="row marginLR-10">
					<div class="col-sm-6 col-md-6 paddingLR10">
						<div class="row desktopFlexRow">
							@if(!empty($category_3[0]))
							@php $article = \App\Models\Helper::processArticleShortly($category_3[0], 6); @endphp
							<div class="col-sm-12 col-md-12 desktopSectionLead">
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<img src="{!! $article->thumb !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption">
										<p class="title10 marginT0"><strong>{!! $article->fullheadline !!}</strong></p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif
						</div>
					</div>

					<div class="col-sm-6 col-md-6 paddingLR10">
						<div class="desktopSectionListMedia listItemFirstPT0 listItemLastBB0 marginT-5">
							@for($i=1; $i<=3; $i++)
							@if(!empty($category_3[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($category_3[$i], 0); @endphp
							<div class="media positionRelative">
								<div class="media-left">
									<div class="positionRelative">
										<img class="media-object borderRadius5" src="{!! $article->thumbSmall !!}" width="160" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconSmall"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconSmall"></span>
										@endif
									</div>
								</div>
								<div class="media-body marginL5">
									<p class="title11">{!! $article->fullheadline !!}</p>
									@if(!empty($article->summary))
									<p class="desktopSummary marginT10">{!! $article->summary !!}</p>
									@endif
								</div>
								<a href="{!! $article->url !!}" class="linkOverlay"></a>
							</div>
							@endif
							@endfor
						</div>
					</div>

					<div class="col-sm-12 col-md-12 paddingLR10"><p class="desktopDivider marginT0 marginB10"></p></div>

					<div class="col-sm-12 col-md-12 paddingLR10 marginT5">
						<div class="row desktopSectionListMedia listItemFirstPT0 listItemLastBB0 marginLR-10">
							@for($i=4; $i<=6; $i++)
							@if(!empty($category_3[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($category_3[$i], 0, 50); @endphp
							<div class="col-sm-4 col-md-4 paddingLR10 desktopSectionLead">
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption">
										<p class="title11 marginT0">{!! $article->fullheadline2 !!}</p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif
							@endfor
						</div>
					</div>
				</div>
			</div>

			<!-- map -->
			<div class="col-sm-4 col-md-4">
				<div class="borderC1-1 borderRadius5 padding20">
					@include('other-pages.map')
				</div>
			</div>

			<div class="col-sm-12 col-md-12">
				<p class="desktopDivider marginT10 marginB15"></p>
			</div>

		</div>
	</div>
	@endif
	<!-- category 3 end -->


	<div class="container marginT70">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="adDiv">
					<img src="{!! env('UploadsLink').'uploads/advertisements/ad-5.jpg' !!}" class="img-responsive w100P" alt="ad">
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="adDiv">
					<img src="{!! env('UploadsLink').'uploads/advertisements/ad-6.jpg' !!}" class="img-responsive w100P" alt="ad">
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="adDiv">
					<img src="{!! env('UploadsLink').'uploads/advertisements/ad-7.jpg' !!}" class="img-responsive w100P" alt="ad">
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="adDiv">
					<img src="{!! env('UploadsLink').'uploads/advertisements/ad-8.jpg' !!}" class="img-responsive w100P" alt="ad">
				</div>
			</div>
		</div>
	</div>



	<div class="container marginT70">
		<div class="row">
			<!-- category 8 -->
			@if(!empty($category_8) && (count($category_8)>0))
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="desktopSectionTitleDiv2">
							<p class="desktopSectionTitle"><a aria-label="{!! $category_8[0]->display_name !!}" href="{!! url($category_8[0]->title) !!}">{!! $category_8[0]->display_name !!}</a></p>
						</div>
					</div>
				</div>
				<div class="row marginLR-10">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 paddingLR10">
						<div class="row marginLR-10 desktopFlexRow">
							@for($i=1; $i<=2; $i++)
							@if(!empty($category_8[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($category_8[$i], 0); @endphp
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingLR10 desktopSectionLead">
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption">
										<p class="title11 marginT0">{!! $article->fullheadline !!}</p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif
							@endfor
						</div>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 paddingLR10">
						<div class="row desktopFlexRow">
							@if(!empty($category_8[0]))
							@php $article = \App\Models\Helper::processArticleShortly($category_8[0], 30, 60); @endphp
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 desktopSectionLead">
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<img src="{!! $article->thumb !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption text-center">
										<p class="title10 marginT0"><strong>{!! $article->fullheadline2 !!}</strong></p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif
						</div>
					</div>

					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 paddingLR10">
						<div class="row marginLR-10 desktopFlexRow">
							@for($i=3; $i<=4; $i++)
							@if(!empty($category_8[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($category_8[$i], 0); @endphp
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingLR10 desktopSectionLead">
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption">
										<p class="title11 marginT0">{!! $article->fullheadline !!}</p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif
							@endfor
						</div>
					</div>
				</div>
			</div>
			@endif
			<!-- category 8 end -->
		</div>

		<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><p class="desktopDivider marginT0 marginB10"></p></div></div>
	</div>


	<div class="container marginT70">
		<div class="row">
			<div class="col-sm-9 col-md-9">
				<div class="row">
					<!-- category 7 -->
					@if(!empty($category_7) && (count($category_7)>0))
					<div class="col-sm-12 col-md-12">
						<div class="row">
							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionTitleDiv2">
									<p class="desktopSectionTitle"><a aria-label="{!! $category_7[0]->display_name !!}" href="{!! url($category_7[0]->title) !!}">{!! $category_7[0]->display_name !!}</a></p>
								</div>
							</div>
						</div>
						<div class="row marginLR-15">
							<div class="col-sm-12 col-md-12 paddingLR10">
								<div class="row marginLR-5 desktopFlexRow">
									@if(!empty($category_7[0]))
									@php $article = \App\Models\Helper::processArticleShortly($category_7[0], 20); @endphp
									<div class="col-sm-8 col-md-8 paddingLR10 desktopSectionLead">
										<div class="thumbnail marginB0">
											<div class="positionRelative">
												<img src="{!! $article->thumb !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
												@if($article->categoryTitle == 'photos')
												<span class="fa fa-image ppIconMedium"></span>
												@elseif(!empty($article->video_code))
												<span class="fa fa-play pvIconMedium"></span>
												@endif
											</div>
											<div class="caption">
												<p class="title10 marginT0"><strong>{!! $article->fullheadline !!}</strong></p>
												@if(!empty($article->summary))
												<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
												@endif
											</div>
											<a href="{!! $article->url !!}" class="linkOverlay"></a>
										</div>
									</div>
									@endif

									<div class="col-sm-4 col-md-4 paddingLR10">
										<div class="row marginLR-5 desktopFlexRow">
											@for($i=1; $i<=2; $i++)
											@if(!empty($category_7[$i]))
											@php $article = \App\Models\Helper::processArticleShortly($category_7[$i], 0); @endphp
											<div class="col-sm-12 col-md-12 paddingLR5 desktopSectionLead">
												<div class="thumbnail marginB0">
													<div class="positionRelative">
														<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
														@if($article->categoryTitle == 'photos')
														<span class="fa fa-image ppIconMedium"></span>
														@elseif(!empty($article->video_code))
														<span class="fa fa-play pvIconMedium"></span>
														@endif
													</div>
													<div class="caption">
														<p class="title11 marginT0">{!! $article->fullheadline !!}</p>
														@if(!empty($article->summary))
														<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
														@endif
													</div>
													<a href="{!! $article->url !!}" class="linkOverlay"></a>
												</div>
											</div>
											@endif
											@endfor
										</div>
									</div>

								</div>
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingLR15"><p class="desktopDivider marginT0 marginB15"></p></div>

							<div class="col-sm-12 col-md-12 paddingLR10">
								<div class="row marginLR-5 desktopFlexRow">
									@for($i=3; $i<=5; $i++)
									@if(!empty($category_7[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($category_7[$i], 0); @endphp
									<div class="col-sm-4 col-md-4 paddingLR10 desktopSectionLead">
										<div class="thumbnail marginB0">
											<div class="positionRelative">
												<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
												@if($article->categoryTitle == 'photos')
												<span class="fa fa-image ppIconMedium"></span>
												@elseif(!empty($article->video_code))
												<span class="fa fa-play pvIconMedium"></span>
												@endif
											</div>
											<div class="caption">
												<p class="title11 marginT0">{!! $article->fullheadline !!}</p>
												@if(!empty($article->summary))
												<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
												@endif
											</div>
											<a href="{!! $article->url !!}" class="linkOverlay"></a>
										</div>
									</div>
									@endif
									@endfor
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-12"><p class="desktopDivider marginT0 marginB10"></p></div>
					@endif
					<!-- category 7 end -->
				</div>
			</div>


			<div class="col-sm-3 col-md-3">


				<!-- Ad Desktop Home 6 -->
				@if(!empty($advPlacements[17]) && !empty($advPlacements[17]->activeOrder))
				<div class="row">
					<div class="col-sm-12 col-md-12 marginB20">
						<div class="adDiv borderRadius5 overflowHidden">
							@if($advPlacements[17]->activeOrder->ad_type == 2)
							{!! $advPlacements[17]->activeOrder->ad_code !!}
							@endif
							@if($advPlacements[17]->activeOrder->ad_type == 1)
							<a rel="sponsored" href="{{$advPlacements[17]->activeOrder->ad_url}}" target="_blank">
								<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[17]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
							</a>
							@endif
						</div>
					</div>
				</div>
				@endif
				<!-- Ad Desktop Home 6 -->


				<!-- Ad Desktop Home 7 -->
				@if(!empty($advPlacements[18]) && !empty($advPlacements[18]->activeOrder))
				<div class="row">
					<div class="col-sm-12 col-md-12 marginB20">
						<div class="adDiv borderRadius5 overflowHidden">
							@if($advPlacements[18]->activeOrder->ad_type == 2)
							{!! $advPlacements[18]->activeOrder->ad_code !!}
							@endif
							@if($advPlacements[18]->activeOrder->ad_type == 1)
							<a rel="sponsored" href="{{$advPlacements[18]->activeOrder->ad_url}}" target="_blank">
								<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[18]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
							</a>
							@endif
						</div>
					</div>
				</div>
				@endif
				<!-- Ad Desktop Home 7 -->


				<!-- Ad 9 rupayan -->
				<div class="row">
					<div class="col-sm-12 col-md-12 marginB20">
						<div class="adDiv borderRadius5 overflowHidden">
							<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/ad-9.jpg'}}" border="0" alt="ad-img"/>
						</div>
					</div>
				</div>
				<!-- Ad rupayan -->


				<!-- poll -->
				@if(!empty($todaysQuestion))
				@php $todaysQuestion = App\Models\Helper::processPoll($todaysQuestion); @endphp
				<div class="row marginT0">
					<div class="col-sm-12 col-md-12 marginB20">
						<div class="marginCenter w300" id="pollContentDiv{!! $todaysQuestion->id !!}">
							<div >
								<p class="pollTitle"><a aria-label="অনলাইন জরিপ" href="{!! url('poll') !!}" class="colorWhite hoverBlack textDecorationNone">অনলাইন জরিপ</a> <span class="downloadPoll" data-pollid="{!! $todaysQuestion->id !!}" data-polldate="{!! $todaysQuestion->poll_date_bangla !!}"><i class="fa fa-download"></i></span></p>
								@if(!empty($todaysQuestion->image))
								<div>
									<a class="textDecorationNone" href="{!! $todaysQuestion->url !!}">
										<img src="{!! asset('uploads/polls/'.$todaysQuestion->image) !!}" class="img-responsive" alt="{!! $todaysQuestion->question !!}">
									</a>
								</div>
								@endif
								<div class="paddingB0 pollTextDiv">
									<div class="thumbnail padding0 border0 marginB0">
										<div class="caption text-left paddingT0">
											<p class="desktopTime color1 marginB10"><i class="fa fa-regular fa-clock"></i> <span class="pollDate">{!! $todaysQuestion->poll_date_bangla !!}</span></p>
											<p class="title4 marginT0"><a class="textDecorationNone colorBlack" href="{!! $todaysQuestion->url !!}"><span>{!! $todaysQuestion->question !!}</span></a></p>

											<div class="marginT10">
												<p class="pollOption"><label class="clickVote" data-pollid="{!! $todaysQuestion->id !!}" data-votetype="yes"><input class="clickVoteInput{!! $todaysQuestion->id !!}" type="radio" name="poll_vote" value="yes"> হ্যাঁ ভোট <span class="pull-right totalyesVote{!! $todaysQuestion->id !!}">{!! $todaysQuestion->yes_vote_percent_bangla !!} %</span></label></p>

												<p class="pollOption"><label class="clickVote" data-pollid="{!! $todaysQuestion->id !!}" data-votetype="no"><input class="clickVoteInput{!! $todaysQuestion->id !!}" type="radio" name="poll_vote" value="no"> না ভোট <span class="pull-right totalNoVote{!! $todaysQuestion->id !!}">{!! $todaysQuestion->no_vote_percent_bangla !!} %</span></label></p>

												<p class="pollOption"><label class="clickVote" data-pollid="{!! $todaysQuestion->id !!}" data-votetype="no_comment"><input class="clickVoteInput{!! $todaysQuestion->id !!}" type="radio" name="poll_vote" value="no_comment"> মন্তব্য নেই <span class="pull-right totalNoCommentVote{!! $todaysQuestion->id !!}">{!! $todaysQuestion->no_opinion_vote_percent_bangla !!} %</span></label></p>
											</div>

											<div class="text-center marginT20 marginB20">
												<p class="title12 color1">মোট ভোটদাতাঃ <span class="totalVoter{!! $todaysQuestion->id !!}">{!! App\Models\Helper::GetBangla($todaysQuestion->total_vote_bangla) !!}</span> জন</p>
											</div>

											<div class="text-center marginT10 pollDownloadTime" style="display: none;">
												<p class="marginT30 marginB0"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_1) !!}" class="img-responsive marginCenter h50" alt="Logo"></p>
												<p class="title1_6 colorBlack">ডাউনলোডঃ {!! App\Models\Helper::GetBangla(date('d M Y, H:i A')) !!}</p>
											</div>

											<div class="row downloadPollShareIcon">
												<div class="col-xs-12 text-center marginB10">
													<!-- sharethis -->
													<div class="sharethis-inline-share-buttons" data-url="{!! $todaysQuestion->url !!}" data-title="{!! $todaysQuestion->question !!}"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endif
				<!-- poll -->

				<!-- archive -->
				<!-- <div class="row ">
					<div class="col-sm-12 col-md-12 marginB20">
						<div class="marginCenter w300 borderRadius5 shadow1">
							<div class="desktopLocationDiv positionRelative">
								<p class="bgRed padding8 title2_3 colorWhite borderTRadius5 marginB0"><a aria-label="আর্কাইভ" href="{!! url('archive') !!}" class="colorWhite hoverBlue textDecorationNone">আর্কাইভ</a></p>
								<div class="padding15">
									<div class="row">
										
										<div class="col-sm-6 col-md-6 paddingLR5">
											<div class="marginL10">
												<select class="form-control selectDay archiveDays">
													<option value="">দিন</option>
												</select>
											</div>
										</div>

										<div class="col-sm-6 col-md-6 paddingLR5">
											<div class="marginR10">
												<select class="form-control selectMonth archiveMonths">
													<option value="">মাস</option>
												</select>
											</div>
										</div>

										<div class="col-sm-12 col-md-12 marginT15">
											<div>
												<select class="form-control selecYear archiveYears">
													<option value="">বছর</option>
												</select>
											</div>
										</div>

										<div class="col-sm-12 col-md-12 marginT15">
											<div>
												<button type="button" class="btn btn-block clickSearchArchive bgRed">অনুসন্ধান</button>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div> -->
				<!-- archive end -->

			</div>

		</div>
	</div>


	<!-- desktop ajax load home -->
	<div class="ajaxDesktopHome"><div class="text-center title11">লোড হচ্ছে <i class="fa fa-spinner title1_4"></i></div></div>
	<!-- desktop ajax load home -->

</div>
<!-- desktop version end -->



<!-- mobile version start -->
<div class="bgWHite visible-xs">

	<!-- featured lead news -->
	@if(!empty($fleadArticle))
	@php $article = \App\Models\Helper::processArticleShortly($fleadArticle, 0); @endphp
	<div class="marginB20 padding20 bgRed">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingLR0 sectionLead">
					<div class="thumbnail bgBlack">
						<div class="positionRelative">
							@if(!empty($article->video_code))
							<div class="fleadVideo">{!! $article->video_code !!}</div>
							@else
							<a href="{!! $article->url !!}" class=""><img src="{!! $article->thumb !!}" class="img-responsive borderTRadius5" alt="{!! $article->headline !!}"></a>
							@if($article->categoryTitle == 'photos')
							<span class="fa fa-image ppIconLarge"></span>
							@endif
							@endif
						</div>
						<div class="caption text-center">
							<p class="title3Large marginT5 marginB5"><a class="textDecorationNone colorWhite hoverBlue" href="{!! $article->url !!}" class="">{!! $article->fullheadline !!}</a></p>
							@if(!empty($article->summary))
							<p class="desktopSummary marginB5 colorWhite">{!! $article->summary !!}</p>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif
	<!-- featured lead news -->


	<!-- justnow news -->
	@if(!empty($justnowArticles) && (count($justnowArticles)>0))
	<div class="container marginB10 marginT20">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingL8 paddingR8">
				<div class="newHeadlines">
					<div class="borderRadius5 borderC1-1 mobileJustnow">
						<table class="bd-color borderRadius5 justnowTable">
							<tbody>
								<tr>
									<td class="headlineNamingTd borderLRadius5 titleTd"><div class="bn-title">এইমাত্র<span></span></div></td>
									<td class="headlineContentTd">
										<marquee class="marquee" onmouseover="this.stop()" onmouseout="this.start()" scrollamount="6">
											@foreach($justnowArticles as $key => $list)
											@if(!empty($list->url))
											<a href="{!! $list->url !!}" class="textDecorationNone title12 paddingR25 hoverBlue color4"><i class="fa fa-circle circleIcon"></i> {!! $list->title !!}</a>
											@else
											<span class="textDecorationNone title12 paddingR25 color4"><i class="fa fa-circle circleIcon"></i> {!! $list->title !!}</span>
											@endif
											@endforeach
										</marquee>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	@else

	<!-- breaking news -->
	@if(!empty($breakingArticles) && (count($breakingArticles)>0))
	<div class="container marginB10 marginT20">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingL8 paddingR8">
				<div class="newHeadlines">
					<div class="borderRadius5 borderC1-1 mobileJustnow">
						<table class="bd-color borderRadius5 justnowTable">
							<tbody>
								<tr>
									<td class="headlineNamingTd borderLRadius5 titleTd"><div class="bn-title">ব্রেকিং<span></span></div></td>
									<td class="headlineContentTd">
										<marquee class="marquee" onmouseover="this.stop()" onmouseout="this.start()" scrollamount="6">
											@foreach($breakingArticles as $key => $list)
											@if(!empty($list->url))
											<a href="{!! $list->url !!}" class="textDecorationNone title12 paddingR25 hoverBlue color4"><i class="fa fa-circle circleIcon"></i> {!! $list->title !!}</a>
											@else
											<span class="textDecorationNone title12 paddingR25 color4"><i class="fa fa-circle circleIcon"></i> {!! $list->title !!}</span>
											@endif
											@endforeach
										</marquee>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif
	@endif



	<!-- election result -->
	@if(!empty($electionInfo) && (count($electionInfo)>0))
	<div class="container">
		<div class="row marginT20 marginB0">
			@foreach($electionInfo as $key => $electionInfoItem)
			@if(!empty($electionInfoItem))
			<div class="col-md-{{12/count($electionInfo)}} col-xs-12 marginB20">
				<div class="bgAshLight borderRadius5" style="border: 5px solid #dcdcdc;">
					<table class="table marginB0" style="background-color: #eaf3e9">
						<tbody>
							<tr class="">
								<td colspan="8" class="text-center title10 padding15 fontBold">{{$electionInfoItem->title}}</td>
							</tr>

							@if(!empty($electionInfoItem->figuresShow) && (count($electionInfoItem->figuresShow)>0))
							@foreach($electionInfoItem->figuresShow as $figureResult)
							<tr>
								<td class="xs-width50 bgAshLight width5P" style="vertical-align: middle;background-color: #ededed;text-align: center;">
									@if(!empty($figureResult->figure_photo))
									<img class="xs-width50 borderRadius50P width70" src="{{env('UploadsLink').'uploads/elections/'.$figureResult->figure_photo}}" alt="{{$figureResult->figure_name}}" style="width: 60px;border: 5px solid white">
									@else
									<img class="xs-width50 borderRadius50P width70" src="{{env('UploadsLink').'uploads/elections/default.png'}}" alt="Default Photo" style="width: 60px;border: 5px solid white">
									@endif
								</td>
								<td class="text-left bgAsh">
									<p class="fontSize22-0-991 marginB0 title12 colorBlack">{{$figureResult->figure_name}}</p>
									<table class="table marginT5 marginB0" style="background-color: unset;">
										<tr>
											<td class="title11 verticleAlignMiddle fontBold width58P" style="width: 50%;padding: 5px 0px 0px">{{App\Http\Controllers\CommonController::GetBangla(number_format($figureResult->total_wins))}}</td>
										</tr>
									</table>
								</td>
							</tr>
							@endforeach
							@endif
							<tr class="bgAsh">
								<td colspan="8" class="text-center title12 padding5 colorBlack">মোট ভোটার: {{App\Http\Controllers\CommonController::GetBangla(number_format($electionInfoItem->total_voter))}} । আসন: {{App\Http\Controllers\CommonController::GetBangla($electionInfoItem->total_center)}} । ঘোষিত আসন: {{App\Http\Controllers\CommonController::GetBangla($electionInfoItem->published_center)}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			@endif
			@endforeach
		</div>
	</div>
	@endif


	<!-- main event -->
	@if(!empty($mainEventArticles) && (count($mainEventArticles)>0))
	<div class="bg1">
		@if(empty($mainEventInfo->small_banner))
		<div class="row marginLR0">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingLR0">
				<p class="marginB0 text-center title9 padding20" style="background-color: #777777 !important;padding-bottom: 30px !important;"><a aria-label="{!! $mainEventInfo->title !!}" href="{!! url('news-issue/'.$mainEventInfo->slug) !!}" class="textDecorationNone colorWhite hoverOrange fontUpperCase lineHeight35">{!! $mainEventInfo->title !!}</a></p>
			</div>
		</div>
		@endif

		<div class="container marginB10 {!! empty($mainEventInfo->small_banner) ? 'marginT-30' : 'marginT5' !!}">
			<div class="row">
				<div class="col-sm-12 col-md-12 marginT15">
					<div class="borderC1-1 borderRadius5 bg1 shadow1 marginB20">

						@if(!empty($mainEventInfo->small_banner))
						<div class="row marginLR-10">
							<div class="col-sm-12 col-md-12 paddingLR10">
								<p class="marginB0"><a aria-label="{!! $mainEventInfo->title !!}" href="{!! url('news-issue/'.$mainEventInfo->slug) !!}" class="textDecorationNone colorWhite hoverOrange fontUpperCase lineHeight35"><img src="{{asset('uploads/events/'.$mainEventInfo->small_banner)}}" alt="{!! $mainEventInfo->title !!}" title="{!! $mainEventInfo->title !!}" class="img-responsive borderTRadius5"></a></p>
							</div>
						</div>
						@endif

						<div class="row marginLR-10 paddingLR10 marginT10">
							@if(!empty($mainEventArticles[0]))
							@php $article = \App\Models\Helper::processArticleShortly($mainEventArticles[0], 0); @endphp
							<div class="col-sm-12 col-md-12 col-xs-12  sectionListThumbnail marginB0" style="padding-left: 10px !important; padding-right: 10px !important">
								<div class="thumbnail h100P bg1">
									<div class="positionRelative">
										<img src="{!! $article->thumbMedium !!}" class="img-responsive borderTRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption paddingLR0 text-center paddingB5">
										<p class="marginT0 marginB0 title3Large">{!! $article->fullheadline !!}</p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif
							<div class="col-sm-12 col-md-12 col-xs-12 paddingLR0"><div class="borderC1T1"></div></div>
						</div>

						<div class="row marginLR-10 desktopFlexRow paddingLR10 marginT10">
							@for($i=1; $i<=4; $i++)
							@if(!empty($mainEventArticles[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($mainEventArticles[$i], 0); @endphp
							<div class="col-sm-6 col-md-6 col-xs-6 paddingLR5 sectionListThumbnail marginB5">
								<div class="thumbnail h100P bg1">
									<div class="positionRelative">
										<img src="{!! $article->thumbMedium !!}" class="img-responsive borderTRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption paddingLR0 text-center">
										<p class="xs-title marginT0">{!! $article->headline2 !!}</p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif
							@endfor
						</div>

					</div>	
				</div>
			</div>	
		</div>
	</div>
	@endif
	<!-- main event end -->



	<!-- trending topics -->
	@if(!empty($trendingTopics) && (count($trendingTopics)>0))
	<div class="container marginT0 borderC1B1">
		<div class="row">
			<div class="col-xs-12 paddingLR15 margin0">
				<div class="mobileHeaderCategoryDiv">
					<span class="mobileTrendingTopicItem mobileTrendingTopicItemActive colorWhite">ট্রেন্ডিং</span>
					@foreach($trendingTopics as $key => $trendingTopic)
					<a class="mobileTrendingTopicItem" aria-label="{!! $trendingTopic->title !!}" href="{{url('/news-issue/'.$trendingTopic->slug)}}">{!! $trendingTopic->title !!} <i class="fa fa-angle-right title1_2"></i></a>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	@endif
	<!-- trending topics end -->

	<div class="container marginT15">

		<!-- lead section -->
		<div class="row">
			@if(!empty($leadArticle))
			@php $article = \App\Models\Helper::processArticleShortly($leadArticle, 15); @endphp
			<div class="col-sm-12 col-md-12 sectionLead padding0 margin0">
				<div class="thumbnail">
					<div class="positionRelative">
						<img src="{!! $article->thumb !!}" class="img-responsive" alt="{!! $article->headline !!}">
						@if(!empty($article->video_code))
						<span class="fa fa-play pvIconLarge"></span>
						@elseif($article->categoryTitle == 'photos')
						<span class="fa fa-image ppIconLarge"></span>
						@endif
					</div>
					<div class="caption text-center">
						<p class="title3Large colorBlack marginT10 marginB5"><strong>{!! $article->fullheadline !!}</strong></p>
						@if(!empty($article->summary))
						<p class="summary marginT10 marginB10 colorBlack">{!! $article->summary !!}</p>
						@endif
						<!-- <p class="time"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p> -->
					</div>
				</div>
				<a href="{!! $article->url !!}" class="linkOverlay"></a>
			</div>
			@endif
			<div class="col-sm-12 col-md-12 paddingLR0"><div class="borderC1T1"></div></div>


			<!-- liveNews -->
			@if(!empty($liveNews) && (count($liveNews)>0))
			<div class="col-sm-12 col-md-12 paddingLR20 marginT15 marginB10">
				<div class="borderRadius5 padding10 paddingB0" style="border: 2px dashed #017ac3 !important;">
					<p class="bgBrand text-center padding5 colorWhite title3 borderRadius5"><a class="colorWhite textDecorationNone" aria-label="{!! $liveNews[0]->display_name !!}" href="{!! url($liveNews[0]->title) !!}"><img src="{!! asset('uploads/settings/liveicon.gif') !!}" class="borderRadius50P verticalAlignMiddle marginT-2" style="height: 17px" /> {!! $liveNews[0]->display_name !!}</a></p>
					<div class="sectionLead positionRelative">
						@if(!empty($liveNews[0]))
						@php $article = \App\Models\Helper::processArticleShortly($liveNews[0], 0); @endphp
						<div class="thumbnail marginB0">
							<div class="positionRelative">
								<img src="{!! $article->thumb !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
								@if($article->categoryTitle == 'photos')
								<span class="fa fa-image ppIconMedium"></span>
								@elseif(!empty($article->video_code))
								<span class="fa fa-play pvIconMedium"></span>
								@endif
							</div>
							<div class="caption text-center">
								<p class="title3 marginT0 marginB0">{!! $article->fullheadline !!}</p>
								@if(!empty($article->summary))
								<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
								@endif
							</div>
							<a href="{!! $article->url !!}" class="linkOverlay"></a>
						</div>
						@endif
					</div>
				</div>
			</div>
			@endif
			<!-- liveNews end -->


			<div class="col-sm-12 col-md-12 paddingLR20 marginT5">
				<div class="sectionListMedia">
					@for($i=0; $i < env('topnews'); $i++)
					@if(!empty($topArticles[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($topArticles[$i], 0); @endphp
					<div class="media positionRelative">
						<div class="media-left paddingR5">
							<div class="positionRelative">
								<img class="media-object" src="{!! $article->thumbSmall !!}" width="140" alt="{!! $article->headline !!}">
								@if(!empty($article->video_code))
								<span class="fa fa-play pvIconSmall"></span>
								@endif
							</div>
						</div>
						<div class="media-body">
							<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
						</div>
						<a href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>

					
					@if($i == 2)
					<!-- Ad Mobile Home 2 -->
					@if(!empty($advPlacements[9]) && !empty($advPlacements[9]->activeOrder))
					<div class="media positionRelative">
						<div class="adDiv w320 borderRadius5 overflowHidden marginT5">
							@if($advPlacements[9]->activeOrder->ad_type == 2)
							{!! $advPlacements[9]->activeOrder->ad_code !!}
							@endif
							@if($advPlacements[9]->activeOrder->ad_type == 1)
							<a rel="sponsored" href="{{$advPlacements[9]->activeOrder->ad_url}}" target="_blank">
								<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[9]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
							</a>
							@endif
						</div>
					</div>
					@endif
					<!-- Ad Mobile Home 2 -->
					@endif
					

					@if($i == 7)
					<!-- Ad Mobile Home 8 -->
					@if(!empty($advPlacements[24]) && !empty($advPlacements[24]->activeOrder))
					<div class="media positionRelative">
						<div class="adDiv w320 borderRadius5 overflowHidden marginT5">
							@if($advPlacements[24]->activeOrder->ad_type == 2)
							{!! $advPlacements[24]->activeOrder->ad_code !!}
							@endif
							@if($advPlacements[24]->activeOrder->ad_type == 1)
							<a rel="sponsored" href="{{$advPlacements[24]->activeOrder->ad_url}}" target="_blank">
								<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[24]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
							</a>
							@endif
						</div>
					</div>
					@endif
					<!-- Ad Mobile Home 8 -->
					@endif
					

					@endif
					@endfor
				</div>
			</div>
			<div class="col-sm-12 col-md-12 paddingLR20"><div class="borderC1T1"></div></div>


			<!-- Ad Mobile Home 1 -->
			@if(!empty($advPlacements[7]) && !empty($advPlacements[7]->activeOrder))
			<div class="col-sm-12 col-md-12 marginT15">
				<div class="adDiv w320">
					@if($advPlacements[7]->activeOrder->ad_type == 2)
					{!! $advPlacements[7]->activeOrder->ad_code !!}
					@endif
					@if($advPlacements[7]->activeOrder->ad_type == 1)
					<a rel="sponsored" href="{{$advPlacements[7]->activeOrder->ad_url}}" target="_blank">
						<img class="img-responsive borderRadius5" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[7]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
					</a>
					@endif
				</div>
			</div>
			<div class="col-sm-12 col-md-12 paddingLR0 marginT15"><div class="borderC1T1 marginT15"></div></div>
			@endif
			<!-- Ad Mobile Home 1 -->
			

			@if(!empty($selected2news) && count($selected2news)>0)
			<div class="col-sm-12 col-md-12 paddingLR20 marginT5">
				<div class="sectionListMedia">
					@for($i = 0; $i <= 2; $i++)
					@if(!empty($selected2news[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($selected2news[$i], 0); @endphp
					<div class="media positionRelative">
						<div class="media-left paddingR5">
							<div class="positionRelative">
								<img class="media-object" src="{!! $article->thumbSmall !!}" width="140" alt="{!! $article->headline !!}">
								@if(!empty($article->video_code))
								<span class="fa fa-play pvIconSmall"></span>
								@endif
							</div>
						</div>
						<div class="media-body">
							<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
						</div>
						<a href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>
					@endif
					@endfor
				</div>
			</div>
			<div class="col-sm-12 col-md-12 paddingLR20"><div class="borderC1T1"></div></div>
			@endif

		</div>
		<!-- lead section end -->


		<!-- ramadan timings -->
		@if(date('Y-m-d') <= '2025-03-31')
		@if(!empty($ramadanTimings) && (count($ramadanTimings)>0))
		<div class="row marginT20">
			<div class="col-md-12 paddingLR20">
				<div>
					<div class="text-center positionRelative" style="margin-bottom: 0px;">
						<table class="table text-center" style="margin-bottom: 0px;">
							<thead>
								<tr style="background-color: #6F1818;color: white;font-size: 18px">
									<td style="padding: 5px 2px;border:none;font-size: 20px !important" colspan="4" class="text-center">সেহরি ও ইফতারের সময়সূচি</td>
								</tr>
								<tr>
									<th style="padding: 3px;font-size: 18px !important;background-color: #b8e365" class="text-center">তারিখ</th>
									<th style="padding: 3px;font-size: 18px !important;background-color: #62cf84" class="text-center">রমজান</th>
									<th style="padding: 3px;font-size: 18px !important;background-color: #57e182" class="text-center">সেহরি</th>
									<th style="padding: 3px;font-size: 18px !important;background-color: #40c068" class="text-center">ইফতার</th>
								</tr>
							</thead>
							<tbody>
								@foreach($ramadanTimings as $key => $ramadanTiming)
								<tr>
									<td style="padding: 3px;font-size: 18px !important;background-color: #b8e365">@php $ramadanDate = \App\Http\Controllers\CommonController::getBangla(date("d M Y", strtotime($ramadanTiming->date))); @endphp {{$ramadanDate}}</td>
									<td style="padding: 3px;font-size: 18px !important;background-color: #62cf84">{{$ramadanTiming->ramadan_no}}</td>
									<td style="padding: 3px;font-size: 18px !important;background-color: #57e182">{{$ramadanTiming->sahri}}</td>
									<td style="padding: 3px;font-size: 18px !important;background-color: #40c068">{{$ramadanTiming->iftar}}</td>
								</tr>
								@endforeach
								<tr style="background-color: #9fd179">
									<td colspan="4" style="padding: 3px;line-height: 16px;font-size: 14px">
										*ঢাকা ও আশেপাশের এলাকার জন্য প্রযোজ্য<br>
									সূত্র: ইসলামিক ফাউন্ডেশন বাংলাদেশ</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		@endif
		@endif


		<!-- Ad Mobile Home 3 -->
		@if(!empty($advPlacements[14]) && !empty($advPlacements[14]->activeOrder))
		<div class="row marginT30">
			<div class="col-sm-12 col-md-12">
				<div class="adDiv w300">
					@if($advPlacements[14]->activeOrder->ad_type == 2)
					{!! $advPlacements[14]->activeOrder->ad_code !!}
					@endif
					@if($advPlacements[14]->activeOrder->ad_type == 1)
					<a rel="sponsored" href="{{$advPlacements[14]->activeOrder->ad_url}}" target="_blank">
						<img class="img-responsive borderRadius5" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[14]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
					</a>
					@endif
				</div>
			</div>
		</div>
		@endif
		<!-- Ad Mobile Home 3 -->


		<!-- selected news -->
		@if(!empty($selectednews) && (count($selectednews)>0))
		<div class="row marginT30 selectedNews">
			<div class="col-sm-12 col-md-12 paddingLR20">
				<div class="borderRadius5 padding10 paddingB0 borderD2C1">
					<p class="bgBrand text-center padding5 colorWhite title3 borderRadius5"><a class="colorWhite textDecorationNone" aria-label="নির্বাচিত" href="{!! url('selected') !!}">নির্বাচিত</a></p>
					<div class="sectionListMedia marginT-5">
						@for($i=0; $i<=3; $i++)
						@if(!empty($selectednews[$i]))
						@php $article = \App\Models\Helper::processArticleShortly($selectednews[$i], 0); @endphp
						<div class="media positionRelative">
							<div class="media-left paddingR5">
								<div class="positionRelative">
									<img class="media-object" src="{!! $article->thumbSmall !!}" width="140" alt="{!! $article->headline !!}">
									@if(!empty($article->video_code))
									<span class="fa fa-play pvIconSmall"></span>
									@endif
								</div>
							</div>
							<div class="media-body">
								<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
							</div>
							<a href="{!! $article->url !!}" class="linkOverlay"></a>
						</div>
						@endif
						@endfor
					</div>
				</div>
			</div>
		</div>
		@endif
		<!-- selected news end -->

		<!-- category 1 -->
		@if(!empty($category_1) && (count($category_1)>0))
		<div class="row marginT50">
			<div class="col-sm-12 col-md-12 paddingLR20">
				<div class="marginB20 borderRadius5 padding15 paddingB0 borderC3-2">
					<div><p class="desktopSectionTitle" style="margin-bottom: -35px;font-size: 2.4rem"><a aria-label="{!! $category_1[0]->display_name !!}" href="{!! url($category_1[0]->title) !!}" style="margin-top: -65px;">{!! $category_1[0]->display_name !!}</a></p></div>
					<div class="sectionListMedia borderLastItemNone">
						@for($i=0; $i<=1; $i++)
						@if(!empty($category_1[$i]))
						@php $article = \App\Models\Helper::processArticle($category_1[$i], 0); @endphp
						<div class="media positionRelative lastItemBorderNone">
							<div class="media-left">
								@if(!empty($article->authorInfo))
								<div class="positionRelative borderRadius50P">
									<img width="70" class="media-object borderRadius50P" src="{!! asset('uploads/authors/'.$article->authorInfo->author_photo) !!}" alt="{!! $article->authorInfo->author_name !!}">
								</div>
								@else
								<div class="positionRelative borderRadius50P" style="width: 70px !important;height: 70px;overflow: hidden;">
									<img class="media-object" src="{!! $article->thumbSmall !!}" alt="{!! $article->headline !!}" style="object-fit: cover;transform: translate(-25%, 0);margin-top: 0px !important">
								</div>
								@endif
							</div>
							<div class="media-body">
								<p class="xs-title">{!! $article->fullheadline !!}</p>
								@if(!empty($article->summary))
								<p class="summary marginT10">{!! $article->summary !!}</p>
								@endif
								<p class="time marginT10"><i class="fa fa-pen" style="background-color: #edebeb;height: 15px;width: 15px;text-align: center;border-radius: 50%;font-size: .8rem;line-height: 1.6rem;"></i> {!! !empty($article->authorInfo) ? $article->authorInfo->author_name : $article->reporter !!}</p>
							</div>
							<a href="{!! $article->url !!}" class="linkOverlay"></a>
						</div>
						@endif
						@endfor
					</div>
				</div>
			</div>
		</div>
		@endif
		<!-- category 1 end -->


		<!-- latest popular news -->
		<div class="row marginT20 popularNewsWidgetMobile">
			<div class="col-sm-12 col-md-12 paddingLR20">
				@include('layouts.latest-popular-tab-news')
			</div>
		</div>
		<!-- latest popular news end -->


		<!-- Ad Mobile Home 4 -->
		@if(!empty($advPlacements[19]) && !empty($advPlacements[19]->activeOrder))
		<div class="row marginT30">
			<div class="ccol-sm-12 col-md-12 paddingLR20">
				<div class="adDiv w300">
					@if($advPlacements[19]->activeOrder->ad_type == 2)
					{!! $advPlacements[19]->activeOrder->ad_code !!}
					@endif
					@if($advPlacements[19]->activeOrder->ad_type == 1)
					<a rel="sponsored" href="{{$advPlacements[19]->activeOrder->ad_url}}" target="_blank">
						<img class="img-responsive borderRadius5" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[19]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
					</a>
					@endif
				</div>
			</div>
		</div>
		@endif
		<!-- Ad Mobile Home 4 -->


		<!-- category 2 -->
		@if(!empty($category_2) && (count($category_2)>0))
		<div class="row marginT50">
			<div class="col-sm-12 col-md-12 paddingLR0">
				<div class="sectionTitleDiv2">
					<p class="sectionTitle"><a aria-label="{!! $category_2[0]->display_name !!}" href="{!! url($category_2[0]->title) !!}">{!! $category_2[0]->display_name !!}</a></p>
				</div>
			</div>

			@if(!empty($category_2[0]))
			@php $article = \App\Models\Helper::processArticleShortly($category_2[0], 0); @endphp
			<div class="col-sm-12 col-md-12 sectionLead padding0 margin0">
				<div class="thumbnail">
					<div class="positionRelative">
						<img src="{!! $article->thumb !!}" class="img-responsive" alt="{!! $article->headline !!}">
						@if(!empty($article->video_code))
						<span class="fa fa-play pvIconLarge"></span>
						@endif
					</div>
					<div class="caption">
						<p class="title3"><strong>{!! $article->fullheadline !!}</strong></p>
					</div>
					<a href="{!! $article->url !!}" class="linkOverlay"></a>
				</div>
			</div>
			@endif
			<div class="col-sm-12 col-md-12 paddingLR0 marginB5"><div class="borderC1T1"></div></div>

			<div class="col-sm-12 col-md-12 paddingLR20">
				<div class="sectionListMedia">
					@for($i=1; $i<=4; $i++)
					@if(!empty($category_2[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($category_2[$i], 0); @endphp
					<div class="media positionRelative">
						<div class="media-left paddingR5">
							<div class="positionRelative">
								<img class="media-object" src="{!! $article->thumbSmall !!}" width="140" alt="{!! $article->headline !!}">
								@if(!empty($article->video_code))
								<span class="fa fa-play pvIconSmall"></span>
								@endif
							</div>
						</div>
						<div class="media-body">
							<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
						</div>
						<a href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>
					@endif
					@endfor
				</div>
			</div>
			<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_2[0]->title) !!}">আরও</a></span></div></div>
		</div>
		@endif
		<!-- category 2 end -->


		<!-- Ad Mobile Home 5 -->
		@if(!empty($advPlacements[20]) && !empty($advPlacements[20]->activeOrder))
		<div class="row marginT30">
			<div class="ccol-sm-12 col-md-12 paddingLR20">
				<div class="adDiv w300">
					@if($advPlacements[20]->activeOrder->ad_type == 2)
					{!! $advPlacements[20]->activeOrder->ad_code !!}
					@endif
					@if($advPlacements[20]->activeOrder->ad_type == 1)
					<a rel="sponsored" href="{{$advPlacements[20]->activeOrder->ad_url}}" target="_blank">
						<img class="img-responsive borderRadius5" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[20]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
					</a>
					@endif
				</div>
			</div>
		</div>
		@endif
		<!-- Ad Mobile Home 5 -->


		<!-- video gallery -->
		@if(!empty($videoGalleries) && (count($videoGalleries)>0))
		<div class="bgVideo row marginT50 paddingT30">
			<div class="col-sm-12 col-md-12 paddingLR0">
				<div class="sectionTitleDiv2">
					<p class="sectionTitle"><a class="bgVideo colorWhite" aria-label="{!! $videoGalleries[0]->display_name !!}" href="{!! url($videoGalleries[0]->title) !!}">{!! $videoGalleries[0]->display_name !!}</a></p>
				</div>
			</div>

			@if(!empty($videoGalleries[0]))
			@php $article = \App\Models\Helper::processArticleShortly($videoGalleries[0], 0); @endphp
			<div class="col-sm-12 col-md-12 sectionLead padding0 margin0">
				<div class="thumbnail bgVideo">
					<div class="positionRelative">
						<img src="{!! !empty($article->thumb2) ? $article->thumb2 : $article->thumb !!}" class="img-responsive" alt="{!! $article->headline !!}">
						<span class="fa fa-play pvIconLarge"></span>
					</div>
					<!-- <div class="caption">
						<p class="title3 colorWhite"><strong>{!! $article->fullheadline !!}</strong></p>
					</div> -->
					<a href="{!! $article->url !!}" class="linkOverlay"></a>
				</div>
			</div>
			@endif
			<div class="col-sm-12 col-md-12 paddingLR0 marginB15"><div class="borderC1T1"></div></div>

			<div class="col-sm-12 col-md-12 paddingLR20">
				<div class="category1 slider customFlexSlider">
					<div class="flexslider carousel bgVideo">
						<ul class="slides">
							@for($i=1; $i<=8; $i++)
							@if(!empty($videoGalleries[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($videoGalleries[$i], 0); @endphp
							<li class="sectionListThumbnail" style="padding: 0px !important">
								<div class="sectionLead">
									<div class="thumbnail borderRadius0 bgVideo">
										<a href="{!! $article->url !!}">
											<div class="positionRelative">
												<img src="{!! !empty($article->thumb2) ? $article->thumb2 : $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
												<span class="fa fa-play pvIconMedium"></span>
											</div>
											<!-- <div class="caption paddingLR0">
												<p class="xs-title marginT0 colorWhite">{!! $article->fullheadline !!}</p>
											</div> -->
										</a>
									</div>
								</div>
							</li>
							@endif
							@endfor
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-12 paddingLR20 marginB15 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore bgVideo"><a href="{!! url($videoGalleries[0]->title) !!}" class="colorWhite">আরও</a></span></div></div>
		</div>
		@endif
		<!-- video gallery end -->


		<!-- Ad Mobile Home 6 -->
		@if(!empty($advPlacements[21]) && !empty($advPlacements[21]->activeOrder))
		<div class="row marginT30">
			<div class="ccol-sm-12 col-md-12 paddingLR20">
				<div class="adDiv w300">
					@if($advPlacements[21]->activeOrder->ad_type == 2)
					{!! $advPlacements[21]->activeOrder->ad_code !!}
					@endif
					@if($advPlacements[21]->activeOrder->ad_type == 1)
					<a rel="sponsored" href="{{$advPlacements[21]->activeOrder->ad_url}}" target="_blank">
						<img class="img-responsive borderRadius5" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[21]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
					</a>
					@endif
				</div>
			</div>
		</div>
		@endif
		<!-- Ad Mobile Home 6 -->


		<!-- category 4 -->
		@if(!empty($category_4) && (count($category_4)>0))
		<div class="row marginT50">
			<div class="col-sm-12 col-md-12 paddingLR0">
				<div class="sectionTitleDiv2">
					<p class="sectionTitle"><a aria-label="{!! $category_4[0]->display_name !!}" href="{!! url($category_4[0]->title) !!}">{!! $category_4[0]->display_name !!}</a></p>
				</div>
			</div>

			@if(!empty($category_4[0]))
			@php $article = \App\Models\Helper::processArticleShortly($category_4[0], 0); @endphp
			<div class="col-sm-12 col-md-12 sectionLead padding0 margin0">
				<div class="thumbnail">
					<div class="positionRelative">
						<img src="{!! $article->thumb !!}" class="img-responsive" alt="{!! $article->headline !!}">
						@if(!empty($article->video_code))
						<span class="fa fa-play pvIconLarge"></span>
						@endif
					</div>
					<div class="caption">
						<p class="title3"><strong>{!! $article->fullheadline !!}</strong></p>
					</div>
					<a href="{!! $article->url !!}" class="linkOverlay"></a>
				</div>
			</div>
			@endif
			<div class="col-sm-12 col-md-12 paddingLR0 marginB5"><div class="borderC1T1"></div></div>

			<div class="col-sm-12 col-md-12 paddingLR20">
				<div class="sectionListMedia">
					@for($i=1; $i<=4; $i++)
					@if(!empty($category_4[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($category_4[$i], 0); @endphp
					<div class="media positionRelative">
						<div class="media-left paddingR5">
							<div class="positionRelative">
								<img class="media-object" src="{!! $article->thumbSmall !!}" width="140" alt="{!! $article->headline !!}">
								@if(!empty($article->video_code))
								<span class="fa fa-play pvIconSmall"></span>
								@endif
							</div>
						</div>
						<div class="media-body">
							<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
						</div>
						<a href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>
					@endif
					@endfor
				</div>
			</div>
			<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_4[0]->title) !!}">আরও</a></span></div></div>
		</div>
		@endif
		<!-- category 4 end -->


		<!-- Ad Mobile Home 7 -->
		@if(!empty($advPlacements[22]) && !empty($advPlacements[22]->activeOrder))
		<div class="row marginT30">
			<div class="ccol-sm-12 col-md-12 paddingLR20">
				<div class="adDiv w300">
					@if($advPlacements[22]->activeOrder->ad_type == 2)
					{!! $advPlacements[22]->activeOrder->ad_code !!}
					@endif
					@if($advPlacements[22]->activeOrder->ad_type == 1)
					<a rel="sponsored" href="{{$advPlacements[22]->activeOrder->ad_url}}" target="_blank">
						<img class="img-responsive borderRadius5" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[22]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
					</a>
					@endif
				</div>
			</div>
		</div>
		@endif
		<!-- Ad Mobile Home 7 -->


		<!-- category 5 -->
		@if(!empty($category_5) && (count($category_5)>0))
		<div class="row marginT50">
			<div class="col-sm-12 col-md-12 paddingLR0">
				<div class="sectionTitleDiv2">
					<p class="sectionTitle"><a aria-label="{!! $category_5[0]->display_name !!}" href="{!! url($category_5[0]->title) !!}">{!! $category_5[0]->display_name !!}</a></p>
				</div>
			</div>

			@if(!empty($category_5[0]))
			@php $article = \App\Models\Helper::processArticleShortly($category_5[0], 0); @endphp
			<div class="col-sm-12 col-md-12 sectionLead padding0 margin0">
				<div class="thumbnail">
					<div class="positionRelative">
						<img src="{!! $article->thumb !!}" class="img-responsive" alt="{!! $article->headline !!}">
						@if(!empty($article->video_code))
						<span class="fa fa-play pvIconLarge"></span>
						@endif
					</div>
					<div class="caption">
						<p class="title3"><strong>{!! $article->fullheadline !!}</strong></p>
					</div>
					<a href="{!! $article->url !!}" class="linkOverlay"></a>
				</div>
			</div>
			@endif
			<div class="col-sm-12 col-md-12 paddingLR0 marginB5"><div class="borderC1T1"></div></div>

			<div class="col-sm-12 col-md-12 paddingLR20">
				<div class="sectionListMedia">
					@for($i=1; $i<=4; $i++)
					@if(!empty($category_5[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($category_5[$i], 0); @endphp
					<div class="media positionRelative">
						<div class="media-left paddingR5">
							<div class="positionRelative">
								<img class="media-object" src="{!! $article->thumbSmall !!}" width="140" alt="{!! $article->headline !!}">
								@if(!empty($article->video_code))
								<span class="fa fa-play pvIconSmall"></span>
								@endif
							</div>
						</div>
						<div class="media-body">
							<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
						</div>
						<a href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>
					@endif
					@endfor
				</div>
			</div>
			<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_5[0]->title) !!}">আরও</a></span></div></div>
		</div>
		@endif
		<!-- category 5 end -->


		<div class="row marginT40">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="adDiv w300 marginB20">
					<img src="{!! env('UploadsLink').'uploads/advertisements/ad-1.jpg' !!}" class="img-responsive w100P" alt="ad">
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="adDiv w300 marginB20">
					<img src="{!! env('UploadsLink').'uploads/advertisements/ad-2.jpg' !!}" class="img-responsive w100P" alt="ad">
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="adDiv w300 marginB20">
					<img src="{!! env('UploadsLink').'uploads/advertisements/ad-3.jpg' !!}" class="img-responsive w100P" alt="ad">
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="adDiv w300 marginB20">
					<img src="{!! env('UploadsLink').'uploads/advertisements/ad-4.jpg' !!}" class="img-responsive w100P" alt="ad">
				</div>
			</div>
		</div>


		<!-- category 6 -->
		@if(!empty($category_6) && (count($category_6)>0))
		<div class="row marginT50">
			<div class="col-sm-12 col-md-12 paddingLR0">
				<div class="sectionTitleDiv2">
					<p class="sectionTitle"><a aria-label="{!! $category_6[0]->display_name !!}" href="{!! url($category_6[0]->title) !!}">{!! $category_6[0]->display_name !!}</a></p>
				</div>
			</div>

			@if(!empty($category_6[0]))
			@php $article = \App\Models\Helper::processArticleShortly($category_6[0], 0); @endphp
			<div class="col-sm-12 col-md-12 sectionLead padding0 margin0">
				<div class="thumbnail">
					<div class="positionRelative">
						<img src="{!! $article->thumb !!}" class="img-responsive" alt="{!! $article->headline !!}">
						@if(!empty($article->video_code))
						<span class="fa fa-play pvIconLarge"></span>
						@endif
					</div>
					<div class="caption">
						<p class="title3"><strong>{!! $article->fullheadline !!}</strong></p>
					</div>
					<a href="{!! $article->url !!}" class="linkOverlay"></a>
				</div>
			</div>
			@endif
			<div class="col-sm-12 col-md-12 paddingLR0 marginB5"><div class="borderC1T1"></div></div>

			<div class="col-sm-12 col-md-12 paddingLR20">
				<div class="sectionListMedia">
					@for($i=1; $i<=4; $i++)
					@if(!empty($category_6[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($category_6[$i], 0); @endphp
					<div class="media positionRelative">
						<div class="media-left paddingR5">
							<div class="positionRelative">
								<img class="media-object" src="{!! $article->thumbSmall !!}" width="140" alt="{!! $article->headline !!}">
								@if(!empty($article->video_code))
								<span class="fa fa-play pvIconSmall"></span>
								@endif
							</div>
						</div>
						<div class="media-body">
							<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
						</div>
						<a href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>
					@endif
					@endfor
				</div>
			</div>
			<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_6[0]->title) !!}">আরও</a></span></div></div>
		</div>
		@endif
		<!-- category 6 end -->


		<!-- category 3 -->
		@if(!empty($category_3) && (count($category_3)>0))
		<!-- location search -->
		<div class="row marginT50">
			<div class="col-sm-12 col-md-12 paddingLR10">
				<div class="desktopLocationDiv padding20 marginL10 marginR10 borderRadius5" style="border: 2px solid #017ac3 !important;">
					<div class="row">
						<div class="col-sm-12 col-md-12 marginB15">
							<div><p class="desktopSectionTitle text-center" style="margin-bottom: -35px;font-size: 2.2rem"><a href="#" style="margin-top: -73px;margin-left: 0px">আপনার এলাকার খবর</a></p></div>
						</div>

						<div class="col-sm-12 col-md-12 searchMessageDiv marginB15" style="display: none;">
							<div class="alert alert-warning alert-dismissible fade in marginB15 text-center title12" role="alert"> <button type="button" class="close colorBlack bgUnset" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> <strong>প্রিয় পাঠক!</strong> বিভাগ, জেলা ও উপজেলা সঠিকভাবে পছন্দ করে অনুসন্ধান করুন। ধন্যবাদ।</div>
						</div>

						<div class="col-sm-6 col-md-6 col-xs-6 paddingR5 marginB15">
							<div>
								<select class="form-control selectDivision" name="division">
									<option value="">বিভাগ</option>
									@if(!empty($divisions) && (count($divisions)>0))
									@foreach($divisions as $key => $division)
									<option data-division="{!! $division->title !!}" value="{!! $division->id !!}">{!! $division->display_name !!}</option>
									@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-xs-6 paddingL5 marginB15">
							<div>
								<select class="form-control selectDistrict" name="district">
									<option value="">জেলা</option>
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-xs-6 paddingR5">
							<div>
								<select class="form-control selectUpazila" name="upazila">
									<option value="">উপজেলা</option>
								</select>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-xs-6 paddingL5">
							<div>
								<button type="button" class="btn btn-block clickSearchButton bgRed">অনুসন্ধান</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- location search end -->

		<div class="row marginT40">
			<div class="col-sm-12 col-md-12 paddingLR0">
				<div class="sectionTitleDiv2">
					<p class="sectionTitle"><a aria-label="{!! $category_3[0]->display_name !!}" href="{!! url($category_3[0]->title) !!}">{!! $category_3[0]->display_name !!}</a></p>
				</div>
			</div>

			@if(!empty($category_3[0]))
			@php $article = \App\Models\Helper::processArticleShortly($category_3[0], 0); @endphp
			<div class="col-sm-12 col-md-12 sectionLead padding0 margin0">
				<div class="thumbnail">
					<div class="positionRelative">
						<img src="{!! $article->thumb !!}" class="img-responsive" alt="{!! $article->headline !!}">
						@if(!empty($article->video_code))
						<span class="fa fa-play pvIconLarge"></span>
						@endif
					</div>
					<div class="caption">
						<p class="title3"><strong>{!! $article->fullheadline !!}</strong></p>
					</div>
					<a href="{!! $article->url !!}" class="linkOverlay"></a>
				</div>
			</div>
			@endif
			<div class="col-sm-12 col-md-12 paddingLR0 marginB5"><div class="borderC1T1"></div></div>

			<div class="col-sm-12 col-md-12 paddingLR20">
				<div class="sectionListMedia">
					@for($i=1; $i<=4; $i++)
					@if(!empty($category_3[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($category_3[$i], 0); @endphp
					<div class="media positionRelative">
						<div class="media-left paddingR5">
							<div class="positionRelative">
								<img class="media-object" src="{!! $article->thumbSmall !!}" width="140" alt="{!! $article->headline !!}">
								@if(!empty($article->video_code))
								<span class="fa fa-play pvIconSmall"></span>
								@endif
							</div>
						</div>
						<div class="media-body">
							<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
						</div>
						<a href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>
					@endif
					@endfor
				</div>
			</div>
			<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_3[0]->title) !!}">আরও</a></span></div></div>
		</div>
		@endif
		<!-- category 3 country end -->



		<div class="row marginT40">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="adDiv w300 marginB20">
					<img src="{!! env('UploadsLink').'uploads/advertisements/ad-5.jpg' !!}" class="img-responsive w100P" alt="ad">
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="adDiv w300 marginB20">
					<img src="{!! env('UploadsLink').'uploads/advertisements/ad-6.jpg' !!}" class="img-responsive w100P" alt="ad">
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="adDiv w300 marginB20">
					<img src="{!! env('UploadsLink').'uploads/advertisements/ad-7.jpg' !!}" class="img-responsive w100P" alt="ad">
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="adDiv w300 marginB20">
					<img src="{!! env('UploadsLink').'uploads/advertisements/ad-8.jpg' !!}" class="img-responsive w100P" alt="ad">
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<div class="adDiv w300 marginB20">
					<img src="{!! env('UploadsLink').'uploads/advertisements/ad-9.jpg' !!}" class="img-responsive w100P" alt="ad">
				</div>
			</div>
		</div>



		<!-- category 8 -->
		@if(!empty($category_8) && (count($category_8)>0))
		<div class="row marginT40">
			<div class="col-sm-12 col-md-12 paddingLR0">
				<div class="sectionTitleDiv2">
					<p class="sectionTitle"><a aria-label="{!! $category_8[0]->display_name !!}" href="{!! url($category_8[0]->title) !!}">{!! $category_8[0]->display_name !!}</a></p>
				</div>
			</div>

			@if(!empty($category_8[0]))
			@php $article = \App\Models\Helper::processArticleShortly($category_8[0], 0); @endphp
			<div class="col-sm-12 col-md-12 sectionLead padding0 margin0">
				<div class="thumbnail">
					<div class="positionRelative">
						<img src="{!! $article->thumb !!}" class="img-responsive" alt="{!! $article->headline !!}">
						@if(!empty($article->video_code))
						<span class="fa fa-play pvIconLarge"></span>
						@endif
					</div>
					<div class="caption">
						<p class="title3"><strong>{!! $article->fullheadline !!}</strong></p>
					</div>
					<a href="{!! $article->url !!}" class="linkOverlay"></a>
				</div>
			</div>
			@endif
			<div class="col-sm-12 col-md-12 paddingLR0 marginB5"><div class="borderC1T1"></div></div>

			<div class="col-sm-12 col-md-12 paddingLR20">
				<div class="sectionListMedia">
					@for($i=1; $i<=4; $i++)
					@if(!empty($category_8[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($category_8[$i], 0); @endphp
					<div class="media positionRelative">
						<div class="media-left paddingR5">
							<div class="positionRelative">
								<img class="media-object" src="{!! $article->thumbSmall !!}" width="140" alt="{!! $article->headline !!}">
								@if(!empty($article->video_code))
								<span class="fa fa-play pvIconSmall"></span>
								@endif
							</div>
						</div>
						<div class="media-body">
							<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
						</div>
						<a href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>
					@endif
					@endfor
				</div>
			</div>
			<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_8[0]->title) !!}">আরও</a></span></div></div>
		</div>
		@endif
		<!-- category 8 end -->


		<!-- category 7 -->
		@if(!empty($category_7) && (count($category_7)>0))
		<div class="row marginT40">
			<div class="col-sm-12 col-md-12 paddingLR0">
				<div class="sectionTitleDiv2">
					<p class="sectionTitle"><a aria-label="{!! $category_7[0]->display_name !!}" href="{!! url($category_7[0]->title) !!}">{!! $category_7[0]->display_name !!}</a></p>
				</div>
			</div>

			@if(!empty($category_7[0]))
			@php $article = \App\Models\Helper::processArticleShortly($category_7[0], 0); @endphp
			<div class="col-sm-12 col-md-12 sectionLead padding0 margin0">
				<div class="thumbnail">
					<div class="positionRelative">
						<img src="{!! $article->thumb !!}" class="img-responsive" alt="{!! $article->headline !!}">
						@if(!empty($article->video_code))
						<span class="fa fa-play pvIconLarge"></span>
						@endif
					</div>
					<div class="caption">
						<p class="title3"><strong>{!! $article->fullheadline !!}</strong></p>
					</div>
					<a href="{!! $article->url !!}" class="linkOverlay"></a>
				</div>
			</div>
			@endif
			<div class="col-sm-12 col-md-12 paddingLR0 marginB5"><div class="borderC1T1"></div></div>

			<div class="col-sm-12 col-md-12 paddingLR20">
				<div class="sectionListMedia">
					@for($i=1; $i<=4; $i++)
					@if(!empty($category_7[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($category_7[$i], 0); @endphp
					<div class="media positionRelative">
						<div class="media-left paddingR5">
							<div class="positionRelative">
								<img class="media-object" src="{!! $article->thumbSmall !!}" width="140" alt="{!! $article->headline !!}">
								@if(!empty($article->video_code))
								<span class="fa fa-play pvIconSmall"></span>
								@endif
							</div>
						</div>
						<div class="media-body">
							<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
						</div>
						<a href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>
					@endif
					@endfor
				</div>
			</div>
			<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_7[0]->title) !!}">আরও</a></span></div></div>
		</div>
		@endif
		<!-- category 7 end -->


		<!-- poll -->
		@if(!empty($todaysQuestion))
		@php $todaysQuestion = App\Models\Helper::processPoll($todaysQuestion); @endphp
		<div class="row marginT50">
			<div class="col-sm-12 col-md-12">
				<div class="marginCenter" id="pollContentDiv{!! $todaysQuestion->id !!}">
					<div >
						<p class="pollTitle"><a aria-label="অনলাইন জরিপ" href="{!! url('poll') !!}" class="colorWhite hoverBlue textDecorationNone">অনলাইন জরিপ</a> <span class="downloadPoll" data-pollid="{!! $todaysQuestion->id !!}" data-polldate="{!! $todaysQuestion->poll_date_bangla !!}"><i class="fa fa-download"></i></span></p>
						@if(!empty($todaysQuestion->image))
						<div>
							<a class="textDecorationNone" href="{!! $todaysQuestion->url !!}">
								<img src="{!! asset('uploads/polls/'.$todaysQuestion->image) !!}" class="img-responsive" alt="{!! $todaysQuestion->question !!}">
							</a>
						</div>
						@endif
						<div class="paddingB0 pollTextDiv">
							<div class="thumbnail padding0 border0 marginB0">
								<div class="caption text-left paddingT0">
									<p class="desktopTime color1 marginB10"><i class="fa fa-regular fa-clock"></i> <span class="pollDate">{!! $todaysQuestion->poll_date_bangla !!}</span></p>
									<p class="title4 marginT0"><a class="textDecorationNone colorBlack" href="{!! $todaysQuestion->url !!}"><span>{!! $todaysQuestion->question !!}</span></a></p>

									<div class="marginT10">
										<p class="pollOption"><label class="clickVote" data-pollid="{!! $todaysQuestion->id !!}" data-votetype="yes"><input class="clickVoteInput{!! $todaysQuestion->id !!}" type="radio" name="poll_vote" value="yes"> হ্যাঁ ভোট <span class="pull-right totalyesVote{!! $todaysQuestion->id !!}">{!! $todaysQuestion->yes_vote_percent_bangla !!} %</span></label></p>

										<p class="pollOption"><label class="clickVote" data-pollid="{!! $todaysQuestion->id !!}" data-votetype="no"><input class="clickVoteInput{!! $todaysQuestion->id !!}" type="radio" name="poll_vote" value="no"> না ভোট <span class="pull-right totalNoVote{!! $todaysQuestion->id !!}">{!! $todaysQuestion->no_vote_percent_bangla !!} %</span></label></p>

										<p class="pollOption"><label class="clickVote" data-pollid="{!! $todaysQuestion->id !!}" data-votetype="no_comment"><input class="clickVoteInput{!! $todaysQuestion->id !!}" type="radio" name="poll_vote" value="no_comment"> মন্তব্য নেই <span class="pull-right totalNoCommentVote{!! $todaysQuestion->id !!}">{!! $todaysQuestion->no_opinion_vote_percent_bangla !!} %</span></label></p>
									</div>

									<div class="text-center marginT20 marginB20">
										<p class="title12 color1">মোট ভোটদাতাঃ <span class="totalVoter{!! $todaysQuestion->id !!}">{!! App\Models\Helper::GetBangla($todaysQuestion->total_vote_bangla) !!}</span> জন</p>
									</div>

									<div class="text-center marginT10 pollDownloadTime" style="display: none;">
										<p class="marginT30 marginB0"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_1) !!}" class="img-responsive marginCenter h50" alt="Logo"></p>
										<p class="title1_6 colorBlack">ডাউনলোডঃ {!! App\Models\Helper::GetBangla(date('d M Y, H:i A')) !!}</p>
									</div>

									<div class="row downloadPollShareIcon">
										<div class="col-xs-12 text-center marginB10">
											<!-- sharethis -->
											<div class="sharethis-inline-share-buttons" data-url="{!! $todaysQuestion->url !!}" data-title="{!! $todaysQuestion->question !!}"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
		<!-- poll -->

		
		<!-- desktop ajax load home -->
		<div class="ajaxMobileHome"><div class="text-center title11">লোড হচ্ছে <i class="fa fa-spinner title1_2"></i></div></div>
		<!-- desktop ajax load home -->

	</div>
</div>
<!-- mobile version end -->
</div>


@if(!empty($advPlacements[1]) && !empty($advPlacements[1]->activeOrder))
<div class="modal fade popupModalAd" id="popupModalDesktop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close popupModalClose hoverBlack popupModalAdCloseButton" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				@if($advPlacements[1]->activeOrder->ad_type == 2)
				{!! $advPlacements[1]->activeOrder->ad_code !!}
				@endif
				@if($advPlacements[1]->activeOrder->ad_type == 1)
				<a href="{{$advPlacements[1]->activeOrder->ad_url}}" target="_blank">
					<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[1]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
				</a>
				@endif
			</div>
		</div>
	</div>
</div>
@endif

@if(!empty($advPlacements[2]) && !empty($advPlacements[2]->activeOrder))
<div class="modal fade popupModalAd" id="popupModalMobile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close popupModalClose hoverBlack popupModalAdCloseButton" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				@if($advPlacements[2]->activeOrder->ad_type == 2)
				{!! $advPlacements[2]->activeOrder->ad_code !!}
				@endif
				@if($advPlacements[2]->activeOrder->ad_type == 1)
				<a href="{{$advPlacements[2]->activeOrder->ad_url}}" target="_blank">
					<img class="img-responsive" src="{{env('UploadsLink').'uploads/advertisements/'.$advPlacements[2]->activeOrder->ad_banner}}" border="0" alt="ad-img"/>
				</a>
				@endif
			</div>
		</div>
	</div>
</div>
@endif


@endsection

@push('js')
<!-- ajax load home -->
<script type="text/javascript">
	var width = $(window).width();
	if(width >= 768){
		document.addEventListener("DOMContentLoaded", function(){
			window.addEventListener('scroll', function() {
				if (window.scrollY > 3500) {
					var url = '{{url("/")}}/ajax/load/desktop/home';
					$.get(url, function(data){
						if(data != ''){
							$('.ajaxDesktopHome').html(data);
							$('.ajaxDesktopHome').removeClass('ajaxDesktopHome');
						}
					});
				}
			});
		});
	}

	if(width <= 767){
		document.addEventListener("DOMContentLoaded", function(){
			window.addEventListener('scroll', function() {
				if (window.scrollY > 5000) {
					var url = '{{url("/")}}/ajax/load/mobile/home';
					$.get(url, function(data){
						if(data != ''){
							$('.ajaxMobileHome').html(data);
							$('.ajaxMobileHome').removeClass('ajaxMobileHome');
						}
					});
				}
			});
		});
	}
</script>
<!-- ajax load home -->

<!-- search archive -->
<script type="text/javascript">
	$('.clickSearchArchive').click(function(){
		var archiveDay = $('.selectDay').val();
		var archiveMonth = $('.selectMonth').val();
		var archiveYear = $('.selecYear').val();
		if(archiveDay == ''){
		}else if(archiveMonth == ''){
		}else if(archiveYear == ''){
		}else{
			var date = archiveYear+'-'+archiveMonth+'-'+archiveDay;
			window.location = "{{url('archive')}}?search=yes&date="+date;
		}
	});
</script>
@endpush