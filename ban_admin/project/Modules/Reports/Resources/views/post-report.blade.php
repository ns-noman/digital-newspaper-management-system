@extends('layouts.app')
@section('title', 'Post Report')

@push('top-scripts')
<link href="{{asset('assets/css/bootstrap-fileupload.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/jasny-bootstrap.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" /> 
<link href="{{asset('assets/css/chosen.css')}}" rel="stylesheet">
<style type="text/css">
	.chosen-container .chosen-single{
		height: 34px !important;
		padding-top: 5px !important;
	}
</style>
@endpush

@section('content')
<section class="vbox">
	<section class="scrollable padder">
		<div class="m-b-md"></div>

		@if(session('success_message'))
		<div class="alert alert-success text-center alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>{{session('success_message')}} </strong>
		</div>
		@endif

		@if(session('error_message'))
		<div class="alert alert-danger text-center alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>{{session('error_message')}} </strong>
		</div>
		@endif

		<div class="row">
			<div class="col-md-12">
				<section class="panel panel-default">
					<header class="panel-heading font-bold">Report: Post Report</header>

					<div class="row wrapper hidden-print" style="padding-bottom: 0px">
						<form method="get">
							<input type="hidden" name="search" value="yes">
							<div class="col-sm-2 m-b-xs">                               
								<div class="input-group date datePicker" data-date-format="yyyy-mm-dd"> 
									<input type="text" name="dateFrom" value="{!! isset($_GET['dateFrom']) && !empty($_GET['dateFrom']) ? date('Y-m-d H:i:s', strtotime($_GET['dateFrom'])) : '' !!}" class="form-control" placeholder="Date From" autocomplete="off" required=""> 
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
								</div> 
							</div>

							<div class="col-sm-2 m-b-xs paddingL0">                               
								<div class="input-group date datePicker" data-date-format="yyyy-mm-dd"> 
									<input type="text" name="dateTo" value="{!! isset($_GET['dateTo']) && !empty($_GET['dateTo']) ? date('Y-m-d H:i:s', strtotime($_GET['dateTo'])) : '' !!}" class="form-control" placeholder="Date To" autocomplete="off" required=""> 
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
								</div> 
							</div>

							<div class="col-sm-2 m-b-xs paddingL0">
								<select class="form-control chosen-select" name="subeditor">
									<option value="">--All Sub Editor--</option>
									@if(!empty($subEditors) && (count($subEditors)>0))
									@foreach($subEditors as $subEditor)
									<option {!! isset($_GET['subeditor']) && $_GET['subeditor'] == $subEditor->id ? 'selected' : '' !!} value="{!! $subEditor->id !!}">{!! $subEditor->name !!}</option>
									@endforeach
									@endif
								</select>
							</div>

							<div class="col-sm-2 m-b-xs paddingL0">
								<select class="form-control chosen-select" name="reportType">
									<option {!! isset($_GET['reportType']) && $_GET['reportType'] == 'summary' ? 'selected' : '' !!} value="summary">Summary</option>
									<option {!! isset($_GET['reportType']) && $_GET['reportType'] == 'detail' ? 'selected' : '' !!} value="detail">Detail</option>
								</select>
							</div>
							<div class="col-sm-1 m-b-xs paddingL0">
								<button class="btn btn-md btn-default btn-block">Search</button>
							</div>
							@if(!empty($postReports) || !empty($usersReport))
							<div class="col-sm-1 m-b-xs paddingL0">
								<button type="button" class="btn btn-md btn-success btn-block" onclick="window.print()">Print</button>
							</div>
							@endif
						</form>
					</div>

					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped marginB0">
								<thead>
									<tr>
										<th colspan="4">Duration: {!! isset($_GET['dateFrom']) ? date('d M Y h:i A', strtotime($_GET['dateFrom'])) : '' !!} - {!! isset($_GET['dateTo']) ? date('d M Y h:i A', strtotime($_GET['dateTo'])) : '' !!} | SubEditor: {!! isset($_GET['subeditor']) && !empty($_GET['subeditor']) ? $subEditorInfo->name : 'ALL' !!} | News Type: {!! isset($_GET['newsType']) && !empty($_GET['newsType']) ? ucfirst($_GET['newsType']).' News' : 'ALL' !!} | Report Type: {!! isset($_GET['reportType']) && !empty($_GET['reportType']) ? ucfirst($_GET['reportType']) : 'ALL' !!}</th>
									</tr>

									<!-- detail report -->
									@if(!empty($postReports))
									<tr>
										<th>SL</th>
										<th>Headline</th>
										<th class="text-center">Hit</th>
										<th>Publish</th>
										<th>SubEditor</th>
									</tr>
									@endif
									<!-- detail report -->

									<!-- user report -->
									@if(!empty($usersReport))
									<tr>
										<th>SL</th>
										<th colspan="2">Name</th>
										<th>Total News</th>
										<th>Total Hit</th>
									</tr>
									@endif
									<!-- user report -->

								</thead>
								<tbody>

									<!-- detail report -->
									@if(!empty($postReports) && (count($postReports)>0))
									@php $totalHit = 0; @endphp
									@foreach($postReports as $key => $postReport)
									@php $hit = App\Http\Controllers\CommonController::articleHit($postReport->created_at, $postReport->id, 0); @endphp
									@php $totalHit = $totalHit+$hit; @endphp
									<tr>
										<td>{!! $key+1 !!}</td>
										<td>
											<a href="{!! !empty($postReport->category_id) && !empty($postReport->parentCategory) ?  env('WEBSITE').$postReport->parentCategory->title.'/'.$postReport->id : '#' !!}" style="color: {!! !empty($postReport->headline_color) ? $postReport->headline_color : '#177bbb' !!}" target="_blank">
												@if(!empty($postReport->shoulder))<span class="shoulder" style="">{{$postReport->shoulder}}</span> <i class="fa fa-circle shoulderIcon"></i> @endif<span>{{$postReport->headline}}</span> @if(!empty($postReport->hanger))<i class="fa fa-circle hangerIcon"></i> <span class="hanger">{{$postReport->hanger}}</span> @endif
											</a>
										</td>
										<td class="text-center">{!! $hit !!}</td>
										<td>{!! date('d M Y h:i A', strtotime($postReport->created_at)) !!}</td>
										<td>{!! $postReport->createdBy->name !!}</td>
									</tr>
									@endforeach
									<tr>
										<th colspan="2" class="text-right">Total Hit</th>
										<th class="text-center">{!! $totalHit !!}</th>
									</tr>
									@endif
									<!-- detail report -->


									<!-- user report -->
									@if(!empty($usersReport) && (count($usersReport)>0))
									@php $totalHit = 0; $totalNews = 0; @endphp
									@foreach($usersReport as $key => $userReport)
									@php $hitInfo = App\Http\Controllers\CommonController::userHit($userReport->id, isset($_GET['dateFrom']) && !empty($_GET['dateFrom']) ? date('Y-m-d H:i:s', strtotime($_GET['dateFrom'])) : date('Y-m-d H:i:s'), isset($_GET['dateTo']) && !empty($_GET['dateTo']) ? date('Y-m-d H:i:s', strtotime($_GET['dateTo'])) : date('Y-m-d H:i:s')); @endphp

									@php $hit = !empty($hitInfo['totalHit']) ? $hitInfo['totalHit'] : 0; $totalHit = $totalHit+$hit; @endphp
									@php $news = !empty($hitInfo['totalNews']) ? $hitInfo['totalNews'] : 0; $totalNews = $totalNews+$news; @endphp
									<tr>
										<td>{!! $key+1 !!}</td>
										<td colspan="2">{!! $userReport->name !!}</td>
										<td>{!! !empty($hitInfo['totalNews']) ? $hitInfo['totalNews'] : 0 !!}</td>
										<td>{!! !empty($hitInfo['totalHit']) ? $hitInfo['totalHit'] : 0 !!}</td>
									</tr>
									@endforeach
									<tr>
										<th colspan="3" class="text-right">Total</th>
										<th>{!! $totalNews !!}</th>
										<th>{!! $totalHit !!}</th>
									</tr>
									@endif
									<!-- user report -->


								</tbody>
							</table>
						</div>
					</div>
				</section>
			</div>
		</div>

	</section>
</section>
@endsection


@push('bottom-scripts')
<script src="{{asset('assets/js/plugins/bootstrap-fileupload.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-datetimepicker.min.js')}}" ></script>
<script src="{{asset('assets/js/plugins/chosen.jquery.min.js')}}"></script>
<script type="text/javascript">
	$('.datePicker').datetimepicker({
		autoclose: 1,
		format: 'yyyy-mm-dd hh:ii:ss',
	});
</script>
@endpush

