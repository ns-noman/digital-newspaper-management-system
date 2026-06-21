@extends('layouts.app')
@section('title', 'Users')

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

		<section class="panel panel-default">
			<header class="panel-heading font-bold">Users
				<a href="javascript::void(0)" data-toggle="modal" data-target="#createModal" class="btn btn-success btn-xs pull-right"> <i class="fa fa-plus-circle"></i> New User</a>
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
						<input name="name" type="text" class="input-sm form-control" value="{{!empty($_GET['name']) ? $_GET['name'] : ''}}" placeholder="Name" autocomplete="off" />
					</div>
					<div class="col-sm-1 m-b-xs" style="padding-left: 0px">
						<button class="btn btn-sm btn-default btn-block">Search</button>
					</div>
				</form>
			</div>

			<form method="post" action="{{url('users/bulkupdate')}}">
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
								<th>Name</th>
								<th class="text-center">Photo</th>
								<th>Designation</th>
								<th>Department</th>
								<th>Role</th>
								<th>Joining</th>
								<th>Create</th>
								<th>Update</th>
								<th>Status</th>
								<th width="100">Action</th>
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
								<td><b>{!! $list->name !!}</b><br>{!! $list->email !!}</td>
								<td class="text-center">
									@if(!empty($list->image))
									<img src="{!! env('UploadsLink').'uploads/users/'.$list->image !!}" class="img-circle" width="30px" height="30px">
									@else
									<img src="{!! env('UploadsLink').'uploads/users/default.png' !!}" class="img-circle" width="30px" height="30px">
									@endif
								</td>
								<td>{!! $list->designation !!}</td>
								<td>{!! $list->department !!}</td>
								<td>{{ucfirst($list->role)}}</td>
								<td>{!! !empty($list->joining_date) ? date('d M, Y', strtotime($list->joining_date)) : Null !!}</td>
								<td>{!! !empty($list->created_by) ? $list->createdBy->name.'<br>' : Null !!}{{date('d M Y, H:i A', strtotime($list->created_at))}}</td>
								<td>
									@if(!empty($list->updated_by))
									{!! !empty($list->updated_by) ? $list->updatedBy->name.'<br>' : Null !!}{{date('d M Y, H:i A', strtotime($list->updated_at))}}
									@endif
								</td>
								<td>{{$list->status == 1 ? 'Active' : 'Inactive'}}</td>
								<td>
									<button type="button" class="btn btn-primary btn-xs editModal" data-toggle="modal" data-target="#editModal" data-id="{{$list->id}}" data-name="{{$list->name}}" data-email="{{$list->email}}" data-role="{{$list->role}}" data-publish-permission="{{$list->publish_permission}}" data-image="{{$list->image}}" data-mobile="{{$list->mobile}}" data-designation="{{$list->designation}}" data-department="{{$list->department}}" data-joining-date="{{$list->joining_date}}" data-status="{{$list->status}}"><i class="fa fa-edit" title="Edit"></i></button>
									<a href="{{url('users/delete/'.$list->id)}}" class="btn btn-danger btn-xs delete" onclick="return confirm('Are you sure you want to  delete?');"><i class="fa fa-trash"></i></a>
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
	<div class="modal-dialog">
		<div class="content">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New User</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{url('users/store')}}" enctype="multipart/form-data">
						{{csrf_field()}}

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Name *</b></label>
							</div>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="name" required />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Email *</b></label>
							</div>
							<div class="col-sm-7">
								<input type="email" class="form-control" name="email" required />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Password *</b></label>
							</div>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="password" required="" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Designation</b></label>
							</div>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="designation" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Department</b></label>
							</div>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="department" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Mobile</b></label>
							</div>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="mobile" />
							</div>
						</div>

						<div class="form-group"> 
							<label class="col-sm-3 col-sm-offset-1"><b>Joining Date</b></label> 
							<div class="col-sm-7">                               
								<div class="input-group date form-date" data-date-format="yyyy-mm-dd"> 
									<input type="text" name="joining_date" class="form-control"> 
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
								</div> 
							</div> 
						</div>

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Role *</b></label>
							</div>
							<div class="col-sm-7">
								<select class="form-control" name="role" required="">
									<option value="admin">Admin</option>
									<option value="editor">Editor</option>
									<option value="uploader">Uploader</option>
								</select>
							</div>
						</div>

						<!-- <div class="form-group">
							<label class="col-sm-3 col-sm-offset-1"><b>Publish Permission</b></label>
							<div class="col-sm-7">
								<label class="switch">
									<input type="checkbox" name="publish_permission"> <span></span> 
								</label>
							</div>
						</div> -->

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Photo (150x150)</b></label>
							</div>
							<div class="col-sm-7">
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
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Status *</b></label>
							</div>
							<div class="col-sm-7">
								<select class="form-control" name="status" id="status" required >
									<option value="1">Active</option>
									<option value="2">Inactive</option>
									<option value="-1">Remove</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-7 col-sm-offset-4">
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
					<h4 class="modal-title">Edit User</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{url('users/update')}} " enctype="multipart/form-data">
						{{csrf_field()}}
						<input type="hidden" id="id" name="id">

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Name *</b></label>
							</div>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="name" id="name" required />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Email *</b></label>
							</div>
							<div class="col-sm-7">
								<input type="email" class="form-control" name="email" id="email" required />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Password</b></label>
							</div>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="password" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Designation</b></label>
							</div>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="designation" id="designation" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Department</b></label>
							</div>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="department" id="department" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Mobile</b></label>
							</div>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="mobile" id="mobile" />
							</div>
						</div>

						<div class="form-group"> 
							<label class="col-sm-3 col-sm-offset-1"><b>Joining Date</b></label> 
							<div class="col-sm-7">                               
								<div class="input-group date form-date" data-date-format="yyyy-mm-dd"> 
									<input type="text" name="joining_date" id="joining_date" class="form-control"> 
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
								</div> 
							</div> 
						</div>

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Role *</b></label>
							</div>
							<div class="col-sm-7">
								<select class="form-control" name="role" id="role" required="">
									<option value="admin">Admin</option>
									<option value="editor">Editor</option>
									<option value="uploader">Uploader</option>
								</select>
							</div>
						</div>

						<!-- <div class="form-group">
							<label class="col-sm-3 col-sm-offset-1"><b>Publish Permission</b></label>
							<div class="col-sm-7">
								<label class="switch">
									<input type="checkbox" name="publish_permission"> <span></span> 
								</label>
							</div>
						</div> -->

						<div class="form-group">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Photo (150x150)</b></label>
							</div>
							<div class="col-sm-7">
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
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label"><b>Status *</b></label>
							</div>
							<div class="col-sm-7">
								<select class="form-control" name="status" id="status" required >
									<option value="1">Active</option>
									<option value="2">Inactive</option>
									<option value="-1">Remove</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-7 col-sm-offset-4">
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
		var name = $(this).data('name');
		var email = $(this).data('email');
		var designation = $(this).data('designation');
		var department = $(this).data('department');
		var mobile = $(this).data('mobile');
		var joining_date = $(this).data('joining-date');
		var role = $(this).data('role');
		var image = $(this).data('image');
		var status = $(this).data('status');

		$('.modal-body #id').val(id);
		$('.modal-body #name').val(name);
		$('.modal-body #email').val(email);
		$('.modal-body #designation').val(designation);
		$('.modal-body #department').val(department);
		$('.modal-body #mobile').val(mobile);
		$('.modal-body #joining_date').val(joining_date);
		$('.modal-body #role').val(role);
		$('.modal-body #status').val(status);

		if(image != ''){
			var image = '{{env('UploadsLink')}}uploads/users/'+image;
			$(".modal-body #image").attr('src', image);
		}else{
			var image = '{{env('UploadsLink')}}uploads/users/default.png';
			$(".modal-body #image").attr('src', image);
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
@endpush

