@extends('layouts.app')
@section('title', 'Tools')

@push('top-scripts')
<link href="{{asset('assets/css/jasny-bootstrap.min.css')}}" rel="stylesheet" />
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
			<header class="panel-heading font-bold">Tools
			</header>

			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6 col-md-3">
						<div class="thumbnail" style="box-shadow: 0px 0px 6px rgb(186 186 186 / 40%);margin-bottom: 0px">
							<div class="caption" style="padding: 20px;">
								<h3 style="margin-top: 0px"><b>Photo<br> Comment Card</b></h3>
								<p><b>Choose and generate photo cards for person's comment.</b></p>
								<p style="margin-top: 20px;margin-bottom: 0px"><a style="border-radius: 5px" data-toggle="modal" data-target="#generateCardModal" title="Generate Card" class="btn btn-lg btn-success cursorPointer generateCardModal" role="button">Generate</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>

		</section>
	</section>
</section>


<!-- generate comment card modal -->
@include('tools::photo-cards.commentcards.cardLayout')

@endsection


@push('bottom-scripts')
@endpush

