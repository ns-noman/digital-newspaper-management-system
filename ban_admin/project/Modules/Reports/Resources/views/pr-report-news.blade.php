@extends('layouts.app')
@section('title', 'PR Report News List')

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
					<header class="panel-heading font-bold">Report: PR Report News List</header>

					<div class="row wrapper hidden-print" style="padding-bottom: 0px">
						<form method="get">
							<input type="hidden" name="search" value="yes">
							<div class="col-sm-2 m-b-xs">                               
								<div class="input-group date datePicker" data-date-format="yyyy-mm-dd"> 
									<input type="text" name="dateFrom" value="{!! isset($_GET['dateFrom']) && !empty($_GET['dateFrom']) ? date('Y-m-d', strtotime($_GET['dateFrom'])) : '' !!}" class="form-control" placeholder="Date From" autocomplete="off"> 
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
								</div> 
							</div>

							<div class="col-sm-2 m-b-xs paddingL0">                               
								<div class="input-group date datePicker" data-date-format="yyyy-mm-dd"> 
									<input type="text" name="dateTo" value="{!! isset($_GET['dateTo']) && !empty($_GET['dateTo']) ? date('Y-m-d', strtotime($_GET['dateTo'])) : '' !!}" class="form-control" placeholder="Date To" autocomplete="off"> 
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
								</div> 
							</div>

							<div class="col-sm-2 m-b-xs paddingL0">
								<select class="form-control chosen-select" name="marketing_company_id">
									<option value="">--All Marketing Company--</option>
									@if(!empty($marketingCompanies) && (count($marketingCompanies)>0))
									@foreach($marketingCompanies as $marketingCompany)
									<option {!! isset($_GET['marketing_company_id']) && $_GET['marketing_company_id'] == $marketingCompany->id ? 'selected' : '' !!} value="{!! $marketingCompany->id !!}">{!! $marketingCompany->title !!}</option>
									@endforeach
									@endif
								</select>
							</div>

							<div class="col-sm-2 m-b-xs paddingL0">
								<select class="form-control chosen-select" name="marketing_person_id">
									<option value="">--All Marketing Person--</option>
									@if(!empty($marketingPersons) && (count($marketingPersons)>0))
									@foreach($marketingPersons as $marketingPerson)
									<option {!! isset($_GET['marketing_person_id']) && $_GET['marketing_person_id'] == $marketingPerson->id ? 'selected' : '' !!} value="{!! $marketingPerson->id !!}">{!! $marketingPerson->title !!}</option>
									@endforeach
									@endif
								</select>
							</div>
							
							<div class="col-sm-2 m-b-xs paddingL0">
								<button type="submit" class="btn btn-md btn-default btn-block">Search</button>
							</div>
							@if(!empty($prReports))
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
										<th colspan="3">Duration: {!! isset($_GET['dateFrom']) ? date('d M Y', strtotime($_GET['dateFrom'])) : '' !!} - {!! isset($_GET['dateTo']) ? date('d M Y', strtotime($_GET['dateTo'])) : '' !!}, Marketing Company: {!! isset($_GET['marketing_company_id']) && !empty($_GET['marketing_company_id']) && !empty($marketingCompanyInfo) ? $marketingCompanyInfo->title : 'ALL' !!}, Marketing Person: {!! isset($_GET['marketing_person_id']) && !empty($_GET['marketing_person_id']) && !empty($marketingPersonInfo) ? $marketingPersonInfo->title : 'ALL' !!}</th>
									</tr>
									<tr>
										<th>SL</th>
										<th>Headline</th>
										<th>Marketing Person</th>
										<th>Marketing Company</th>
									</tr>
								</thead>
								<tbody>
									@if(!empty($prReports) && (count($prReports)>0))
									@foreach($prReports as $key => $prReport)
									<tr>
										<td>{!! $key+1 !!}</td>
										<td>
											<a href="{!! !empty($prReport->category_id) && !empty($prReport->parentCategory) ?  env('WEBSITE').$prReport->parentCategory->title.'/'.$prReport->id : '#' !!}" style="color: {!! !empty($prReport->headline_color) ? $prReport->headline_color : '#177bbb' !!}" target="_blank">
												@if(!empty($prReport->shoulder))<span class="shoulder" style="">{{$prReport->shoulder}}</span> <i class="fa fa-circle shoulderIcon"></i> @endif<span>{{$prReport->headline}}</span> @if(!empty($prReport->hanger))<i class="fa fa-circle hangerIcon"></i> <span class="hanger">{{$prReport->hanger}}</span> @endif
											</a>
										</td>
										<td>{!! !empty($prReport->marketing_person_id) && !empty($prReport->marketingPersonInfo) ? $prReport->marketingPersonInfo->title : '-' !!}</td>
										<td>{!! !empty($prReport->marketing_company_id) && !empty($prReport->marketingCompanyInfo) ? $prReport->marketingCompanyInfo->title : '-' !!}</td>
									</tr>
									@endforeach
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
	$('.datePicker').datetimepicker({
		todayBtn:  1,
		autoclose: 1,
		minView: 2
	});
</script>

<script type="text/javascript">
	$('.pickDate').datetimepicker({
		locale: 'ru',
		startDate: new Date()
	});
</script>

@endpush

