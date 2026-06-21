@extends('layouts.app')
@section('title', 'Events')

@push('top-scripts')
<link href="{{asset('assets/css/jasny-bootstrap.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/css/bootstrap-fileupload.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" /> 
<link href="{{asset('assets/vendors/select2/css/select2.min.css')}}" rel="stylesheet">
<style type="text/css">
	.select2-container{
		width: 100% !important;
	}
</style>
@endpush

@section('content')
<section class="vbox">
	<section class="scrollable padder">
		<div class="m-b-md"></div>

		@if(session('successMessage'))
		<div class="alert alert-success text-center alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>{{session('successMessage')}} </strong>
		</div>
		@endif

		@if(session('errorMessage'))
		<div class="alert alert-danger text-center alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>{{session('errorMessage')}} </strong>
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
			<header class="panel-heading font-bold">Events
				<a href="javascript::void(0)" data-toggle="modal" data-target="#createModal" class="btn btn-success btn-xs pull-right"> <i class="fa fa-plus-circle"></i> New Event</a>
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
						<input name="title" type="text" class="input-sm form-control" value="{{!empty($_GET['title']) ? $_GET['title'] : ''}}" placeholder="Title" autocomplete="off" />
					</div>
					<div class="col-sm-2 m-b-xs paddingL0">
						<select class="input-sm form-control loadTopics" name="topic_id">
							<option value="">-Select Topic-</option>
						</select>
					</div>
					<div class="col-sm-1 m-b-xs paddingL0">
						<button class="btn btn-sm btn-default btn-block">Search</button>
					</div>
				</form>
			</div>

			<form method="post" action="{{route('Events Bulk Update')}}">
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
								<th>Topic</th>
								<th>Small Banner</th>
								<th>Large Banner</th>
								<th>No Of Post</th>
								<th>Type</th>
								<th>Create</th>
								<th>Update</th>
								<th>Status</th>
								<th width="120">Action</th>
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
									<a style="color: #177bbb" href="{!! !empty($list->topic_id) ? env('WEBSITE').'news-issue/'.$list->topicInfo->topic_slug : '#' !!}" target="_blank">{!! $list->title !!}</a>
									<p class="marginB0"><u>Slug:</u> {!! $list->slug !!}</p>
								</td>
								<td>{!! !empty($list->topic_id) ? $list->topicInfo->topic_title : '' !!}</td>
								<td width="80">
									@if(!empty($list->small_banner))
									<img src="{!! env('UploadsLink').'uploads/events/'.$list->small_banner !!}" style="width: 80px">
									@endif
								</td>
								<td width="80">
									@if(!empty($list->large_banner))
									<img src="{!! env('UploadsLink').'uploads/events/'.$list->large_banner !!}" style="width: 80px">
									@endif
								</td>
								<td>{!! $list->no_of_article !!}</td>
								<td>Event {!! $list->type !!}</td>
								<td>{{$list->createdBy->name}}<br>{{$list->created_at}}</td>
								<td>@if(!empty($list->updated_at)){{$list->updatedBy->name}}<br>{{$list->updated_at}}@endif</td>
								<td>{{$list->status == 1 ? 'Active' : 'Inactive'}}</td>
								<td>
									<a title="News List" href="{{route('Events News', $list->id)}}" class="btn btn-success btn-xs"><i class="fa fa-th-list"></i></a>
									<button type="button" class="btn btn-primary btn-xs editModal" data-toggle="modal" data-target="#editModal" data-id="{{$list->id}}" data-title="{{$list->title}}" data-slug="{{$list->slug}}" data-topic-id="{{$list->topic_id}}" data-topic-title="{{$list->topicInfo->topic_title}}" data-no-of-article="{{$list->no_of_article}}" data-small-banner="{{$list->small_banner}}" data-large-banner="{{$list->large_banner}}" data-type="{{$list->type}}" data-status="{{$list->status}}"><i class="fa fa-edit" title="Edit"></i></button>
									<a href="{{route('Events Delete', $list->id)}}" class="btn btn-danger btn-xs delete" onclick="return confirm('Are you sure you want to  delete?');"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
							@endforeach
							@else
							<tr><td colspan="12" class="text-center">No Data</td></tr>
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
	<div class="modal-dialog">
		<div class="content">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Event</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{route('Events Store')}}" enctype="multipart/form-data">
						{{csrf_field()}}

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Title *</b></label></label> 
							<div class="col-sm-8">
								<input type="text" class="form-control" name="title" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Url Slug *</b></label></label> 
							<div class="col-sm-8">
								<input type="text" class="form-control" name="slug" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Topic *</b></label></label>
							<div class="col-sm-8 select234">
								<select class="form-control loadTopics" name="topic_id" required="">
									<option value="">-Select Topic-</option>
								</select>
								@if($errors->has('topic_id'))
								<span class="help-block">{{ $errors->first('topic_id') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>No Of Post *</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="no_of_article" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Type *</b></label></label>
							<div class="col-sm-8">
								<select class="form-control" name="type" required="">
									<option value="1">Event 1</option>
									<option value="2">Event 2</option>
									<option value="3">Event 3</option>
								</select>
								@if($errors->has('type'))
								<span class="help-block">{{ $errors->first('type') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Small Banner (800x200)</b></label></label>
							<div class="col-sm-8">
								<div class="fileupload fileupload-new" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px;">
									</span>
									<span>
										<label class="btn btn-primary btn-rounded btn-file btn-sm">
											<span class="fileupload-new">
												<i class="fa fa-picture-o"></i> Select Image
											</span>
											<span class="fileupload-exists">
												<i class="fa fa-picture-o"></i> Change
											</span>
											<input type="file" name="small_banner" value="">
										</label>
										<a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Large Banner (1600x200)</b></label></label>
							<div class="col-sm-8">
								<div class="fileupload fileupload-new" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px">
									</span>
									<span>
										<label class="btn btn-primary btn-rounded btn-file btn-sm">
											<span class="fileupload-new">
												<i class="fa fa-picture-o"></i> Select Image
											</span>
											<span class="fileupload-exists">
												<i class="fa fa-picture-o"></i> Change
											</span>
											<input type="file" name="large_banner" value="">
										</label>
										<a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Status *</b></label></label>
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
	<div class="modal-dialog">
		<div class="content">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Event</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{route('Events Update')}} " enctype="multipart/form-data">
						{{csrf_field()}}
						<input type="hidden" id="id" name="id">

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Title *</b></label></label> 
							<div class="col-sm-8">
								<input type="text" class="form-control" name="title" id="title" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Url Slug *</b></label></label> 
							<div class="col-sm-8">
								<input type="text" class="form-control" name="slug" id="slug" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Topic *</b></label></label>
							<div class="col-sm-8 select234">
								<select class="form-control loadTopics" name="topic_id" id="topic_id" required="">
									<option value="">-Select Topic-</option>
								</select>
								@if($errors->has('topic_id'))
								<span class="help-block">{{ $errors->first('topic_id') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>No Of Post *</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="no_of_article" id="no_of_article" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Type *</b></label></label>
							<div class="col-sm-8">
								<select class="form-control" name="type" id="type" required="">
									<option value="1">Event 1</option>
									<option value="2">Event 2</option>
									<option value="3">Event 3</option>
								</select>
								@if($errors->has('type'))
								<span class="help-block">{{ $errors->first('type') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Small Banner (800x200)</b></label></label>
							<div class="col-sm-9">
								<div class="fileupload fileupload-exists" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail">
										<img id="small_banner" alt="image" class="img-responsive" style="max-width: 150px;"/>
									</span>
									<span>
										<label class="btn btn-primary btn-rounded btn-file btn-sm">
											<span class="fileupload-new">
												<i class="fa fa-picture-o"></i> Select Photo
											</span>
											<span class="fileupload-exists">
												<i class="fa fa-picture-o"></i> Change
											</span>
											<input type="file" name="small_banner">
										</label>
										<a href="" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Large Banner (1600x200)</b></label></label>
							<div class="col-sm-9">
								<div class="fileupload fileupload-exists" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail">
										<img id="large_banner" alt="image" class="img-responsive" style="max-width: 150px;"/>
									</span>
									<span>
										<label class="btn btn-primary btn-rounded btn-file btn-sm">
											<span class="fileupload-new">
												<i class="fa fa-picture-o"></i> Select Photo
											</span>
											<span class="fileupload-exists">
												<i class="fa fa-picture-o"></i> Change
											</span>
											<input type="file" name="large_banner">
										</label>
										<a href="" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Status *</b></label></label>
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

@endsection


@push('bottom-scripts')
<script src="{{asset('assets/js/plugins/bootstrap-fileupload.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-datetimepicker.min.js')}}" ></script>

<script type="text/javascript">
	$('.form-date').datetimepicker({
		todayBtn:  1,
		autoclose: 1,
		minView: 2
	});
</script>

<script type="text/javascript">
	$(".editModal").click(function(){
		var id = $(this).data('id');
		var title = $(this).data('title');
		var slug = $(this).data('slug');
		var topic_id = $(this).data('topic-id');
		var topic_title = $(this).data('topic-title');
		var small_banner = $(this).data('small-banner');
		var large_banner = $(this).data('large-banner');
		var no_of_article = $(this).data('no-of-article');
		var type = $(this).data('type');
		var status = $(this).data('status');

		$('.modal-body #id').val(id);
		$('.modal-body #title').val(title);
		$('.modal-body #slug').val(slug);
		$('.modal-body #no_of_article').val(no_of_article);
		$('.modal-body #type').val(type);
		$('.modal-body #status').val(status);
		$('.modal-body #topic_id').append('<option value="'+topic_id+'" selected="">'+topic_title+'</option>').trigger('change');


		if(small_banner){
			var small_banner = '{{env('UploadsLink')}}uploads/events/'+small_banner;
			$(".modal-body #small_banner").attr('src', small_banner);
		}

		if(large_banner){
			var large_banner = '{{env('UploadsLink')}}uploads/events/'+large_banner;
			$(".modal-body #large_banner").attr('src', large_banner);
		}

	});
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

