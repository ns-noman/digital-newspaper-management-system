<!-- photo cart modal -->
<div id="photoCardModal" class="modal fade" role='dialog' style="overflow: scroll;">
	<div class="modal-dialog modal-lg" style="width: 1300px">
		<div class="content">
			<div class="modal-content" >
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Generate Photo Card</h4>
				</div>
				<div class="modal-body text-center" style="background-color: #ecf5f5;">
					<div class="photoFrameDiv">
						<p class="photoFrameDivTitle">Select Frame</p>

						<!-- <div class="selectDesign selectedDesign" data-design="9">
							<p class="selectDesignTitle">D9 <span class="selectDesignSelect"><i class="fa fa-check"></i></span></p>
							<p class="selectDesignCart"><img src="{!! asset('assets/images/photoframes/cartdesign-9.jpg') !!}" class="img-responsive"></p>
						</div>

						<div class="selectDesign" data-design="8">
							<p class="selectDesignTitle">D8 <span class="selectDesignSelect"></span></p>
							<p class="selectDesignCart"><img src="{!! asset('assets/images/photoframes/cartdesign-8.jpg') !!}" class="img-responsive"></p>
						</div>
						
						<div class="selectDesign" data-design="7">
							<p class="selectDesignTitle">D7 <span class="selectDesignSelect"></span></p>
							<p class="selectDesignCart"><img src="{!! asset('assets/images/photoframes/cartdesign-7.jpg') !!}" class="img-responsive"></p>
						</div>

						<div class="selectDesign" data-design="6">
							<p class="selectDesignTitle">D6 <span class="selectDesignSelect"></span></p>
							<p class="selectDesignCart"><img src="{!! asset('assets/images/photoframes/cartdesign-6.jpg') !!}" class="img-responsive"></p>
						</div>

						<div class="selectDesign" data-design="5">
							<p class="selectDesignTitle">D5 <span class="selectDesignSelect"></span></p>
							<p class="selectDesignCart"><img src="{!! asset('assets/images/photoframes/cartdesign-5.jpg') !!}" class="img-responsive"></p>
						</div>

						<div class="selectDesign" data-design="4">
							<p class="selectDesignTitle">D4 <span class="selectDesignSelect"></span></p>
							<p class="selectDesignCart"><img src="{!! asset('assets/images/photoframes/cartdesign-4.jpg') !!}" class="img-responsive"></p>
						</div>

						<div class="selectDesign" data-design="3">
							<p class="selectDesignTitle">D3 <span class="selectDesignSelect"></span></p>
							<p class="selectDesignCart"><img src="{!! asset('assets/images/photoframes/cartdesign-3.jpg') !!}" class="img-responsive"></p>
						</div> -->

						<div class="selectDesign selectedDesign" data-design="1">
							<p class="selectDesignTitle">D1 <span class="selectDesignSelect"><i class="fa fa-check"></i></span></p>
							<p class="selectDesignCart"><img src="{!! asset('assets/images/photoframes/cartdesign-1.jpg') !!}" class="img-responsive"></p>
						</div>

						<div class="selectDesign" data-design="2">
							<p class="selectDesignTitle">D2 <span class="selectDesignSelect"></span></p>
							<p class="selectDesignCart"><img src="{!! asset('assets/images/photoframes/cartdesign-2.jpg') !!}" class="img-responsive"></p>
						</div>

						<div class="selectDesign" data-design="3">
							<p class="selectDesignTitle">D3 <span class="selectDesignSelect"></span></p>
							<p class="selectDesignCart"><img src="{!! asset('assets/images/photoframes/cartdesign-3.jpg') !!}" class="img-responsive"></p>
						</div>

						<div class="selectDesign" data-design="4">
							<p class="selectDesignTitle">D4 <span class="selectDesignSelect"></span></p>
							<p class="selectDesignCart"><img src="{!! asset('assets/images/photoframes/cartdesign-4.jpg') !!}" class="img-responsive"></p>
						</div>

						<div class="selectDesign" data-design="5">
							<p class="selectDesignTitle">D5 <span class="selectDesignSelect"></span></p>
							<p class="selectDesignCart"><img src="{!! asset('assets/images/photoframes/cartdesign-5.jpg') !!}" class="img-responsive"></p>
						</div>

						<div class="selectDesign" data-design="6">
							<p class="selectDesignTitle">D6 <span class="selectDesignSelect"></span></p>
							<p class="selectDesignCart"><img src="{!! asset('assets/images/photoframes/cartdesign-6.jpg') !!}" class="img-responsive"></p>
						</div>

					</div>
					<div style="display: inline-block;width: 995px">
						<div id="generatedPhotoCard"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>


@push('bottom-scripts')
<script type="text/javascript">
	$('.photoCardModal').click(function(){
		$('#photoCardModal #generatedPhotoCard').html('<div class="text-center" style="padding: 50px"><i class="fa fa-spinner" style="font-size: 4rem"></i></div>');
		var newsid = $(this).data('newsid');
		var thumbnail = $(this).data('thumbnail');
		var design = $('.selectedDesign').data('design');
		$('#photoCardModal .modal-content .modal-body .selectDesign').attr('data-newsid', newsid);
		$('#photoCardModal .modal-content .modal-body .selectDesign').attr('data-thumbnail', thumbnail);

		var url = '{{url("tools/photocard/generate")}}/'+newsid+'?imageUrl='+thumbnail+'&design='+design;
		$.get(url, function(data){
			if(data != ''){
				$('#photoCardModal .modal-content .modal-body #generatedPhotoCard').html(data);
			}
		});
	});
</script>

<script type="text/javascript">
	$('#photoCardModal').on('click', '.selectDesign', function(){
		$('#photoCardModal #generatedPhotoCard').html('<div class="text-center" style="padding: 50px"><i class="fa fa-spinner" style="font-size: 4rem"></i></div>');
		var newsid = $(this).data('newsid');
		var thumbnail = $(this).data('thumbnail');
		var design = $(this).data('design');
		var url = '{{url("tools/photocard/generate")}}/'+newsid+'?imageUrl='+thumbnail+'&design='+design;
		$.get(url, function(data){
			if(data != ''){
				$('#photoCardModal .modal-content .modal-body #generatedPhotoCard').html(data);
			}
		});
	});
</script>

<script type="text/javascript">
	$('#photoCardModal').on('click', '.selectDesign', function(){
		$('#photoCardModal .selectDesign').removeClass('selectedDesign');
		$('#photoCardModal .selectDesignSelect').html('');
		$(this).addClass('selectedDesign');
		$('#photoCardModal .selectedDesign .selectDesignSelect').html('<i class="fa fa-check"></i>');
	})
</script>
@endpush