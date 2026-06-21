@extends('layouts.app')
@section('title', 'Important Links')

@push('top-scripts')
<link href="{{asset('assets/css/bootstrap-fileupload.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/bootstrap-tagsinput.css')}}" rel="stylesheet">
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
		<div class="alert alert-danger text-center alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>{{session('error_message')}} </strong>
		</div>
		@endif

		<section class="panel panel-default">
			<header class="panel-heading font-bold">Important Links
				<a href="javascript::void(0)" data-toggle="modal" data-target="#createModal" class="btn btn-success btn-xs pull-right"> <i class="fa fa-plus-circle"></i> New Link</a>
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
						<select class="input-sm form-control" name="important_link_category_id">
							<option value="">-Select Link Category-</option>
							@if(!empty($linkCategories) && (count($linkCategories)>0))
							@foreach($linkCategories as $key => $linkCategory)
							<option {{!empty($_GET['important_link_category_id']) && $_GET['important_link_category_id'] == $linkCategory->id ? 'selected' : ''}} value="{!! $linkCategory->id !!}">{!! $linkCategory->title !!}</option>
							@endforeach
							@endif
						</select>
					</div>
					<div class="col-sm-2 m-b-xs paddingL0">
						<select class="input-sm form-control" name="type">
							<option value="">-Select Type-</option>
							<option {{!empty($_GET['type']) && $_GET['type'] == 1 ? 'selected' : ''}} value="1">Newspaper</option>
							<option {{!empty($_GET['type']) && $_GET['type'] == 2 ? 'selected' : ''}} value="2">Social Media</option>
						</select>
					</div>
					<div class="col-sm-1 m-b-xs paddingL0">
						<button class="btn btn-sm btn-default btn-block">Search</button>
					</div>
				</form>
			</div>

			<form method="post" action="{{route('ImportantLinks Bulk Update')}}">
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
								<th>Link Category</th>
								<th>Type</th>	
								<!-- <th>Menubar Show</th>	 -->
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
								<td><a style="color: #337ab7 !important;" href="{!! $list->link!!}" target="_blank">{{$list->title}}</a></td>
								<td>
									@if(!empty($list->photo))
									<img src="{{env('UploadsLink').'uploads/links/'.$list->photo}}" width="80px" class="img-responsive">
									@endif
								</td>
								<td>{{!empty($list->important_link_category_id) ? $list->importantLinkCategoryInfo->title : ''}}</td>
								<td>{{$list->type == 1 ? 'Newspaper' : ($list->type == 2 ? 'Social Media' : '')}}</td>
								<!-- <td>{{$list->menubar == 1 ? 'Yes' : ''}}</td> -->
								<td>{{$list->status == 1 ? 'Active' : 'Inactive'}}</td>
								<td>
									<button type="button" class="btn btn-primary btn-xs openeditModal" data-toggle="modal" data-target="#editModal" data-id="{{$list->id}}" data-title="{{$list->title}}" data-photo="{{$list->photo}}" data-link="{{$list->link}}" data-type="{{$list->type}}" data-menubar="{{$list->menubar}}" data-category="{{$list->important_link_category_id}}" data-status="{{$list->status}}"><i class="fa fa-edit" title="Edit"></i></button>
									<a href="{{route('ImportantLinks Delete', $list->id)}}" class="btn btn-danger btn-xs delete" onclick="return confirm('Are you sure you want to  delete?');"><i class="fa fa-trash"></i></a>
								</td>

							</tr>
							@endforeach
							@else
							<tr><td colspan="9" class="text-center">No Data</td></tr>
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
	<div class="modal-dialog modal-md">
		<div class="content">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Link</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{route('ImportantLinks Store')}}" enctype="multipart/form-data">
						{{csrf_field()}}

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Title *</b></label>
							<div class="col-sm-8">
								<input type="text" name="title" class="form-control" autofocus required />
								@if($errors->has('title'))
								<span class="help-block">{{ $errors->first('title') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Link *</b></label>
							<div class="col-sm-8">
								<input type="text" name="link" class="form-control" autofocus required />
								@if($errors->has('link'))
								<span class="help-block">{{ $errors->first('link') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Photo (300x100)</b></label>
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
											<input type="file" name="photo" value="">
										</label>
										<a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Link Category</b></label>
							<div class="col-sm-8">
								<select class="form-control" name="important_link_category_id">
									<option value="">-Select Link Category-</option>
									@if(!empty($linkCategories) && (count($linkCategories)>0))
									@foreach($linkCategories as $key => $linkCategory)
									<option value="{!! $linkCategory->id !!}">{!! $linkCategory->title !!}</option>
									@endforeach
									@endif
								</select>
								@if($errors->has('important_link_category_id'))
								<span class="help-block">{{ $errors->first('important_link_category_id') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Type</b></label>
							<div class="col-sm-8">
								<select class="form-control" name="type">
									<option value="">-Select Type-</option>
									<option value="1">Newspaper</option>
									<option value="2">Social Media</option>
								</select>
								@if($errors->has('type'))
								<span class="help-block">{{ $errors->first('type') }}</span>
								@endif
							</div>
						</div>

						<!-- <div class="form-group">
							<label class="col-sm-3 control-label"><b>Menubar Show</b></label>
							<div class="col-sm-8">
								<select class="form-control" name="menubar">
									<option value="">No</option>
									<option value="1">Yes</option>
								</select>
								@if($errors->has('menubar'))
								<span class="help-block">{{ $errors->first('menubar') }}</span>
								@endif
							</div>
						</div> -->
						
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
	<div class="modal-dialog modal-md">
		<div class="content">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Link</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{route('ImportantLinks Update')}} " enctype="multipart/form-data">
						{{csrf_field()}}
						<input type="hidden" id="id" name="id">

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Title *</b></label>
							<div class="col-sm-8">
								<input type="text" name="title" id="title" class="form-control" autofocus required />
								@if($errors->has('title'))
								<span class="help-block">{{ $errors->first('title') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Link *</b></label>
							<div class="col-sm-8">
								<input type="text" name="link" id="link" class="form-control" autofocus required />
								@if($errors->has('link'))
								<span class="help-block">{{ $errors->first('link') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Photo (300x100) *</b></label>
							</div>
							<div class="col-sm-8">
								<div class="fileupload fileupload-exists" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail">
										<img id="photo" alt="photo" class="img-responsive" style="max-width: 150px;"/>
									</span>
									<span>
										<label class="btn btn-primary btn-rounded btn-file btn-sm">
											<span class="fileupload-new">
												<i class="fa fa-picture-o"></i> Select Photo
											</span>
											<span class="fileupload-exists">
												<i class="fa fa-picture-o"></i> Change
											</span>
											<input type="file" name="photo">
										</label>
										<a href="" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Link Category</b></label>
							<div class="col-sm-8">
								<select class="form-control" name="important_link_category_id" id="category">
									<option value="">-Select Link Category-</option>
									@if(!empty($linkCategories) && (count($linkCategories)>0))
									@foreach($linkCategories as $key => $linkCategory)
									<option value="{!! $linkCategory->id !!}">{!! $linkCategory->title !!}</option>
									@endforeach
									@endif
								</select>
								@if($errors->has('important_link_category_id'))
								<span class="help-block">{{ $errors->first('important_link_category_id') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Type</b></label>
							<div class="col-sm-8">
								<select class="form-control" name="type" id="type">
									<option value="">-Select Type-</option>
									<option value="1">Newspaper</option>
									<option value="2">Social Media</option>
								</select>
								@if($errors->has('type'))
								<span class="help-block">{{ $errors->first('type') }}</span>
								@endif
							</div>
						</div>

						<!-- <div class="form-group">
							<label class="col-sm-3 control-label"><b>Menubar Show</b></label>
							<div class="col-sm-8">
								<select class="form-control" name="menubar" id="menubar">
									<option value="">No</option>
									<option value="1">Yes</option>
								</select>
								@if($errors->has('menubar'))
								<span class="help-block">{{ $errors->first('menubar') }}</span>
								@endif
							</div>
						</div> -->
						
						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Status *</b></label>
							<div class="col-sm-8">
								<select class="form-control" name="status" id="status" required="">
									<option value="1">Active</option>
									<option value="2">Inactive</option>
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
<script src="{{asset('assets/js/plugins/bootstrap-fileupload.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-tagsinput.min.js')}}"></script>

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
		var title = $(this).data('title');
		var link = $(this).data('link');
		var category = $(this).data('category');
		var type = $(this).data('type');
		var menubar = $(this).data('menubar');
		var status = $(this).data('status');
		var photo = $(this).data('photo');

		$('.modal-body #id').val(id);
		$('.modal-body #title').val(title);
		$('.modal-body #link').val(link);
		$('.modal-body #category').val(category);
		$('.modal-body #type').val(type);
		$('.modal-body #menubar').val(menubar);
		$('.modal-body #status').val(status);

		if(photo){
			var authorPhoto = '{{env('UploadsLink')}}/uploads/links'+'/'+photo;
			$(".modal-body #photo").attr('src', authorPhoto);
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
@endpush

