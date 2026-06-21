@extends('layouts.app')
@section('title', 'Todayspaper New Bulk News')
@push('top-scripts')
<link href="{{asset('assets/css/text-editor.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/chosen.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/bootstrap-tagsinput.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/bootstrap-fileupload.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" />
<style type="text/css">
	.bootstrap-tagsinput{
		width: 100%
	}
	.datetimepicker{
		/*margin-top: -260px !important;*/
		margin-left: -50px !important
	}
	.fileinput .btn-file{
		padding: 0px !important;
		margin: 0px !important;
	}
	.fileinput .btn-file .fileinput-new{
		padding: 9px !important;
		margin-bottom: 0px !important;
	}
	.note-editor{
		margin-bottom: 0px !important;
	}
	.chosen-container .chosen-single{
		height: 34px !important;
		padding-top: 5px !important;
	}
</style>
@endpush

@section('content')

<section class="vbox">
	<section class="scrollable padder">
		<br>

		@if(session('message'))
		<div class="alert alert-danger text-center alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>{{session('message')}} </strong>
		</div>
		@endif

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


		<form class="form-horizontal" method="post" action="{{route('Todayspaper Bulk Store')}}" enctype="multipart/form-data">
			{{csrf_field()}}

			<section class="panel panel-default">
				<header class="panel-heading font-bold">Todayspaper News | New Bulk News</header>
				<div class="panel-body">

					<div class="row">
						<div class="col-md-3">
							<div class="form-group" style="margin-bottom: 0px"> 
								<label class="col-sm-12">Todayspaper Date *</label> 
								<div class="col-sm-12">                               
									<div class="input-group date publishDatePick" data-date-format="yyyy-mm-dd"> 
										<input type="text" name="publish_date" value="{{date('Y-m-d')}}" class="form-control" required=""> 
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
									</div> 
								</div> 
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group" style="margin-bottom: 0px">
								<label class="col-sm-12">Category *</label>
								<div class="col-sm-12">
									<select style="width:100%" name="categories" class="chosen-select onlinecategory" id="category" required="">
										@if(!empty($categories) && (count($categories)>0))
										@foreach($categories as $category)
										<option value="{{$category->id}}"	class="optionGroup">{{$category->display_name}}</option>

										@if(!empty($category->childCategoriesActive) && (count($category->childCategoriesActive)>0))
										@foreach($category->childCategoriesActive as $subcategory)
										<option value="{{$subcategory->id}}" class="optionChild">{{$subcategory->display_name}}</option>
										@endforeach
										@endif

										@endforeach
										@endif
									</select>
								</div>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group" style="margin-bottom: 0px">
								<label class="col-sm-12">Upload Txt File *</label>
								<div class="col-sm-12">
									<input type="file" class="form-control" name="newsFile" required="">
								</div>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group" style="margin-bottom: 0px">
								<label class="col-sm-12">--</label>
								<div class="col-sm-12">
									<button type="submit" class="btn btn-success btn-block">Save</button>
								</div>
							</div>
						</div>
					</div>

				</div>
			</section>
		</form>
	</section>
</section>

@endsection

@push('bottom-scripts')
<script src="{{asset('assets/js/plugins/text-editor.min.js?v=1.10')}}"></script>
<script src="{{asset('assets/js/plugins/chosen.jquery.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-fileupload.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/jasny-bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/summernote-image-captionit.js')}}"></script>
<script src="{{asset('assets/js/pages/article.js?v=1.8')}}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker.min.js') }}" ></script>

<script type="text/javascript">
	$('.publishDatePick').datetimepicker({
		todayBtn:  1,
		autoclose: 1,
		minView: 2
	});
	$('.form-date').datetimepicker({
		locale: 'ru',
		startDate: new Date(),
	});

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
</script>
@endpush
