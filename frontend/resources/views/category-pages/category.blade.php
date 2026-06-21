@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : (!empty($categoryInfo->meta_title) ? $categoryInfo->meta_title : $categoryInfo->display_name.' - '.$settingsInfo->newspaper_name) !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : (!empty($categoryInfo->meta_title) ? $categoryInfo->meta_title : $categoryInfo->display_name.' - '.$settingsInfo->newspaper_name) !!}" />
<meta property="og:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : (!empty($categoryInfo->meta_description) ? $categoryInfo->meta_description : '') !!}" />
<meta name="description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : (!empty($categoryInfo->meta_description) ? $categoryInfo->meta_description : '') !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : (!empty($categoryInfo->meta_title) ? $categoryInfo->meta_title : $categoryInfo->display_name.' - '.$settingsInfo->newspaper_name) !!}" />
<meta name="twitter:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : (!empty($categoryInfo->meta_description) ? $categoryInfo->meta_description : '') !!}" />
<meta name="keywords" content="{!! !empty($pageInfo) ? $pageInfo->meta_keywords : (!empty($categoryInfo->meta_keywords) ? $categoryInfo->meta_keywords : '') !!}" />
<meta property="og:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : asset('uploads/settings/'.$settingsInfo->default_img_1) !!}" />
<meta name="twitter:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : asset('uploads/settings/'.$settingsInfo->default_img_1) !!}" />
<meta name="robots" content="index, follow" />
{!! !empty($pageInfo) ? $pageInfo->header_code : $categoryInfo->header_code !!}
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
					@if(!empty($parentCategoryInfo))
					<span class="desktopCategoryTitle"><a aria-label="{!! $parentCategoryInfo->display_name !!}" href="{!! url($parentCategoryInfo->title) !!}"><strong>{!! $parentCategoryInfo->display_name !!}</strong></a> <i class="fa fa-circle marginR5 marginT-3 verticalMiddle title1_0 colorBrand"></i></span>
					@endif
					<h1 class="desktopCategoryTitle"><strong>{!! $categoryInfo->display_name !!}</strong></h1>
					<!-- subcategories -->
					@if(!empty($subCategories) && (count($subCategories)>0))
					<div class="desktopSubCategoryDiv marginB10">
						<ul>
							@foreach($subCategories as $key => $subCat)
							<li><i class="fa fa-circle"></i> <p><a aria-label="{!! $subCat->display_name !!}" href="{!! url($subCat->title) !!}">{!! $subCat->display_name !!}</a></p></li>
							@endforeach
						</ul>
					</div>
					@endif

					<!-- locations -->
					@if(($categoryInfo->title == 'country') && !empty($divisions) && (count($divisions)>0))
					<div class="desktopSubCategoryDiv marginB10">
						<ul>
							@foreach($divisions as $key => $division)
							<li><i class="fa fa-circle"></i> <p><a aria-label="{!! $division->display_name !!}" href="{!! url('area/'.$division->title) !!}">{!! $division->display_name !!}</a></p></li>
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
							@if(!empty($categoryArticles[0]))
							@php $article = \App\Models\Helper::processArticleShortly($categoryArticles[0], 20); @endphp
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
									@if(!empty($categoryArticles[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($categoryArticles[$i], 0); @endphp
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
									@if(!empty($categoryArticles[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($categoryArticles[$i], 0); @endphp
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

						<!-- location search -->
						@if($categoryInfo->title == 'country' || (!empty($parentCategoryInfo) && $parentCategoryInfo->title == 'country'))
						<div class="row">
							<div class="col-sm-12 col-md-12">
								<div class="desktopLocationDiv marginB20 padding10 borderC1-1 borderRadius5">
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<p class="desktopSectionTitle marginT-5 marginB5"><span class="leftSpan"></span> আপনার এলাকার খবর</p>
										</div>

										<div class="col-sm-12 col-md-12 searchMessageDiv" style="display: none;">
											<div class="alert alert-warning alert-dismissible fade in marginB15 text-center title12" role="alert"> <button type="button" class="close colorBlack bgUnset" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> <strong>প্রিয় পাঠক!</strong> বিভাগ, জেলা ও উপজেলা সঠিকভাবে পছন্দ করে অনুসন্ধান করুন। ধন্যবাদ।</div>
										</div>
										<div class="col-sm-12 col-md-12 marginB10">
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
										<div class="col-sm-12 col-md-12 marginB10">
											<div>
												<select class="form-control selectDistrict" name="district">
													<option value="">জেলা</option>
												</select>
											</div>
										</div>
										<div class="col-sm-12 col-md-12 marginB10">
											<div>
												<select class="form-control selectUpazila" name="upazila">
													<option value="">উপজেলা</option>
												</select>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div>
												<button type="button" class="btn btn-block clickSearchButton bgRed">অনুসন্ধান</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						@else

						<!-- ad -->
						<div class="row marginT0">
							<div class="col-sm-12 col-md-12 marginB20">
								<div class="adDiv w300 borderRadius5 overflowHidden">
									<a href="#" target="_blank"><img src="{!! asset('uploads/advertisements/300x250-1.jpg') !!}" align="Ad" class="img-responsive"></a>
								</div>
							</div>
						</div>
						<!-- ad -->

						@endif
						<!-- location search end -->

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
						<div class="desktopSectionListMedia listItemLastBB0 loadMoreCategoryNewsDesktop">
							@for($i=6; $i<=19; $i++)
							@if(!empty($categoryArticles[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($categoryArticles[$i], 20); @endphp
							<div class="media positionRelative marginB5">
								<div class="media-body">
									<p class="title10 marginT0"><a class="colorBlack hoverBlue" href="{!! $article->url !!}">{!! $article->fullheadline !!}</a></p>
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
					<span data-paginate="1" class="loadMoreButton clickLoadMoreDesktop">{!! $categoryInfo->title == 'videos' || $categoryInfo->title == 'photos' ? 'আরও দেখুন' : 'আরও পড়ুন' !!} <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span>
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
				@if(!empty($parentCategoryInfo))
				<span class="sectionTitle displayInline border0"><a aria-label="{!! $parentCategoryInfo->display_name !!}" href="{!! url($parentCategoryInfo->title) !!}"><strong>{!! $parentCategoryInfo->display_name !!}</strong></a> <i class="fa fa-circle marginR5 marginT-5 verticalMiddle title1_0 colorBrand"></i></span>
				@endif
				<h1 class="sectionTitle displayInline border0 margin0 marginB0"><strong>{!! $categoryInfo->display_name !!}</strong></h1>
				<!-- subcategories -->
				@if(!empty($subCategories) && (count($subCategories)>0))
				<div class="subCategoryDiv marginT5">
					<ul>
						@foreach($subCategories as $key => $subCat)
						<li><i class="fa fa-circle"></i> <p><a aria-label="{!! $subCat->display_name !!}" href="{!! url($subCat->title) !!}">{!! $subCat->display_name !!}</a></p></li>
						@endforeach
					</ul>
				</div>
				@endif

				<!-- locations -->
				@if(($categoryInfo->title == 'country') && !empty($divisions) && (count($divisions)>0))
				<div class="subCategoryDiv marginT5">
					<ul>
						@foreach($divisions as $key => $division)
						<li><i class="fa fa-circle"></i> <p><a aria-label="{!! $division->display_name !!}" href="{!! url('area/'.$division->title) !!}">{!! $division->display_name !!}</a></p></li>
						@endforeach
					</ul>
				</div>
				@endif
			</div>

			
			<!-- lead news -->
			@if(!empty($categoryArticles[0]))
			@php $article = \App\Models\Helper::processArticleShortly($categoryArticles[0], 0); @endphp
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


			@if(!empty($categoryArticles) && (count($categoryArticles)>0))
			<div class="col-sm-12 col-md-12 paddingLR26 marginT15">
				<div class="row desktopFlexRow">
					@for($i=1; $i<=18; $i++)
					@if(!empty($categoryArticles[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($categoryArticles[$i], 0); @endphp
					<div class="col-sm-6 col-md-6 col-xs-6 paddingLR7 sectionListThumbnail">
						<div class="thumbnail">
							<div class="positionRelative">
								<img src="{!! $article->thumbMedium !!}" class="img-responsive" alt="{!! $article->headline !!}">
								@if($article->categoryTitle == 'photos')
								<span class="fa fa-image ppIconSmall"></span>
								@elseif(!empty($article->video_code))
								<span class="fa fa-play pvIconSmall"></span>
								@endif
							</div>
							<div class="caption">
								<p class="xs-title">{!! $article->fullheadline !!}</p>
							</div>
							<a href="{!! $article->url !!}" class="linkOverlay"></a>
						</div>
					</div>
					@endif
					@endfor
				</div>
			</div>

			<!-- list news -->
			<div class="col-sm-12 col-md-12 paddingLR20 borderC1T1 loadMoreCategoryNewsMobileWidget" style="display: none;">
				<div class="sectionListMedia marginT5">
					<!-- load more news -->
					<div class="loadMoreCategoryNewsMobile"></div>
					<!-- load more news end -->
				</div>
			</div>

			<!-- load more button -->
			<div class="text-center marginT30">
				<span data-paginate="1" class="loadMoreButtonMobile clickLoadMoreMobile">{!! $categoryInfo->title == 'videos' || $categoryInfo->title == 'photos' ? 'আরও দেখুন' : 'আরও পড়ুন' !!} <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span>
			</div>
			<!-- load more button -->


			<!-- elakar khobor map -->
			@if($categoryInfo->title == 'country' || (!empty($parentCategoryInfo) && $parentCategoryInfo->title == 'country'))
			<div class="col-sm-12 col-md-12 marginT30 paddingLR20">
				<div class="borderRadius5 overflowHidden borderC1-1 shadow1">
					<p class="title10 text-center borderC1B1 padding10 colorBlack">আপনার এলাকার খবর</p>
					<div class="padding10">
						@include('other-pages.map')
					</div>

					<div class="desktopLocationDiv borderC1T1 paddingLR20 paddingT10 paddingB10">
						<div class="row">
							<div class="col-sm-12 col-md-12 searchMessageDiv marginB0 paddingLR5" style="display: none;">
								<div class="alert alert-warning alert-dismissible fade in marginB15 text-center title12" role="alert"> <button type="button" class="close bgUnset colorBlack" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> <strong>প্রিয় পাঠক!</strong> বিভাগ, জেলা ও উপজেলা সঠিকভাবে পছন্দ করে অনুসন্ধান করুন। ধন্যবাদ।</div>
							</div>

							<div class="col-sm-6 col-md-6 marginB10 paddingLR5">
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
							<div class="col-sm-6 col-md-6 marginB10 paddingLR5">
								<div>
									<select class="form-control selectDistrict" name="district">
										<option value="">জেলা</option>
									</select>
								</div>
							</div>
							<div class="col-sm-6 col-md-6 marginB10 paddingLR5">
								<div>
									<select class="form-control selectUpazila" name="upazila">
										<option value="">উপজেলা</option>
									</select>
								</div>
							</div>
							<div class="col-sm-6 col-md-6 paddingLR5">
								<div>
									<button type="button" class="btn btn-block clickSearchButton bgRed">অনুসন্ধান</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif
			<!-- elakar khobor map end -->
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
		var url = '{{url("ajax/load/categorynews/")}}/{{$categoryInfo->id}}/20/'+paginate+'/20';
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
		var url = '{{url("ajax/load/categorynews/")}}/{{$categoryInfo->id}}/20/'+paginate+'/0';
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
					var row = $('<div class="media positionRelative"><div class="media-left paddingR5"><div class="positionRelative"><img class="media-object" src="'+value.thumbSmall+'" width="140" alt="'+value.headline+'">'+icon+'</div></div><div class="media-body"><p class="xs-title marginL5">'+value.fullheadline+'</p></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div>');
					$('.loadMoreCategoryNewsMobile').append(row);
				});
			}
		});
		$('.loadMoreCategoryNewsMobileWidget').show();
	});
</script>
@endpush