<style type="text/css">
	.photoFrameDiv{
		width: 200px;display: inline-block;vertical-align: top;margin-right: 10px;border-radius: 5px;padding-bottom: 20px;background-color: white;height: 995px;overflow-y: scroll;
	}
	.photoFrameDivTitle{
		margin-bottom: 0px;text-align: center;background-color: #7f0909;padding: 10px;color: white;font-size: 2rem;border-top-left-radius: 5px;border-top-right-radius: 5px;
	}
	.selectDesign{
		padding: 20px 20px 0px 20px;
	}
	.selectedDesign .selectDesignTitle{
		margin-bottom: 0px;cursor: pointer;font-size: 1.8rem;background-color: #7f0909;color: white;padding: 0px 8px;
	}
	.selectedDesign .selectDesignCart{
		margin-bottom: 0px;cursor: pointer;
	}

	.selectDesignTitle{
		margin-bottom: 0px;cursor: pointer;font-size: 1.8rem;background-color: #a7a0a0;color: white;padding: 0px 8px;
	}
	.selectDesignCart{
		margin-bottom: 0px;cursor: pointer;
	}
</style>
<!-- photo cart modal -->
<div id="generateCardModal" class="modal fade" role='dialog' style="overflow: scroll;">
	<div class="modal-dialog modal-lg" style="width: 1500px">
		<div class="content">
			<div class="modal-content" >
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Generate: Comment Card</h4>
				</div>
				<div class="modal-body text-center" style="background-color: #ecf5f5;">
					<div class="photoFrameDiv" style="display: inline-block;">
						<p class="photoFrameDivTitle">Select Frame</p>

						<div class="selectDesign selectedDesign" data-design="1">
							<p class="selectDesignTitle">D1 <span class="selectDesignSelect"><i class="fa fa-check"></i></span></p>
							<p class="selectDesignCart"><img src="{!! asset('assets/images/photoframes/commentcarddesign-1.jpg') !!}" class="img-responsive"></p>
						</div>

						<div class="selectDesign" data-design="2">
							<p class="selectDesignTitle">D2 <span class="selectDesignSelect"></span></p>
							<p class="selectDesignCart"><img src="{!! asset('assets/images/photoframes/commentcarddesign-2.jpg') !!}" class="img-responsive"></p>
						</div>
					</div>
					<div style="display: inline-block;width: 1000px">
						<div id="generatedPhotoCart">
							@include('tools::photo-cards.commentcards.card1')
						</div>
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
	$('.generateCardModal').click(function(){
	});
</script>

<script type="text/javascript">
	$('.selectDesign').click(function(){
		$('#generatedPhotoCart').html('<div class="text-center" style="padding: 50px"><i class="fa fa-spinner" style="font-size: 4rem"></i></div>');
		var design = $(this).data('design');
		var url = '{{url("tools/commentcard/ajax/generate")}}/?design='+design;
		$.get(url, function(data){
			if(data != ''){
				$('#generateCardModal .modal-content .modal-body #generatedPhotoCart').html(data);
			}
		});
	});
</script>

<script type="text/javascript">
	$('.selectDesign').click(function(){
		$('.selectDesign').removeClass('selectedDesign');
		$('.selectDesignSelect').html('');
		$(this).addClass('selectedDesign');
		$('.selectedDesign .selectDesignSelect').html('<i class="fa fa-check"></i>');
	})
</script>



@endpush