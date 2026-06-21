@extends('layouts.app')
@section('title', 'Advertisement Placements')

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
			<header class="panel-heading font-bold">Advertisement Placements
				<a href="javascript::void(0)" data-toggle="modal" data-target="#createModal" class="btn btn-success btn-xs pull-right"> <i class="fa fa-plus-circle"></i> New Placement</a>
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
						<input name="placement_name" type="text" class="input-sm form-control" value="{{!empty($_GET['placement_name']) ? $_GET['placement_name'] : ''}}" placeholder="Placement Name" autocomplete="off" />
					</div>
					<div class="col-sm-1 m-b-xs" style="padding-left: 0px">
						<button class="btn btn-sm btn-default btn-block">Search</button>
					</div>
				</form>
			</div>

			<form method="post" action="{{route('Advertisements Placements Bulk Update')}}">
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
								<th>Placement Name</th>
								<th>Placement Size</th>
								<th>Placement Photo</th>
								<th>Create</th>
								<th>Update</th>
								<th>Status</th>	
								<th>Action</th>
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
								<td>{{$list->placement_name}}</td>
								<td>{{$list->placement_size}}</td>
								<td>
									@if(!empty($list->placement_photo))
									<img src="{{env('UploadsLink').'uploads/advertisements/'.$list->placement_photo}}" height="60px" width="40px" class="img-responsive" style="border-radius: 50%">
									@endif
								</td>
								<td>{{$list->createdBy->name}}<br>{{$list->created_at}}</td>
								<td>@if(!empty($list->updated_at)){{$list->updatedBy->name}}<br>{{$list->updated_at}}@endif</td>
								<td>{{$list->status == 1 ? 'Active' : 'Inactive'}}</td>
								<td>
									<button type="button" class="btn btn-primary btn-xs openeditModal" data-toggle="modal" data-target="#editModal" data-id="{{$list->id}}" data-placement-name="{{$list->placement_name}}" data-placement-size="{{$list->placement_size}}" data-placement-photo="{{$list->placement_photo}}" data-status="{{$list->status}}"><i class="fa fa-edit" title="Edit"></i></button>
									<a href="{{route('Advertisements Placements Delete', $list->id)}}" class="btn btn-danger btn-xs delete" onclick="return confirm('Are you sure you want to  delete?');"><i class="fa fa-trash"></i></a>
									<a href="{{route('Advertisements Orders', $list->id)}}" class="btn btn-success btn-xs">Orders</a>
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
					<h4 class="modal-title">Add New Placement</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{route('Advertisements Placements Store')}}" enctype="multipart/form-data">
						{{csrf_field()}}

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Name *</b></label>
							<div class="col-sm-8">
								<input type="text" name="placement_name" class="form-control" autofocus required />
								@if($errors->has('placement_name'))
								<span class="help-block">{{ $errors->first('placement_name') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Size</b></label>
							<div class="col-sm-8">
								<input type="text" name="placement_size" class="form-control" autofocus />
								@if($errors->has('placement_size'))
								<span class="help-block">{{ $errors->first('placement_size') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Photo (500x500)</b></label>
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
											<input type="file" name="placement_photo" value="">
										</label>
										<a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
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
	<div class="modal-dialog modal-md">
		<div class="content">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Placement</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{route('Advertisements Placements Update')}} " enctype="multipart/form-data">
						{{csrf_field()}}
						<input type="hidden" id="id" name="id">

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Name *</b></label>
							<div class="col-sm-8">
								<input type="text" name="placement_name" id="placement_name" class="form-control" autofocus required />
								@if($errors->has('placement_name'))
								<span class="help-block">{{ $errors->first('placement_name') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><b>Size</b></label>
							<div class="col-sm-8">
								<input type="text" name="placement_size" id="placement_size" class="form-control" autofocus />
								@if($errors->has('placement_size'))
								<span class="help-block">{{ $errors->first('placement_size') }}</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Photo (500x500)</b></label>
							</div>
							<div class="col-sm-8">
								<div class="fileupload fileupload-exists" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail">
										<img id="placement_photo" alt="placement_photo" class="img-responsive" style="max-width: 150px;"/>
									</span>
									<span>
										<label class="btn btn-primary btn-rounded btn-file btn-sm">
											<span class="fileupload-new">
												<i class="fa fa-picture-o"></i> Select Photo
											</span>
											<span class="fileupload-exists">
												<i class="fa fa-picture-o"></i> Change
											</span>
											<input type="file" name="placement_photo">
										</label>
										<a href="" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Status *</b></label>
							</div>
							<div class="col-sm-8">
								<select class="form-control" name="status" id="status" required="">
									<option value="1">Active</option>
									<option value="2">Inactive</option>
									<option value="-1">Remove</option>
								</select>
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
		var placement_name = $(this).data('placement-name');
		var placement_size = $(this).data('placement-size');
		var placement_photo = $(this).data('placement-photo');
		var status = $(this).data('status');

		$('.modal-body #id').val(id);
		$('.modal-body #placement_name').val(placement_name);
		$('.modal-body #placement_size').val(placement_size);
		$('.modal-body #status').val(status);

		if(placement_photo){
			var placement_photo = '{{env('UploadsLink')}}/uploads/advertisement'+'/'+placement_photo;
			$(".modal-body #placement_photo").attr('src', placement_photo);
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

