@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : $locationInfo->display_name !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : $locationInfo->display_name !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : $locationInfo->display_name !!}" />
<meta name="description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $settingsInfo->description !!}" />
<meta property="og:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $settingsInfo->description !!}" />
<meta name="twitter:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $settingsInfo->description !!}" />
<meta name="keywords" content="{!! !empty($pageInfo) ? $pageInfo->meta_keywords : $locationInfo->display_name !!}" />
<meta property="og:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : asset('uploads/settings/'.$settingsInfo->default_img_1) !!}" />
<meta name="twitter:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : asset('uploads/settings/'.$settingsInfo->default_img_1) !!}" />
<meta name="robots" content="index, follow" />
{!! !empty($pageInfo) ? $pageInfo->header_code : '' !!}
@endpush

@section('content')

<!-- desktop version start -->
<div class="bgWHite hidden-xs">
	<div class="container">
		<div class="row">

			<!-- category header -->
			<div class="col-sm-12 col-md-12 marginB20">
				<div class="borderC1B1">
					<span class="leftSpan marginR3"></span>
					<span class="desktopCategoryTitle"><a aria-label="সারাদেশ" href="{!! url('country') !!}"><strong>সারাদেশ</strong></a> <i class="fa fa-circle marginR5 marginT-3 verticalMiddle title1_0 colorBrand"></i></span>
					@if(!empty($divisionInfo))
					<span class="desktopCategoryTitle"><a aria-label="{!! $divisionInfo->display_name !!}" href="{!! url('area/'.$divisionInfo->title) !!}"><strong>{!! $divisionInfo->display_name !!}</strong></a> <i class="fa fa-circle marginR5 marginT-3 verticalMiddle title1_0 colorBrand"></i></span>
					@endif
					@if(!empty($districtInfo))
					<span class="desktopCategoryTitle"><a aria-label="{!! $districtInfo->display_name !!}" href="{!! url('area/'.$districtInfo->title) !!}"><strong>{!! $districtInfo->display_name !!}</strong></a> <i class="fa fa-circle marginR5 marginT-3 verticalMiddle title1_0 colorBrand"></i></span>
					@endif
					<h1 class="desktopCategoryTitle"><a aria-label="{!! $locationInfo->display_name !!}" href="{!! url('area/'.$locationInfo->title) !!}"><strong>{!! $locationInfo->display_name !!}</strong></a></h1>
					<!-- subcategories -->
					@if(!empty($locations) && (count($locations)>0))
					<div class="desktopSubCategoryDiv marginB10">
						<ul>
							@foreach($locations as $key => $location)
							<li><i class="fa fa-circle"></i> <p><a aria-label="{!! $location->display_name !!}" href="{!! url('area/'.$location->title) !!}">{!! $location->display_name !!}</a></p></li>
							@endforeach
						</ul>
					</div>
					@endif
				</div>
			</div>


			<div class="col-sm-12 col-md-12">
				<div class="row marginLR-10">
					<!-- category lead news -->
					<div class="col-sm-9 col-md-9">
						<div class="row">
							@if(!empty($locationArticles[0]))
							@php $article = \App\Models\Helper::processArticleShortly($locationArticles[0], 20); @endphp
							<div class="col-sm-8 col-md-8 paddingLR10 desktopSectionLead">
								<div class="thumbnail">
									<div class="positionRelative">
										<a href="{!! $article->url !!}"><img src="{!! $article->thumb !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}"></a>
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconLarge"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconLarge"></span>
										@endif
									</div>
									<div class="caption">
										<a class="colorBlack hoverBlue" href="{!! $article->url !!}"><p class="title10 marginT5 marginB5"><strong>{!! $article->fullheadline !!}</strong></p></a>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5 marginT10">{!! $article->summary !!}</p>
										@endif
									</div>
								</div>
							</div>
							@endif

							<!-- category top news -->
							<div class="col-sm-4 col-md-4">
								<div class="row borderLastItemNone desktopFlexRow">
									@for($i=1; $i<=2; $i++)
									@if(!empty($locationArticles[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($locationArticles[$i], 0); @endphp
									<div class="col-sm-12 col-md-12 lastItemNone paddingLR10">
										<div class="desktopSectionLead marginB5">
											<div class="thumbnail borderRadius0 bgUnset">
												<div class="positionRelative">
													<a href="{!! $article->url !!}"><img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}"></a>
													@if($article->categoryTitle == 'photos')
													<span class="fa fa-image ppIconMedium"></span>
													@elseif(!empty($article->video_code))
													<span class="fa fa-play pvIconMedium"></span>
													@endif
												</div>
												<div class="caption paddingTB0 paddingLR10">
													<a class="colorBlack hoverBlue" href="{!! $article->url !!}"><p class="title11 marginT0">{!! $article->fullheadline !!}</p></a>
												</div>
											</div>
										</div>
									</div>
									@endif
									@endfor
								</div>
							</div>

							<!-- category top news -->
							<div class="col-sm-12 col-md-12">
								<div class="row borderLastItemNone desktopFlexRow">
									@for($i=3; $i<=5; $i++)
									@if(!empty($locationArticles[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($locationArticles[$i], 0); @endphp
									<div class="col-sm-4 col-md-4 lastItemNone paddingLR10">
										<div class="desktopSectionLead marginB5">
											<div class="thumbnail borderRadius0 bgUnset">
												<div class="positionRelative">
													<a href="{!! $article->url !!}"><img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}"></a>
													@if($article->categoryTitle == 'photos')
													<span class="fa fa-image ppIconMedium"></span>
													@elseif(!empty($article->video_code))
													<span class="fa fa-play pvIconMedium"></span>
													@endif
												</div>
												<div class="caption paddingTB0 paddingLR10">
													<a class="colorBlack hoverBlue" href="{!! $article->url !!}"><p class="title11 marginT0">{!! $article->fullheadline !!}</p></a>
												</div>
											</div>
										</div>
									</div>
									@endif
									@endfor
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-3 col-md-3">
						<!-- ad -->
						<div class="row marginT0">
							<div class="col-sm-12 col-md-12 marginB20">
								<div class="adDiv w300 borderRadius5 overflowHidden">
									<a href="#" target="_blank"><img src="{!! asset('uploads/advertisements/300x250-1.jpg') !!}" align="Ad" class="img-responsive"></a>
								</div>
							</div>
						</div>
						<!-- ad -->

						<!-- ad -->
						<div class="row marginT0">
							<div class="col-sm-12 col-md-12 marginB20">
								<div class="adDiv w300 borderRadius5 overflowHidden">
									<a href="#" target="_blank"><img src="{!! asset('uploads/advertisements/300x250-1.jpg') !!}" align="Ad" class="img-responsive"></a>
								</div>
							</div>
						</div>
						<!-- ad -->
					</div>

				</div>

				<div class="row">
					<div class="col-sm-12 col-md-12"><p class="desktopDivider marginT0 marginB10"></p></div>
					<div class="col-sm-8 col-md-8 col-md-offset-2 marginT20">
						<div class="desktopSectionListMedia loadMoreCategoryNewsDesktop">
							@for($i=6; $i<=19; $i++)
							@if(!empty($locationArticles[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($locationArticles[$i], 20); @endphp
							<div class="media positionRelative marginB5">
								<div class="media-body">
									<a class="colorBlack hoverBlue" href="{!! $article->url !!}"><p class="title10 marginT0">{!! $article->fullheadline !!}</p></a>
									@if(!empty($article->summary))
									<p class="desktopSummary marginT10 hidden-xs">{!! $article->summary !!}</p>
									@endif
									<p class="desktopTime marginT15"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
								</div>
								<div class="media-right">
									<div class="positionRelative">
										<a href="{!! $article->url !!}"><img class="media-object borderRadius5 xs-width120" src="{!! $article->thumbMedium !!}" width="300" alt="{!! $article->headline !!}"></a>
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
								</div>
							</div>
							@endif
							@endfor
						</div>
					</div>
				</div>

				<!-- load more button -->
				<div class="text-center marginT20">
					<span data-paginate="1" class="loadMoreButton clickLoadMoreDesktop">আরও পড়ুন <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span>
				</div>
				<!-- load more button -->

			</div>

		</div>
	</div>

</div>
<!-- desktop version end -->



<!-- mobile version start -->
<div class="bgWHite visible-xs">
	<div class="container paddingT10">
		<div class="row">
			<!-- header -->
			<div class="col-sm-12 col-md-12 paddingLR20 marginB15 marginT10">
				<span class="leftSpan marginR3"></span>
				<span class="sectionTitle displayInline border0"><a aria-label="সারাদেশ" href="{!! url('country') !!}"><strong>সারাদেশ</strong></a> <i class="fa fa-circle marginR5 marginT-2 verticalMiddle title1_0 colorBrand"></i></span>
				@if(!empty($divisionInfo))
				<span class="sectionTitle displayInline border0"><a aria-label="{!! $divisionInfo->display_name !!}" href="{!! url('area/'.$divisionInfo->title) !!}"><strong>{!! $divisionInfo->display_name !!}</strong></a> <i class="fa fa-circle marginR5 marginT-2 verticalMiddle title1_0 colorBrand"></i></span>
				@endif
				@if(!empty($districtInfo))
				<span class="sectionTitle displayInline border0"><a aria-label="{!! $districtInfo->display_name !!}" href="{!! url('area/'.$districtInfo->title) !!}"><strong>{!! $districtInfo->display_name !!}</strong></a> <i class="fa fa-circle marginR5 marginT-2 verticalMiddle title1_0 colorBrand"></i></span>
				@endif
				<p class="sectionTitle displayInline border0 margin0 marginB0"><a aria-label="{!! $locationInfo->display_name !!}" href="{!! url('area/'.$locationInfo->title) !!}"><strong>{!! $locationInfo->display_name !!}</strong></a></p>
				<!-- subcategories -->
				@if(!empty($locations) && (count($locations)>0))
				<div class="subCategoryDiv marginT5">
					<ul>
						@foreach($locations as $key => $location)
						<li> <i class="fa fa-circle"></i> <p><a aria-label="{!! $location->display_name !!}" href="{!! url('area/'.$location->title) !!}">{!! $location->display_name !!}</a></p></li>
						@endforeach
					</ul>
				</div>
				@endif
			</div>

			
			<!-- lead news -->
			@if(!empty($locationArticles[0]))
			@php $article = \App\Models\Helper::processArticleShortly($locationArticles[0], 0); @endphp
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
					</div>
					<a href="{!! $article->url !!}" class="linkOverlay"></a>
				</div>
			</div>
			@endif
			<div class="col-sm-12 col-md-12 paddingLR0 marginB5"><div class="borderC1T1"></div></div>


			@if(!empty($locationArticles) && (count($locationArticles)>0))
			<div class="col-sm-12 col-md-12 paddingLR20 marginT0">
				<div class="sectionListMedia loadMoreCategoryNewsMobile borderC1B1">
					@for($i=1; $i<=19; $i++)
					@if(!empty($locationArticles[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($locationArticles[$i], 0); @endphp
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
			<div class="text-center marginT30">
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
<!-- desktop ajax load more category news -->
<script type="text/javascript">
	$('.clickLoadMoreDesktop').click(function(){
		$('.loadingIcon').show();
		var paginate = $(this).data('paginate');
		$(this).data('paginate', parseInt(paginate)+1);
		var url = '{{url("ajax/load/locationnews/")}}/{{$locationInfo->id}}/{{$locationInfo->type}}/20/'+paginate+'/20';
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
					var row = $('<div class="media positionRelative marginB5"><div class="media-body"><a class="colorBlack hoverBlue" href="'+value.url+'"><p class="title10 marginT0">'+value.fullheadline+'</p></a><p class="desktopSummary marginT10 hidden-xs">'+value.summary+'</p><p class="desktopTime marginT15"><i class="fa fa-regular fa-clock"></i> '+value.publishTime+'</p></div><div class="media-right"><div class="positionRelative"><a href="'+value.url+'"><img class="media-object borderRadius5 xs-width120" src="'+value.thumbMedium+'" width="300" alt="'+value.headline+'"></a>'+icon+'</div></div></div>');
					$('.loadMoreCategoryNewsDesktop').append(row);
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
		var url = '{{url("ajax/load/locationnews/")}}/{{$locationInfo->id}}/{{$locationInfo->type}}/20/'+paginate+'/0';
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
					var row = $('<div class="media positionRelative"><div class="media-left paddingR5"><div class="positionRelative"><img class="media-object" src="'+value.thumbSmall+'" width="140" alt="'+value.headline+'">'+icon+'</div></div><div class="media-body"><p class="xs-title marginL5">'+value.fullheadline+'</p><p class="time marginT5 marginL5"><i class="fa fa-regular fa-clock"></i> '+value.publishTime+'</p></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div>');
					$('.loadMoreCategoryNewsMobile').append(row);
				});
			}
		});
		$('.loadMoreCategoryNewsMobileWidget').show();
	});
</script>
@endpush