@extends('layouts.app')
@section('title', 'Categories')

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
			<header class="panel-heading font-bold">Categories
				<a href="javascript::void(0)" data-toggle="modal" data-target="#createModal" class="btn btn-success btn-xs pull-right"> <i class="fa fa-plus-circle"></i> New Category</a>
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
						<input name="display_name" type="text" class="input-sm form-control" value="{{!empty($_GET['display_name']) ? $_GET['display_name'] : ''}}" placeholder="Display Name" autocomplete="off" />
					</div>
					<div class="col-sm-2 m-b-xs paddingL0">
						<input name="title" type="text" class="input-sm form-control" value="{{!empty($_GET['title']) ? $_GET['title'] : ''}}" placeholder="Title" autocomplete="off" />
					</div>
					<div class="col-sm-1 m-b-xs paddingL0">
						<button class="btn btn-sm btn-default btn-block">Search</button>
					</div>
				</form>
			</div>

			<form method="post" action="{{route('Categories Bulk Update')}}">
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
								<th>Category Name</th>
								<th>Sub-category Name</th>
								<th>Title</th>
								<th>Parent</th>
								<th class="text-center">Header</th>
								<th class="text-center">Menubar</th>
								<th>Status</th>
								<th class="text-center" width="90">Action</th>
							</tr>
						</thead>
						<tbody class="dragAndDrop">
							@if(!empty($lists) && (count($lists)>0))
							@foreach($lists as $key => $list)
							<tr>
								<td>
									<label class="checkbox m-l m-t-none m-b-none i-checks selectParentCategory" data-parent="{{$list->id}}" data-type="checked">
										<input type="checkbox" name="ids[]" value="{{$list->id}},{{$list->order_id}}"><i></i>
									</label>
								</td>
								<td>{!! isset($_GET['page']) && !empty($_GET['page']) ? (($_GET['page']-1)*10)+($key+1) : $key + 1 !!}</td>
								<td>{{$list->display_name}}</td>
								<td></td>
								<td>{{$list->title}}</td>
								<td></td>
								<td class="text-center">{!! $list->header_display == 1 ? 'Yes' : 'No' !!}</td>
								<td class="text-center">{!! $list->menubar_display == 1 ? 'Yes' : 'No' !!}</td>
								<td>{!! $list->status == 1 ? 'Active' : 'Inactive' !!}</td>
								<td class="text-center">
									<button type="button" class="btn btn-primary btn-xs editModal" data-toggle="modal" data-target="#editModal" data-id="{{$list->id}}" data-date="{{$list->poll_date}}" data-question="{{$list->question}}" data-image="{{$list->image}}" data-status="{{$list->status}}" data-yes-vote="{{$list->yes_vote}}" data-no-vote="{{$list->no_vote}}" data-no-opinion="{{$list->no_opinion}}"><i class="fa fa-edit" title="Edit"></i></button>
									<a href="{{url('polls/delete/'.$list->id)}}" class="btn btn-danger btn-xs delete" onclick="return confirm('Are you sure you want to  delete?');"><i class="fa fa-trash"></i></a>
								</td>
							</tr>

							@if(!empty($list->activeChildCategories) && (count($list->activeChildCategories)>0))
							@foreach($list->activeChildCategories as $key => $activeChildCategory)
							<tr>
								<td class="text-right" colspan="2">
									<label class="checkbox m-l m-t-none m-b-none i-checks chindCategory{{$list->id}}">
										<input type="checkbox" name="ids[]" value="{{$activeChildCategory->id}},{{$activeChildCategory->sub_hierarchy}}"><i></i>
									</label>
								</td>
								<td>{!! isset($_GET['page']) && !empty($_GET['page']) ? (($_GET['page']-1)*10)+($key+1) : $key + 1 !!}</td>
								<td>{{$activeChildCategory->display_name}}</td>
								<td>{{$activeChildCategory->title}}</td>
								<td>{{$activeChildCategory->parentInfo->display_name}}</td>
								<td class="text-center">{!! $activeChildCategory->header_display == 1 ? 'Yes' : 'No' !!}</td>
								<td class="text-center">{!! $activeChildCategory->menubar_display == 1 ? 'Yes' : 'No' !!}</td>
								<td>{!! $activeChildCategory->status == 1 ? 'Active' : 'Inactive' !!}</td>
								<td class="text-center">
									<button type="button" class="btn btn-primary btn-xs editModal" data-toggle="modal" data-target="#editModal" data-id="{{$activeChildCategory->id}}" data-date="{{$activeChildCategory->poll_date}}" data-question="{{$activeChildCategory->question}}" data-image="{{$activeChildCategory->image}}" data-status="{{$activeChildCategory->status}}" data-yes-vote="{{$activeChildCategory->yes_vote}}" data-no-vote="{{$activeChildCategory->no_vote}}" data-no-opinion="{{$activeChildCategory->no_opinion}}"><i class="fa fa-edit" title="Edit"></i></button>
									<a href="{{url('polls/delete/'.$activeChildCategory->id)}}" class="btn btn-danger btn-xs delete" onclick="return confirm('Are you sure you want to  delete?');"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
							@endforeach
							@endif


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
								<option value="swapOrderChild">Sub Category Swap Order</option>
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
					<h4 class="modal-title">Add New Poll</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{url('polls/store')}}" enctype="multipart/form-data">
						{{csrf_field()}}

						<div class="form-group"> 
							<label class="col-sm-3 text-right"><b>Poll Date *</b></label> 
							<div class="col-sm-8">                               
								<div class="input-group date form-date" data-date-format="yyyy-mm-dd"> 
									<input type="text" name="poll_date" class="form-control" required> 
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
								</div> 
							</div> 
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><b>Question *</b></label> 
							<div class="col-sm-8">
								<textarea class="form-control" rows="4" name="question" required></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><b>Image (995x560)</b></label>
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
											<input type="file" name="image" value="">
										</label>
										<a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><b>Status *</b></label>
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

						<hr>

						<div class="form-group"> 
							<label class="col-sm-3 text-right"><b>Yes Vote</b></label> 
							<div class="col-sm-8">                               
								<input type="number" name="yes_vote" min="0" value="0" class="form-control" required> 
							</div> 
						</div>

						<div class="form-group"> 
							<label class="col-sm-3 text-right"><b>No Vote</b></label> 
							<div class="col-sm-8">                               
								<input type="number" name="no_vote" min="0" value="0" class="form-control" required> 
							</div> 
						</div>

						<div class="form-group"> 
							<label class="col-sm-3 text-right"><b>No Opinion</b></label> 
							<div class="col-sm-8">                               
								<input type="number" name="no_opinion" min="0" value="0" class="form-control" required> 
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
					<h4 class="modal-title">Edit Poll</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{url('polls/update')}} " enctype="multipart/form-data">
						{{csrf_field()}}
						<input type="hidden" id="id" name="id">

						<div class="form-group"> 
							<label class="col-sm-3 text-right"><b>Poll Date *</b></label> 
							<div class="col-sm-8">                               
								<div class="input-group date form-date" data-date-format="yyyy-mm-dd"> 
									<input type="text" name="poll_date" id="poll_date" class="form-control" required> 
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
								</div> 
							</div> 
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><b>Question *</b></label> 
							<div class="col-sm-8">
								<textarea class="form-control" rows="4" name="question" id="question" required></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><b>Image (995x560)</b></label>
							<div class="col-sm-9">
								<div class="fileupload fileupload-exists" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail">
										<img id="image" alt="image" class="img-responsive" style="max-height: 100px;"/>
									</span>
									<span>
										<label class="btn btn-primary btn-rounded btn-file btn-sm">
											<span class="fileupload-new">
												<i class="fa fa-picture-o"></i> Select Photo
											</span>
											<span class="fileupload-exists">
												<i class="fa fa-picture-o"></i> Change
											</span>
											<input type="file" name="image">
										</label>
										<a href="" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><b>Status *</b></label>
							<div class="col-sm-8">
								<select class="form-control" name="status" id="status" required="">
									<option value="1">Active</option>
									<option value="2">Inactive</option>
									<option value="-1">Remove</option>
								</select>
							</div>
						</div>

						<hr>

						<div class="form-group"> 
							<label class="col-sm-3 text-right"><b>Yes Vote</b></label> 
							<div class="col-sm-8">                               
								<input type="number" name="yes_vote" id="yes_vote" min="0" value="0" class="form-control" required> 
							</div> 
						</div>

						<div class="form-group"> 
							<label class="col-sm-3 text-right"><b>No Vote</b></label> 
							<div class="col-sm-8">                               
								<input type="number" name="no_vote" id="no_vote" min="0" value="0" class="form-control" required> 
							</div> 
						</div>

						<div class="form-group"> 
							<label class="col-sm-3 text-right"><b>No Opinion</b></label> 
							<div class="col-sm-8">                               
								<input type="number" name="no_opinion" id="no_opinion" min="0" value="0" class="form-control" required> 
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
		var poll_date = $(this).data('date');
		var question = $(this).data('question');
		var image = $(this).data('image');
		var status = $(this).data('status');
		var yes_vote = $(this).data('yes-vote');
		var no_vote = $(this).data('no-vote');
		var no_opinion = $(this).data('no-opinion');

		$('.modal-body #id').val(id);
		$('.modal-body #poll_date').val(poll_date);
		$('.modal-body #question').val(question);
		$('.modal-body #status').val(status);
		$('.modal-body #yes_vote').val(yes_vote);
		$('.modal-body #no_vote').val(no_vote);
		$('.modal-body #no_opinion').val(no_opinion);

		if(image){
			var image = '{{env('UploadsLink')}}uploads/polls/'+image;
			$(".modal-body #image").attr('src', image);
		}

	});
</script>

<!-- drag and drop -->
<script src="{{asset('assets/vendors/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>
<script type="text/javascript">
	$('.dragAndDrop').sortable();
	$('.bulkAction').change(function(){
		var bulkAction = $('.bulkAction').val();
		if(bulkAction == 'swapOrder'){
			$('.checkbox').find(':checkbox').attr('checked', 'checked');
		}else{
			$('.checkbox').find(':checkbox').removeAttr('checked');
		}
	});

	$('.selectParentCategory').change(function(){
		var parent = $(this).data('parent');
		var type = $(this).data('type');
		if(type == 'checked'){
			$('.selectParentCategory').attr('data-type', 'unchecked');
			$('.chindCategory'+parent).find(':checkbox').attr('checked', 'checked');
		}else{
			$('.selectParentCategory').attr('data-type', 'checked');
			$('.chindCategory'+parent).find(':checkbox').removeAttr('checked');
		}
	});
</script>
@endpush

