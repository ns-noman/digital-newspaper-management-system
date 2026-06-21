@extends('layouts.app')
@section('title', 'Election Figures')

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
			<header class="panel-heading font-bold">Election Figures: {!! $electionInfo->title !!}
				<a href="javascript::void(0)" data-toggle="modal" data-target="#createModal" class="btn btn-success btn-xs pull-right"> <i class="fa fa-plus-circle"></i> New Figure</a>
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
						<input name="figure_name" type="text" class="input-sm form-control" value="{{!empty($_GET['figure_name']) ? $_GET['figure_name'] : ''}}" placeholder="Election Figures" autocomplete="off" />
					</div>
					<div class="col-sm-1 m-b-xs paddingL0">
						<button class="btn btn-sm btn-default btn-block">Search</button>
					</div>
				</form>
			</div>

			<form method="post" action="{{route('Elections Figures Bulk Update')}}">
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
								<th>Figure Name</th>
								<th>Photo</th>
								<th>Symbol Name</th>
								<th>Symbol</th>
								<th>Vote Earned</th>
								<th>Center Wins</th>
								<th>Center Leads</th>
								<th>Show Result</th>
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
								<td>{!! $list->figure_name !!}</td>
								<td width="80">
									@if(!empty($list->figure_photo))
									<img src="{!! env('UploadsLink').'uploads/elections/'.$list->figure_photo !!}" style="width: 50px;border-radius: 50%">
									@endif
								</td>
								<td>{!! $list->symbol_name !!}</td>
								<td width="80">
									@if(!empty($list->symbol_logo))
									<img src="{!! env('UploadsLink').'uploads/elections/'.$list->symbol_logo !!}" style="width: 50px;border-radius: 50%">
									@endif
								</td>
								<td>{!! $list->total_vote !!}</td>
								<td>{!! $list->total_leads !!}</td>
								<td>{!! $list->total_wins !!}</td>
								<td>{{$list->display_result == 1 ? 'Yes' : 'No'}}</td>
								<td>{{$list->status == 1 ? 'Active' : 'Inactive'}}</td>
								<td>
									<button type="button" class="btn btn-primary btn-xs editModal" data-toggle="modal" data-target="#editModal" data-id="{{$list->id}}" data-election-result-id="{{$list->election_result_id}}" data-figure-name="{{$list->figure_name}}" data-symbol-name="{{$list->symbol_name}}" data-total-vote="{{$list->total_vote}}" data-total-leads="{{$list->total_leads}}" data-total-wins="{{$list->total_wins}}" data-display-result="{{$list->display_result}}" data-figure-photo="{{$list->figure_photo}}" data-symbol-logo="{{$list->symbol_logo}}" data-status="{{$list->status}}"><i class="fa fa-edit" title="Edit"></i></button>
									<a href="{{route('Elections Figures Delete', $list->id)}}" class="btn btn-danger btn-xs delete" onclick="return confirm('Are you sure you want to  delete?');"><i class="fa fa-trash"></i></a>
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
					<h4 class="modal-title">Add New Figure</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{route('Elections Figures Store')}}" enctype="multipart/form-data">
						{{csrf_field()}}
						<input type="hidden" name="election_result_id" value="{{$electionInfo->id}}">

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Figure Name *</b></label></label> 
							<div class="col-sm-8">
								<input type="text" class="form-control" name="figure_name" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Figure Photo (200x200)</b></label></label>
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
											<input type="file" name="figure_photo" value="">
										</label>
										<a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Symbol Name *</b></label></label> 
							<div class="col-sm-8">
								<input type="text" class="form-control" name="symbol_name" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Symbol Logo (200x200)</b></label></label>
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
											<input type="file" name="symbol_logo" value="">
										</label>
										<a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Vote Earned</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="total_vote" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Center Wins</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="total_wins" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Center Leads</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="total_leads" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Show Result</b></label></label>
							<div class="col-sm-8">
								<select class="form-control" name="display_result">
									<option value="1">Yes</option>
									<option value="">No</option>
								</select>
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
					<form role="form" class="form-horizontal" method="post" action="{{route('Elections Figures Update')}} " enctype="multipart/form-data">
						{{csrf_field()}}
						<input type="hidden" id="id" name="id">
						<input type="hidden" name="election_result_id" value="{{$electionInfo->id}}">

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Figure Name *</b></label></label> 
							<div class="col-sm-8">
								<input type="text" class="form-control" name="figure_name" id="figure_name" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Figure Photo (200x200)</b></label></label>
							<div class="col-sm-9">
								<div class="fileupload fileupload-exists" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail">
										<img id="figure_photo" alt="image" class="img-responsive" style="max-width: 150px;"/>
									</span>
									<span>
										<label class="btn btn-primary btn-rounded btn-file btn-sm">
											<span class="fileupload-new">
												<i class="fa fa-picture-o"></i> Select Photo
											</span>
											<span class="fileupload-exists">
												<i class="fa fa-picture-o"></i> Change
											</span>
											<input type="file" name="figure_photo">
										</label>
										<a href="" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Symbol Name *</b></label></label> 
							<div class="col-sm-8">
								<input type="text" class="form-control" name="symbol_name" id="symbol_name" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Symbol Logo (200x200)</b></label></label>
							<div class="col-sm-9">
								<div class="fileupload fileupload-exists" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail">
										<img id="symbol_logo" alt="image" class="img-responsive" style="max-width: 150px;"/>
									</span>
									<span>
										<label class="btn btn-primary btn-rounded btn-file btn-sm">
											<span class="fileupload-new">
												<i class="fa fa-picture-o"></i> Select Photo
											</span>
											<span class="fileupload-exists">
												<i class="fa fa-picture-o"></i> Change
											</span>
											<input type="file" name="symbol_logo">
										</label>
										<a href="" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
											<i class="fa fa-times"></i> Remove
										</a>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Vote Earned</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="total_vote" id="total_vote" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Center Wins</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="total_wins" id="total_wins" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Center Leads</b></label></label> 
							<div class="col-sm-8">
								<input type="number" class="form-control" name="total_leads" id="total_leads" min="0" value="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 text-right"><label class="control-label"><b>Show Result</b></label></label>
							<div class="col-sm-8">
								<select class="form-control" name="display_result" id="display_result">
									<option value="1">Yes</option>
									<option value="">No</option>
								</select>
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
		var figure_name = $(this).data('figure-name');
		var symbol_name = $(this).data('symbol-name');
		var total_vote = $(this).data('total-vote');
		var total_leads = $(this).data('total-leads');
		var total_wins = $(this).data('total-wins');
		var display_result = $(this).data('display-result');
		var figure_photo = $(this).data('figure-photo');
		var symbol_logo = $(this).data('symbol-logo');
		var status = $(this).data('status');

		$('.modal-body #id').val(id);
		$('.modal-body #figure_name').val(figure_name);
		$('.modal-body #symbol_name').val(symbol_name);
		$('.modal-body #total_vote').val(total_vote);
		$('.modal-body #total_leads').val(total_leads);
		$('.modal-body #total_wins').val(total_wins);
		$('.modal-body #display_result').val(display_result);
		$('.modal-body #status').val(status);

		if(figure_photo){
			var figure_photo = '{{env('UploadsLink')}}uploads/elections/'+figure_photo;
			$(".modal-body #figure_photo").attr('src', figure_photo);
		}

		if(symbol_logo){
			var symbol_logo = '{{env('UploadsLink')}}uploads/elections/'+symbol_logo;
			$(".modal-body #symbol_logo").attr('src', symbol_logo);
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

