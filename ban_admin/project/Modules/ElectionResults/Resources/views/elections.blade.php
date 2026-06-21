@extends('layouts.app')
@section('title', 'Elections')

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
			<header class="panel-heading font-bold">Elections
				<a href="javascript::void(0)" data-toggle="modal" data-target="#createModal" class="btn btn-success btn-xs pull-right"> <i class="fa fa-plus-circle"></i> New Election</a>
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
						<input name="title" type="text" class="input-sm form-control" value="{{!empty($_GET['title']) ? $_GET['title'] : ''}}" placeholder="Election Name" autocomplete="off" />
					</div>
					<div class="col-sm-1 m-b-xs paddingL0">
						<button class="btn btn-sm btn-default btn-block">Search</button>
					</div>
				</form>
			</div>

			<form method="post" action="{{route('Elections Bulk Update')}}">
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
								<th>Election Name</th>
								<th>Election Date</th>
								<th>Total Voter</th>
								<th>Male Voter</th>
								<th>Female Voter</th>
								<th>Other Voter</th>
								<th>Total Center</th>
								<th>Published Center</th>
								<th>Status</th>
								<th width="140">Action</th>
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
								<td>{!! $list->title !!}</td>
								<td>{!! date('d M, Y', strtotime($list->date)) !!}</td>
								<td>{!! $list->total_voter !!}</td>
								<td>{!! $list->male_voter !!}</td>
								<td>{!! $list->female_voter !!}</td>
								<td>{!! $list->other_voter !!}</td>
								<td>{!! $list->total_center !!}</td>
								<td>{!! $list->published_center !!}</td>
								<td>{{$list->status == 1 ? 'Active' : 'Inactive'}}</td>
								<td>
									<button type="button" class="btn btn-primary btn-xs editModal" data-toggle="modal" data-target="#editModal" data-id="{{$list->id}}" data-title="{{$list->title}}" data-date="{{$list->date}}" data-total-voter="{{$list->total_voter}}" data-male-voter="{{$list->male_voter}}" data-female-voter="{{$list->female_voter}}" data-other-voter="{{$list->other_voter}}" data-total-center="{{$list->total_center}}" data-published-center="{{$list->published_center}}" data-small-banner="{{$list->small_banner}}" data-large-banner="{{$list->large_banner}}" data-status="{{$list->status}}"><i class="fa fa-edit" title="Edit"></i></button>
									<a href="{{route('Elections Delete', $list->id)}}" class="btn btn-danger btn-xs delete" onclick="return confirm('Are you sure you want to  delete?');"><i class="fa fa-trash"></i></a>
									<a title="Figures" href="{{route('Elections Figures', $list->id)}}" class="btn btn-info btn-xs"><i class="fa fa-users"></i></a>
									<a title="Result" href="{{route('Elections Results', $list->id)}}" class="btn btn-success btn-xs"><i class="fa fa-filter"></i></a>
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
	<div class="modal-dialog modal-lg">
		<div class="content">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Election</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{route('Elections Store')}}" enctype="multipart/form-data">
						{{csrf_field()}}

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Election Name *</b></label></label> 
							<div class="col-sm-8">
								<input type="text" class="form-control" name="title" required>
							</div>
						</div>

						<div class="form-group"> 
							<label class="col-sm-3 text-right"><b>Election Date *</b></label> 
							<div class="col-sm-8">                               
								<div class="input-group date form-date" data-date-format="yyyy-mm-dd"> 
									<input type="text" name="date" class="form-control" required> 
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
								</div> 
							</div> 
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Total Voter</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="total_voter" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Male Voter</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="male_voter" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Female Voter</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="female_voter" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Other Voter</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="other_voter" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Total Center</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="total_center" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Published Center</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="published_center" min="0" value="0">
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
	<div class="modal-dialog modal-lg">
		<div class="content">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Election</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{route('Elections Update')}} " enctype="multipart/form-data">
						{{csrf_field()}}
						<input type="hidden" id="id" name="id">

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Election Name *</b></label></label> 
							<div class="col-sm-8">
								<input type="text" class="form-control" name="title" id="title" required>
							</div>
						</div>

						<div class="form-group"> 
							<label class="col-sm-3 text-right"><b>Election Date *</b></label> 
							<div class="col-sm-8">                               
								<div class="input-group date form-date" data-date-format="yyyy-mm-dd"> 
									<input type="text" name="date" id="date" class="form-control" required> 
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
								</div> 
							</div> 
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Total Voter</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="total_voter" id="total_voter" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Male Voter</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="male_voter" id="male_voter" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Female Voter</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="female_voter" id="female_voter" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Other Voter</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="other_voter" id="other_voter" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Total Center</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="total_center" id="total_center" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Published Center</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="published_center" id="published_center" min="0" value="0">
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
		var date = $(this).data('date');
		var male_voter = $(this).data('male-voter');
		var female_voter = $(this).data('female-voter');
		var other_voter = $(this).data('other-voter');
		var total_voter = $(this).data('total-voter');
		var total_center = $(this).data('total-center');
		var published_center = $(this).data('published-center');
		var small_banner = $(this).data('small-banner');
		var large_banner = $(this).data('large-banner');
		var status = $(this).data('status');

		$('.modal-body #id').val(id);
		$('.modal-body #title').val(title);
		$('.modal-body #date').val(date);
		$('.modal-body #male_voter').val(male_voter);
		$('.modal-body #female_voter').val(female_voter);
		$('.modal-body #other_voter').val(other_voter);
		$('.modal-body #total_voter').val(total_voter);
		$('.modal-body #total_center').val(total_center);
		$('.modal-body #published_center').val(published_center);
		$('.modal-body #status').val(status);

		if(small_banner){
			var small_banner = '{{env('UploadsLink')}}uploads/elections/'+small_banner;
			$(".modal-body #small_banner").attr('src', small_banner);
		}

		if(large_banner){
			var large_banner = '{{env('UploadsLink')}}uploads/elections/'+large_banner;
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
@endpush

