@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : 'সর্বাধিক পঠিত - '.$settingsInfo->title !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'সর্বাধিক পঠিত - '.$settingsInfo->title !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'সর্বাধিক পঠিত - '.$settingsInfo->title !!}" />
<meta name="description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $settingsInfo->description !!}" />
<meta property="og:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $settingsInfo->description !!}" />
<meta name="twitter:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $settingsInfo->description !!}" />
<meta name="keywords" content="{!! !empty($pageInfo) ? $pageInfo->meta_keywords : $settingsInfo->keywords !!}" />
<meta property="og:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : asset('uploads/settings/'.$settingsInfo->default_img_1) !!}" />
<meta name="twitter:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : asset('uploads/settings/'.$settingsInfo->default_img_1) !!}" />
<meta name="robots" content="index, follow" />
{!! !empty($pageInfo) ? $pageInfo->header_code : '' !!}
@endpush

@section('content')
<!-- desktop version start -->
<div class="bgWHite hidden-xs">
	<div class="container ">
		<div class="row">

			<!-- header -->
			<div class="col-sm-12 col-md-12 marginB20 hidden-xs">
				<div class="borderC1B1">
					<h1 class="desktopCategoryTitle"><strong><span class="leftSpan"></span> সর্বাধিক পঠিত</strong></h1>
				</div>
			</div>

			<div class="col-sm-9 col-md-9">
				<div class="row">
					@if(!empty($popularNews) && (count($popularNews)>0))
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row marginLR-10 desktopFlexRow topThumbNews">
							@for($i=0; $i<=2; $i++)
							@if(!empty($popularNews[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($popularNews[$i], 0); @endphp
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 paddingLR10 borderItem borderC1R1 desktopSectionLead">
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
										<p class="title10 marginT0">{!! $article->fullheadline !!}</p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
										<p class="desktopTime marginT10"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif
							@endfor
						</div>
						<p class="desktopDivider marginT15 marginB5"></p>
					</div>

					<div class="col-sm-12 col-md-12">
						<div class="desktopSectionListMedia listItemLastBB0 loadMoreCategoryNews">
							@for($i=3; $i<=9; $i++)
							@if(!empty($popularNews[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($popularNews[$i], 20); @endphp
							<div class="media positionRelative">
								<div class="media-left">
									<div class="positionRelative">
										<img class="media-object borderRadius5 xs-width120" src="{!! $article->thumbMedium !!}" width="270" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconSmall"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconSmall"></span>
										@endif
									</div>
								</div>
								<div class="media-body marginL5">
									<p class="title10 marginT2">{!! $article->fullheadline !!}</p>
									@if(!empty($article->summary))
									<p class="desktopSummary marginT10 hidden-xs">{!! $article->summary !!}</p>
									@endif
									<p class="desktopTime marginT10"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
								</div>
								<a href="{!! $article->url !!}" class="linkOverlay"></a>
							</div>
							@endif
							@endfor
						</div>
					</div>
					@else
					<div class="col-sm-12 col-md-12">
						<div class="text-center">No Data Found</div>
					</div>
					@endif
				</div>
			</div>

			<!-- first sidebar -->
			<div class="col-sm-3 col-md-3">
				<!-- latest popular news -->
				<div class="row">
					<div class="col-sm-12 col-md-12 marginB20">
						@include('layouts.latest-popular-tab-news')
					</div>
				</div>
				<!-- latest popular news end -->
			</div>
		</div>
	</div>
</div>
<!-- desktop version end -->



<!-- mobile version start -->
<div class="bgWHite visible-xs">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12 paddingLR20 marginB15 paddingT10 marginT10">
				<p class="sectionTitle displayInline border0 margin0 marginB0"><strong><span class="leftSpan"></span> সর্বাধিক পঠিত</strong></p>
			</div>

			<!-- lead news -->
			@if(!empty($popularNews[0]))
			@php $article = \App\Models\Helper::processArticleShortly($popularNews[0], 0); @endphp
			<div class="col-sm-12 col-md-12 sectionLead padding0 margin0">
				<div class="thumbnail">
					<div class="positionRelative">
						<img src="{!! $article->thumb !!}" class="img-responsive" alt="{!! $article->headline !!}">
						@if($article->categoryTitle == 'photos')
						<span class="fa fa-image ppIconMedium"></span>
						@elseif(!empty($article->video_code))
						<span class="fa fa-play pvIconMedium"></span>
						@endif
					</div>
					<div class="caption">
						<p class="title3"><strong>{!! $article->fullheadline !!}</strong></p>
						<p class="time marginT5"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
					</div>
					<a href="{!! $article->url !!}" class="linkOverlay"></a>
				</div>
			</div>
			@endif
			<div class="col-sm-12 col-md-12 paddingLR0 marginB5"><div class="borderC1T1"></div></div>


			@if(!empty($popularNews) && (count($popularNews)>0))
			<div class="col-sm-12 col-md-12 paddingLR20 marginT0">
				<div class="sectionListMedia loadMoreCategoryNewsMobile borderC1B1">
					@for($i=1; $i<=9; $i++)
					@if(!empty($popularNews[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($popularNews[$i], 0); @endphp
					<div class="media positionRelative">
						<div class="media-left paddingR5">
							<div class="positionRelative">
								<img class="media-object" src="{!! $article->thumbSmall !!}" width="140" alt="{!! $article->headline !!}">
								@if($article->categoryTitle == 'photos')
								<span class="fa fa-image ppIconSmall"></span>
								@elseif(!empty($article->video_code))
								<span class="fa fa-play pvIconSmall"></span>
								@endif
							</div>
						</div>
						<div class="media-body">
							<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
							<p class="time marginT5 marginL5"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
						</div>
						<a href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>
					@endif
					@endfor
				</div>
			</div>
			@endif

		</div>
	</div>
</div>
<!-- mobile version end -->
@endsection

@push('js')

@endpush