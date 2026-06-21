@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : 'শিরোনাম - '.$settingsInfo->title !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'শিরোনাম - '.$settingsInfo->title !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'শিরোনাম - '.$settingsInfo->title !!}" />
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
<div class="bgWHite">
	<div class="container ">
		<div class="row">

			<!-- header -->
			<div class="col-sm-12 col-md-12 marginB20 xs-marginT30">
				<div class="borderC1B1">
					<h1 class="desktopCategoryTitle"><a href="{!! Request::url() !!}"><strong><span class="leftSpan"></span> শিরোনাম- {!! \App\Models\Helper::GetBangla(isset($_GET['date'])&& !empty($_GET['date']) ? date('d M Y', strtotime($_GET['date'])) : date('d M Y')) !!}</strong></a></h1>
				</div>
			</div>

			<div class="col-sm-9 col-md-9">
				<div class="row">
					<div class="col-sm-12 col-md-12 marginB20 hidden-print">
						<form method="get">
							<input type="hidden" name="search" value="yes">
							<div class="panel panel-default borderRadius5 borderAsh1 marginB0">
								<div class="panel-body bgAsh">
									<div class="row">
										<div class="col-md-3 paddingR0 xs-paddingL15 xs-paddingR15 xs-marginT10">
											<div class="input-group date" id="datePicker">
												<input name="date" value="{{isset($_GET['date'])&& !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d')}}" placeholder="তারিখ" class="form-control borderRadius5 h50" type="text" autocomplete="off">
												<span class="input-group-addon borderRadius5 h50"><i class="fa fa-calendar"></i></span>
											</div>
										</div>
										<div class="col-md-2 col-xs-6 xs-marginT10 paddingR0">
											<button type="submit" class="btn btn-block borderRadius5 width100P bgRed title1_8 colorWhite h50 padding3"><i class="fa fa-search title1_3"></i> </button>
										</div>
										<div class="col-md-2 col-xs-6 xs-marginT10">
											<button type="button" onclick="window.print()" title="Print Headlines" class="btn btn-success btn-block borderRadius5 width100P title1_8 colorWhite h50 padding3"><i class="fa fa-print title1_3"></i></button>
										</div>
									</div>
								</div>
							</div>
						</form>
						<!-- <p class="desktopDivider marginB10"></p> -->
					</div>

					@if(!empty($headlines) && (count($headlines)>0))
					<div class="col-sm-12 col-md-12 marginT0">
						<div class="">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="title11">#</th>
										<th class="title11">শিরোনাম</th>
										<th class="title11 hidden-xs">তারিখ</th>
									</tr>
								</thead>
								<tbody>
									@foreach($headlines as $key => $headline)
									@php $article = \App\Models\Helper::processArticleShortly($headline, 0); @endphp
									<tr>
										<td class="title11">{!! \App\Models\Helper::GetBangla($key+1) !!}</td>
										<td class="title11"><a href="{!! $article->url !!}" class="textDecorationNone" target="_blank">{!! $article->fullheadline !!}</a></td>
										<td class="title11 hidden-xs">{!! $article->publishTime !!}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					@else
					<div class="col-sm-12 col-md-12">
						<div class="text-center">কিছু পাওয়া যায়নি</div>
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

@endsection

@push('js')

@endpush