	<div class="container marginT70">
		<div class="row">
			<!-- category 9 -->
			@if(!empty($category_9) && (count($category_9)>0))
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="desktopSectionTitleDiv2">
							<p class="desktopSectionTitle"><a aria-label="{!! $category_9[0]->display_name !!}" href="{!! url($category_9[0]->title) !!}">{!! $category_9[0]->display_name !!}</a></p>
						</div>
					</div>
				</div>
				<div class="row marginLR-10">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 paddingLR10">
						<div class="row desktopFlexRow">
							@if(!empty($category_9[0]))
							@php $article = \App\Models\Helper::processArticleShortly($category_9[0], 15); @endphp
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
							@for($i=1; $i<=4; $i++)
							@if(!empty($category_9[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($category_9[$i], 0, 40); @endphp
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

					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 paddingLR10">
						<div class="desktopSectionListMedia listItemFirstPT0 listItemLastBB0 marginT-5">
							@for($i=5; $i<=7; $i++)
							@if(!empty($category_9[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($category_9[$i], 0); @endphp
							<div class="media positionRelative">
								<div class="media-left">
									<div class="positionRelative">
										<img class="media-object borderRadius5" src="{!! $article->thumbSmall !!}" width="180" alt="{!! $article->headline !!}">
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

				</div>
			</div>
			@endif
			<!-- category 9 end -->
		</div>

		<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><p class="desktopDivider marginT0 marginB10"></p></div></div>
	</div>


	<div class="container marginT70">
		<div class="row">
			<!-- category 11 -->
			@if(!empty($category_11) && (count($category_11)>0))
			<div class="col-sm-12 col-md-12">
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<div class="desktopSectionTitleDiv2">
							<p class="desktopSectionTitle"><a aria-label="{!! $category_11[0]->display_name !!}" href="{!! url($category_11[0]->title) !!}">{!! $category_11[0]->display_name !!}</a></p>
						</div>
					</div>
				</div>
				<div class="row marginLR-15">
					<div class="col-sm-12 col-md-12 paddingLR10">
						<div class="row marginLR-5 desktopFlexRow">
							@for($i=0; $i<=3; $i++)
							@if(!empty($category_11[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($category_11[$i], 0); @endphp
							<div class="col-sm-3 col-md-3 paddingLR10 desktopSectionLead">
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
										<p class="title11 marginT0"><strong>{!! $article->fullheadline !!}</strong></p>
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
			<!-- category 11 end -->
		</div>
	</div>



	<div class="container marginT70">
		<div class="row">
			<!-- category 17 -->
			@if(!empty($category_17) && (count($category_17)>0))
			<div class="col-sm-6 col-md-6 borderC1R1">
				<div class="row marginLR-10">
					<div class="col-sm-12 col-md-12 marginLR-5">
						<div class="desktopSectionTitleDiv2">
							<p class="desktopSectionTitle"><a aria-label="{!! $category_17[0]->display_name !!}" href="{!! url($category_17[0]->title) !!}">{!! $category_17[0]->display_name !!}</a></p>
						</div>
					</div>

					@if(!empty($category_17[0]))
					@php $article = \App\Models\Helper::processArticleShortly($category_17[0], 20); @endphp
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
							@if(!empty($category_17[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($category_17[$i], 0, 45); @endphp
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


			<!-- category 18 -->
			@if(!empty($category_18) && (count($category_18)>0))
			<div class="col-sm-6 col-md-6">
				<div class="row marginLR-10">
					<div class="col-sm-12 col-md-12 marginLR-5">
						<div class="desktopSectionTitleDiv2">
							<p class="desktopSectionTitle"><a aria-label="{!! $category_18[0]->display_name !!}" href="{!! url($category_18[0]->title) !!}">{!! $category_18[0]->display_name !!}</a></p>
						</div>
					</div>

					@if(!empty($category_18[0]))
					@php $article = \App\Models\Helper::processArticleShortly($category_18[0], 20); @endphp
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
							@if(!empty($category_18[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($category_18[$i], 0, 45); @endphp
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
			<div class="col-sm-12 col-md-12">
				<div class="row">
					<!-- category 12 -->
					@if(!empty($category_12) && (count($category_12)>0))
					<div class="col-sm-3 col-md-3">
						<div class="row desktopFlexRow">
							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionTitleDiv2">
									<p class="desktopSectionTitle"><a aria-label="{!! $category_12[0]->display_name !!}" href="{!! url($category_12[0]->title) !!}">{!! $category_12[0]->display_name !!}</a></p>
								</div>
							</div>

							@if(!empty($category_12[0]))
							@php $article = \App\Models\Helper::processArticleShortly($category_12[0], 0); @endphp
							<div class="col-sm-12 col-md-12 desktopSectionLead">
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption borderC1B1">
										<p class="title10 marginT0"><strong>{!! $article->fullheadline !!}</strong></p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif

							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionListMedia listItemLastBB0">
									@for($i=1; $i<=3; $i++)
									@if(!empty($category_12[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($category_12[$i], 0); @endphp
									<div class="media positionRelative">
										<div class="media-body">
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
						</div>
					</div>
					@endif
					<!-- category 12 end -->


					<!-- category 13 -->
					@if(!empty($category_13) && (count($category_13)>0))
					<div class="col-sm-3 col-md-3">
						<div class="row desktopFlexRow">
							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionTitleDiv2">
									<p class="desktopSectionTitle"><a aria-label="{!! $category_13[0]->display_name !!}" href="{!! url($category_13[0]->title) !!}">{!! $category_13[0]->display_name !!}</a></p>
								</div>
							</div>

							@if(!empty($category_13[0]))
							@php $article = \App\Models\Helper::processArticleShortly($category_13[0], 0); @endphp
							<div class="col-sm-12 col-md-12 desktopSectionLead">
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption borderC1B1">
										<p class="title10 marginT0"><strong>{!! $article->fullheadline !!}</strong></p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif

							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionListMedia listItemLastBB0">
									@for($i=1; $i<=3; $i++)
									@if(!empty($category_13[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($category_13[$i], 0); @endphp
									<div class="media positionRelative">
										<div class="media-body">
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
						</div>
					</div>
					@endif
					<!-- category 13 end -->


					<!-- category 14 -->
					@if(!empty($category_14) && (count($category_14)>0))
					<div class="col-sm-3 col-md-3">
						<div class="row desktopFlexRow">
							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionTitleDiv2">
									<p class="desktopSectionTitle"><a aria-label="{!! $category_14[0]->display_name !!}" href="{!! url($category_14[0]->title) !!}">{!! $category_14[0]->display_name !!}</a></p>
								</div>
							</div>

							@if(!empty($category_14[0]))
							@php $article = \App\Models\Helper::processArticleShortly($category_14[0], 0); @endphp
							<div class="col-sm-12 col-md-12 desktopSectionLead">
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption borderC1B1">
										<p class="title10 marginT0"><strong>{!! $article->fullheadline !!}</strong></p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif

							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionListMedia listItemLastBB0">
									@for($i=1; $i<=3; $i++)
									@if(!empty($category_14[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($category_14[$i], 0); @endphp
									<div class="media positionRelative">
										<div class="media-body">
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
						</div>
					</div>
					@endif
					<!-- category 14 end -->


					<!-- category 15 -->
					@if(!empty($category_15) && (count($category_15)>0))
					<div class="col-sm-3 col-md-3">
						<div class="row desktopFlexRow">
							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionTitleDiv2">
									<p class="desktopSectionTitle"><a aria-label="{!! $category_15[0]->display_name !!}" href="{!! url($category_15[0]->title) !!}">{!! $category_15[0]->display_name !!}</a></p>
								</div>
							</div>

							@if(!empty($category_15[0]))
							@php $article = \App\Models\Helper::processArticleShortly($category_15[0], 0); @endphp
							<div class="col-sm-12 col-md-12 desktopSectionLead">
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption borderC1B1">
										<p class="title10 marginT0"><strong>{!! $article->fullheadline !!}</strong></p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif

							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionListMedia listItemLastBB0">
									@for($i=1; $i<=3; $i++)
									@if(!empty($category_15[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($category_15[$i], 0); @endphp
									<div class="media positionRelative">
										<div class="media-body">
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
						</div>
					</div>
					@endif
					<!-- category 15 end -->

				</div>
			</div>

			<div class="col-sm-12 col-md-12"><p class="desktopDivider marginT0 marginB10"></p></div>
		</div>
	</div>



	<div class="container marginT70">
		<div class="row">
			<!-- category 19 -->
			@if(!empty($category_19) && (count($category_19)>0))
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="desktopSectionTitleDiv2">
							<p class="desktopSectionTitle"><a aria-label="{!! $category_19[0]->display_name !!}" href="{!! url($category_19[0]->title) !!}">{!! $category_19[0]->display_name !!}</a></p>
						</div>
					</div>
				</div>
				<div class="row marginLR-10">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 paddingLR10">
						<div class="row marginLR-10 desktopFlexRow">
							@for($i=1; $i<=4; $i++)
							@if(!empty($category_19[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($category_19[$i], 0); @endphp
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
							@if(!empty($category_19[0]))
							@php $article = \App\Models\Helper::processArticleShortly($category_19[0], 13); @endphp
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
							@if(!empty($category_19[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($category_19[$i], 0); @endphp
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
			<!-- category 19 end -->
		</div>

		<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><p class="desktopDivider marginT0 marginB10"></p></div></div>
	</div>



	<div class="container marginT70">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="row">
					<!-- category 20 -->
					@if(!empty($category_20) && (count($category_20)>0))
					<div class="col-sm-3 col-md-3">
						<div class="row desktopFlexRow">
							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionTitleDiv2">
									<p class="desktopSectionTitle"><a aria-label="{!! $category_20[0]->display_name !!}" href="{!! url($category_20[0]->title) !!}">{!! $category_20[0]->display_name !!}</a></p>
								</div>
							</div>

							@if(!empty($category_20[0]))
							@php $article = \App\Models\Helper::processArticleShortly($category_20[0], 0); @endphp
							<div class="col-sm-12 col-md-12 desktopSectionLead">
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption borderC1B1">
										<p class="title10 marginT0"><strong>{!! $article->fullheadline !!}</strong></p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif

							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionListMedia listItemLastBB0">
									@for($i=1; $i<=3; $i++)
									@if(!empty($category_20[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($category_20[$i], 0); @endphp
									<div class="media positionRelative">
										<div class="media-body">
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
						</div>
					</div>
					@endif
					<!-- category 20 end -->


					<!-- category 21 -->
					@if(!empty($category_21) && (count($category_21)>0))
					<div class="col-sm-3 col-md-3">
						<div class="row desktopFlexRow">
							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionTitleDiv2">
									<p class="desktopSectionTitle"><a aria-label="{!! $category_21[0]->display_name !!}" href="{!! url($category_21[0]->title) !!}">{!! $category_21[0]->display_name !!}</a></p>
								</div>
							</div>

							@if(!empty($category_21[0]))
							@php $article = \App\Models\Helper::processArticleShortly($category_21[0], 0); @endphp
							<div class="col-sm-12 col-md-12 desktopSectionLead">
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption borderC1B1">
										<p class="title10 marginT0"><strong>{!! $article->fullheadline !!}</strong></p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif

							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionListMedia listItemLastBB0">
									@for($i=1; $i<=3; $i++)
									@if(!empty($category_21[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($category_21[$i], 0); @endphp
									<div class="media positionRelative">
										<div class="media-body">
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
						</div>
					</div>
					@endif
					<!-- category 21 end -->


					<!-- category 22 -->
					@if(!empty($category_22) && (count($category_22)>0))
					<div class="col-sm-3 col-md-3">
						<div class="row desktopFlexRow">
							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionTitleDiv2">
									<p class="desktopSectionTitle"><a aria-label="{!! $category_22[0]->display_name !!}" href="{!! url($category_22[0]->title) !!}">{!! $category_22[0]->display_name !!}</a></p>
								</div>
							</div>

							@if(!empty($category_22[0]))
							@php $article = \App\Models\Helper::processArticleShortly($category_22[0], 0); @endphp
							<div class="col-sm-12 col-md-12 desktopSectionLead">
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption borderC1B1">
										<p class="title10 marginT0"><strong>{!! $article->fullheadline !!}</strong></p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif

							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionListMedia listItemLastBB0">
									@for($i=1; $i<=3; $i++)
									@if(!empty($category_22[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($category_22[$i], 0); @endphp
									<div class="media positionRelative">
										<div class="media-body">
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
						</div>
					</div>
					@endif
					<!-- category 22 end -->


					<!-- category 23 -->
					@if(!empty($category_23) && (count($category_23)>0))
					<div class="col-sm-3 col-md-3">
						<div class="row desktopFlexRow">
							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionTitleDiv2">
									<p class="desktopSectionTitle"><a aria-label="{!! $category_23[0]->display_name !!}" href="{!! url($category_23[0]->title) !!}">{!! $category_23[0]->display_name !!}</a></p>
								</div>
							</div>

							@if(!empty($category_23[0]))
							@php $article = \App\Models\Helper::processArticleShortly($category_23[0], 0); @endphp
							<div class="col-sm-12 col-md-12 desktopSectionLead">
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption borderC1B1">
										<p class="title10 marginT0"><strong>{!! $article->fullheadline !!}</strong></p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif

							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionListMedia listItemLastBB0">
									@for($i=1; $i<=3; $i++)
									@if(!empty($category_23[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($category_23[$i], 0); @endphp
									<div class="media positionRelative">
										<div class="media-body">
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
						</div>
					</div>
					@endif
					<!-- category 23 end -->

				</div>
			</div>

			<div class="col-sm-12 col-md-12"><p class="desktopDivider marginT0 marginB10"></p></div>
		</div>
	</div>


	<div class="container marginT70">
		<div class="row">
			<!-- category 16 -->
			@if(!empty($category_16) && (count($category_16)>0))
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="desktopSectionTitleDiv2">
							<p class="desktopSectionTitle"><a aria-label="{!! $category_16[0]->display_name !!}" href="{!! url($category_16[0]->title) !!}">{!! $category_16[0]->display_name !!}</a></p>
						</div>
					</div>
				</div>
				<div class="row marginLR-10">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 paddingLR10">
						<div class="row marginLR-10 desktopFlexRow">
							@for($i=1; $i<=4; $i++)
							@if(!empty($category_16[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($category_16[$i], 0); @endphp
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
							@if(!empty($category_16[0]))
							@php $article = \App\Models\Helper::processArticleShortly($category_16[0], 13); @endphp
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
							@if(!empty($category_16[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($category_16[$i], 0); @endphp
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
			<!-- category 16 end -->
		</div>

		<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><p class="desktopDivider marginT0 marginB10"></p></div></div>
	</div>


	<div class="container marginT70">
		<div class="row">
			<!-- category 24 -->
			@if(!empty($category_24) && (count($category_24)>0))
			<div class="col-sm-12 col-md-12">
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<div class="desktopSectionTitleDiv2">
							<p class="desktopSectionTitle"><a aria-label="{!! $category_24[0]->display_name !!}" href="{!! url($category_24[0]->title) !!}">{!! $category_24[0]->display_name !!}</a></p>
						</div>
					</div>
				</div>
				<div class="row marginLR-15">
					<div class="col-sm-12 col-md-12 paddingLR10">
						<div class="row marginLR-5 desktopFlexRow">
							@for($i=0; $i<=3; $i++)
							@if(!empty($category_24[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($category_24[$i], 0); @endphp
							<div class="col-sm-3 col-md-3 paddingLR10 desktopSectionLead">
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
										<p class="title11 marginT0"><strong>{!! $article->fullheadline !!}</strong></p>
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
			<!-- category 24 end -->
		</div>
	</div>


	<!-- category photos -->
	@if(!empty($photoGalleries) && (count($photoGalleries)>0))
	<div class="bg2 paddingT60 paddingB40 marginT40">
		<div class="container marginB20">
			<div class="row marginLR-10 desktopFlexRow">
				<div class="col-sm-12 col-md-12 paddingLR10">
					<div class="desktopSectionTitleDiv2">
						<p class="desktopSectionTitle"><a class="bg2" aria-label="{!! $photoGalleries[0]->display_name !!}" href="{!! url($photoGalleries[0]->title) !!}">{!! $photoGalleries[0]->display_name !!}</a></p>
					</div>
				</div>

				@if(!empty($photoGalleries[0]))
				@php $article = \App\Models\Helper::processArticleShortly($photoGalleries[0], 0); @endphp
				<div class="col-sm-7 col-md-7 desktopSectionLead paddingLR10">
					<div class="thumbnail bgUnset">
						<div id="carousel-example-generic" class="carousel slide customCarousel" data-ride="carousel">
							<div class="customProgressBar"><div class="bar"><div class="in"></div></div></div>
							<div class="carousel-inner borderTRadius5 positionRelative">
								@foreach($photoGalleries[0]->articlePhotos as $key => $articlePhoto)
								<div class="item {!! $key==0 ? 'active' : '' !!}">
									<a href="{!! $article->url !!}">
										<img class="img-responsive borderBRadius5" src="{!! asset('uploads/news_photos/'.date('Y/m/d', strtotime($article->created_at))).'/'.$articlePhoto->image !!}" alt="{!! $article->headline !!}" title="{!! $article->headline !!}">
										<span class="carousel-counter">{{App\Http\Controllers\CommonController::GetBangla($key+1)}} / {{App\Http\Controllers\CommonController::GetBangla(count($photoGalleries[0]->articlePhotos))}}</span>

										@if(!empty($articlePhoto->image_caption))
										<div class="carousel-caption borderBRadius5 carousel-caption-custom">
											<p class="title12 marginB0 text-left colorWhite marginT0">{!! $articlePhoto->image_caption !!}</p>
										</div>
										@endif
									</a>
								</div>
								@endforeach
							</div>

							<!-- Controls -->
							<span class="customCarouselPauseButton"><i class="fa fa-pause"></i></span>
							<span class="customCarouselPlayButton" style="display: none;"><i class="fa fa-play"></i></span>

							<a class="left carousel-control bgImageNone leftControl" href="#carousel-example-generic" role="button" data-slide="prev">
								<span class="glyphicon glyphicon-chevron-left photoGalleryPrevButton" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="right carousel-control bgImageNone bgImgUnset" href="#carousel-example-generic" role="button" data-slide="next">
								<span class="glyphicon glyphicon-chevron-right photoGalleryNextButton" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
						<div class="caption">
							<p class="title10 marginB0"><a class="colorBlack hoverBlue" href="{!! $article->url !!}">{!! $article->fullheadline !!}</a></p>
						</div>
					</div>
				</div>
				@endif


				<div class="col-sm-5 col-md-5">
					<div class="row">
						<div class="col-sm-6 col-md-6 paddingLR10">
							<div class="borderRadius5">
								<div class="row">
									@for($i=1; $i<=2; $i++)
									@if(!empty($photoGalleries[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($photoGalleries[$i], 0); @endphp
									<div class="col-sm-12 col-md-12">
										<div class="desktopSectionLead marginB15 borderC2B1">
											<div class="thumbnail bgUnset">
												<div class="positionRelative">
													<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
													<span class="fa fa-image ppIconMedium"></span>
													<div class="caption">
														<p class="title11 marginB0 marginT0">{!! $article->fullheadline !!}</p>
													</div>
												</div>
												<a href="{!! $article->url !!}" class="linkOverlay"></a>
											</div>
										</div>
									</div>
									@endif
									@endfor
								</div>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 paddingLR10">
							<div class=" borderRadius5">
								<div class="row">
									@for($i=3; $i<=4; $i++)
									@if(!empty($photoGalleries[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($photoGalleries[$i], 0); @endphp
									<div class="col-sm-12 col-md-12">
										<div class="desktopSectionLead marginB15 borderC2B1">
											<div class="thumbnail bgUnset">
												<div class="positionRelative">
													<img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
													<span class="fa fa-image ppIconMedium"></span>
													<div class="caption">
														<p class="title11 marginB0 marginT0">{!! $article->fullheadline !!}</p>
													</div>
												</div>
												<a href="{!! $article->url !!}" class="linkOverlay"></a>
											</div>
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
		</div>
	</div>
	@endif
	<!-- category photos end -->