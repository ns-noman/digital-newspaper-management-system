@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : 'লেখক - '.$authorInfo->author_name !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'লেখক - '.$authorInfo->author_name !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'লেখক - '.$authorInfo->author_name !!}" />
<meta name="description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $authorInfo->author_about !!}" />
<meta property="og:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $authorInfo->author_about !!}" />
<meta name="twitter:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $authorInfo->author_about !!}" />
<meta name="keywords" content="{!! !empty($pageInfo) ? $pageInfo->meta_keywords : $authorInfo->author_name !!}" />
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

			<div class="col-sm-9 col-md-9">
				@if(!empty($authorInfo))
				<div class="row marginB30">
					<div class="col-sm-12 col-md-12 xs-marginT10">
						<div class="card bg2 hovercard marginT0 paddingT20 paddingB10 text-center borderRadius5 borderD2C1">
							<div class="avatar">
								@if(!empty($authorInfo->author_photo))
								<img width="150" src="{{asset('uploads/authors/'.$authorInfo->author_photo)}}" alt="{{$authorInfo->author_name}}" title="{{$authorInfo->author_name}}" class="borderRadius50P" style="border: 10px solid white">
								@else
								<img width="150" src="{{asset('uploads/authors/default-avatar.png')}}" alt="{{$authorInfo->author_name}}" title="{{$authorInfo->author_name}}" class="borderRadius50P" style="border: 10px solid white">
								@endif
							</div>
							<div class="info marginT10">
								<div class="title">
									<a class="title10 colorBlack hoverOrange textDecorationNone" href="{{url('author/'.$authorInfo->id.'/'.$authorInfo->author_slug)}}"><strong>{{$authorInfo->author_name}}</strong></a>
								</div>
								@if(!empty($authorInfo->author_about))
								<div class="title12">{{$authorInfo->author_about}}</div>
								@endif
							</div>
							<div class="text-center marginT10 marginB10">
								<!-- sharethis -->
								<div class="sharethis-inline-share-buttons st-center" style="text-align: center;" data-url="{!! Request::url() !!}"></div>
							</div>
						</div>
					</div>
				</div>
				@endif

				<div class="row marginT10">
					@if(!empty($authorArticles) && (count($authorArticles)>0))
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row marginLR-10 desktopFlexRow topThumbNews">
							@for($i=0; $i<=2; $i++)
							@if(!empty($authorArticles[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($authorArticles[$i], 0); @endphp
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
						<div class="desktopSectionListMedia listItemLastBB0 loadMoreCategoryNews borderC1B1">
							@for($i=3; $i<=9; $i++)
							@if(!empty($authorArticles[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($authorArticles[$i], 20); @endphp
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
						<div class="text-center colorBlack">কিছু পাওয়া যায়নি</div>
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

			@if(!empty($authorInfo))
			<div class="col-sm-12 col-md-12 padding0 marginT20 marginB10 paddingLR20">
				<div class="card bg2 hovercard marginT0 paddingT20 paddingB10 text-center borderRadius5 borderD2C1">
					<div class="avatar">
						@if(!empty($authorInfo->author_photo))
						<img width="150" src="{{asset('uploads/authors/'.$authorInfo->author_photo)}}" alt="{{$authorInfo->author_name}}" title="{{$authorInfo->author_name}}" class="borderRadius50P" style="border: 10px solid white">
						@else
						<img width="150" src="{{asset('uploads/authors/default-avatar.png')}}" alt="{{$authorInfo->author_name}}" title="{{$authorInfo->author_name}}" class="borderRadius50P" style="border: 10px solid white">
						@endif
					</div>
					<div class="info marginT10">
						<div class="title">
							<a class="title10 colorBlack hoverOrange textDecorationNone" href="{{url('author/'.$authorInfo->id.'/'.$authorInfo->author_slug)}}"><strong>{{$authorInfo->author_name}}</strong></a>
						</div>
						@if(!empty($authorInfo->author_about))
						<div class="title12">{{$authorInfo->author_about}}</div>
						@endif
					</div>
					<div class="text-center marginT10 marginB10">
						<!-- sharethis -->
						<div class="sharethis-inline-share-buttons st-center" style="text-align: center;" data-url="{!! Request::url() !!}"></div>
					</div>
				</div>
			</div>
			@endif


			@if(!empty($authorArticles) && (count($authorArticles)>0))
			<div class="col-sm-12 col-md-12 paddingLR20 marginT0">
				<div class="sectionListMedia loadMoreCategoryNewsMobile borderC1B1">
					@for($i=0; $i<=9; $i++)
					@if(!empty($authorArticles[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($authorArticles[$i], 0); @endphp
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
<!-- ajax load more author news -->
<script type="text/javascript">
	$('.clickLoadMore').click(function(){
		$('.loadingIcon').show();
		var paginate = $(this).data('paginate');
		$(this).data('paginate', parseInt(paginate)+1);
		var url = '{{url("ajax/load/authornews/")}}/{{$authorInfo->id}}/10/'+paginate+'/20';
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

<!-- mobile ajax load more category news -->
<script type="text/javascript">
	$('.clickLoadMoreMobile').click(function(){
		$('.loadingIcon').show();
		var paginate = $(this).data('paginate');
		$(this).data('paginate', parseInt(paginate)+1);
		var url = '{{url("ajax/load/authornews/")}}/{{$authorInfo->id}}/10/'+paginate+'/0';
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