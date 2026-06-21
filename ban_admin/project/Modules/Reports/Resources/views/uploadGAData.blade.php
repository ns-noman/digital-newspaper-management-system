@extends('layouts.app')
@section('title', 'Upload GA Data')

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
			<div class="col-md-8 hidden-print">
				<section class="panel panel-default">
					<header class="panel-heading font-bold">Upload GA Data</header>
					<div class="panel-body">
						<form method="post" action="{{route('Upload GAData Store')}}" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="table-responsive">
								<table class="table table-bordered table-striped marginB0">
									<tbody>
										<tr>
											<th width="80">Month</th>
											<td>
												<select class="form-control chosen-select" name="report_date" required="">
													<option value="">--Select Date--</option>
													@if(!empty($reportDates))
													@foreach($reportDates as $reportDate)
													<option value="{!! $reportDate['year_month'] !!}">{!! $reportDate['year_month_title'] !!}</option>
													@endforeach
													@endif
												</select>
											</td>
										</tr>
										<tr>
											<th>GA File</th>
											<td>
												<input type="file" name="ga_file" class="form-control" required="">
											</td>
										</tr>
										<tr>
											<th>Action</th>
											<td>
												<button type="submit" class="btn btn-success btn-md btn-block">Process Data</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</form>
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

