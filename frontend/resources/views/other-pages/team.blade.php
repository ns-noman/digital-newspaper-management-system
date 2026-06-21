@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : 'Team - '.$settingsInfo->title !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'Team - '.$settingsInfo->title !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'Team - '.$settingsInfo->title !!}" />
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
<!-- desktop version and mobile start -->
<div class="bgWHite">
	<div class="container">
		<div class="row">

			<div class="col-sm-12 col-md-12">
				<div class="marginB20">

					@if(!empty($departments) && (count($departments)>0))
					@foreach($departments as $key => $department)
					@if(!empty($department->teams) && (count($department->teams)>0))
					<div class="row marginB30 text-center marginT10">
						<p class="title10 marginB15"><span class="teamDepartmentDiv colorBlack"><strong>{!! $department->title !!}</strong></span></p>
						@foreach($department->teams as $key => $authorInfo)
						<div class="xs-marginT0 marginB20 hoverBlue teamProfileDiv">
							<div class="card bg2 hovercard marginT0 paddingT20 paddingB0 text-center borderRadius5 borderD2C1 positionRelative">
								<div class="avatar">
									@if(!empty($authorInfo->author_photo))
									<img width="150" src="{{asset('uploads/authors/'.$authorInfo->author_photo)}}" alt="{{$authorInfo->author_name}}" title="{{$authorInfo->author_name}}" class="borderRadius50P" style="border: 5px solid white">
									@else
									<img width="150" src="{{asset('uploads/authors/default-avatar.png')}}" alt="{{$authorInfo->author_name}}" title="{{$authorInfo->author_name}}" class="borderRadius50P" style="border: 5px solid white">
									@endif
								</div>
								<div class="info marginT15 padding10 bgWHite borderBRadius5">
									<div class="title">
										<p class="title11 textDecorationNone marginT5 marginB0 colorBlack hoverBlue"><strong>{{$authorInfo->author_name}}</strong></p>
									</div>
									@if(!empty($authorInfo->author_about))
									<div class="title12 colorBlack">{{$authorInfo->author_about}}</div>
									@endif
								</div>
								<a href="{{url('author/'.$authorInfo->id.'/'.$authorInfo->author_slug)}}" class="linkOverlay"></a>
							</div>
						</div>
						@endforeach
					</div>
					@endif
					@endforeach
					@endif


				</div>
			</div>
		</div>
	</div>
</div>
<!-- desktop and mobile version end -->
@endsection

@push('js')

@endpush