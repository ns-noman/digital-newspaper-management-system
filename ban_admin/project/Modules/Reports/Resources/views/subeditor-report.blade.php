@extends('layouts.app')
@section('title', 'Sub Editor Report: Google Analytics')

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
					<header class="panel-heading font-bold">Report: Sub Editor From Google Analytics</header>

					<div class="row wrapper hidden-print" style="padding-bottom: 0px">
						<form method="get">
							<input type="hidden" name="search" value="yes">
							<div class="col-sm-2 m-b-xs">
								<select class="form-control chosen-select" name="report_date" required="">
									<option value="">--Select Date--</option>
									@if(!empty($reportDates))
									@foreach($reportDates as $reportDate)
									<option {!! isset($_GET['report_date']) && $_GET['report_date'] == $reportDate['year_month'] ? 'selected' : '' !!} value="{!! $reportDate['year_month'] !!}">{!! $reportDate['year_month_title'] !!}</option>
									@endforeach
									@endif
								</select>
							</div>
							<div class="col-sm-2 m-b-xs paddingL0">
								<select class="form-control chosen-select" name="users">
									<option value="">--All User--</option>
									@if(!empty($users) && (count($users)>0))
									@foreach($users as $user)
									<option {!! isset($_GET['users']) && $_GET['users'] == $user->id ? 'selected' : '' !!} value="{!! $user->id !!}">{!! $user->name !!}</option>
									@endforeach
									@endif
								</select>
							</div>
							<div class="col-sm-2 m-b-xs paddingL0">
								<button class="btn btn-md btn-default btn-block">Search</button>
							</div>
							@if(!empty($usersReport[0]))
							<div class="col-sm-2 m-b-xs paddingL0">
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
										<th colspan="3">Month: {!! isset($_GET['report_date']) ? date('M Y', strtotime($_GET['report_date'].'-01')) : '' !!}, User: {!! isset($_GET['users']) && !empty($_GET['users']) && !empty($userInfo) ? $userInfo->name : 'ALL' !!}</th>
									</tr>
									<tr>
										<th>SL</th>
										<th>User</th>
										<th>Total News</th>
										<th>Total Hit</th>
									</tr>
								</thead>
								<tbody>
									@if(!empty($usersReport) && (count($usersReport)>0))
									@php $totalNews = 0; $totalHit = 0; @endphp
									@foreach($usersReport as $key => $userReport)
									@php $totalNews = $totalNews+$userReport->total_news; $totalHit = $totalHit+$userReport->total_hit; @endphp
									<tr>
										<td>{!! $key+1 !!}</td>
										<td>{!! $userReport->name !!}</td>
										<td>{!! $userReport->total_news !!}</td>
										<td>{!! $userReport->total_hit !!}</td>
									</tr>
									@endforeach
									<tr>
										<th colspan="2" class="text-right">Total</th>
										<th>{!! $totalNews !!}</th>
										<th>{!! $totalHit !!}</th>
									</tr>
									@endif
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
	$('.pickDate').datetimepicker({
		locale: 'ru',
		startDate: new Date()
	});
</script>

@endpush

