@extends('layouts.app')

@section('title', 'Category')

@push('top-scripts')
<link rel="stylesheet" href="{{asset('assets/css/datatables.css')}}" type="text/css" />
@endpush

@section('content')

<section class="vbox">
	<section class="scrollable padder">
		<br>

		@if(session('success_message'))
		<div class="alert alert-success text-center alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>{{session('success_message')}} </strong>
		</div>
		@endif


		@if(session('info_message'))
		<div class="alert alert-info text-center alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>{{session('info_message')}} </strong>
		</div>
		@endif

		<section class="panel panel-default">
			<header class="panel-heading font-bold">Category | Category List <a href="javascript:void(0)" data-toggle="modal" data-target="#createCategoryModal" class="btn btn-success btn-xs pull-right"><i class="fa fa-plus-circle"></i> New Category</a>
			</header>

			<div class="table-responsive">
				<table class="table table-striped m-b-none" id="categoryTable">
					<thead>
						<tr>
							<th>SL</th>
							<th>Category Name</th>
							<th>Sub-category Name</th>
							<th>Title</th>
							<th>Parent</th>
							<th>Header Display</th>
							<th>Menubar Display</th>
							<th>Status</th>
							<th width="140">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($categories as $key => $category)
						<tr>
							<td>{{$key+1}}</td>
							<td>{{$category->category_name}}</td>
							<td>{{$category->subCategory_name}}</td>
							<td>{{$category->title}}</td>
							<td>{{$category->parent}}</td>
							<td>@if($category->header_display){{'Yes'}}@else{{'No'}}@endif</td>
							<td>@if($category->menubar_display){{'Yes'}}@else{{'No'}}@endif</td>
							<td>@if($category->status){{"Active"}}@else{{"Inactive"}}@endif</td>
							<td>

								<a href="#" data-toggle="modal" data-id="{{$category->id}}" data-order="{{$category->order_id}}" class="btn btn-primary btn-xs open-editCategoryModal" data-target="#editCategoryModal"><i class="fa fa-pencil-square-o"></i></a>
								<a href="javascript:void(0)" data-id="{{$category->id}}" data-order="{{$category->order_id}}" class="btn btn-info btn-xs upCategory"><i class="fa fa-arrow-up"></i></a>
								<a href="javascript:void(0)" data-id="{{$category->id}}" data-order="{{$category->order_id}}" class="btn btn-danger btn-xs downCategory"><i class="fa fa-arrow-down"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</section>
	</section>
</section>


<!-- Modal -->
<div id="createCategoryModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Create Category</h4>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal" method="post" action="{{url('/category/store')}}">
					{{csrf_field()}}

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Display Name *</b></label>
						</div>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="display_name" value="" required />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Title *</b></label>
						</div>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="title" placeholder="Ex:- whole-country" value="" required />
						</div>
					</div>

					<div class="form-group"> 
						<label class="col-sm-4 text-right"><b>Color</b></label> 
						<div class="col-sm-7">                               
							<div class="input-group"> 
								<input type="text" class="form-control color-input" name="color">
								<span class="input-group-addon"><input type="color" class="color-picker color" value="#000000"> </span> 
							</div> 
						</div> 
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Parent *</b></label>
						</div>
						<div class="col-sm-7">
							<select name="parent" class="form-control" required>
								<option value="0">No Parent</option>
								@php $categories = \App\Http\Controllers\CategoryController::getParentCategories(); @endphp
								@foreach($categories as $category)
								<option value="{{$category->id}}">{{$category->display_name}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Header Display *</b></label>
						</div>
						<div class="col-sm-7">
							<select name="header_display" class="form-control" required>
								<option value="1">Yes</option>
								<option value="0">No</option>     
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Menubar Display *</b></label>
						</div>
						<div class="col-sm-7">
							<select name="menubar_display" class="form-control" required>
								<option value="1">Yes</option>
								<option value="0">No</option>     
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Edition *</b></label>
						</div>
						<div class="col-sm-7">
							<select class="form-control" name="edition" required >
								<option value="online">Online</option>
								<option value="todayspaper">Todayspaper</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Status *</b></label>
						</div>
						<div class="col-sm-7">
							<select class="form-control" name="status" required >
								<option value="1">Active</option>
								<option value="0">Inactive</option>
								<option value="2">Remove</option>
							</select>
						</div>
					</div>

					<hr>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Meta Title</b></label>
						</div>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="meta_title" value="" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Meta Keywords</b></label>
						</div>
						<div class="col-sm-7">
							<textarea class="form-control" name="meta_keywords" rows="4" placeholder="Comma separated keywords"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Meta Description</b></label>
						</div>
						<div class="col-sm-7">
							<textarea class="form-control" name="meta_description" rows="4"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Page Header Code</b></label>
						</div>
						<div class="col-sm-7">
							<textarea class="form-control" name="header_code" rows="4"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-7  col-sm-offset-4">
							<button type="submit" class="btn btn-primary btn-block">Create</button>
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



<div id="editCategoryModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Update Category</h4>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal" method="post" action="{{url('/category/update')}}">
					{{csrf_field()}}

					<input type="hidden" name="category_id" id="category_id" value="" />

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Display Name *</b></label>
						</div>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="display_name" id="display_name" value="" required />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Title *</b></label>
						</div>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="title" id="title" value="" required />
						</div>
					</div>

					<div class="form-group"> 
						<label class="col-sm-4 text-right"><b>Color</b></label> 
						<div class="col-sm-7">                               
							<div class="input-group"> 
								<input type="text" class="form-control" name="color" id="color-input" value="">
								<span class="input-group-addon"><input type="color" class="color-picker" value="#000000" id="color"> </span> 
							</div> 
						</div> 
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Parent *</b></label>
						</div>
						<div class="col-sm-7">
							<select name="parent" class="form-control" id="parent" required>
								<option value="0">No Parent</option>
								@php $categories = \App\Http\Controllers\CategoryController::getParentCategories(); @endphp
								@foreach($categories as $category)
								<option value="{{$category->id}}">{{$category->display_name}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Header Display *</b></label>
						</div>
						<div class="col-sm-7">
							<select name="header_display" class="form-control" id="header_display" required>
								<option value="1">Yes</option>
								<option value="0">No</option>     
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Menubar Display *</b></label>
						</div>
						<div class="col-sm-7">
							<select name="menubar_display" class="form-control" id="menubar_display" required>
								<option value="1">Yes</option>
								<option value="0">No</option>     
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Edition *</b></label>
						</div>
						<div class="col-sm-7">
							<select class="form-control" name="edition" id="edition" required >
								<option value="online">Online</option>
								<option value="todayspaper">Todayspaper</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Status *</b></label>
						</div>
						<div class="col-sm-7">
							<select class="form-control" name="status" id="status" required >
								<option value="1">Active</option>
								<option value="0">Inactive</option>
								<option value="2">Remove</option>
							</select>
						</div>
					</div>

					<hr>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Meta Title</b></label>
						</div>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="meta_title" id="meta_title" value="" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Meta Keywords</b></label>
						</div>
						<div class="col-sm-7">
							<textarea class="form-control" name="meta_keywords" id="meta_keywords" rows="4" placeholder="Comma separated keywords"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Meta Description</b></label>
						</div>
						<div class="col-sm-7">
							<textarea class="form-control" name="meta_description" id="meta_description" rows="4"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-4 text-right">
							<label class="control-label"><b>Page Header Code</b></label>
						</div>
						<div class="col-sm-7">
							<textarea class="form-control" name="header_code" id="header_code" rows="4"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-7  col-sm-offset-4">
							<button type="submit" class="btn btn-primary btn-block">Update</button>
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

@endsection

@push('bottom-scripts')
<script src="{{asset('assets/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>

<script type="text/javascript">
	$('#categoryTable').DataTable({
		processing: true,
		serverSide: false,
		dom: "<'row'<'col-xs-6'l><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
		ordering: false,
		"pageLength": 100,          
	});

	$(document).on("click", ".upCategory", function () {
		var id = $(this).data('id');
		$.ajax({
			type: 'GET',
			url: '{{URL("ajax/upCategory")}}'+"/"+id,
			success: function (data) {
				location.reload(true);
			}
		});
	});

	$(document).on("click", ".downCategory", function () {
		var id = $(this).data('id');
		$.ajax({
			type: 'GET',
			url: '{{URL("ajax/downCategory")}}'+"/"+id,
			success: function (data) {
				location.reload(true);
			}
		});
	});


	$(document).on("click", ".open-editCategoryModal", function () {
		var id = $(this).data('id');
		$.ajax({
			type: 'GET',
			url: '{{URL("ajax/category/edit")}}'+"/"+id,
			success: function (data) {
				$(".modal-body #category_id").val(data.category.id);
				$(".modal-body #display_name").val(data.category.display_name);
				$(".modal-body #title").val(data.category.title);
				$(".modal-body #color-input").val(data.category.color);
				$(".modal-body #parent").val(data.category.parent);
				$(".modal-body #header_display").val(data.category.header_display);
				$(".modal-body #menubar_display").val(data.category.menubar_display);
				$(".modal-body #meta_title").val(data.category.meta_title);
				$(".modal-body #meta_keywords").val(data.category.meta_keywords);
				$(".modal-body #meta_description").val(data.category.meta_description);
				$(".modal-body #header_code").val(data.category.header_code);
				$(".modal-body #edition").val(data.category.edition);
				$(".modal-body #status").val(data.category.status);
			}
		});
	});

	$(".color").change(function() {
		$( ".color-input").val($(".color" ).val()); 
	});

	$("#color").change(function() {
		$( "#color-input").val($("#color" ).val()); 
	});

</script>
@endpush
