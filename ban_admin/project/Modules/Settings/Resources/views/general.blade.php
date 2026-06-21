@extends('layouts.app')
@section('title', 'General Settings')

@push('top-scripts')
<link href="{{asset('assets/css/bootstrap-fileupload.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/text-editor.css')}}" rel="stylesheet">
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
			<header class="panel-heading font-bold">Settings |  General Settings</header>
			<div class="panel-body">
				<form role="form" class="form-horizontal" method="post" action="{{url('/settings/general/update')}}" enctype="multipart/form-data">
					{{csrf_field()}}

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>News Paper Name</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="newspaper_name" value="{{$generalInfo->newspaper_name}}" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>News Paper Name Bangla</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="newspaper_name_bn" value="{{$generalInfo->newspaper_name_bn}}" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Number of Top News</b></label>
						</div>
						<div class="col-sm-9">
							<input type="number" class="form-control" name="show_topnews" min="7" value="{{!empty($generalInfo->show_topnews) ? $generalInfo->show_topnews : 7}}" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Show Selected2</b></label>
						</div>
						<div class="col-sm-9">
							<select class="form-control" name="show_selected2">
								<option value="">Hide</option>
								<option value="1" {!! !empty($generalInfo->show_selected2) && $generalInfo->show_selected2 == 1 ? 'selected' : '' !!}>Show</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Show Live</b></label>
						</div>
						<div class="col-sm-9">
							<select class="form-control" name="show_live">
								<option value="">Hide</option>
								<option value="1" {!! !empty($generalInfo->show_live) && $generalInfo->show_live == 1 ? 'selected' : '' !!}>Show</option>
							</select>
						</div>
					</div>


					<div class="form-group"> 
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Brand Color</b></label> 
						</div>
						<div class="col-sm-9">                      
							<div class="input-group"> 
								<input type="text" class="form-control color-input" name="brand_color" value="{{$generalInfo->brand_color}}">
								<span class="input-group-addon"><input type="color" class="color-picker color"> </span> 
							</div> 
						</div> 
					</div>

					<div class="form-group"> 
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Hover Color</b></label> 
						</div>
						<div class="col-sm-9">                      
							<div class="input-group"> 
								<input type="text" class="form-control color-input" name="hover_color" value="{{$generalInfo->hover_color}}">
								<span class="input-group-addon"><input type="color" class="color-picker color"> </span> 
							</div> 
						</div> 
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Publisher</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="publisher" value="{{$generalInfo->publisher}}" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Editor</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="editor" value="{{$generalInfo->editor}}" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Online Head</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="online_head" value="{{$generalInfo->online_head}}" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Address</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="address" value="{{$generalInfo->address}}" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Mobile</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="mobile" value="{{$generalInfo->mobile}}" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Email</b></label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="email" value="{{$generalInfo->email}}" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>About Us</b></label>
						</div>
						<div class="col-sm-9">
							<textarea class="form-control" id="aboutEditor" name="about">{{$generalInfo->about}}</textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Contact Us</b></label>
						</div>
						<div class="col-sm-9">
							<textarea class="form-control" id="contactEditor" name="contact">{{$generalInfo->contact}}</textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Terms & Condition</b></label>
						</div>
						<div class="col-sm-9">
							<textarea class="form-control" id="termsEditor" name="terms">{{$generalInfo->terms}}</textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Privacy Policy</b></label>
						</div>
						<div class="col-sm-9">
							<textarea class="form-control" id="privacyEditor" name="privacy">{{$generalInfo->privacy}}</textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Advertisement Price</b></label>
						</div>
						<div class="col-sm-9">
							<textarea class="form-control" id="adPriceEditor" name="advertisement">{{$generalInfo->advertisement}}</textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Footer Info</b></label>
						</div>
						<div class="col-sm-9">
							<textarea class="form-control" id="footerEditor" name="footer">{{$generalInfo->footer}}</textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Logo</b></label>
						</div>
						<div class="col-sm-9">
							<div class="fileupload fileupload-exists" data-provides="fileupload" >
								<span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px;">
									@if(!empty($generalInfo->logo_1))
									<img src="{{env('UploadsLink').'uploads/settings/'.$generalInfo->logo_1}}" alt="Logo" class="img-responsive" style="max-width: 150px;"/>
									@endif
								</span>
								<span>
									<label class="btn btn-primary btn-file btn-sm"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
										<input type="file" name="logo_1">
									</label>
								</span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Logo 2</b></label>
						</div>
						<div class="col-sm-9">
							<div class="fileupload fileupload-exists" data-provides="fileupload" >
								<span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px;">
									@if(!empty($generalInfo->logo_2))
									<img src="{{env('UploadsLink').'uploads/settings/'.$generalInfo->logo_2}}" alt="Logo" class="img-responsive" style="max-width: 150px;"/>
									@endif
								</span>
								<span>
									<label class="btn btn-primary btn-file btn-sm"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
										<input type="file" name="logo_2">
									</label>
								</span>
							</div>
						</div>
					</div>


					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Icon (w=32xh=32)</b></label>
						</div>
						<div class="col-sm-9">
							<div class="fileupload fileupload-exists" data-provides="fileupload" >
								<span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px;">
									@if(!empty($generalInfo->icon_1))
									<img src="{{env('UploadsLink').'uploads/settings/'.$generalInfo->icon_1}}" alt="Logo" class="img-responsive" style="max-width: 150px;"/>
									@endif
								</span>
								<span>
									<label class="btn btn-primary btn-file btn-sm"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
										<input type="file" name="icon_1">
									</label>
								</span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Icon (w=100xh=100)</b></label>
						</div>
						<div class="col-sm-9">
							<div class="fileupload fileupload-exists" data-provides="fileupload" >
								<span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px;">
									@if(!empty($generalInfo->icon_2))
									<img src="{{env('UploadsLink').'uploads/settings/'.$generalInfo->icon_2}}" alt="Logo" class="img-responsive" style="max-width: 150px;"/>
									@endif
								</span>
								<span>
									<label class="btn btn-primary btn-file btn-sm"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
										<input type="file" name="icon_2">
									</label>
								</span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Default Image (w=150xh=150)</b></label>
						</div>
						<div class="col-sm-9">
							<div class="fileupload fileupload-exists" data-provides="fileupload" >
								<span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px;">
									@if(!empty($generalInfo->default_img_2))
									<img src="{{env('UploadsLink').'uploads/settings/'.$generalInfo->default_img_2}}" alt="Logo" class="img-responsive" style="max-width: 150px;"/>
									@endif
								</span>
								<span>
									<label class="btn btn-primary btn-file btn-sm"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
										<input type="file" name="default_img_2">
									</label>
								</span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Default Image (w=995xh=560)</b></label>
						</div>
						<div class="col-sm-9">
							<div class="fileupload fileupload-exists" data-provides="fileupload" >
								<span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px;">
									@if(!empty($generalInfo->default_img_1))
									<img src="{{env('UploadsLink').'uploads/settings/'.$generalInfo->default_img_1}}" alt="Logo" class="img-responsive" style="max-width: 150px;"/>
									@endif
								</span>
								<span>
									<label class="btn btn-primary btn-file btn-sm"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
										<input type="file" name="default_img_1">
									</label>
								</span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-9  col-sm-offset-3">
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
<script src="{{asset('assets/js/plugins/bootstrap-fileupload.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/text-editor.min.js')}}"></script>
<script type="text/javascript">
	$('#aboutEditor').summernote({
		tabsize: 2,
		height: 300,
		// toolbar: [
		// ['font', ['bold', 'italic', 'underline']],
		// ],
	});

	$('#contactEditor').summernote({
		tabsize: 2,
		height: 300,
		// toolbar: [
		// ['font', ['bold', 'italic', 'underline']],
		// ],
	});

	$('#privacyEditor').summernote({
		tabsize: 2,
		height: 300,
		// toolbar: [
		// ['font', ['bold', 'italic', 'underline']],
		// ],
	});

	$('#termsEditor').summernote({
		tabsize: 2,
		height: 300,
		// toolbar: [
		// ['font', ['bold', 'italic', 'underline']],
		// ],
	});

	$('#adPriceEditor').summernote({
		tabsize: 2,
		height: 300,
		// toolbar: [
		// ['font', ['bold', 'italic', 'underline']],
		// ],
	});

	$('#footerEditor').summernote({
		tabsize: 2,
		height: 300,
		// toolbar: [
		// ['font', ['bold', 'italic', 'underline']],
		// ],
	});
</script>
@endpush
