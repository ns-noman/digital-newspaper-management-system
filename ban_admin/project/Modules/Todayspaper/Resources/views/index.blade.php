@extends('layouts.app')
@section('title', 'Todayspaper News List')
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
			<header class="panel-heading font-bold">Todayspaper News | List 
				<a href="{{route('Todayspaper Create')}}" class="btn btn-xs btn-success pull-right"><i class="fa fa-plus"></i> New News</a>
				<select name="paginationAmount" class="input-sm form-control input-s-sm inline v-middle pull-right paginationAmount" style="margin-right: 10px;padding: 2px 5px;height: 23px;width: 100px">
					<option value="10">News- 10</option>
					<option value="50" {{isset($_GET['paginationAmount']) && $_GET['paginationAmount'] == 50 ? 'selected' : Null}}>News- 50</option>
					<option value="100" {{isset($_GET['paginationAmount']) && $_GET['paginationAmount'] == 100 ? 'selected' : Null}}>News- 100</option>
					<option value="200" {{isset($_GET['paginationAmount']) && $_GET['paginationAmount'] == 200 ? 'selected' : Null}}>News- 200</option>
					<option value="300" {{isset($_GET['paginationAmount']) && $_GET['paginationAmount'] == 300 ? 'selected' : Null}}>News- 300</option>
				</select>
			</header>

			<div class="row wrapper">
				<form method="get">
					<input type="hidden" name="paginationAmount" value="{{isset($_GET['paginationAmount']) && !empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : 10}}">

					<div class="col-sm-2">                               
						<div class="input-group date datePicker" data-date-format="yyyy-mm-dd"> 
							<input type="text" name="dateFrom" value="{!! isset($_GET['dateFrom']) && !empty($_GET['dateFrom']) ? date('Y-m-d', strtotime($_GET['dateFrom'])) : '' !!}" class="form-control" placeholder="Date From" autocomplete="off"> 
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
						</div> 
					</div>

					<div class="col-sm-2" style="padding-left: 0px">                               
						<div class="input-group date datePicker" data-date-format="yyyy-mm-dd"> 
							<input type="text" name="dateTo" value="{!! isset($_GET['dateTo']) && !empty($_GET['dateTo']) ? date('Y-m-d', strtotime($_GET['dateTo'])) : '' !!}" class="form-control" placeholder="Date To" autocomplete="off"> 
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
						</div> 
					</div>

					<div class="col-sm-2" style="padding-left: 0px">
						<select style="width:100%" name="category" class="chosen-select onlinecategory">
							<option value="">-Select Category-</option>
							@if(!empty($categories) && (count($categories)>0))
							@foreach($categories as $category)
							<option {!! isset($_GET['category']) && $_GET['category'] == $category->id ? 'selected' : '' !!} value="{{$category->id}}" class="optionGroup">{{$category->display_name}}</option>
							@if(!empty($category->childCategoriesActive) && (count($category->childCategoriesActive)>0))
							@foreach($category->childCategoriesActive as $subcategory)
							<option {!! isset($_GET['category']) && $_GET['category'] == $subcategory->id ? 'selected' : '' !!} value="{{$subcategory->id}}" class="optionChild">{{$subcategory->display_name}}</option>
							@endforeach
							@endif 
							@endforeach
							@endif
						</select>
					</div>

					<div class="col-sm-3" style="padding-left: 0px">
						<input type="text" name="headline" value="{!! isset($_GET['headline']) && !empty($_GET['headline']) ? $_GET['headline'] : '' !!}" class="form-control" placeholder="Headline" />
					</div>

					<div class="col-sm-1" style="padding-left: 0px">
						<input type="text" name="reporter" value="{!! isset($_GET['reporter']) && !empty($_GET['reporter']) ? $_GET['reporter'] : '' !!}" class="form-control" placeholder="Reporter" />
					</div>

					<div class="col-sm-1" style="padding-left: 0px">
						<input type="text" name="newsId" value="{!! isset($_GET['newsId']) && !empty($_GET['newsId']) ? $_GET['newsId'] : '' !!}" class="form-control" placeholder="News ID" />
					</div>

					<div class="col-sm-1" style="padding-left: 0px">
						<button type="submit" class="btn btn-default" style="width: 100%">Search</button>
					</div>
				</form>
			</div>

			<form method="post" action="{{route('Todayspaper Bulk Update')}}">
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
										<input type="checkbox" name="ids[]" value="{{$article->id}},{{$article->order_id}}"><i></i>
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
								<option value="0" class="optionGroup" disabled="">Placement</option>
								<option value="no_placement">No Placement</option>
								<option value="lead">Lead</option>
								<option value="top">Top</option>
								<option value="0" class="optionGroup" disabled="">Other Options</option>
								<option value="swapOrder">Swap Order</option>
								<option value="releaseArticle">Release Article</option>
								<option value="0" class="optionGroup" disabled="">Post Status</option>
								<!-- <option value="publish">Publish</option> -->
								<option value="unpublish">Unpublish</option>
								@if(Auth::user()->role == 'admin')
								<option value="remove">Remove</option>
								@endif
							</select>
							<button type="submit" class="btn btn-sm btn-default">Apply</button>
						</div>

						@if(!empty($articles) && count($articles)>0)
						<div class="col-sm-8 text-right customPaginationStyle">
							{{$articles->appends(request()->input())->links()}}
						</div>
						@endif
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
@endpush

