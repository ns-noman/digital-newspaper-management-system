@extends('layouts.app')
@section('title', 'User Profile')

@push('top-scripts')
<link href="{{asset('assets/css/jasny-bootstrap.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/css/bootstrap-fileupload.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" /> 
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

		<section class="panel panel-default">
			<header class="panel-heading font-bold">Profile: {!! $profileInfo->name !!}</header>

			<div class="row wrapper">
				<form role="form" class="form-horizontal" method="post" action="{{url('users/profile/update')}}" enctype="multipart/form-data">
					{{csrf_field()}}

					<div class="col-sm-4">
						<div>
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th colspan="2" class="text-center">
											@if(!empty($profileInfo->image))
											<img src="{!! env('UploadsLink').'uploads/users/'.$profileInfo->image !!}" class="img-circle" width="150px" height="150px">
											@else
											<img src="{!! env('UploadsLink').'uploads/users/default.png' !!}" class="img-circle" width="150px" height="150px">
											@endif
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Name</td>
										<td>{!! $profileInfo->name !!}</td>
									</tr>
									<tr>
										<td>Email</td>
										<td>{!! $profileInfo->email !!}</td>
									</tr>
									<tr>
										<td>Mobile</td>
										<td>{!! $profileInfo->mobile !!}</td>
									</tr>
									<tr>
										<td>Designation</td>
										<td>{!! $profileInfo->designation !!}</td>
									</tr>
									<tr>
										<td>Department</td>
										<td>{!! $profileInfo->department !!}</td>
									</tr>
									<tr>
										<td>Joining Date</td>
										<td>{!! !empty($profileInfo->joining_date) ? date('d M, Y', strtotime($profileInfo->joining_date)) : Null !!}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col-sm-8">
						<div class="form-group">
							<div class="col-sm-12">
								<label class="control-label" style="padding-top: 0px"><b>Name *</b></label>
							</div>
							<div class="col-sm-12">
								<input type="text" class="form-control" name="name" value="{!! $profileInfo->name !!}" required />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								<label class="control-label"><b>Email *</b></label>
							</div>
							<div class="col-sm-12">
								<input type="email" class="form-control" name="email" value="{!! $profileInfo->email !!}" required />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								<label class="control-label"><b>Mobile</b></label>
							</div>
							<div class="col-sm-12">
								<input type="text" class="form-control" name="mobile" value="{!! $profileInfo->mobile !!}" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								<label class="control-label"><b>Designation</b></label>
							</div>
							<div class="col-sm-12">
								<input type="text" class="form-control" name="designation" value="{!! $profileInfo->designation !!}" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								<label class="control-label"><b>Department</b></label>
							</div>
							<div class="col-sm-12">
								<input type="text" class="form-control" name="department" value="{!! $profileInfo->department !!}" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								<label class="control-label"><b>Password</b></label>
							</div>
							<div class="col-sm-12">
								<input type="text" class="form-control" name="password" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								<label class="control-label"><b>Photo (150x150)</b></label>
							</div>
							<div class="col-sm-12">
								<input type="file" class="form-control" name="image" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-primary btn-block">Save</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</section>
	</section>
</section>
@endsection


@push('bottom-scripts')
<script src="{{asset('assets/js/plugins/bootstrap-fileupload.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-datetimepicker.min.js')}}" ></script>
@endpush

