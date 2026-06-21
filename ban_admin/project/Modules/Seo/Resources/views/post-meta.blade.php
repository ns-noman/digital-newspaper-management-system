@extends('layouts.app')
@section('title', 'Post Meta')

@push('top-scripts')
<link href="{{asset('assets/css/chosen.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/bootstrap-tagsinput.css')}}" rel="stylesheet">
<style type="text/css">
	.bootstrap-tagsinput{
		width: 100%
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
			<header class="panel-heading font-bold">Post | Meta Data</header>
			<div class="row wrapper">
				<form method="get">
					<input type="hidden" name="search" value="yes">
					
					<div class="col-sm-2 m-b-xs">
						<select name="category" style="width: 100%" class="chosen-select" id="category">
							<option value="0">-Select Category-</option>
							@if(!empty($categories))
							@foreach($categories as $category)
							<option value="{{$category->id}}" class="optionGroup" {{!empty($_GET['category']) && $_GET['category'] == $category->id ? 'selected' : ''}}>{{$category->display_name}}</option>
							@if(!empty($category->subcategories))
							@foreach($category->subcategories as $subcategory)
							<option value="{{$subcategory->id}}" class="optionChild" {{!empty($_GET['category']) && $_GET['category'] == $subcategory->id ? 'selected' : ''}}>{{$subcategory->display_name}}</option>
							@endforeach
							@endif 
							@endforeach
							@endif
						</select>
					</div>
					<div class="col-sm-2 m-b-xs" style="padding-left: 0px">
						<input name="headline" type="text" class="input-sm form-control" value="{{!empty($_GET['headline']) ? $_GET['headline'] : ''}}" placeholder="Headline" autocomplete="off" />
					</div>
					<div class="col-sm-2 m-b-xs" style="padding-left: 0px">
						<button class="btn btn-sm btn-default btn-block">Search</button>
					</div>
				</form>
			</div>

			@if(!empty($lists) && (count($lists)>0))
			<form method="post" action="{{route('Seo Post Meta Update')}}" enctype="multipart/form-data">
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
								<th width="30%">Post</th>
								<th width="40%">Meta Description</th>
								<th width="15%">Meta Keywords</th>
								<th width="15%">News Tag</th>
							</tr>
						</thead>

						<tbody>
							@foreach($lists as $key => $article)
							<tr>
								<td>
									<label class="checkbox m-l m-t-none m-b-none i-checks">
										<input type="checkbox" name="articles[]" value="{{$article->id}}"><i></i>
									</label>
								</td>
								<td>
									<p><a style="color: blue" href="{{env('WEBSITE').$article->categories->title.'/'.$article->id}}" target="_blank">{{$article->headline}}</a></p>
									<p style="margin-bottom: 0px">
										{!! date('Y-m-d H:i', strtotime($article->created_at)) !!} ({!! $article->createdBy->name !!})</p>
									</td>

									<td>
										<textarea name="meta_description[{{$article->id}}]" class="form-control" required="" rows="6">{!! $article->description !!}</textarea>
									</td>

									<td>
										<input type="text" name="keywords[{{$article->id}}]" class="form-control tags_input" value="{{$article->keywords}}" data-role="tagsinput">
									</td>

									<td>
										<input type="text" name="tags[{{$article->id}}]" class="form-control tags_input" value="{{$article->tags}}" data-role="tagsinput">
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<footer class="panel-footer">
						<div class="row">
							<div class="col-sm-2">
								<button type="submit" class="btn btn-sm btn-success btn-block">Apply Update</button>
							</div>
							@if(!empty($lists) && count($lists)>0)
							<div class="col-sm-7 col-sm-offset-3 text-right customPaginationStyle">
								{{$lists->appends(request()->input())->links()}}
							</div>
							@endif
						</div>
					</footer>
				</form>
				@endif

			</section>
		</section>
	</section>

	@endsection


	@push('bottom-scripts')
	<script src="{{asset('assets/js/plugins/bootstrap-tagsinput.min.js')}}"></script>
	<script src="{{asset('assets/js/plugins/chosen.jquery.min.js')}}"></script>
	@endpush

