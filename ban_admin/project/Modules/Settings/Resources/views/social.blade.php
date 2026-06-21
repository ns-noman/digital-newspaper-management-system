@extends('layouts.app')
@section('title', 'Social Pages Settings')

@push('top-scripts')
@endpush

@section('content')
<section class="vbox">
	<section class="scrollable padder">
		<br>

		@if(session('message'))
		<div class="alert alert-success text-center alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>{{session('message')}} </strong>
		</div>
		@endif

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
			<header class="panel-heading font-bold">Settings |  Social Pages Settings</header>
			<div class="panel-body">
				<form role="form" class="form-horizontal" method="post" action="{{url('/settings/social/update')}}" >
					{{csrf_field()}}

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Facebook Url</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="facebook" value="{{$socialInfo->facebook}}"  />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Twitter Url</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="twitter" value="{{$socialInfo->twitter}}"  />
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Instagram Url</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="instagram" value="{{$socialInfo->instagram}}"  />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Google Url</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="google" value="{{$socialInfo->google}}"  />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>LinkedIn Url</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="linkedin" value="{{$socialInfo->linkedin}}"  />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Youtube Url</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="youtube" value="{{$socialInfo->youtube}}"  />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Android Url</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="android" value="{{$socialInfo->android}}"  />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>IOS Url</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="ios" value="{{$socialInfo->ios}}"  />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Rss Url</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="rss" value="{{$socialInfo->rss}}"  />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Another Site</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="another_site" value="{{$socialInfo->another_site}}"  />
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Another Site 2</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="another_site2" value="{{$socialInfo->another_site2}}"  />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3">
							<button type="submit" class="btn btn-primary btn-block">Update</button>
						</div>
					</div>

				</form>
			</div>
		</section>
	</section>
</section>

@endsection

@push('bottom-scripts')

@endpush
