@extends('layouts.app')
@section('title', 'Breakings')

@push('top-scripts')
<link href="{{asset('assets/css/jasny-bootstrap.min.css')}}" rel="stylesheet" />
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

		@if(session('success_message'))
		<div class="alert alert-danger text-center alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>{{session('success_message')}} </strong>
		</div>
		@endif

		<section class="panel panel-default">
			<header class="panel-heading font-bold">Breakings
				<a href="javascript::void(0)" data-toggle="modal" data-target="#createModal" class="btn btn-success btn-xs pull-right"> <i class="fa fa-plus-circle"></i> New Breaking</a>
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
					<div class="col-sm-1 m-b-xs" style="padding-left: 0px">
						<button class="btn btn-sm btn-default btn-block">Search</button>
					</div>
				</form>
			</div>

			<form method="post" action="{{url('breakings/bulkupdate')}}">
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
								<th width="400">Title</th>
								<th>Visible Till</th>
								<th>Type</th>
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
								<td>
									@if(!empty($list->url))
									<a style="color: blue" href="{!! $list->url !!}" target="_blank">{!! $list->title !!}</a>
									@else
									{!! $list->title !!}
									@endif
								</td>
								<td>{!! date('d M Y, H:i:s', strtotime($list->breaking_time)) !!}</td>
								<td>{{$list->type == 1 ? 'Breaking' : 'JustNow'}}</td>
								<td>{{$list->createdBy->name}}<br>{{$list->created_at}}</td>
								<td>@if(!empty($list->updated_at)){{$list->updatedBy->name}}<br>{{$list->updated_at}}@endif</td>
								<td>{{$list->status == 1 ? 'Active' : 'Inactive'}}</td>
								<td>
									<button type="button" class="btn btn-primary btn-xs editModal" data-toggle="modal" data-target="#editModal" data-id="{{$list->id}}" data-title="{{$list->title}}" data-url="{{$list->url}}" data-breaking-time="{{$list->breaking_time}}" data-type="{{$list->type}}" data-status="{{$list->status}}"><i class="fa fa-edit" title="Edit"></i></button>
									<a href="{{url('breakings/delete/'.$list->id)}}" class="btn btn-danger btn-xs delete" onclick="return confirm('Are you sure you want to  delete?');"><i class="fa fa-trash"></i></a>
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
	<div class="modal-dialog">
		<div class="content">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Breakings</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{url('breakings/store')}} " enctype="multipart/form-data">
						{{csrf_field()}}

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Title*</b></label>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="title" required="" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Link</b></label>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="url" / >
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Visibile Till*</b></label>
							</div>
							<div class="col-sm-8">
								<div class="input-group date pickDate" >
									<input type="text" name="breaking_time" class="form-control" value="{{ old('breaking_time') }}" >
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Type *</b></label>
							</div>
							<div class="col-sm-8">
								<select  class="form-control" name="type" required="">
									<option value="1">Breaking</option>
									<option value="2">Just Now</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Status *</b></label>
							</div>
							<div class="col-sm-8">
								<select  class="form-control" name="status" required="">
									<option value="1">Active</option>
									<option value="2">Inactive</option>
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



<!-- edit modal -->
<div id="editModal" class="modal fade" role='dialog'>
	<div class="modal-dialog">
		<div class="content">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Breakings</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="
					{{url('breakings/update')}}" enctype="multipart/form-data">
					{{csrf_field()}}
					<input type="hidden" id="id" name="id">

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Title*</b></label>
						</div>
						<div class="col-sm-8">
							<input type="text" id="title" class="form-control" name="title" required="" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Link</b></label>
						</div>
						<div class="col-sm-8">
							<input type="text" id="url" class="form-control" name="url"/>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Visible Till*</b></label>
						</div>
						<div class="col-sm-8">
							<div class="input-group date pickDate" >
								<input type="text" id="breaking_time" name="breaking_time" class="form-control" value="" >
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Type *</b></label>
						</div>
						<div class="col-sm-8">
							<select  class="form-control" id="type" name="type" required="">
								<option value="1">Breaking</option>
								<option value="2">Just Now</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Status *</b></label>
						</div>
						<div class="col-sm-8">
							<select  class="form-control" id="status" name="status" required="">
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
<script src="{{asset('assets/js/plugins/bootstrap-datetimepicker.min.js')}}" ></script>

<script type="text/javascript">
	$('.pickDate').datetimepicker({
		locale: 'ru',
		startDate: new Date()
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
	$(".editModal").click(function(){
		var id = $(this).data('id');
		var title = $(this).data('title');
		var url = $(this).data('url');
		var breaking_time = $(this).data('breaking-time');
		var type = $(this).data('type');
		var status = $(this).data('status');

		$('.modal-body #id').val(id);
		$('.modal-body #title').val(title);
		$('.modal-body #url').val(url);
		$('.modal-body #breaking_time').val(breaking_time);
		$('.modal-body #type').val(type);
		$('.modal-body #status').val(status);
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

