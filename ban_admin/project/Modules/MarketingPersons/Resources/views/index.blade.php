@extends('layouts.app')
@section('title', 'Marketing Persons')

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

		@if(session('error_message'))
		<div class="alert alert-danger text-center alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>{{session('error_message')}} </strong>
		</div>
		@endif

		<section class="panel panel-default">
			<header class="panel-heading font-bold">Marketing Persons
				<a href="javascript::void(0)" data-toggle="modal" data-target="#createModal" class="btn btn-success btn-xs pull-right"> <i class="fa fa-plus-circle"></i> New Person</a>
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
						<input name="contact" type="text" class="input-sm form-control" value="{{!empty($_GET['contact']) ? $_GET['contact'] : ''}}" placeholder="Contact" autocomplete="off" />
					</div>
					<div class="col-sm-2 m-b-xs paddingL0">
						<input name="email" type="text" class="input-sm form-control" value="{{!empty($_GET['email']) ? $_GET['email'] : ''}}" placeholder="Email" autocomplete="off" />
					</div>
					<div class="col-sm-1 m-b-xs paddingL0">
						<button class="btn btn-sm btn-default btn-block">Search</button>
					</div>
				</form>
			</div>

			<form method="post" action="{{route('MarketingPersons Bulk Update')}}">
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
								<th>Designation</th>
								<th>Contact</th>
								<th>Email</th>
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
										<input type="checkbox" name="ids[]" value="{{$list->id}},{{$list->id}}"><i></i>
									</label>
								</td>
								<td>{!! isset($_GET['page']) && !empty($_GET['page']) ? (($_GET['page']-1)*10)+($key+1) : $key + 1 !!}</td>
								<td>{!! $list->title !!}</td>
								<td>{!! $list->designation !!}</td>
								<td>{!! $list->contact !!}</td>
								<td>{!! $list->email !!}</td>
								<td>{{$list->createdBy->name}}<br>{{$list->created_at}}</td>
								<td>@if(!empty($list->updated_at)){{$list->updatedBy->name}}<br>{{$list->updated_at}}@endif</td>
								<td>{{$list->status == 1 ? 'Active' : 'Inactive'}}</td>
								<td>
									<button type="button" class="btn btn-primary btn-xs editModal" data-toggle="modal" data-target="#editModal" data-id="{{$list->id}}" data-title="{{$list->title}}" data-designation="{{$list->designation}}" data-contact="{{$list->contact}}" data-email="{{$list->email}}" data-status="{{$list->status}}"><i class="fa fa-edit" title="Edit"></i></button>
									<a href="{{route('MarketingPersons Delete', $list->id)}}" class="btn btn-danger btn-xs delete" onclick="return confirm('Are you sure you want to  delete?');"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
							@endforeach
							@else
							<tr><td colspan="10" class="text-center">No Data</td></tr>
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
					<h4 class="modal-title">Add New Person</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{route('MarketingPersons Store')}} " enctype="multipart/form-data">
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
								<label class="control-label"><b>Designation</b></label>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="designation" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Contact</b></label>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="contact" />
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Email</b></label>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="email" />
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
					<h4 class="modal-title">Edit Person</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="
					{{route('MarketingPersons Update')}}" enctype="multipart/form-data">
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
							<label class="control-label"><b>Designation</b></label>
						</div>
						<div class="col-sm-8">
							<input type="text" id="designation" class="form-control" name="designation" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Contact</b></label>
						</div>
						<div class="col-sm-8">
							<input type="text" id="contact" class="form-control" name="contact" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 text-right">
							<label class="control-label"><b>Email</b></label>
						</div>
						<div class="col-sm-8">
							<input type="text" id="email" class="form-control" name="email" />
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
	$(".editModal").click(function(){
		var id = $(this).data('id');
		var title = $(this).data('title');
		var designation = $(this).data('designation');
		var contact = $(this).data('contact');
		var email = $(this).data('email');
		var status = $(this).data('status');

		$('.modal-body #id').val(id);
		$('.modal-body #title').val(title);
		$('.modal-body #designation').val(designation);
		$('.modal-body #contact').val(contact);
		$('.modal-body #email').val(email);
		$('.modal-body #status').val(status);
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

