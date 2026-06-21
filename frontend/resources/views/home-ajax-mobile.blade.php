<!-- category 9 -->
@if(!empty($category_9) && (count($category_9)>0))
<div class="row marginT40">
	<div class="col-sm-12 col-md-12 paddingLR0">
		<div class="sectionTitleDiv2">
			<p class="sectionTitle"><a aria-label="{!! $category_9[0]->display_name !!}" href="{!! url($category_9[0]->title) !!}">{!! $category_9[0]->display_name !!}</a></p>
		</div>
	</div>

	@if(!empty($category_9[0]))
	@php $article = \App\Models\Helper::processArticleShortly($category_9[0], 0); @endphp
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
			@if(!empty($category_9[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($category_9[$i], 0); @endphp
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
	<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_9[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
<!-- category 9 end -->



<!-- category 11 -->
@if(!empty($category_11) && (count($category_11)>0))
<div class="row marginT40">
	<div class="col-sm-12 col-md-12 paddingLR0">
		<div class="sectionTitleDiv2">
			<p class="sectionTitle"><a aria-label="{!! $category_11[0]->display_name !!}" href="{!! url($category_11[0]->title) !!}">{!! $category_11[0]->display_name !!}</a></p>
		</div>
	</div>

	@if(!empty($category_11[0]))
	@php $article = \App\Models\Helper::processArticleShortly($category_11[0], 0); @endphp
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
			@if(!empty($category_11[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($category_11[$i], 0); @endphp
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
	<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_11[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
<!-- category 11 end -->


<!-- category 17 -->
@if(!empty($category_17) && (count($category_17)>0))
<div class="row marginT40">
	<div class="col-sm-12 col-md-12 paddingLR0">
		<div class="sectionTitleDiv2">
			<p class="sectionTitle"><a aria-label="{!! $category_17[0]->display_name !!}" href="{!! url($category_17[0]->title) !!}">{!! $category_17[0]->display_name !!}</a></p>
		</div>
	</div>

	@if(!empty($category_17[0]))
	@php $article = \App\Models\Helper::processArticleShortly($category_17[0], 0); @endphp
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
			@if(!empty($category_17[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($category_17[$i], 0); @endphp
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
	<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_17[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
<!-- category 17 end -->


<!-- category 18 -->
@if(!empty($category_18) && (count($category_18)>0))
<div class="row marginT40">
	<div class="col-sm-12 col-md-12 paddingLR0">
		<div class="sectionTitleDiv2">
			<p class="sectionTitle"><a aria-label="{!! $category_18[0]->display_name !!}" href="{!! url($category_18[0]->title) !!}">{!! $category_18[0]->display_name !!}</a></p>
		</div>
	</div>

	@if(!empty($category_18[0]))
	@php $article = \App\Models\Helper::processArticleShortly($category_18[0], 0); @endphp
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
			@if(!empty($category_18[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($category_18[$i], 0); @endphp
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
	<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_18[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
<!-- category 18 end -->



<!-- category 12 -->
@if(!empty($category_12) && (count($category_12)>0))
<div class="row marginT40">
	<div class="col-sm-12 col-md-12 paddingLR0">
		<div class="sectionTitleDiv2">
			<p class="sectionTitle"><a aria-label="{!! $category_12[0]->display_name !!}" href="{!! url($category_12[0]->title) !!}">{!! $category_12[0]->display_name !!}</a></p>
		</div>
	</div>

	@if(!empty($category_12[0]))
	@php $article = \App\Models\Helper::processArticleShortly($category_12[0], 0); @endphp
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
			@if(!empty($category_12[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($category_12[$i], 0); @endphp
			<div class="media positionRelative">
				<div class="media-body">
					<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
				</div>
				<a href="{!! $article->url !!}" class="linkOverlay"></a>
			</div>
			@endif
			@endfor
		</div>
	</div>
	<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_12[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
<!-- category 12 end -->



<!-- category 13 -->
@if(!empty($category_13) && (count($category_13)>0))
<div class="row marginT40">
	<div class="col-sm-12 col-md-12 paddingLR0">
		<div class="sectionTitleDiv2">
			<p class="sectionTitle"><a aria-label="{!! $category_13[0]->display_name !!}" href="{!! url($category_13[0]->title) !!}">{!! $category_13[0]->display_name !!}</a></p>
		</div>
	</div>

	@if(!empty($category_13[0]))
	@php $article = \App\Models\Helper::processArticleShortly($category_13[0], 0); @endphp
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
			@if(!empty($category_13[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($category_13[$i], 0); @endphp
			<div class="media positionRelative">
				<div class="media-body">
					<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
				</div>
				<a href="{!! $article->url !!}" class="linkOverlay"></a>
			</div>
			@endif
			@endfor
		</div>
	</div>
	<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_13[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
<!-- category 14 -->
@if(!empty($category_14) && (count($category_14)>0))
<div class="row marginT40">
	<div class="col-sm-12 col-md-12 paddingLR0">
		<div class="sectionTitleDiv2">
			<p class="sectionTitle"><a aria-label="{!! $category_14[0]->display_name !!}" href="{!! url($category_14[0]->title) !!}">{!! $category_14[0]->display_name !!}</a></p>
		</div>
	</div>

	@if(!empty($category_14[0]))
	@php $article = \App\Models\Helper::processArticleShortly($category_14[0], 0); @endphp
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
			@if(!empty($category_14[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($category_14[$i], 0); @endphp
			<div class="media positionRelative">
				<div class="media-body">
					<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
				</div>
				<a href="{!! $article->url !!}" class="linkOverlay"></a>
			</div>
			@endif
			@endfor
		</div>
	</div>
	<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_14[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
<!-- category 14 end -->


<!-- category 15 -->
@if(!empty($category_15) && (count($category_15)>0))
<div class="row marginT40">
	<div class="col-sm-12 col-md-12 paddingLR0">
		<div class="sectionTitleDiv2">
			<p class="sectionTitle"><a aria-label="{!! $category_15[0]->display_name !!}" href="{!! url($category_15[0]->title) !!}">{!! $category_15[0]->display_name !!}</a></p>
		</div>
	</div>

	@if(!empty($category_15[0]))
	@php $article = \App\Models\Helper::processArticleShortly($category_15[0], 0); @endphp
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
			@if(!empty($category_15[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($category_15[$i], 0); @endphp
			<div class="media positionRelative">
				<div class="media-body">
					<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
				</div>
				<a href="{!! $article->url !!}" class="linkOverlay"></a>
			</div>
			@endif
			@endfor
		</div>
	</div>
	<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_15[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
<!-- category 15 end -->


<!-- category 19 -->
@if(!empty($category_19) && (count($category_19)>0))
<div class="row marginT40">
	<div class="col-sm-12 col-md-12 paddingLR0">
		<div class="sectionTitleDiv2">
			<p class="sectionTitle"><a aria-label="{!! $category_19[0]->display_name !!}" href="{!! url($category_19[0]->title) !!}">{!! $category_19[0]->display_name !!}</a></p>
		</div>
	</div>

	@if(!empty($category_19[0]))
	@php $article = \App\Models\Helper::processArticleShortly($category_19[0], 0); @endphp
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
			@if(!empty($category_19[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($category_19[$i], 0); @endphp
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
	<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_19[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
<!-- category 19 end -->


<!-- category 20 -->
@if(!empty($category_20) && (count($category_20)>0))
<div class="row marginT40">
	<div class="col-sm-12 col-md-12 paddingLR0">
		<div class="sectionTitleDiv2">
			<p class="sectionTitle"><a aria-label="{!! $category_20[0]->display_name !!}" href="{!! url($category_20[0]->title) !!}">{!! $category_20[0]->display_name !!}</a></p>
		</div>
	</div>

	@if(!empty($category_20[0]))
	@php $article = \App\Models\Helper::processArticleShortly($category_20[0], 0); @endphp
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
			@if(!empty($category_20[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($category_20[$i], 0); @endphp
			<div class="media positionRelative">
				<div class="media-body">
					<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
				</div>
				<a href="{!! $article->url !!}" class="linkOverlay"></a>
			</div>
			@endif
			@endfor
		</div>
	</div>
	<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_20[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
<!-- category 20 end -->



<!-- category 21 -->
@if(!empty($category_21) && (count($category_21)>0))
<div class="row marginT40">
	<div class="col-sm-12 col-md-12 paddingLR0">
		<div class="sectionTitleDiv2">
			<p class="sectionTitle"><a aria-label="{!! $category_21[0]->display_name !!}" href="{!! url($category_21[0]->title) !!}">{!! $category_21[0]->display_name !!}</a></p>
		</div>
	</div>

	@if(!empty($category_21[0]))
	@php $article = \App\Models\Helper::processArticleShortly($category_21[0], 0); @endphp
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
			@if(!empty($category_21[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($category_21[$i], 0); @endphp
			<div class="media positionRelative">
				<div class="media-body">
					<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
				</div>
				<a href="{!! $article->url !!}" class="linkOverlay"></a>
			</div>
			@endif
			@endfor
		</div>
	</div>
	<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_21[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
<!-- category 21 -->



<!-- category 22 -->
@if(!empty($category_22) && (count($category_22)>0))
<div class="row marginT40">
	<div class="col-sm-12 col-md-12 paddingLR0">
		<div class="sectionTitleDiv2">
			<p class="sectionTitle"><a aria-label="{!! $category_22[0]->display_name !!}" href="{!! url($category_22[0]->title) !!}">{!! $category_22[0]->display_name !!}</a></p>
		</div>
	</div>

	@if(!empty($category_22[0]))
	@php $article = \App\Models\Helper::processArticleShortly($category_22[0], 0); @endphp
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
			@if(!empty($category_22[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($category_22[$i], 0); @endphp
			<div class="media positionRelative">
				<div class="media-body">
					<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
				</div>
				<a href="{!! $article->url !!}" class="linkOverlay"></a>
			</div>
			@endif
			@endfor
		</div>
	</div>
	<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_22[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
<!-- category 22 end -->


<!-- category 23 -->
@if(!empty($category_23) && (count($category_23)>0))
<div class="row marginT40">
	<div class="col-sm-12 col-md-12 paddingLR0">
		<div class="sectionTitleDiv2">
			<p class="sectionTitle"><a aria-label="{!! $category_23[0]->display_name !!}" href="{!! url($category_23[0]->title) !!}">{!! $category_23[0]->display_name !!}</a></p>
		</div>
	</div>

	@if(!empty($category_23[0]))
	@php $article = \App\Models\Helper::processArticleShortly($category_23[0], 0); @endphp
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
			@if(!empty($category_23[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($category_23[$i], 0); @endphp
			<div class="media positionRelative">
				<div class="media-body">
					<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
				</div>
				<a href="{!! $article->url !!}" class="linkOverlay"></a>
			</div>
			@endif
			@endfor
		</div>
	</div>
	<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_23[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
<!-- category 23 end -->


<!-- category 16 -->
@if(!empty($category_16) && (count($category_16)>0))
<div class="row marginT40">
	<div class="col-sm-12 col-md-12 paddingLR0">
		<div class="sectionTitleDiv2">
			<p class="sectionTitle"><a aria-label="{!! $category_16[0]->display_name !!}" href="{!! url($category_16[0]->title) !!}">{!! $category_16[0]->display_name !!}</a></p>
		</div>
	</div>

	@if(!empty($category_16[0]))
	@php $article = \App\Models\Helper::processArticleShortly($category_16[0], 0); @endphp
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
			@if(!empty($category_16[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($category_16[$i], 0); @endphp
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
	<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_16[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
<!-- category 16 end -->


<!-- category 24 -->
@if(!empty($category_24) && (count($category_24)>0))
<div class="row marginT40">
	<div class="col-sm-12 col-md-12 paddingLR0">
		<div class="sectionTitleDiv2">
			<p class="sectionTitle"><a aria-label="{!! $category_24[0]->display_name !!}" href="{!! url($category_24[0]->title) !!}">{!! $category_24[0]->display_name !!}</a></p>
		</div>
	</div>

	@if(!empty($category_24[0]))
	@php $article = \App\Models\Helper::processArticleShortly($category_24[0], 0); @endphp
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
			@if(!empty($category_24[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($category_24[$i], 0); @endphp
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
	<div class="col-sm-12 col-md-12 paddingLR20 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($category_24[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
<!-- category 24 end -->

<!-- category photos -->
@if(!empty($photoGalleries) && (count($photoGalleries)>0))
<div class="bg2 row marginT50 paddingT20">
	<div class="col-sm-12 col-md-12 paddingLR10">
		<p class="sectionTitle marginB15"><a aria-label="{!! $photoGalleries[0]->display_name !!}" href="{!! url($photoGalleries[0]->title) !!}">@if(!empty($photoGalleries[0]->icon))<img src="{!! asset('uploads/categories/'.$photoGalleries[0]->icon) !!}" alt="{!! $category_2[0]->title !!} icon" class="categoryIcon">@endif <strong>{!! $photoGalleries[0]->display_name !!}</strong></a> <a href="{!! url($photoGalleries[0]->title) !!}" class="float-right"><i class="fa fa-angle-double-right title1_4"></i></a> <span class="bottomMarked"></span></p>
	</div>


	@if(!empty($photoGalleries[0]))
	@php $article = \App\Models\Helper::processArticleShortly($photoGalleries[0], 0); @endphp
	<div class="col-sm-12 col-md-12 sectionLead padding0 margin0">
		<div class="thumbnail bg2">
			<div id="carousel-example-generic" class="carousel slide customCarousel borderRadius0" data-ride="carousel" style="overflow: hidden;">
				<div class="customProgressBar"><div class="bar borderRadius0"><div class="in borderRadius0"></div></div></div>
				<div class="carousel-inner positionRelative">

					@foreach($photoGalleries[0]->articlePhotos as $key => $articlePhoto)
					<div class="item {!! $key==0 ? 'active' : '' !!}">
						<a href="{!! $article->url !!}">
							<img class="img-responsive" src="{!! asset('uploads/news_photos/'.date('Y/m/d/', strtotime($article->created_at))).$articlePhoto->image !!}" alt="{!! $article->headline !!}" title="{!! $article->headline !!}">
							<span class="carousel-counter">{{App\Http\Controllers\CommonController::GetBangla($key+1)}} / {{App\Http\Controllers\CommonController::GetBangla(count($photoGalleries[0]->articlePhotos))}}</span>

							@if(!empty($articlePhoto->image_caption))
							<div class="carousel-caption carousel-caption-custom">
								<p class="marginB0 text-left colorWhite marginT0 title1_8">{!! $articlePhoto->image_caption !!}</p>
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
		</div>
	</div>
	@endif
	<div class="col-sm-12 col-md-12 paddingLR0 marginB15"><div class="borderC1T1"></div></div>

	<div class="col-sm-12 col-md-12 paddingLR26">
		<div class="row desktopFlexRow">
			@for($i=1; $i<=4; $i++)
			@if(!empty($photoGalleries[$i]))
			@php $article = \App\Models\Helper::processArticleShortly($photoGalleries[$i], 0); @endphp
			<div class="col-sm-6 col-md-6 col-xs-6 paddingLR7 sectionListThumbnail">
				<div class="thumbnail bg2">
					<div class="positionRelative">
						<img src="{!! $article->thumbMedium !!}" class="img-responsive" alt="{!! $article->headline !!}">
						<span class="fa fa-image ppIconSmall"></span>
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
	<div class="col-sm-12 col-md-12 paddingLR20 marginB15 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore bg2"><a href="{!! url($photoGalleries[0]->title) !!}">আরও</a></span></div></div>
</div>
@endif
		<!-- category photos end -->