@extends('layouts.app')
@section('title', 'Election Result')

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


		<div class="panel panel-default">
			<div class="panel-heading"><b>Election Result | {{$electionInfo->title}}</b></div>
			<div class="panel-body">
				<form role="form" class="form-horizontal" method="post" action="{{route('Elections Results Update')}}"  enctype="multipart/form-data" >
					{{csrf_field()}}
					<input type="hidden" name="election_id" value="{{$electionInfo->id}}" required="">

					@if(!empty($electionInfo))
					<table class="table table-bordered" style="margin-bottom: 20px">
						<thead>
							<tr>
								<th>Total Voter</th>
								<th>Male Voter</th>
								<th>Female Voter</th>
								<th>Other Voter</th>
								<th>Total Center</th>
								<th>Published Center</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input type="number" value="{{$electionInfo->total_voter ? $electionInfo->total_voter : 0}}" name="total_voter" class="form-control" min="0" /></td>
								<td><input type="number" value="{{$electionInfo->male_voter ? $electionInfo->male_voter : 0}}" name="male_voter" class="form-control" min="0" /></td>
								<td><input type="number" value="{{$electionInfo->female_voter ? $electionInfo->female_voter : 0}}" name="female_voter" class="form-control" min="0" /></td>
								<td><input type="number" value="{{$electionInfo->other_voter ? $electionInfo->other_voter : 0}}" name="other_voter" class="form-control" min="0" /></td>
								<td><input type="number" value="{{$electionInfo->total_center ? $electionInfo->total_center : 0}}" name="total_center" class="form-control" min="0" /></td>
								<td><input type="number" value="{{$electionInfo->published_center ? $electionInfo->published_center : 0}}" name="published_center" class="form-control" min="0" /></td>
							</tr>
						</tbody>
					</table>
					@endif


					@if(!empty($electionInfo->figures) && count(
					$electionInfo->figures)>0)
					<table class="table table-bordered" style="margin-bottom: 0px">
						<thead>
							<tr>
								<th>Figure Name</th>
								<th>Total Vote Earned</th>
								<th>Total Leads</th>
								<th>Total Wins</th>
							</tr>
						</thead>
						<tbody>
							@foreach($electionInfo->figures as $list)
							<tr>
								<td><b>{!! $list->figure_name !!}</b><br>{!! $list->symbol_name !!}</td>
								<td>
									<input type="number" value="{{$list->total_vote}}" name="figures[{{$list->id}}]" class="form-control" min="0" />
								</td>
								<td>
									<input type="number" value="{{$list->total_leads}}" name="leads[{{$list->id}}]" class="form-control" min="0" />
								</td>
								<td>
									<input type="number" value="{{$list->total_wins}}" name="wins[{{$list->id}}]" class="form-control" min="0" />
								</td>
							</tr>
							@endforeach
							<tr>
								<th colspan="4">
									<button class="btn btn-success btn-block" type="submit">Update Result</button>
								</th>
							</tr>
						</tbody>
					</table>
					@endif
				</form>
			</div>
		</div>

	</section>
</section>
@endsection

@push('bottom-scripts')

@endpush