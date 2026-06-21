@extends('layouts.app') 
@section('title', 'Dashboard') 

@push('top-scripts')
<style>
@media only screen and (max-width: 667px) {
    .legend{
        display: none;
    }
    .xs-marginT20{
        margin-top: 20px;
    }
}
</style>
@endpush

@section('content')

<section class="hbox stretch">
	<section>
		<section class="vbox">
			<section class="scrollable padder">
				<br>
				<div class="row flex-row">

					<div class="col-sm-3 col-xs-12">
						<div class="row">
							<div class="col-md-12">
								<div style="background-color: #411542;padding: 10px;margin-bottom: 10px">
									<a href="#" class="block padder-v hover">
										<span class="i-s i-s-2x pull-left m-r-sm" style="background-color:#1DC499;color:white;border-top-right-radius: 30%"><i class="fa fa-users"></i></span>
										<span class="clear"> <span class="h3 block m-t-xs text-success">{{$totalUser}} </span></span> <small class="text-muted text-u-c">Total Users</small> 
									</a>
								</div>
							</div>
							<div class="col-md-12">
								<div style="background-color: #411542;padding: 10px;margin-bottom: 10px">
									<a href="#" class="block padder-v hover">
										<span class="i-s i-s-2x pull-left m-r-sm" style="background-color:#1CCACC;color:white;border-top-right-radius: 30%"><i class="fa fa-header"></i></span>
										<span class="clear"> <span class="h3 block m-t-xs text-info">{{$activeScrolls ? $activeScrolls : '0'}}</span>  <small class="text-muted text-u-c">Active Breakings</small> 
									</span>
								</a>
							</div>
						</div>
						<div class="col-md-12">
							<div style="background-color: #411542;padding: 10px;margin-bottom: 10px">
								<a href="#" class="block padder-v hover">
									<span class="i-s i-s-2x pull-left m-r-sm" style="background-color:#CDDC39;color:white;border-top-right-radius: 30%"><i class="fa fa-file-o"></i></span>
									<span class="clear"> <span class="h3 block m-t-xs text-success">{{$todaysNews ? $todaysNews : '0'}} </span></span> <small class="text-muted text-u-c">Todays News</small> 
								</a>
							</div>
						</div>
						<div class="col-md-12">
							<div style="background-color: #411542;padding: 10px">
								<a href="#" class="block padder-v hover"> 
									<span class="i-s i-s-2x pull-left m-r-sm" style="background-color:#177BBB;color:white;border-top-right-radius: 30%"><i class="fa fa-star-half-o"></i></span>
									<span class="clear"> <span class="h3 block m-t-xs text-primary ajaxTodaysHit">0</span>  <small class="text-muted text-u-c">Todays HIT</small> 
								</span>
							</a>
						</div>
					</div>
				</div>
			</div>


			<div class="col-md-9 col-xs-12 xs-marginT20">
				<section style="background-color: white;padding: 0px 10px;height: 100%">
					<header class="font-bold padder-v">
						<div class="btn-group pull-right">
							<button data-toggle="dropdown" class="btn btn-sm btn-rounded btn-default dropdown-toggle"> <span class="dropdown-label">Today</span> 
							</button>
						</div>Analysis</header>
						<div class="panel-body flot-legend">
							<div id="flot-pie-donut" style="height:240px"></div>
						</div>
					</section>
				</div>
			</div>

		</section>
	</section>
</section>
</section>

@endsection 

@push('bottom-scripts')
<script src="{{asset('assets/js/plugins/charts/jquery.flot.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/charts/jquery.flot.pie.min.js')}}"></script>

<script type="text/javascript">
	var da = [
	@foreach($pieData as $item)
	{
		label: "{{$item->label}} ({{$item->data}})",
		data: {{$item->data}}
	},
	@endforeach    
	],
	
	da1 = [],
	series = Math.floor(Math.random() * 4) + 3;
	for (var i = 0; i < series; i++) {
		da1[i] = {
			label: "Series" + (i + 1),
			data: Math.floor(Math.random() * 100) + 1
		}
	}
	
	$("#flot-pie-donut").length && $.plot($("#flot-pie-donut"), da, {
		series: {
			pie: {
				innerRadius: 0.4,
				show: true,
				stroke: {
					width: 0
				},
				label: {
					show: true,
					threshold: 0.05
				},
			}
		},
		colors: ["#65b5c2","#4da7c1","#3993bb","#2e7bad","#23649e"],
		grid: {
			hoverable: true,
			clickable: false
		},
		tooltip: true,
		tooltipOpts: {
			content: "%s: %p.0%"
		}
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$(".toggleActiveUser").click(function(){
			$(".toggledActiveUser").toggle();
		});
	});
</script>

<script type="text/javascript">
	$.ajax({
		type: 'GET',
		url: '{{URL("ajax/todayshit")}}',
		success: function (data){
			$('.ajaxTodaysHit').html(data);
		}
	});
</script>
@endpush