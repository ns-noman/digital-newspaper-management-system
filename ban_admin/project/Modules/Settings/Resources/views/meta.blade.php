@extends('layouts.app')
@section('title', 'Meta Tag Settings')

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
			<header class="panel-heading font-bold">Settings |  Meta Tag Settings</header>
			<div class="panel-body">
				<form role="form" class="form-horizontal" method="post" action="{{url('/settings/meta/update')}}" >
					{{csrf_field()}}

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Meta Title</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="title" value="{{$metaInfo->title}}"  />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Domain</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="domain" value="{{$metaInfo->domain}}"  />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Keywords</b></label>
						</div>
						<div class="col-sm-9">
							<textarea class="form-control" name="keywords" rows="4">{{$metaInfo->keywords}}</textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Description</b></label>
						</div>
						<div class="col-sm-9">
							<textarea class="form-control" name="description" rows="4">{{$metaInfo->description}}</textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Facebook Page Id</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="fb_pages" value="{{$metaInfo->fb_pages}}"  />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Facebook App Id</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="fb_app_id" value="{{$metaInfo->fb_app_id}}"  />
						</div>
					</div>
					<!-- <div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Site Name (Short)</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="site_name" value="{{$metaInfo->site_name}}"  />
						</div>
					</div> -->
					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Twitter Username</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="twitter_username" value="{{$metaInfo->twitter_username}}"  />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Auto Refresh</b></label>
						</div>
						<div class="col-sm-9">
							<input type="number" class="form-control" name="refresh" value="{{$metaInfo->refresh}}"  />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Header Code</b></label>
						</div>
						<div class="col-sm-9">
							<textarea class="form-control" name="header_code" rows="4">{{$metaInfo->header_code}}</textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Body Code</b></label>
						</div>
						<div class="col-sm-9">
							<textarea class="form-control" name="body_code" rows="4">{{$metaInfo->body_code}}</textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Search Plugin</b></label>
						</div>
						<div class="col-sm-9">
							<textarea class="form-control" name="search_plugin" rows="4">{{$metaInfo->search_plugin}}</textarea>
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
