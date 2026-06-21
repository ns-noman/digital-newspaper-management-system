@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : (!empty($archivedTopicInfo->meta_title) ? $archivedTopicInfo->meta_title : $tag_title) !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : (!empty($archivedTopicInfo->meta_title) ? $archivedTopicInfo->meta_title : $tag_title) !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : (!empty($archivedTopicInfo->meta_title) ? $archivedTopicInfo->meta_title : $tag_title) !!}" />
<meta name="description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : (!empty($archivedTopicInfo->meta_descriptions) ? $archivedTopicInfo->meta_descriptions : $tag_title.' বিষয়ের খবর।') !!}" />
<meta property="og:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : (!empty($archivedTopicInfo->meta_descriptions) ? $archivedTopicInfo->meta_descriptions : $tag_title.' বিষয়ের খবর।') !!}" />
<meta name="twitter:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : (!empty($archivedTopicInfo->meta_descriptions) ? $archivedTopicInfo->meta_descriptions : $tag_title.' বিষয়ের খবর।') !!}" />
<meta name="keywords" content="{!! !empty($pageInfo) ? $pageInfo->meta_keywords : (!empty($archivedTopicInfo->meta_keywords) ? $archivedTopicInfo->meta_keywords : $tag_title) !!}" />
<meta property="og:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : (!empty($archivedTopicInfo->meta_image) ? env('UploadsLink').'uploads/topics/'.$archivedTopicInfo->meta_image : asset('uploads/settings/'.$settingsInfo->default_img_1)) !!}" />
<meta name="twitter:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : (!empty($archivedTopicInfo->meta_image) ? env('UploadsLink').'uploads/topics/'.$archivedTopicInfo->meta_image : asset('uploads/settings/'.$settingsInfo->default_img_1)) !!}" />
<meta property="og:type" content="website" />
<meta name="robots" content="{!! !empty($archivedTopicInfo->noindex) && $archivedTopicInfo->noindex == 1 ? 'noindex, nofollow' : 'index, follow' !!}" />
{!! !empty($pageInfo) ? $pageInfo->header_code : '' !!}
@endpush

@section('content')
<!-- desktop version start -->
<div class="bgWHite hidden-xs">
	<div class="container ">
		<div class="row">

			<!-- header -->
			<div class="col-sm-12 col-md-12 marginB20 hidden-xs">
				<div class="borderC1B1 paddingB20">
					<div class="row">
						<!-- <div class="col-sm-2 col-md-2">
							@if(!empty($archivedTopicInfo->topic_photo))
							<img src="{{env('UploadsLink').'uploads/topics/'.$archivedTopicInfo->topic_photo}}" alt="{!! !empty($archivedTopicInfo->topic_title) ? $archivedTopicInfo->topic_title : $tag_title !!}" class="img-responsive borderRadius5">
							@else
							<img src="{{asset('uploads/settings/'.$settingsInfo->default_img_1)}}" alt="Topic Image" class="img-responsive borderRadius5">
							@endif
						</div> -->
						<div class="col-sm-10 col-md-10">
							<h1 class="desktopCategoryTitleLarge"><strong>{!! !empty($archivedTopicInfo->topic_title) ? $archivedTopicInfo->topic_title : $tag_title !!}</strong></h1>

							@if(!empty($archivedTopicInfo->topic_descriptions))
							<div class="textBody">
								<p class="title12 text-left marginB0">{!! $archivedTopicInfo->topic_descriptions !!}</p>
							</div>
							@endif

							<div class="marginT10">
								<!-- sharethis -->
								<div class="sharethis-inline-share-buttons st-left displayInline" style="text-align: left;" data-url="{!! Request::url() !!}"></div>
							</div>
						</div>
					</div>

					
				</div>
			</div>

			<div class="col-sm-9 col-md-9">
				<div class="row">
					@if(!empty($topicNews) && (count($topicNews)>0))
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row marginLR-10 desktopFlexRow topThumbNews">
							@for($i=0; $i<=2; $i++)
							@if(!empty($topicNews[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($topicNews[$i], 0); @endphp
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 paddingLR10 borderItem borderC1R1 desktopSectionLead">
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<a href="{!! $article->url !!}"><img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}"></a>
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption paddingB0">
										<a class="colorBlack hoverBlue" href="{!! $article->url !!}"><p class="title10 marginT0">{!! $article->fullheadline !!}</p></a>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
										<p class="desktopTime marginT10"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
									</div>
								</div>
							</div>
							@endif
							@endfor
						</div>
						<p class="desktopDivider marginT15 marginB5"></p>
					</div>

					<div class="col-sm-12 col-md-12">
						<div class="desktopSectionListMedia loadMoreCategoryNews">
							@for($i=3; $i<=9; $i++)
							@if(!empty($topicNews[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($topicNews[$i], 20); @endphp
							<div class="media positionRelative">
								<div class="media-left">
									<div class="positionRelative">
										<a href="{!! $article->url !!}"><img class="media-object borderRadius5 xs-width120" src="{!! $article->thumbMedium !!}" width="270" alt="{!! $article->headline !!}"></a>
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconSmall"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconSmall"></span>
										@endif
									</div>
								</div>
								<div class="media-body marginL5">
									<a class="colorBlack hoverBlue" href="{!! $article->url !!}"><p class="title10 marginT2">{!! $article->fullheadline !!}</p></a>
									@if(!empty($article->summary))
									<p class="desktopSummary marginT10 hidden-xs">{!! $article->summary !!}</p>
									@endif
									<p class="desktopTime marginT10"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
								</div>
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

				<!--load more -->
				<div class="row marginT30 marginB30">
					<div class="col-md-12 col-xs-12">
						<div class="text-center"><span data-paginate="1" class="loadMoreButton clickLoadMore">আরও পড়ুন <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span></div>
					</div>
				</div>
				<!-- load more end -->

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
				<h1 class="sectionTitleLarge displayInline border0 margin0 marginB0"><strong>{!! !empty($archivedTopicInfo->topic_title) ? $archivedTopicInfo->topic_title : $tag_title !!}</strong></h1>
				@if(!empty($archivedTopicInfo->topic_descriptions))
				<div class="textBody">
					<p class="title12 text-left marginB0">{!! $archivedTopicInfo->topic_descriptions !!}</p>
				</div>
				@endif
				<div class="marginT10">
					<!-- sharethis -->
					<div class="sharethis-inline-share-buttons st-left displayInline" style="text-align: left;" data-url="{!! Request::url() !!}"></div>
				</div>
			</div>

			<!-- lead news -->
			@if(!empty($topicNews[0]))
			@php $article = \App\Models\Helper::processArticleShortly($topicNews[0], 0); @endphp
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


			@if(!empty($topicNews) && (count($topicNews)>0))
			<div class="col-sm-12 col-md-12 paddingLR20 marginT0">
				<div class="sectionListMedia loadMoreCategoryNewsMobile borderC1B1">
					@for($i=1; $i<=9; $i++)
					@if(!empty($topicNews[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($topicNews[$i], 0); @endphp
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
			<div class="text-center marginT20">
				<span data-paginate="1" class="loadMoreButtonMobile clickLoadMoreMobile">আরও পড়ুন <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span>
			</div>
			<!-- load more button -->
			@endif

		</div>
	</div>
</div>
<!-- mobile version end -->
@endsection

@push('js')
<!-- desktop ajax load more latest news -->
<script type="text/javascript">
	$('.clickLoadMore').click(function(){
		$('.loadingIcon').show();
		var paginate = $(this).data('paginate');
		$(this).data('paginate', parseInt(paginate)+1);

		var topicId = '{{!empty($archivedTopicInfo) ? $archivedTopicInfo->id : ''}}';
		if(topicId != ''){
			var url = '{{url("ajax/load/topicnews/")}}/'+topicId+'/0/10/'+paginate+'/20';
		}else{
			var url = '{{url("ajax/load/tagnews/")}}/{{$tag_title}}/0/10/'+paginate+'/20';
		}
		
		$.get(url, function(data){
			if(data != ''){
				$('.loadingIcon').hide();
				$.each(data, function(key, value){
					$('.loaderDiv1').hide();
					if(value.categoryTitle == 'photos'){
						var icon = '<span class="fa fa-image ppIconMedium"></span>';
					}else if(value.video_code != null){
						var icon = '<span class="fa fa-play pvIconMedium"></span>';
					}else{
						var icon = '';
					}
					var row = $('<div class="media positionRelative"><div class="media-left paddingL5"><div class="positionRelative"><a href="'+value.url+'"><img class="media-object borderRadius5 xs-width120" src="'+value.thumbMedium+'" width="270" alt="'+value.headline+'"></a>'+icon+'</div></div><div class="media-body"><a class="colorBlack hoverBlue" href="'+value.url+'"><p class="title10 marginT2">'+value.fullheadline+'</p></a><p class="desktopSummary marginT10 hidden-xs">'+value.summary+'</p><p class="desktopTime marginT10"><i class="fa fa-regular fa-clock"></i> '+value.publishTime+'</p></div></div>');
					$('.loadMoreCategoryNews').append(row);
				});
			}
		});
	});
</script>

<!-- mobile ajax load more latest news -->
<script type="text/javascript">
	$('.clickLoadMoreMobile').click(function(){
		$('.loadingIcon').show();
		var paginate = $(this).data('paginate');
		$(this).data('paginate', parseInt(paginate)+1);

		var topicId = '{{!empty($archivedTopicInfo) ? $archivedTopicInfo->id : ''}}';
		if(topicId != ''){
			var url = '{{url("ajax/load/topicnews/")}}/'+topicId+'/0/10/'+paginate+'/20';
		}else{
			var url = '{{url("ajax/load/tagnews/")}}/{{$tag_title}}/0/10/'+paginate+'/20';
		}
		$.get(url, function(data){
			if(data != ''){
				$('.loadingIcon').hide();
				$.each(data, function(key, value){
					$('.loaderDiv1').hide();
					if(value.categoryTitle == 'photos'){
						var icon = '<span class="fa fa-image ppIconSmall"></span>';
					}else if(value.video_code != null){
						var icon = '<span class="fa fa-play pvIconSmall"></span>';
					}else{
						var icon = '';
					}
					var row = $('<div class="media positionRelative"><div class="media-left paddingR5"><div class="positionRelative"><img class="media-object" src="'+value.thumbSmall+'" width="140" alt="'+value.headline+'">'+icon+'</div></div><div class="media-body"><p class="xs-title marginL5 marginB0">'+value.fullheadline+'</p><p class="time marginT5 marginL5"><i class="fa fa-regular fa-clock"></i> '+value.publishTime+'</p></div><a href="'+value.url+'" class="linkOverlay"></a></div>');
					$('.loadMoreCategoryNewsMobile').append(row);
				});
			}
		});
	});
</script>
@endpush