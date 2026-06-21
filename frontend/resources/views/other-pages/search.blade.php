@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : 'অনুসন্ধান - '.$settingsInfo->title !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'অনুসন্ধান - '.$settingsInfo->title !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'অনুসন্ধান - '.$settingsInfo->title !!}" />
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
					<h1 class="desktopCategoryTitle marginB10"><strong><span class="leftSpan"></span> অনুসন্ধান</strong></h1>
				</div>
			</div>

			<div class="col-sm-9 col-md-9">
				<div class="row">
					<div class="col-sm-12 col-md-12 marginB20">
						<form method="get">
							<input type="hidden" name="search" value="yes">
							<div class="panel panel-default borderRadius5 borderAsh1 marginB0">
								<div class="panel-body bgAsh">
									<div class="row">
										<div class="col-md-9 paddingR0">
											<div>
												<input value="{{isset($_GET['q'])&& !empty($_GET['q']) ? $_GET['q'] : ''}}" name="q" class="form-control borderRadius5 h50" type="text" placeholder="শিরোনাম" autocomplete="off">
											</div>
										</div>
										<div class="col-md-3 xs-marginT10">
											<button type="submit" class="btn btn-block borderRadius5 width100P bgRed title1_8 colorWhite h50 padding3"><i class="fa fa-search title1_3"></i> খুঁজুন </button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>

					@if(!empty(!empty($_GET['q'])) && !empty($settingsInfo->search_plugin))
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row marginLR-10">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingLR10 desktopSectionLead">
								<div class="borderRadius5 borderC1-1">
									{!! $settingsInfo->search_plugin !!}
								</div>
							</div>
						</div>
					</div>
					@endif

					{{-- @if(!empty($archiveArticles) && (count($archiveArticles)>0))
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row marginLR-10 desktopFlexRow topThumbNews">
								@for($i=0; $i<=2; $i++)
								@if(!empty($archiveArticles[$i]))
								@php $article = \App\Models\Helper::processArticleShortly($archiveArticles[$i], 0); @endphp
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

						<div class="col-sm-12 col-md-12 marginT0">
							<div class="desktopSectionListMedia listItemLastBB0">
								@for($i=3; $i<=9; $i++)
								@if(!empty($archiveArticles[$i]))
								@php $article = \App\Models\Helper::processArticleShortly($archiveArticles[$i], 20); @endphp
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

						<div class="col-sm-12 col-md-12">
							<div class="pagination2 text-center marginB30 marginT5 borderC1T1">
								<div class="marginT20">
									{{$archiveArticles->appends(request()->query())->links()}}
								</div>
							</div>
						</div>
						@else
						<div class="col-sm-12 col-md-12">
							<div class="text-center">কিছু পাওয়া যায়নি</div>
						</div>
						@endif --}}
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
					<h1 class="sectionTitle displayInline border0 margin0 marginB0"><strong><span class="leftSpan"></span> অনুসন্ধান</strong></h1>
				</div>

				<div class="col-sm-12 col-md-12 marginB20">
					<form method="get">
						<input type="hidden" name="search" value="yes">
						<div class="panel panel-default borderRadius5 borderAsh1 marginB0">
							<div class="panel-body bgAsh">
								<div class="row">
									<div class="col-md-6">
										<div>
											<input value="{{isset($_GET['q'])&& !empty($_GET['q']) ? $_GET['q'] : ''}}" name="q" class="form-control borderRadius5 h34" type="text" placeholder="শিরোনাম" autocomplete="off">
										</div>
									</div>
									<div class="col-md-3 xs-marginT10">
										<button type="submit" class="btn btn-block borderRadius5 width100P bgRed title1_8 colorWhite h34 padding3"><i class="fa fa-search title1_3"></i> খুঁজুন </button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>


				@if(!empty(!empty($_GET['q'])) && !empty($settingsInfo->search_plugin))
				<div class="col-sm-12 col-md-12 margin0">
					<div class="borderRadius5 borderC1-1">
						{!! $settingsInfo->search_plugin !!}
					</div>
				</div>
				@endif


				{{-- <!-- lead news -->
					@if(!empty($archiveArticles[0]))
					@php $article = \App\Models\Helper::processArticleShortly($archiveArticles[0], 0); @endphp
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


					@if(!empty($archiveArticles) && (count($archiveArticles)>0))
					<div class="col-sm-12 col-md-12 paddingLR20 marginT0">
						<div class="sectionListMedia loadMoreCategoryNewsMobile borderC1B1">
							@for($i=1; $i<=9; $i++)
							@if(!empty($archiveArticles[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($archiveArticles[$i], 0); @endphp
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

					<!-- load more button -->
					<div class="col-sm-12 col-md-12 paddingLR20">
						<div class="text-center marginT0">
							<div class="marginT20">
								{{$archiveArticles->appends(request()->query())->links()}}
							</div>
						</div>
					</div>
					<!-- load more button -->
					@endif --}}

				</div>
			</div>
		</div>
		<!-- mobile version end -->
		@endsection

		@push('js')

		@endpush