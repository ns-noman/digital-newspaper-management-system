@extends('layouts.app')
@section('title', 'New Post')

@push('top-scripts')
<link href="{{asset('assets/css/text-editor.css')}}" rel="stylesheet">
<link href="{{asset('assets/vendors/chosen/chosen.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/bootstrap-tagsinput.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/bootstrap-fileupload.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" />
<link href="{{asset('assets/vendors/select2/css/select2.min.css')}}" rel="stylesheet">
<style type="text/css">
	.bootstrap-tagsinput{
		width: 100%;
		height: 34px;
		border-radius: 2px !important;
	}
	.datetimepicker{
		margin-left: -50px !important
	}
	.fileinput .btn-file{
		padding: 0px !important;
		margin: 0px !important;
	}
	.fileinput .btn-file .fileinput-new{
		padding: 9px !important;
		margin-bottom: 0px !important;
	}
	.chosen-container{
		width: 100% !important;
	}
	.chosen-container .chosen-single{
		height: 34px !important;
		padding-top: 4px !important;
		border-radius: 2px !important;
		background: unset !important;
		box-shadow: unset !important;
	}
	.chosen-container-single .chosen-single div b {
		margin-top: 4px
	}
	.chosen-container .chosen-choices{
		min-height: 34px !important;
		padding-top: 4px !important;
		border-radius: 2px !important;
		background: unset !important;
		box-shadow: unset !important;
	}
	.chosen-results {
		overflow: auto;
	}
	.chosen-results::-webkit-scrollbar {
		width: 18px;
	}
	.chosen-results::-webkit-scrollbar-track {
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	}
	.chosen-results::-webkit-scrollbar-thumb {
		border-radius: 0px;
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
	}
</style>
@endpush

@section('content')

<section class="vbox">
	<section class="scrollable padder">
		<br>

		@if(session('message'))
		<div class="alert alert-danger text-center alert-dismissable fade in">
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

		@if(session('info_message'))
		<div class="alert alert-info text-center alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>{{session('info_message')}} </strong>
		</div>
		@endif

		<section class="panel panel-default">
			<header class="panel-heading"><b>Post | New Post</b>
				<div class="pull-right xs-pull-unset">
					<input type="text" name="wrongWord" class="wrongWord" placeholder="Wrong Word">
					<input type="text" name="replaceToWord" class="replaceToWord" placeholder="Replace To">
					<button type="button" class="replaceNow">Replace</button>
				</div>
			</header>

			<div class="panel-body">
				<form class="form-horizontal" method="post" action="{{route('Posts Store')}}" enctype="multipart/form-data">
					{{csrf_field()}}
					<input type="hidden" name="news_type" value="1">
					<input type="hidden" name="home_status" value="1">

					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-4 paddingLR5" style="background-color: #f6f6f6;border-radius: 10px;padding: 15px !important;box-shadow: 0px 0px 6px rgb(120 120 120 / 40%);">

								<div class="form-group">
									<label class="col-sm-12">Placement</label>
									<div class="col-sm-12">
										<select style="width:100%" name="display_position" class="chosen-select">
											<option value="">--Select Placement--</option>
											<option value="lead" @if(old('display_position') == 'lead') selected @endif>Lead</option>
											<option value="top" @if(old('display_position') == 'top') selected @endif>Top</option>
										</select>
										@if($errors->has('display_position'))
										<span class="help-block text-danger">{{ $errors->first('display_position') }}</span>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12">Category <span class="text-danger">**</span></label>
									<div class="col-sm-12">
										<select style="width:100%" name="categories[]" multiple class="chosen-select onlinecategory" id="category" required="">
											<option value=""></option>
											@if(!empty($categories) && (count($categories)>0))
											@foreach($categories as $category)
											<option parent-id="" parent-name="" value="{{$category->id}}" class="optionGroup" {{ !empty(old("categories")) && in_array($category->id, old("categories")) ? "selected" : "" }}>{{$category->display_name}}</option>

											@if(!empty($category->childCategoriesActive) && (count($category->childCategoriesActive)>0))
											@foreach($category->childCategoriesActive as $subcategory)
											<option parent-id="{{$category->id}}" parent-name="{{$category->display_name}}" value="{{$subcategory->id}}" class="optionChild" {{ !empty(old("categories")) && in_array($subcategory->id, old("categories")) ? "selected" : "" }}>{{$category->display_name.'_'.$subcategory->display_name}}</option>
											@endforeach
											@endif
											@endforeach
											@endif
										</select>
										@if($errors->has('categories'))
										<span class="help-block text-danger">{{ $errors->first('categories') }}</span>
										@endif
										@if(session('invalidCategoryselection'))
										<span class="help-block text-danger">{{session('invalidCategoryselection')}}</span>
										@endif
									</div>
								</div>

								<div class="form-group" style="margin-left: -5px;margin-right: -5px;">
									<div class="col-sm-6 paddingLR5">
										<div class="row">
											<label class="col-sm-12">Parent Category <span class="text-danger">**</span></label>
											<div class="col-sm-12">
												<select style="width:100%" name="parentCategory" class="chosen-select parentCategory" required="">
												</select>
												@if($errors->has('parentCategory'))
												<span class="help-block text-danger">{{ $errors->first('parentCategory') }}</span>
												@endif
											</div>
										</div>
									</div>

									<div class="col-sm-6 paddingLR5">
										<div class="row">
											<label class="col-sm-12">Hide Home Section</label>
											<div class="col-sm-12">
												<select style="width:100%" name="hideCategory[]" class="chosen-select hideCategory" multiple>
												</select>
												@if($errors->has('hideCategory'))
												<span class="help-block text-danger">{{ $errors->first('hideCategory') }}</span>
												@endif
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-12">Author</label>
									<div class="col-sm-12">
										<select style="width:100%" name="author_id[]" multiple="" class="chosen-select">
											@if(!empty($authors) && (count($authors)>0))
											@foreach($authors as $key => $author)
											<option value="{{$author->id}}" @if(old('author_id') == $author->id) selected @endif >{{$author->author_name}}- {{$author->type == 1 ? 'Office Journalist' : 'External Writer'}}</option>
											@endforeach
											@endif
										</select>
										@if($errors->has('author_id'))
										<span class="help-block text-danger">{{ $errors->first('author_id') }}</span>
										@endif
									</div>
								</div>


								<div class="form-group" style="margin-left: -5px;margin-right: -5px;">
									<div class="col-sm-6 paddingLR5">
										<div class="row">
											<label class="col-sm-12">Incidents</label>
											<div class="col-sm-12">
												<select style="width:100%" name="incident" class="chosen-select">
													<option value="">--Select Incident--</option>
													@if(!empty($incidents) && (count($incidents)>0))
													@foreach($incidents as $key => $incident)
													<option value="{{$incident->id}}" @if(old('incident') == $incident->id) selected @endif >{{$incident->title}}</option>
													@endforeach
													@endif
												</select>
												@if($errors->has('incident'))
												<span class="help-block text-danger">{{ $errors->first('incident') }}</span>
												@endif
											</div>
										</div>
									</div>

									<div class="col-sm-6 paddingLR5">
										<div class="row">
											<label class="col-sm-12">Live Update</label>
											<div class="col-sm-12">
												<select style="width:100%" name="liveupdate_status" class="chosen-select">
													<option value="">No</option>
													<option value="1" {!! old('liveupdate_status') == 1 ? 'selected' : '' !!}>Yes</option>
													<option value="2" {!! old('liveupdate_status') == 2 ? 'selected' : '' !!}>Ended</option>
												</select>
												@if($errors->has('liveupdate_status'))
												<span class="help-block text-danger">{{ $errors->first('liveupdate_status') }}</span>
												@endif
											</div>
										</div>
									</div>
								</div>

								<div class="form-group" style="margin-left: -5px;margin-right: -5px;">
									<label class="col-sm-12 paddingLR5">Location <span class="text-danger locationRequired" style="display: none;">**</span></label>
									<div class="col-sm-4 paddingLR5">
										<select name="division" class="form-control getDivision">
											<option value="" data-divtitle="">--Select Division--</option>
											@if(!empty($divisions) && (count($divisions)>0))
											@foreach($divisions as $divisionList)
											<option value="{{$divisionList->id}}" data-divtitle="{{$divisionList->display_name}}" @if(old('division') == $divisionList->id) selected @endif>{{$divisionList->display_name}}</option>
											@endforeach
											@endif
										</select>
									</div>
									<div class="col-sm-4 paddingLR5">
										<select name="district" class="form-control ajaxDistricts getDistrict" id="selectDistrict" disabled="">
										</select>
									</div>
									<div class="col-sm-4 paddingLR5">
										<select name="upazila" class="form-control ajaxUpazilas" id="selectUpazila" disabled="">
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12">Video</label>
									<div class="col-sm-12 table-responsive">
										<table class="table table-bordered marginB0">
											<tbody>
												<tr>
													<td style="width: 130px">
														<div class="fileupload fileupload-new marginB0" data-provides="fileupload" >
															<span class="fileupload-preview fileupload-exists thumbnail marginB0" style="max-width: 130px;border: none;padding: 0px"></span>
															<label class="btn btn-primary btn-file btn-sm" style="width: 100%;margin-top: 5px">
																<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Thumb</span>
																<span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
																<input type="file" name="thumbnail2" id="thumbnail2">
															</label>
															<a style="width: 100%;margin-top: 5px" href="#" class="btn fileupload-exists btn-default btn-sm" data-dismiss="fileupload">
																<i class="fa fa-times"></i> Remove
															</a>
														</div>
													</td>

													<td>
														<textarea class="form-control videoCode" name="video_code" id="video_code" rows="3" placeholder="Video (Embed Code)">{{old('video_code')}}</textarea>
														@if($errors->has('video_code'))
														<span class="help-block text-danger">{{ $errors->first('video_code') }}</span>
														@endif
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12">Podcast (Embed)</label>
									<div class="col-sm-12">
										<textarea name="audio_code" class="form-control" rows="4" placeholder="Audio Embed Code">{{old('audio_code')}}</textarea>
										@if($errors->has('audio_code'))
										<span class="help-block text-danger">{{ $errors->first('audio_code') }}</span>
										@endif
									</div>
								</div>

								<div class="form-group" style="margin-left: -5px;margin-right: -5px;">
									<div class="col-sm-6 paddingLR5">
										<div class="row">
											<label class="col-sm-12">PR For Company</label>
											<div class="col-sm-12">
												<select style="width:100%" name="marketing_company_id" class="chosen-select">
													<option value="">--Select Company--</option>
													@if(!empty($marketingCompanies) && (count($marketingCompanies)>0))
													@foreach($marketingCompanies as $key => $marketingCompany)
													<option value="{{$marketingCompany->id}}" @if(old('marketing_company_id') == $marketingCompany->id) selected @endif >{{$marketingCompany->title}}</option>
													@endforeach
													@endif
												</select>
												@if($errors->has('marketing_company_id'))
												<span class="help-block text-danger">{{ $errors->first('marketing_company_id') }}</span>
												@endif
											</div>
										</div>
									</div>

									<div class="col-sm-6 paddingLR5">
										<div class="row">
											<label class="col-sm-12">Marketing Person</label>
											<div class="col-sm-12">
												<select style="width:100%" name="marketing_person_id" class="chosen-select">
													<option value="">--Select Person--</option>
													@if(!empty($marketingPersons) && (count($marketingPersons)>0))
													@foreach($marketingPersons as $key => $marketingPerson)
													<option value="{{$marketingPerson->id}}" @if(old('marketing_person_id') == $marketingPerson->id) selected @endif >{{$marketingPerson->title}}</option>
													@endforeach
													@endif
												</select>
												@if($errors->has('marketing_person_id'))
												<span class="help-block text-danger">{{ $errors->first('marketing_person_id') }}</span>
												@endif
											</div>
										</div>
									</div>
								</div>

								<div class="form-group" style="margin-left: -5px;margin-right: -5px;">
									@if(Auth::user()->role == 'admin')
									<div class="col-sm-6 paddingLR5">
										<div class="row">
											<label class="col-sm-12">No-Index</label>
											<div class="col-sm-12">
												<select style="width:100%" name="noindex" class="chosen-select">
													<option value="">No</option>
													<option value="1" {!! old('noindex') == 1 ? 'selected' : '' !!}>Yes</option>
												</select>
												@if($errors->has('noindex'))
												<span class="help-block text-danger">{{ $errors->first('noindex') }}</span>
												@endif
											</div>
										</div>
									</div>

									<div class="col-sm-6 paddingLR5">
										<div class="row">
											<label class="col-sm-12">Exclude XML</label>
											<div class="col-sm-12">
												<select style="width:100%" name="exclude_xml" class="chosen-select">
													<option value="">No</option>
													<option value="1" {!! old('exclude_xml') == 1 ? 'selected' : '' !!}>Yes</option>
												</select>
												@if($errors->has('exclude_xml'))
												<span class="help-block text-danger">{{ $errors->first('exclude_xml') }}</span>
												@endif
											</div>
										</div>
									</div>
									@endif

									<div class="col-sm-6 paddingLR5" style="margin-top: 10px">
										<div class="row">
											<label class="col-sm-12">Mark As Evergreen</label>
											<div class="col-sm-12">
												<select style="width:100%" name="custom_xml" class="chosen-select">
													<option value="">No</option>
													<option value="1" {!! old('custom_xml') == 1 ? 'selected' : '' !!}>Yes</option>
												</select>
												@if($errors->has('custom_xml'))
												<span class="help-block text-danger">{{ $errors->first('custom_xml') }}</span>
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>


							<div class="col-sm-8 paddingR5 paddingL30 xs-paddingL5 xs-marginT10">

								<div class="form-group" style="margin-left: -5px;margin-right: -5px;">
									<div class="col-sm-10 paddingLR5">
										<div class="row">
											<label class="col-sm-12">Main Headline <span class="text-danger">**</span> <span class="pull-right removeCharacterLimit" style="color: #337ab7;cursor: pointer;">Increase Limit</span></label>
											<div class="col-sm-12">
												<input type="text" name="headline" id="headline" class="form-control headline" value="{{old('headline')}}" autocomplete="off" required>
												<span class="headlineCount"></span>
												@if($errors->has('headline'))
												<span class="help-block text-danger">{{ $errors->first('headline') }}</span>
												@endif
											</div>
										</div>
									</div>

									<div class="col-sm-2 paddingLR5">
										<div class="row">
											<label class="col-sm-12">Headline Color</label>
											<div class="col-sm-12">
												<div class="input-group">
													<input type="text" class="form-control" name="headline_color" id="headline_color_input" value="{!! !empty(old('headline_color')) ? old('headline_color') : '' !!}">
													<span class="input-group-addon" style="padding-left: 5px;padding-right: 5px;"><input type="color" id="headline_color" class="color-picker" value="{!! !empty(old('headline_color')) ? old('headline_color') : '' !!}" style="height: 20px;"> </span>
												</div>
												@if($errors->has('headline_color'))
												<span class="help-block text-danger">{{ $errors->first('headline_color') }}</span>
												@endif
											</div>
										</div>
									</div>
								</div>

								<div class="form-group" style="margin-left: -5px;margin-right: -5px;">
									<div class="col-sm-3 paddingLR5">
										<div class="row">
											<label class="col-sm-12">Shoulder</label>
											<div class="col-sm-12">
												<input type="text" name="shoulder" id="shoulder" value="{{old('shoulder')}}" class="form-control" autocomplete="off">
												@if($errors->has('shoulder'))
												<span class="help-block text-danger">{{ $errors->first('shoulder') }}</span>
												@endif
											</div>
										</div>
									</div>

									<div class="col-sm-3 paddingLR5">
										<div class="row">
											<label class="col-sm-12">Hanger</label>
											<div class="col-sm-12">
												<input type="text" name="hanger" id="hanger" value="{{old('hanger')}}" class="form-control" autocomplete="off">
												@if($errors->has('hanger'))
												<span class="help-block text-danger">{{ $errors->first('hanger') }}</span>
												@endif
											</div>
										</div>
									</div>

									<div class="col-sm-3 paddingLR5">
										<div class="row">
											<label class="col-sm-12">Reporter <span class="text-danger">**</span></label>
											<div class="col-sm-12">
												<input type="text" class="form-control" name="reporter" value="{{old('reporter')}}" id="reporter" required="" list="suggestions">
												<datalist id="suggestions">
													<option value="অনলাইন ডেস্ক" />
													<option value="আইটি ডেস্ক" />
													<option value="স্পোর্টস ডেস্ক" />
													<option value="ক্রীড়া প্রতিবেদক" />
													<option value="লাইফস্টাইল ডেস্ক" />
													<option value="বিনোদন ডেস্ক" />
													<option value="আন্তর্জাতিক ডেস্ক" />
													<option value="বিজনেস ডেস্ক" />
													<option value="সম্পাদকীয়" />
													<option value="ক্যাম্পাস ডেস্ক" />
													<option value="সংবাদ বিজ্ঞপ্তি" />
												</datalist>
												@if($errors->has('reporter'))
												<span class="help-block text-danger">{{ $errors->first('reporter') }}</span>
												@endif
											</div>
										</div>
									</div>

									<div class="col-sm-3 paddingLR5">
										<div class="row">
											<label class="col-sm-12">Meta Title</label>
											<div class="col-sm-12">
												<input type="text" name="headline2" id="headline2" class="form-control" value="{{old('headline2')}}" autocomplete="off">
												@if($errors->has('headline2'))
												<span class="help-block text-danger">{{ $errors->first('headline2') }}</span>
												@endif
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12">Body</label>
									<div class="col-sm-12">
										<textarea id="text-editor" name="body">{{ old('body') }}</textarea>
										@if($errors->has('body'))
										<span class="help-block text-danger">{{ $errors->first('body') }}</span>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12">Post Excerpt</label>
									<div class="col-sm-12">
										<input class="form-control" name="excerpt" id="excerpt" value="{{old('excerpt')}}">
										@if($errors->has('excerpt'))
										<span class="help-block text-danger">{{ $errors->first('excerpt') }}</span>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12">Meta Description</label>
									<div class="col-sm-12">
										<input class="form-control metaDescription" name="description" id="description" value="{{old('description')}}">
										<span class="metaDescriptionCount"></span>
										@if($errors->has('description'))
										<span class="help-block text-danger">{{ $errors->first('description') }}</span>
										@endif
									</div>
								</div>

								<div class="form-group" style="margin-left: -5px;margin-right: -5px;">
									<div class="col-sm-9 paddingLR5">
										<div class="row">
											<label class="col-sm-12">Tag</label>
											<div class="col-sm-12 select234">
												<select style="width:100%" name="topic[]" class="loadTopics" multiple="multiple">
												</select>
												@if($errors->has('topic'))
												<span class="help-block text-danger">{{ $errors->first('topic') }}</span>
												@endif
											</div>
										</div>
									</div>

									<!-- <div class="col-sm-9 paddingLR5">
										<div class="row">
											<label class="col-sm-12">Meta Keywords <span class="text-danger">**</span></label>
											<div class="col-sm-12">
												<input type="text" name="keywords" class="form-control tags_input" value="{{old('keywords')}}" data-role="tagsinput" required="">
												@if($errors->has('keywords'))
												<span class="help-block text-danger">{{ $errors->first('keywords') }}</span>
												@endif
											</div>
										</div>
									</div> -->

									<div class="col-sm-3 paddingLR5">
										<div class="row">
											<label class="col-sm-12">Meta GPI</label>
											<div class="col-sm-12">
												<select style="width:100%" name="meta_sticker" class="chosen-select">
													@if(!empty($metaStickers) && (count($metaStickers)>0))
													@foreach($metaStickers as $key => $metaSticker)
													<option value="{{$metaSticker->id}}" @if(old('meta_sticker') == $metaSticker->id) selected @endif >{{$metaSticker->title}}</option>
													@endforeach
													@endif
												</select>
												@if($errors->has('meta_sticker'))
												<span class="help-block text-danger">{{ $errors->first('meta_sticker') }}</span>
												@endif
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12">Photos (1200x675)</label>
									<div class="col-sm-12 table-responsive">
										<table class="table table-bordered appended_tr marginB0">
											<tbody>
												<tr>
													<td style="max-width: 160px;vertical-align: middle;">
														<div class="fileupload fileupload-new marginB0" data-provides="fileupload" >
															<span class="fileupload-preview fileupload-exists thumbnail marginB0" style="max-width: 75px;"></span>
															<label class="btn btn-primary btn-file btn-sm" >
																<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Photo</span>
																<span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
																<input type="file" name="image[]" id="image">
															</label>
															<a href="#" class="btn fileupload-exists btn-default btn-sm" data-dismiss="fileupload">
																<i class="fa fa-times"></i> Remove
															</a>
														</div>
													</td>
													<td style="vertical-align: middle;"><input class="form-control" name="image_caption[]" placeholder="Photo Caption" id="image_caption"></td>
													<td style="max-width: 30px;vertical-align: middle;"><i class="fa fa-trash-o fa-2x fileupload-exists" data-dismiss="fileupload"></i></td>

													<td style="max-width: 70px;vertical-align: middle;">
														<button type="button" class="add_more_photo btn btn-default btn-sm pull-right"><i class="fa fa-plus"></i> Add More</button>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>


								<div class="form-group">
									<div class="col-sm-12 table-responsive" style="margin-top: 7px;">
										<table class="table table-bordered table-striped appended_initial_tr marginB0">
											<tbody>
												<tr>
													<th>Initial Type</th>
													<th>Initial</th>
													<th class="text-center"><button type="button" class="add_more_initial btn btn-default btn-sm pull-right"><i class="fa fa-plus"></i> Add More</button></th>
												</tr>
												<tr class="defaultTr">
													<td style="vertical-align: middle;">
														<select class="form-control employeeTypesOption chosen-select" name="initial_types[]" required="">
															@if(!empty($types) && (count($types)>0))
															@foreach($types as $key => $type)
															<option {!! $type->id == 2 ? 'selected' : '' !!} value="{!! $type->id !!}">{!! $type->title !!}</option>
															@endforeach
															@endif
														</select>
													</td>
													<td class="requiredDiv" style="vertical-align: middle;">
														<select class="form-control employeeInitialsOption chosen-select required" name="initials[]" required="">
															<option value="">-Select Initial-</option>
															@if(!empty($employeeInitials) && (count($employeeInitials)>0))
															@foreach($employeeInitials as $key => $employeeInitial)
															<option value="{!! $employeeInitial->id !!}">{{$employeeInitial->name}}_{{$employeeInitial->initial}}</option>
															@endforeach
															@endif
														</select>
														<span class="requiredMessage"></span>
													</td>
													<td class="text-center" style="width: 30px;vertical-align: middle;">
														<i class="fa fa-trash-o fa-2x"></i>
													</td>
												</tr>

												<tr class="defaultTr">
													<td style="vertical-align: middle;">
														<select class="form-control employeeTypesOption chosen-select" name="initial_types[]" required="">
															@if(!empty($types) && (count($types)>0))
															@foreach($types as $key => $type)
															<option {!! $type->id == 6 ? 'selected' : '' !!} value="{!! $type->id !!}">{!! $type->title !!}</option>
															@endforeach
															@endif
														</select>
													</td>
													<td class="requiredDiv" style="vertical-align: middle;">
														<select class="form-control employeeInitialsOption chosen-select required" name="initials[]" required="">
															<option value="">-Select Initial-</option>
															@if(!empty($employeeInitials) && (count($employeeInitials)>0))
															@foreach($employeeInitials as $key => $employeeInitial)
															<option value="{!! $employeeInitial->id !!}">{{$employeeInitial->name}}_{{$employeeInitial->initial}}</option>
															@endforeach
															@endif
														</select>
														<span class="requiredMessage"></span>
													</td>
													<td class="text-center" style="width: 30px;vertical-align: middle;">
														<i class="fa fa-trash-o fa-2x"></i>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>

							</div>
						</div>
					</div>


					<div class="line line-dashed b-b line-lg pull-in"></div>
					<div class="form-group">
						<div class="col-md-12">
							<div class="pull-right">
								<a class="btn"><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox" name="selected_status" value="1"><i></i> Mark Selected</label></a>
								<a class="btn"><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox" name="selected2_status" value="1"><i></i> Mark Selected2</label></a>
								<a class="btn"><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox" name="paidnews_status" value="1"><i></i> Mark Paid</label></a>
								<a class="btn"><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox" name="hide_latest" value="1"><i></i> Hide Latest</label></a>
								<a class="btn"><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox" name="show_updatetime" value="1"><i></i> Show Update Time</label></a>
								<a class="btn"><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox" name="proved_id" value="{{Auth::user()->id}}"><i></i> Mark As Proved</label></a>
								<a href="{{route('Posts')}}" class="btn btn-danger">Cancel</a>
								<button type="submit" class="btn btn-primary publish" name="draft" value="draft">Unpublish</button>
								<button type="submit" class="btn btn-success publish">Publish</button>
							</div>
						</div>
					</div>

				</form>
			</div>
		</section>
	</section>
</section>

<input type="hidden" class="headlineLimit" value="65">
@endsection

@push('bottom-scripts')
<script src="{{asset('assets/js/plugins/text-editor.min.js?v=1.11')}}"></script>
<script src="{{asset('assets/vendors/chosen/chosen.jquery.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-fileupload.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/jasny-bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/summernote-image-captionit.js')}}"></script>
<script src="{{asset('assets/js/pages/article.js?v=1.15')}}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker.min.js') }}" ></script>

<!-- character count -->
<script type="text/javascript">
	$('.headline').keyup(function(){
		var headlinecharacterCount = $('.headlineLimit').val();
		var headlinecharacterCountMessage = '';
		var headlineCount = $(this).val().length;
		if(headlineCount > headlinecharacterCount){
			var newheadlineCount = $(this).val().substring(0, headlinecharacterCount);
			$('.headline').val(newheadlineCount);
			var headlinecharacterCountMessage = '. Headline should 5-'+headlinecharacterCount+' character.';
			alert('Headline should 5-'+headlinecharacterCount+' character.');
		}
		$('.headlineCount').text('Character: '+headlineCount+headlinecharacterCountMessage);
		if(headlineCount == 0){
			$('.headlineCount').hide();
		}else{
			$('.headlineCount').show();
		}
	});

	$('.metaDescription').keyup(function(){
		var characterCount = 160;
		var characterCountMessage = '';
		var metaDescriptionCount = $(this).val().length;
		if(metaDescriptionCount > characterCount){
			var newmetaDescriptionCount = $(this).val().substring(0, characterCount);
			$('.metaDescription').val(newmetaDescriptionCount);
			var characterCountMessage = '. Meta description should 50-160 character.';
			alert('Meta description should 50-160 character.');
		}
		$('.metaDescriptionCount').text('Character: '+metaDescriptionCount+characterCountMessage);
		if(metaDescriptionCount == 0){
			$('.metaDescriptionCount').hide();
		}else{
			$('.metaDescriptionCount').show();
		}
	});
</script>

<script type="text/javascript">
	$(document).on('click', '.removeCharacterLimit', function(e){
		$('.headlineLimit').val(200);
		$('.removeCharacterLimit').html('Char increased to 200');
	})
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.onlinecategory').on('change', function(event, params) {
			$('.getDivision').prop('required', false);
			$('.locationRequired').hide();
			$('.parentCategory').empty();
			// $('.hideCategory').empty();
			var selectedOptions = $(this).chosen().find("option:selected");
			var mainCategory = [];

			$.each(selectedOptions, function( index, value ) {
				if(value.text == 'সারাদেশ'){
					$('.getDivision').prop('required', true);
					$('.locationRequired').show();
				}

				mainCategory.push(value.value);
				
				// parent category
				var parent_name = $(value).attr("parent-name");
				var parent_id = $(value).attr("parent-id");
				if(parent_id != ''){
					mainCategory.push(parent_id);
					$('.parentCategory').append('<option value="'+parent_id+'">'+parent_name+'</option>');
					$('.hideCategory').append('<option value="'+parent_id+'">'+parent_name+'</option>');
				}
				// parent category end

				$('.parentCategory').append('<option value="'+value.value+'">'+value.text+'</option>')
				$('.hideCategory').append('<option value="'+value.value+'">'+value.text+'</option>')
			});
			var uniqueMainCategory = Array.from(new Set(mainCategory));
			$('.onlinecategory').chosen().val(uniqueMainCategory).trigger("chosen:updated");

			$(".parentCategory option").each(function() {
				$(this).siblings('[value="'+ this.value +'"]').remove();
			});
			$(".parentCategory").chosen().trigger("chosen:updated");

			$(".hideCategory option").each(function() {
				$(this).siblings('[value="'+ this.value +'"]').remove();
			});
			$(".hideCategory").chosen().trigger("chosen:updated");
		});
	});
</script>

<script type="text/javascript">
	$('.publishDatePick').datetimepicker({
		todayBtn:  1,
		autoclose: 1,
		minView: 2
	});
	$('.form-date').datetimepicker({
		locale: 'ru',
		startDate: new Date(),
	});

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	function uploadImage(image){
		var data = new FormData();
		data.append("image", image);
		$.ajax({
			url: '{{URL("ajax/text-editor/image/")}}',
			cache: false,
			contentType: false,
			processData: false,
			data: data,
			type: "post",
			success: function(url) {
				var image = $('<img>').attr('src', url).attr('class', 'img-responsive');
				$('#text-editor').summernote("insertNode", image[0]);
			},
		});
	}
</script>


<script type="text/javascript">
	$(document).ready(function() {
		var max_fields = 50; 
		var wrapper = $(".appended_file_tr"); 
		var add_button = $(".add_more_file"); 
		var x = 1; 
		$(add_button).click(function(e){
			e.preventDefault();
			if(x < max_fields){ 
				x++; 
				$(wrapper).append('<tr><td><input  type="text"  class="form-control"  placeholder="File Caption"name="filecaption[]"></td><td><div class="fileinput input-group fileinput-new" data-provides="fileinput"><div class="form-control"><i class="glyphicon glyphicon-file fileinput-exists"></i><span class="fileinput-filename"></span></div><span class="input-group-addon btn btn-default btn-file"><input type="file" id="document_file" name="document_file[]"><label class="fileinput-new" for="file" data-trigger="fileinput">Select File</label></span><a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a></div></td><td><i class="fa fa-trash-o fa-2x text-dark remove_field_file"></i></td></tr>');
			}
		});
		$(wrapper).on("click",".remove_field_file", function(e){ 
			e.preventDefault(); $(this).closest('tr').remove(); x--;
		})
	});
</script>


<!-- ajax district list -->
<script type="text/javascript">
	$(document).ready(function() {
		$(".getDivision").on("change", function(){
			var getDivision = $(this).val();
			$.ajax({
				type: 'GET',
				url: '{{URL("ajax/get/districts")}}'+"/"+getDivision,
				success: function (data) {
					$('.ajaxDistricts').html(data);
					$('.ajaxDistricts').removeAttr('disabled');
				}
			});
		});
	});
</script>

<!-- ajax upazila list -->
<script type="text/javascript">
	$(document).ready(function() {
		$(".getDistrict").on("change", function(){
			var getDistrict = $(this).val();
			$.ajax({
				type: 'GET',
				url: '{{URL("ajax/get/upazilas")}}'+"/"+getDistrict,
				success: function (data) {
					$('.ajaxUpazilas').html(data);
					$('.ajaxUpazilas').removeAttr('disabled');
				}
			});
		});
	});
</script>

<script type="text/javascript">
	// $('.publish').click(function(){
	// 	var keywords = $('.keywords').val();
	// 	if(keywords == ''){
	// 		$('.keywordsAlert').html('Meta keywords field is required');
	// 		$('.keywordsAlert').show();
	// 		alert('Meta keywords field is required');
	// 	}
	// })
</script>


<script type="text/javascript">
	$(document).ready(function() {
		var max_fields = 50; 
		var wrapper = $(".appended_initial_tr"); 
		var add_button = $(".add_more_initial"); 
		var x = 1; 
		$(add_button).click(function(e){
			var employeeTypesOption = $('.employeeTypesOption').html();
			var employeeInitialsOption = $('.employeeInitialsOption').html();

			e.preventDefault();
			if(x < max_fields){ 
				x++; 
				$(wrapper).append('<tr><td style="vertical-align: middle;"><select class="form-control chosen-select types'+x+'" name="initial_types[]" required="">'+employeeTypesOption+'</select></td><td class="requiredDiv" style="vertical-align: middle;"><select class="form-control chosen-select required initials'+x+'" name="initials[]" required="">'+employeeInitialsOption+'</select><span class="requiredMessage"></span></td><td style="width: 30px;vertical-align: middle;" class="text-center"><i class="fa fa-trash-o fa-2x text-dark remove_field_initial"></i></td></tr>');

				$(".types"+x).chosen().trigger("chosen:updated");
				$(".initials"+x).chosen().trigger("chosen:updated");
			}
		});
		$(wrapper).on("click",".remove_field_initial", function(e){ 
			e.preventDefault(); $(this).closest('tr').remove(); x--;
		})
	});
</script>

<script type="text/javascript">
	$('.videoCode').on('change', function(){
		var videoCode = $('.videoCode').val();
		if(videoCode != ''){
			var employeeTypesOption = $('.employeeTypesOption').html();
			var employeeInitialsOption = $('.employeeInitialsOption').html();
			$('.defaultTr').empty();

			$('.appended_initial_tr').append('<tr class="defaultTr"><td style="vertical-align: middle;"><select class="form-control chosen-select employeeTypesOption typesReporter" name="initial_types[]" required="">'+employeeTypesOption+'</select></td><td class="requiredDiv" style="vertical-align: middle;"><select class="form-control chosen-select employeeInitialsOption required initialsReporter" name="initials[]" required="">'+employeeInitialsOption+'</select><span class="requiredMessage"></span></td><td class="text-center" style="width: 30px;vertical-align: middle;"><i class="fa fa-trash-o fa-2x"></i></td></tr>');
			$(".typesReporter").val(2).chosen().trigger("chosen:updated");
			$(".initialsReporter").chosen().trigger("chosen:updated");

			$('.appended_initial_tr').append('<tr class="defaultTr"><td style="vertical-align: middle;"><select class="form-control chosen-select employeeTypesOption typesVideoEditor" name="initial_types[]" required="">'+employeeTypesOption+'</select></td><td class="requiredDiv" style="vertical-align: middle;"><select class="form-control chosen-select employeeInitialsOption required initialsVideoEditor" name="initials[]" required="">'+employeeInitialsOption+'</select><span class="requiredMessage"></span></td><td class="text-center" style="width: 30px;vertical-align: middle;"><i class="fa fa-trash-o fa-2x"></i></td></tr>');
			$(".typesVideoEditor").val(12).chosen().trigger("chosen:updated");
			$(".initialsVideoEditor").chosen().trigger("chosen:updated");

			$('.appended_initial_tr').append('<tr class="defaultTr"><td style="vertical-align: middle;"><select class="form-control chosen-select employeeTypesOption typesUploadSeo" name="initial_types[]" required="">'+employeeTypesOption+'</select></td><td class="requiredDiv" style="vertical-align: middle;"><select class="form-control chosen-select employeeInitialsOption required initialsUploadSeo" name="initials[]" required="">'+employeeInitialsOption+'</select><span class="requiredMessage"></span></td><td class="text-center" style="width: 30px;vertical-align: middle;"><i class="fa fa-trash-o fa-2x"></i></td></tr>');
			$(".typesUploadSeo").val(13).chosen().trigger("chosen:updated");
			$(".initialsUploadSeo").chosen().trigger("chosen:updated");
		}
	})
</script>

<script type="text/javascript">
	$('.publish').click(function () {
		$('.requiredMessage').empty();
		$(".requiredDiv .required").each(function() {
			if($(this).val() == ''){
				$(this).closest('.requiredDiv').find('.requiredMessage').html('This filed is required.');
			}
		});
	});
</script>

<script src="{{ asset('assets/vendors/select2/js/select2.min.js') }}" ></script>
<script type="text/javascript">
	$( document ).ready(function() {
		function loadTopics()
		{
			$(".loadTopics").select2({
				placeholder: "Select Tag",
				ajax: { 
					url:  '{{URL("ajax/get/topic")}}',
					type: "get",
					dataType: 'json',
					delay: 250,
					data: function (params) {
						return {
							searchTerm: params.term
						};
					},
					processResults: function (response) {
						return {
							results: response
						};
					},
					cache: true
				},

				minimumInputLength: 0,
				escapeMarkup: function(result) {
					return result;
				},
				templateResult: function (result) {
					if (result.loading) return 'Searching...';
					return result['text'];
				},
			});
		}

		loadTopics();
	});
</script>
@endpush
