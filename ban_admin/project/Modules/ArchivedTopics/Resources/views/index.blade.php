@extends('layouts.app')
@section('title', 'Topics')

@push('top-scripts')
<link href="{{asset('assets/css/bootstrap-fileupload.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/bootstrap-tagsinput.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/text-editor.css')}}" rel="stylesheet">
<style type="text/css">
	.bootstrap-tagsinput{
		width: 100%
	}
	.pager{
		text-align: right;
	}
	.pager li>a, .pager li>span{
		border-radius: 0px !important
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
		<div class="alert alert-info text-center alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>{{session('error_message')}} </strong>
		</div>
		@endif

		<section class="panel panel-default">
			<header class="panel-heading font-bold">Topics
				<a href="javascript::void(0)" data-toggle="modal" data-target="#createModal" class="btn btn-success btn-xs pull-right"> <i class="fa fa-plus-circle"></i> New Topic</a>
				<select name="paginationAmount" class="input-sm form-control input-s-sm inline v-middle pull-right paginationAmount" style="margin-right: 10px;padding: 2px 5px;height: 23px;width: 100px">
					<option value="10">Row- 10</option>
					<option value="50" {{isset($_GET['paginationAmount']) && $_GET['paginationAmount'] == 50 ? 'selected' : Null}}>Row- 50</option>
					<option value="100" {{isset($_GET['paginationAmount']) && $_GET['paginationAmount'] == 100 ? 'selected' : Null}}>Row- 100</option>
					<option value="200" {{isset($_GET['paginationAmount']) && $_GET['paginationAmount'] == 200 ? 'selected' : Null}}>Row- 200</option>
					<option value="300" {{isset($_GET['paginationAmount']) && $_GET['paginationAmount'] == 300 ? 'selected' : Null}}>Row- 300</option>
				</select>
			</header>

			<div class="row wrapper">
				<form method="get">
					<input type="hidden" name="search" value="yes">
					<input type="hidden" name="paginationAmount" value="{{isset($_GET['paginationAmount']) && !empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : 10}}">

					<div class="col-sm-2 m-b-xs">
						<input name="topic_title" type="text" class="input-sm form-control" value="{{!empty($_GET['topic_title']) ? $_GET['topic_title'] : ''}}" placeholder="Topic Title" autocomplete="off" />
					</div>
					<div class="col-sm-2 m-b-xs paddingL0">
						<input name="topic_alternate_title" type="text" class="input-sm form-control" value="{{!empty($_GET['topic_alternate_title']) ? $_GET['topic_alternate_title'] : ''}}" placeholder="Topic Alternate Title" autocomplete="off" />
					</div>
					<div class="col-sm-1 m-b-xs paddingL0">
						<button class="btn btn-sm btn-default btn-block">Search</button>
					</div>
				</form>
			</div>

			<form method="post" action="{{route('ArchivedTopics Bulk Update')}}">
				{{csrf_field()}}
				<div class="table-responsive">
					<table class="table table-striped b-t b-light table-bordered table-hover">
						<thead>
							<tr>
								<th width="20">
									<label class="checkbox m-l m-t-none m-b-none i-checks">
										<input type="checkbox"><i></i>
									</label>
								</th>
								<th>SL</th>
								<th>Title</th>
								<th>Photo</th>
								<th>Meta Title</th>
								<th>Meta Photo</th>
								<th>Meta Keywords</th>	
								<th>Create</th>
								<th>Other</th>
								<th>Status</th>	
								<th width="90">Action</th>
							</tr>
						</thead>
						<tbody class="dragAndDrop">
							@if(!empty($lists) && (count($lists)>0))
							@foreach($lists as $key => $list)
							<tr>
								<td>
									<label class="checkbox m-l m-t-none m-b-none i-checks">
										<input type="checkbox" name="ids[]" value="{{$list->id}},{{$list->order_id}}"><i></i>
									</label>
								</td>
								<td>{!! isset($_GET['page']) && !empty($_GET['page']) ? (($_GET['page']-1)*10)+($key+1) : $key + 1 !!}</td>
								<td>
									<a style="color: #177bbb" href="{!! env('WEBSITE').'news-issue/'.$list->topic_slug !!}" target="_blank">{!! $list->topic_title !!}</a>
									<p class="marginB0"><u>Slug:</u> {!! $list->topic_slug !!}</p>
									<p class="marginB0"><u>Alternate:</u> {!! $list->topic_alternate_title !!}</p>
								</td>
								<td>
									@if(!empty($list->topic_photo))
									<img src="{{env('UploadsLink').'uploads/topics/'.$list->topic_photo}}" width="50px" class="img-responsive" />
									@else
									<img src="{{env('UploadsLink').'uploads/topics/default.jpg'}}" width="50px" class="img-responsive" />
									@endif
								</td>
								<td>{!! $list->meta_title !!}</td>
								<td>
									@if(!empty($list->meta_image))
									<img src="{{env('UploadsLink').'uploads/topics/'.$list->meta_image}}" width="50px" class="img-responsive" />
									@else
									<img src="{{env('UploadsLink').'uploads/topics/default.jpg'}}" width="50px" class="img-responsive" />
									@endif
								</td>
								<td>{!! $list->meta_keywords !!}</td>
								<td>
									<p class="margin0"><b><u>Create:</u> {{$list->createdBy->name}}</b></p>
									<p class="margin0">{{date('d M Y h:i A', strtotime($list->created_at))}}</p>
									@if(!empty($list->updated_at))
									<p class="margin0 marginT5"><b><u>Update:</u> {{$list->updatedBy ? $list->updatedBy->name : ''}}</b></p>
									<p class="margin0">{{date('d M Y h:i A', strtotime($list->updated_at))}}</p>
									@endif
								</td>
								<td width="135">
									<p class="margin0">No-Index: {{$list->noindex == 1 ? 'Yes' : 'No'}}</p>
									<p class="margin0">Exclude XML: {{$list->exclude_xml == 1 ? 'Yes' : 'No'}}</p>
								</td>
								<td>{{$list->status == 1 ? 'Active' : 'Inactive'}}</td>
								<td>
									<button type="button" class="btn btn-primary btn-xs openeditModal" data-toggle="modal" data-target="#editModal" data-id="{{$list->id}}" data-topic-title ="{{$list->topic_title }}" data-topic-alternate-title ="{{$list->topic_alternate_title }}" data-topic-slug ="{{$list->topic_slug }}" data-topic-photo="{{$list->topic_photo}}" data-topic-descriptions="{{$list->topic_descriptions}}" data-meta-title="{{$list->meta_title}}" data-meta-image="{{$list->meta_image}}" data-meta-descriptions="{{$list->meta_descriptions}}" data-meta-keywords="{{$list->meta_keywords}}" data-noindex="{{$list->noindex}}" data-excludexml="{{$list->exclude_xml}}" data-status="{{$list->status}}"><i class="fa fa-edit" title="Edit"></i></button>
									<a href="{{route('ArchivedTopics Delete', $list->id)}}" class="btn btn-danger btn-xs delete" onclick="return confirm('Are you sure you want to  delete?');"><i class="fa fa-trash"></i></a>
								</td>

							</tr>
							@endforeach
							@else
							<tr><td colspan="11" class="text-center">No Data</td></tr>
							@endif
						</tbody>
					</table>
				</div>

				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-4">
							<select class="input-sm form-control input-s-sm inline v-middle bulkAction" name="bulkStatus" required="">
								<option value="">Select</option>
								<option value="" class="optionGroup" disabled="">Status</option>
								<option value="1">Active</option>
								<option value="2">Inactive</option>
								<option value="-1">Remove</option>
								<option value="" class="optionGroup" disabled="">Other Options</option>
								<option value="swapOrder">Swap Order</option>
							</select>
							<button type="submit" class="btn btn-sm btn-default">Apply</button>
						</div>
						@if(!empty($lists) && count($lists)>0)
						<div class="col-sm-8 text-right customPaginationStyle">
							{{$lists->appends(request()->input())->links()}}
						</div>
						@endif
					</div>
				</footer>
			</form>

		</section>
	</section>
</section>



<!-- create modal -->
<div id="createModal" class="modal fade" role='dialog'>
	<div class="modal-dialog modal-lg">
		<div class="content">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Topic</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{route('ArchivedTopics Store')}}" enctype="multipart/form-data">
						{{csrf_field()}}

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Title *</b></label>
							<div class="col-sm-8">
								<input type="text" name="topic_title" class="form-control topicTitle" autofocus required="" placeholder="Ex: আজকের খবর" />
								@if($errors->has('topic_title'))
								<span class="help-block">{{ $errors->first('topic_title') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Url Slug *</b></label>
							<div class="col-sm-8">
								<input type="text" name="topic_slug" class="form-control topicSlug" autofocus required="" placeholder="Ex: আজকের-খবর" />
								@if($errors->has('topic_slug'))
								<span class="help-block">{{ $errors->first('topic_slug') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Alternate Title</b></label>
							<div class="col-sm-8">
								<input type="text" name="topic_alternate_title" class="form-control" placeholder="Ex: আজকের খবর" />
								@if($errors->has('topic_alternate_title'))
								<span class="help-block">{{ $errors->first('topic_alternate_title') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Description</b></label>
							<div class="col-sm-8">
								<textarea type="text" name="topic_descriptions" class="form-control text-editor" rows="4"></textarea>
								@if($errors->has('topic_descriptions'))
								<span class="help-block">{{ $errors->first('topic_descriptions') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Photo (300x300)</b></label>
							</div>
							<div class="col-sm-8">
								<div class="fileupload fileupload-new" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 300px; max-height: 200px;">
									</span>
									<span>
										<label class="btn btn-primary btn-rounded btn-file btn-sm">
											<span class="fileupload-new">
												<i class="fa fa-picture-o"></i> Select Image
											</span>
											<span class="fileupload-exists">
												<i class="fa fa-picture-o"></i> Change
											</span>
											<input type="file" name="topic_photo" value="">
										</label>
										<a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Meta Title</b></label>
							<div class="col-sm-8">
								<input type="text" name="meta_title" class="form-control" autofocus />
								@if($errors->has('meta_title'))
								<span class="help-block">{{ $errors->first('meta_title') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Meta Description (160 Chr)</b></label>
							<div class="col-sm-8">
								<textarea type="text" name="meta_descriptions" class="form-control" rows="4"></textarea>
								@if($errors->has('meta_descriptions'))
								<span class="help-block">{{ $errors->first('meta_descriptions') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Meta Keywords</b></label>
							<div class="col-sm-8">
								<input type="text" name="meta_keywords" class="form-control" autofocus placeholder="Comma separated value" />
								@if($errors->has('meta_keywords'))
								<span class="help-block">{{ $errors->first('meta_keywords') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Meta Photo (995x560)</b></label>
							</div>
							<div class="col-sm-8">
								<div class="fileupload fileupload-new" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 300px; max-height: 200px;">
									</span>
									<span>
										<label class="btn btn-primary btn-rounded btn-file btn-sm">
											<span class="fileupload-new">
												<i class="fa fa-picture-o"></i> Select Image
											</span>
											<span class="fileupload-exists">
												<i class="fa fa-picture-o"></i> Change
											</span>
											<input type="file" name="meta_image" value="">
										</label>
										<a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>No-Index</b></label>
							<div class="col-sm-8">
								<select class="form-control" name="noindex">
									<option value="">No</option>
									<option value="1">Yes</option>
								</select>
								@if($errors->has('noindex'))
								<span class="help-block">{{ $errors->first('noindex') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Exclude XML</b></label>
							<div class="col-sm-8">
								<select class="form-control" name="exclude_xml">
									<option value="">No</option>
									<option value="1">Yes</option>
								</select>
								@if($errors->has('exclude_xml'))
								<span class="help-block">{{ $errors->first('exclude_xml') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Status *</b></label>
							<div class="col-sm-8">
								<select class="form-control" name="status" required="">
									<option value="1">Active</option>
									<option value="2">Inactive</option>
								</select>
								@if($errors->has('status'))
								<span class="help-block">{{ $errors->first('status') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-3">
								<button type="submit" class="btn btn-primary btn-block">Save</button>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>



<!-- edit modal -->
<div id="editModal" class="modal fade" role='dialog'>
	<div class="modal-dialog modal-lg">
		<div class="content">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Topic</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{route('ArchivedTopics Update')}} " enctype="multipart/form-data">
						{{csrf_field()}}
						<input type="hidden" id="id" name="id">

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Title *</b></label>
							<div class="col-sm-8">
								<input type="text" name="topic_title" id="topic_title" class="form-control editTopicTitle" autofocus required="" />
								@if($errors->has('topic_title'))
								<span class="help-block">{{ $errors->first('topic_title') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Slug *</b></label>
							<div class="col-sm-8">
								<input type="text" name="topic_slug" id="topic_slug" class="form-control editTopicSlug" autofocus required="" />
								@if($errors->has('topic_slug'))
								<span class="help-block">{{ $errors->first('topic_slug') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Alternate Title</b></label>
							<div class="col-sm-8">
								<input type="text" name="topic_alternate_title" id="topic_alternate_title" class="form-control" placeholder="Ex: আজকের খবর" />
								@if($errors->has('topic_alternate_title'))
								<span class="help-block">{{ $errors->first('topic_alternate_title') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Description</b></label>
							<div class="col-sm-8">
								<textarea type="text" name="topic_descriptions" id="topic_descriptions" class="form-control text-editor" rows="4"></textarea>
								@if($errors->has('topic_descriptions'))
								<span class="help-block">{{ $errors->first('topic_descriptions') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Photo (300x300)</b></label>
							</div>
							<div class="col-sm-8">
								<div class="fileupload fileupload-exists" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail">
										<img id="topic_photo" alt="topic_photo" class="img-responsive" style="max-height: 100px;"/>
									</span>
									<span>
										<label class="btn btn-primary btn-rounded btn-file btn-sm">
											<span class="fileupload-new">
												<i class="fa fa-picture-o"></i> Select Photo
											</span>
											<span class="fileupload-exists">
												<i class="fa fa-picture-o"></i> Change
											</span>
											<input type="file" name="topic_photo">
										</label>
										<a href="" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Meta Title</b></label>
							<div class="col-sm-8">
								<input type="text" name="meta_title" id="meta_title" class="form-control" autofocus />
								@if($errors->has('meta_title'))
								<span class="help-block">{{ $errors->first('meta_title') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Meta Description (160 Chr)</b></label>
							<div class="col-sm-8">
								<textarea type="text" name="meta_descriptions" id="meta_descriptions" class="form-control" rows="4"></textarea>
								@if($errors->has('meta_descriptions'))
								<span class="help-block">{{ $errors->first('meta_descriptions') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Meta Keywords</b></label>
							<div class="col-sm-8">
								<input type="text" name="meta_keywords" id="meta_keywords" class="form-control" autofocus placeholder="Comma separated value" />
								@if($errors->has('meta_keywords'))
								<span class="help-block">{{ $errors->first('meta_keywords') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Meta Photo (995x560)</b></label>
							</div>
							<div class="col-sm-8">
								<div class="fileupload fileupload-exists" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail">
										<img id="meta_image" alt="meta_image" class="img-responsive" style="max-height: 100px;"/>
									</span>
									<span>
										<label class="btn btn-primary btn-rounded btn-file btn-sm">
											<span class="fileupload-new">
												<i class="fa fa-picture-o"></i> Select Photo
											</span>
											<span class="fileupload-exists">
												<i class="fa fa-picture-o"></i> Change
											</span>
											<input type="file" name="meta_image">
										</label>
										<a href="" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>


						<div class="form-group">
							<label class="col-sm-3 control-label"><b>No-Index</b></label>
							<div class="col-sm-8">
								<select class="form-control" name="noindex" id="noindex">
									<option value="">No</option>
									<option value="1">Yes</option>
								</select>
								@if($errors->has('noindex'))
								<span class="help-block">{{ $errors->first('noindex') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Exclude XML</b></label>
							<div class="col-sm-8">
								<select class="form-control" name="exclude_xml" id="exclude_xml">
									<option value="">No</option>
									<option value="1">Yes</option>
								</select>
								@if($errors->has('exclude_xml'))
								<span class="help-block">{{ $errors->first('exclude_xml') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Status *</b></label>
							<div class="col-sm-8">
								<select class="form-control" name="status" id="status" required="">
									<option value="1">Active</option>
									<option value="2">Inactive</option>
									<option value="-1">Remove</option>
								</select>
								@if($errors->has('status'))
								<span class="help-block">{{ $errors->first('status') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-8  col-sm-offset-3">
								<button type="submit" class="btn btn-primary btn-block">Save</button>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection


@push('bottom-scripts')
<script src="{{asset('assets/js/plugins/text-editor.min.js?v=1.10')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-fileupload.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-tagsinput.min.js')}}"></script>

<script type="text/javascript">
	$('.text-editor').summernote({
		placeholder: '',
		height: 200,
		toolbar: [
		["style", ["none"]],
		["font", ["bold", "underline", "clear"]],
		["color", ["color"]],
		["para", ["ul", "ol", "paragraph"]],
		["view", ["fullscreen", "codeview", "help"]]
		],
	});
</script>

<script type="text/javascript">
	$('.delete').on("click", function (e) {
		e.preventDefault();
		var choice = confirm($(this).attr('data-confirm'));
		if (choice) {
			window.location.href = $(this).attr('href');
		}
	});
</script>

<script type="text/javascript">
	$(".openeditModal").click(function(){
		var id = $(this).data('id');
		var topic_title = $(this).data('topic-title');
		var topic_alternate_title = $(this).data('topic-alternate-title');
		var topic_slug = $(this).data('topic-slug');
		var topic_photo = $(this).data('topic-photo');
		var topic_descriptions = $(this).data('topic-descriptions');
		var meta_title = $(this).data('meta-title');
		var meta_image = $(this).data('meta-image');
		var meta_descriptions = $(this).data('meta-descriptions');
		var meta_keywords = $(this).data('meta-keywords');
		var noindex = $(this).data('noindex');
		var exclude_xml = $(this).data('excludexml');
		var status = $(this).data('status');

		$('.modal-body #id').val(id);
		$('.modal-body #topic_title').val(topic_title);
		$('.modal-body #topic_alternate_title').val(topic_alternate_title);
		$('.modal-body #topic_slug').val(topic_slug);
		$('.modal-body #topic_descriptions').summernote('code', topic_descriptions);
		$('.modal-body #meta_title').val(meta_title);
		$('.modal-body #meta_descriptions').val(meta_descriptions);
		$('.modal-body #meta_keywords').val(meta_keywords);
		$('.modal-body #noindex').val(noindex);
		$('.modal-body #exclude_xml').val(exclude_xml);
		$('.modal-body #status').val(status);

		if(topic_photo != ''){
			var topicphoto = '{{env('UploadsLink')}}/uploads/topics'+'/'+topic_photo;
			$(".modal-body #topic_photo").attr('src', topicphoto);
		}else{
			var topicphoto = '{{env('UploadsLink')}}/uploads/topics/default.jpg';
			$(".modal-body #topic_photo").attr('src', topicphoto);
		}

		if(meta_image != ''){
			var metaimage = '{{env('UploadsLink')}}/uploads/topics'+'/'+meta_image;
			$(".modal-body #meta_image").attr('src', metaimage);
		}else{
			var metaimage = '{{env('UploadsLink')}}/uploads/topics/default.jpg';
			$(".modal-body #topic_photo").attr('src', metaimage);
		}

	});
</script>

<!-- pagination -->
<script type="text/javascript">
	$('.paginationAmount').on('change',function(){
		var paginationAmount = $('.paginationAmount').val();
		var existingPaginationAmount = '{{!empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : ''}}';

		var refreshUrl = '{{Request::fullUrl()}}';
		if(existingPaginationAmount != ''){
			refreshUrl = refreshUrl.replace("paginationAmount="+existingPaginationAmount, "paginationAmount="+paginationAmount);
		}else{
			refreshUrl = refreshUrl+'?paginationAmount='+paginationAmount;
		}
		refreshUrl = refreshUrl.replaceAll("amp;", "");
		window.location = refreshUrl;
	})
</script>

<!-- drag and drop -->
<script src="{{asset('assets/vendors/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>
<script type="text/javascript">
	$('.bulkAction').change(function(){
		var bulkAction = $('.bulkAction').val();
		if(bulkAction == 'swapOrder'){
			$('.checkbox').find(':checkbox').attr('checked', 'checked');
			$('.dragAndDrop').sortable();
		}else{
			$('.checkbox').find(':checkbox').removeAttr('checked');
		}
	});
</script>

<script type="text/javascript">
	$('.topicTitle').on("change keyup paste", function(){
		var topicTitle = $('.topicTitle').val();
		var topicTitle = topicTitle.replaceAll(' ', '-');
		$('.topicSlug').val(topicTitle);
	});
	$('.editTopicTitle').on("change keyup paste", function(){
		var editTopicTitle = $('.editTopicTitle').val();
		var editTopicTitle = editTopicTitle.replaceAll(' ', '-');
		$('.editTopicSlug').val(editTopicTitle);
	});
</script>
@endpush

