@extends('layouts.app')
@section('title', 'Advertisement Orders')

@push('top-scripts')
<link href="{{asset('assets/css/bootstrap-fileupload.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" /> 
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
			<header class="panel-heading font-bold">Advertisement Orders | Placement: {{$placementInfo->placement_name}}
				<a href="javascript::void(0)" data-toggle="modal" data-target="#createModal" class="btn btn-success btn-xs pull-right"> <i class="fa fa-plus-circle"></i> New Order</a>
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

					<div class="col-sm-2">                               
						<div class="input-group date datePicker" data-date-format="yyyy-mm-dd"> 
							<input type="text" name="dateFrom" value="{!! isset($_GET['dateFrom']) && !empty($_GET['dateFrom']) ? date('Y-m-d', strtotime($_GET['dateFrom'])) : '' !!}" class="form-control" placeholder="Date From" autocomplete="off"> 
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
						</div> 
					</div>

					<div class="col-sm-2 paddingL0">                               
						<div class="input-group date datePicker" data-date-format="yyyy-mm-dd"> 
							<input type="text" name="dateTo" value="{!! isset($_GET['dateTo']) && !empty($_GET['dateTo']) ? date('Y-m-d', strtotime($_GET['dateTo'])) : '' !!}" class="form-control" placeholder="Date To" autocomplete="off"> 
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
						</div> 
					</div>

					<div class="col-sm-2 m-b-xs paddingL0">
						<input name="advertiser_name" type="text" class="input-sm form-control" value="{{!empty($_GET['advertiser_name']) ? $_GET['advertiser_name'] : ''}}" placeholder="Advertiser Name" autocomplete="off" />
					</div>
					<div class="col-sm-2 m-b-xs paddingL0">
						<input name="advertiser_contact" type="text" class="input-sm form-control" value="{{!empty($_GET['advertiser_contact']) ? $_GET['advertiser_contact'] : ''}}" placeholder="Contact" autocomplete="off" />
					</div>
					<div class="col-sm-1 m-b-xs paddingL0">
						<button class="btn btn-sm btn-default btn-block">Search</button>
					</div>
				</form>
			</div>

			<form method="post" action="">
				{{csrf_field()}}
				<div class="table-responsive">
					<table class="table table-striped m-b-none table-bordered table-hover">
						<thead>
							<tr>
								<th>SL</th>
								<th>Advertiser</th>
								<th>Advertisement</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>Type</th>
								<th>Create</th>
								<th>Update</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($lists) && (count($lists)>0))
							@foreach($lists as $key => $list)
							<tr>
								<td>{{$key+1}}</td>
								<td>
									Name: {{$list->advertiser_name ? $list->advertiser_name : '-'}}<br>
									Contact: {{$list->advertiser_contact ? $list->advertiser_contact : '-'}}<br>
									Email: {{$list->advertiser_email ? $list->advertiser_email : '-'}}
								</td>
								<td>
									@if($list->ad_type == 1)
									<a target="_blank" href="{{$list->ad_url}}"><img src="{!! env('UploadsLink').'uploads/advertisements/'.$list->ad_banner !!}" style="width: 100px"></a>
									@elseif($list->ad_type == 2)
									{{$list->ad_code}}
									@endif
								</td>
								<td>{{$list->start_date}}</td>
								<td>{{$list->end_date}}</td>
								<td>{{$list->ad_type == 1 ? 'Banner' : 'Code'}}</td>
								<td>{{$list->createdBy->name}}<br>{{$list->created_at}}</td>
								<td>@if(!empty($list->updated_at)){{$list->updatedBy->name}}<br>{{$list->updated_at}}@endif</td>
								<td>{{$list->status == 1 ? 'Active' : 'Inactive'}}</td>
								<td>
									<a class="btn btn-xs btn-primary editModal" data-id="{{$list->id}}" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>

				<footer class="panel-footer">
					<div class="row">
						@if(!empty($lists) && count($lists)>0)
						<div class="col-sm-8 text-left customPaginationStyle">
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
					<h4 class="modal-title">Add New Order</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{route('Advertisements Orders Store')}}" enctype="multipart/form-data">
						{{csrf_field()}}

						<input type="hidden" name="placement_id" value="{{$placementInfo->id}}" required="" />

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Ad Type **</b></label>
							</div>
							<div class="col-sm-8">
								<select class="form-control ad_type" name="ad_type" required >
									<option value="1">Banner</option>
									<option value="2">Ad Code</option>
								</select>
							</div>
						</div>

						<div class="form-group ad_code" style="display: none;">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Ad Code</b></label>
							</div>
							<div class="col-sm-8">
								<textarea class="form-control" rows="5" name="ad_code"></textarea>
							</div>
						</div>

						<div class="form-group ad_banner">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Ad Banner</b></label>
							</div>
							<div class="col-sm-8">
								<input type="file" name="ad_banner" class="form-control">
							</div>
						</div>

						<div class="form-group ad_url">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Ad Url</b></label>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="ad_url" placeholder="http://example.com">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Start Date **</b></label>
							</div>
							<div class="col-sm-8">
								<div class="input-group date start_date" >
									<input type="text" name="start_date" value="" class="form-control" placeholder="Start Date">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>End Date **</b></label>
							</div>
							<div class="col-sm-8">
								<div class="input-group date end_date" >
									<input type="text" name="end_date" value="" class="form-control" placeholder="End Date">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
								</div>
							</div>
						</div>

						<hr>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Advertiser Name</b></label>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="advertiser_name">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Contact</b></label>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="advertiser_contact">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Email</b></label>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="advertiser_email">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Status *</b></label>
							</div>
							<div class="col-sm-8">
								<select class="form-control" name="status" required >
									<option value="1">Active</option>
									<option value="2">InActive</option>
								</select>
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
					<h4 class="modal-title">Edit Order</h4>
				</div>
				<div class="modal-body">
					<form role="form" class="form-horizontal" method="post" action="{{route('Advertisements Orders Update')}} " enctype="multipart/form-data">
						{{csrf_field()}}
						<input type="hidden" id="id" name="id">

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Ad Type **</b></label>
							</div>
							<div class="col-sm-8">
								<select class="form-control ad_type" name="ad_type" id="ad_type" required >
									<option value="1">Banner</option>
									<option value="2">Ad Code</option>
								</select>
							</div>
						</div>

						<div class="form-group ad_code">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Ad Code</b></label>
							</div>
							<div class="col-sm-8">
								<textarea class="form-control" rows="5" name="ad_code" id="ad_code"></textarea>
							</div>
						</div>

						<div class="form-group ad_banner">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Ad Banner</b></label>
							</div>
							<div class="col-sm-2">
								<img src="" id="ad_banner" class="img-responsive">
							</div>
							<div class="col-sm-5">
								<input type="file" name="ad_banner" class="form-control">
							</div>
						</div>

						<div class="form-group ad_url">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Ad Url</b></label>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="ad_url" id="ad_url" placeholder="http://example.com">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Start Date **</b></label>
							</div>
							<div class="col-sm-8">
								<div class="input-group date start_date" >
									<input type="text" name="start_date" id="start_date" value="" class="form-control" placeholder="Start Date">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>End Date **</b></label>
							</div>
							<div class="col-sm-8">
								<div class="input-group date end_date" >
									<input type="text" name="end_date" id="end_date" value="" class="form-control" placeholder="End Date">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
								</div>
							</div>
						</div>

						<hr>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Advertiser Name</b></label>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="advertiser_name" id="advertiser_name">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Contact</b></label>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="advertiser_contact" id="advertiser_contact">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Email</b></label>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="advertiser_email" id="advertiser_email">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3 text-right">
								<label class="control-label"><b>Status *</b></label>
							</div>
							<div class="col-sm-8">
								<select class="form-control" name="status" id="status" required >
									<option value="1">Active</option>
									<option value="2">InActive</option>
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
<script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker.min.js') }}" ></script>
<script type="text/javascript">
	$('.start_date').datetimepicker({
		autoclose: true,
		locale: 'ru',
		startDate: new Date()
	});
	$('.end_date').datetimepicker({
		autoclose: true,
		locale: 'ru',
		startDate: new Date()
	});
	$('.datePicker').datetimepicker({
		todayBtn:  1,
		autoclose: 1,
		minView: 2
	});
</script>

<script type="text/javascript">
	$('.ad_type').change(function(){
		var ad_type = $(this).val();
		if(ad_type == 1){
			$('.ad_banner').show();
			$('.ad_url').show();
			$('.ad_code').hide();
		}else{
			$('.ad_banner').hide();
			$('.ad_url').hide();
			$('.ad_code').show();
		}
	})
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
	$(document).on("click", ".editModal", function () {
		var id = $(this).data('id');
		$.ajax({
			type: 'GET',
			url: '{{URL("advertisements/placements/orders/detail")}}'+"/"+id,
			success: function (data) {
				$(".modal-body #id").val(data.id);
				$(".modal-body #ad_type").val(data.ad_type);
				$(".modal-body #ad_code").val(data.ad_code);
				$(".modal-body #ad_url").val(data.ad_url);
				$(".modal-body #start_date").val(data.start_date);
				$(".modal-body #end_date").val(data.end_date);
				$(".modal-body #advertiser_name").val(data.advertiser_name);
				$(".modal-body #advertiser_contact").val(data.advertiser_contact);
				$(".modal-body #advertiser_email").val(data.advertiser_email);
				$(".modal-body #status").val(data.status);

				if(data.ad_type == 1){
					$('.ad_banner').show();
					$('.ad_url').show();
					$('.ad_code').hide();
				}else{
					$('.ad_banner').hide();
					$('.ad_url').hide();
					$('.ad_code').show();
				}

				if(data.ad_banner != ''){
					var ad_banner = '{{env('UploadsLink')}}uploads/advertisements'+'/'+data.ad_banner;
					$(".modal-body #ad_banner").attr('src', ad_banner);
				}
				
			}
		});
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

