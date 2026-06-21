@extends('layouts.app')
@section('title', 'Todayspaper Unpublished News List')
@push('top-scripts')
<link href="{{asset('assets/css/chosen.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" />
<style type="text/css">
	.pager{
		text-align: right;
	}
	.pager li>a, .pager li>span{
		border-radius: 0px !important
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
		@if(session('editor_message'))
		<div class="alert alert-danger text-center alert-dismissable fade in" style="background-color: #920000;font-size: 18px;color: white">
			<a style="font-size: 35px;color: white !important;opacity: unset;margin-top: 10px;" href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>{!! session('editor_message') !!} </strong>
		</div>
		@endif

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

		<section class="panel panel-default">
			<header class="panel-heading font-bold">Todayspaper Unpublished News | List <a href="{{Request::url('/')}}" class="btn btn-xs btn-primary pull-right"><i class="fa fa-refresh"></i> Refresh</a></header>

			<div class="row wrapper">
				<form method="get">
					<div class="col-sm-2">                               
						<div class="input-group date datePicker" data-date-format="yyyy-mm-dd"> 
							<input type="text" name="date" value="{!! isset($_GET['date']) && !empty($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'])) : '' !!}" class="form-control" placeholder="Select Date" autocomplete="off"> 
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
						</div> 
					</div>

					<div class="col-sm-1" style="padding-left: 0px">
						<button type="submit" class="btn btn-default">Search</button>
					</div>
				</form>
			</div>

			<form method="post" action="{{route('Todayspaper Bulk Update')}}" enctype="multipart/form-data">
				{{csrf_field()}}
				<input type="hidden" name="publishDate" value="{{isset($_GET['date']) && !empty($_GET['date']) ? $_GET['date'] : ''}}">

				<div class="table-responsive">
					<table class="table table-striped b-t b-light table-bordered table-hover">
						<thead>
							<tr>
								<th width="20">
									<label class="checkbox m-l m-t-none m-b-none i-checks">
										<input type="checkbox"><i></i>
									</label>
								</th>
								<th>Headline</th>
								<th>Placement</th>
								<th width="80">Thumbnail</th>   
								<th>Category</th>
								<th width="200">Create & Update</th>                           
								<th>Hit</th>
								<th class="text-center" width="90">Action</th>
								<th class="text-center"></th>
							</tr>
						</thead>
						<tbody class="dragAndDrop">
							@php $l_count = 0; $t_count = 0; $fl_count = 0; @endphp
							@if(!empty($articles) && (count($articles)>0))
							@foreach($articles as $article)
							<tr class="{{!empty($article->editor_taken) ? 'editorWorkingDiv' : ''}}">
								<td>
									<label class="checkbox m-l m-t-none m-b-none i-checks">
										<input type="checkbox" name="ids[]" value="{{$article->id}},{{$article->category_id}}"><i></i>
									</label>
								</td>

								<td>
									@if(!empty($article->shoulder))<span class="shoulder" style="">{{$article->shoulder}}</span> <i class="fa fa-circle shoulderIcon"></i> @endif<span>{{$article->headline}}</span> @if(!empty($article->hanger))<i class="fa fa-circle hangerIcon"></i> <span class="hanger">{{$article->hanger}}</span> @endif

									@if(!empty($article->note))
									<p class="note"><u>নোট:</u> {!! $article->note !!}</p>
									@endif

									@if(!empty($article->editor_taken))<br><b class="fontSize12">Editing: {!! $article->editorTaken->name !!}@if(!empty($article->editor_taken_at)), AT: {!! date('d M y- H:i', strtotime($article->editor_taken_at)) !!}@endif</b>@endif
									@if(!empty($article->proved_id))
									<br>
									<b class="fontSize12">Proved By: {!! $article->provedBy->name !!}</b>
									@endif
								</td>

								<td>
									@if($article->display_position == 'lead')
									@php $l_count++; @endphp
									<span class="btn btn-xs btn-danger font-bold" style="width: 30px">L</span>
									@elseif($article->display_position == 'top')
									@php $t_count++; @endphp
									<span class="btn btn-xs btn-primary font-bold" style="width: 30px">T</span>
									@endif
								</td>

								<td>
									@if($article->id <= env('Old_NewsId'))
									<img src="{{env('Old_AssetLink').date('/Y/m/d/', strtotime($article->created_at)).$article->thumbnail}}" width="80px" class="img-responsive" />
									@elseif(!empty($article->thumbnail))
									<img src="{{env('New_AssetLink').date('/Y/m/d/', strtotime($article->created_at)).$article->thumbnail}}" width="80px" class="img-responsive" />
									@else 
									<img src="{{env('UploadsLink').'uploads/settings/'.$settingsInfo->default_img_2}}" width="80px" class="img-responsive" />
									@endif

									@if(empty($article->thumbnail))
									<p class="tpImageUpload"><input type="file" name="images[{{$article->id}}]"></p>
									@endif
								</td>

								<td>
									@if(!empty($article->articleCategories) && (count($article->articleCategories)>0))
									@foreach($article->articleCategories as $key1 => $category)
									{{$key1 != 0 ? ', ' : ''}}{{$category->categoryInfo->display_name}}
									@endforeach
									@endif
								</td>

								<td>
									<p class="margin0"><b><u>Create:</u> {{$article->createdBy->name}}</b></p>
									<p class="margin0">{{date('d M Y h:i A', strtotime($article->created_at))}}</p>
									@if(!empty($article->updated_at))
									<p class="margin0 marginT5"><b><u>Update:</u> {{$article->updatedBy ? $article->updatedBy->name : ''}}</b></p>
									<p class="margin0">{{date('d M Y h:i A', strtotime($article->updated_at))}}</p>
									@endif
								</td>

								<td>0</td>

								<td class="text-center">
									@if($article->id > env('Old_NewsId'))
									<a href="{{route('Posts Edit', $article->id)}}?redirect={{Request::fullUrl()}}" class="btn btn-primary btn-xs" title="Edit" ><i class="fa fa-edit"></i></a> 
									@endif
								</td>
								<td class="text-center">
									@if($article->status)
									<i class="fa fa-check text-success"></i>
									@else
									<i class="fa fa-times text-danger"></i>
									@endif
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-4">
							<select class="input-sm form-control input-s-sm inline v-middle bulkAction" name="bulkStatus" required="">
								<option value="0">Select</option>
								<option value="publishArticlePrint">Publish</option>
								<option value="updatePrintNewsPhoto">Update Photo</option>
							</select>
							<button type="submit" class="btn btn-sm btn-default">Apply</button>
						</div>
					</div>
				</footer>

			</form>
		</section>
	</section>
</section>
@endsection

@push('bottom-scripts')
<script src="{{asset('assets/js/plugins/chosen.jquery.min.js')}}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker.min.js') }}" ></script>
<script type="text/javascript">
	$('.datePicker').datetimepicker({
		todayBtn:  1,
		autoclose: 1,
		minView: 2
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
@endpush

