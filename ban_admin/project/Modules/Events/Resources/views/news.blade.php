@extends('layouts.app')
@section('title', 'Event News List')

@push('top-scripts')
<link href="{{asset('assets/css/chosen.css')}}" rel="stylesheet">
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
			<header class="panel-heading font-bold">Event: {!! $eventInfo->title !!} | News List 
				<a href="{{Request::url('/')}}" class="btn btn-xs btn-primary pull-right"><i class="fa fa-refresh"></i> Refresh</a>
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
						<input name="headline" type="text" class="input-sm form-control" value="{{!empty($_GET['headline']) ? $_GET['headline'] : ''}}" placeholder="Headline" autocomplete="off" />
					</div>
					<div class="col-sm-2 m-b-xs paddingL0">
						<select name="category" style="width: 100%" class="chosen-select" id="category">
							<option value="0">-Select Category-</option>
							@if(!empty($categories))
							@foreach($categories as $category)
							<option value="{{$category->id}}" class="optionGroup" {{!empty($_GET['category']) && $_GET['category'] == $category->id ? 'selected' : ''}}>{{$category->display_name}}</option>
							@if(!empty($category->childCategoriesActive))
							@foreach($category->childCategoriesActive as $subcategory)
							<option value="{{$subcategory->id}}" class="optionChild" {{!empty($_GET['category']) && $_GET['category'] == $subcategory->id ? 'selected' : ''}}>{{$subcategory->display_name}}</option>
							@endforeach
							@endif 
							@endforeach
							@endif
						</select>
					</div>
					<div class="col-sm-1 m-b-xs paddingL0">
						<button class="btn btn-sm btn-default btn-block">Search</button>
					</div>
				</form>
			</div>

			<form method="post" action="{{route('Events News Bulk Update')}}">
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
								<th width="300">Headline</th>
								<th>Event Lead</th>
								<th width="80">Thumbnail</th>
								<th>Category</th>
								<th width="170">Create</th>
								<th class="text-center" width="90">Action</th>
								<th class="text-center"></th>
							</tr>
						</thead>
						<tbody class="dragAndDrop">
							@php $evLCount = 0; @endphp
							@if(!empty($articles) && (count($articles)>0))
							@foreach($articles as $key => $article)
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
									@if(!empty($article->event_display_position))
									@php $evLCount++; @endphp
									<span class="btn btn-xs btn-danger font-bold">EL {{$evLCount}}</span>
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

								<td class="text-center">
									@if($article->id > env('Old_NewsId'))
									<a href="{{route('Posts Edit', $article->id)}}" class="btn btn-primary btn-xs" title="Edit" ><i class="fa fa-edit"></i></a> 
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
							<select class="input-sm form-control input-s-sm inline v-middle bulkAction" name="bulkStatus">
								<option value="0">Select</option>
								<option value="0" class="optionGroup" disabled="">Assign Event Lead</option>
								<option value="eventLeadNo">Remove Event Lead</option>
								<option value="eventLead">Event Lead</option>
								<option value="0" class="optionGroup" disabled="">Other Options</option>
								<option value="releaseArticle">Release Article</option>
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
@endsection

@push('bottom-scripts')
<script src="{{asset('assets/js/plugins/chosen.jquery.min.js')}}"></script>

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

