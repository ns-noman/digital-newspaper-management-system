<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Bengali:wght@100..900&display=swap" rel="stylesheet">

<style type="text/css">
	#photoCardModal p{
		font-family: 'Noto Serif Bengali','SolaimanLipi';
	}
	#photoCardModal span{
		font-family: 'Noto Serif Bengali','SolaimanLipi';
	}
	#photoCardModal .cartBody{
		width: 995px !important;height: 995px !important; margin: 0 auto;position: relative;
	}
	#photoCardModal .cartBody{
		width: 995px;margin: 0 auto;position: relative;background-color: #7f0909;
	}
	#photoCardModal .cartBody .frameImg{
		z-index: 10;position: relative;
	}
	#photoCardModal .cartBody .newsImg{
		position: absolute;left: 0;top: 0;width: 100%;
	}
	#photoCardModal .cartBody .titleMainDiv{
		position: absolute;top: 0;margin-top: 560px;text-align: center;width: 100%;height: 435px;z-index: 11;cursor: all-scroll;
	}
	#photoCardModal .cartBody .titleDiv{
		width: 100%;position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);padding: 50px;
	}
	#photoCardModal .cartBody .shoulderClass{
		color: rgb(67 255 0);font-size: 4rem;line-height: 6rem;
	}
	#photoCardModal .cartBody .hangerClass{
		color: #fb9e85;font-size: 4rem;line-height: 6rem;
	}
	#photoCardModal .cartBody .headlineClass{
		margin-bottom: 0px;color: white;font-size: 6rem;font-weight: bold;line-height: 8rem;
	}
	#photoCardModal .downloadButton{
		margin-top: 20px;
		margin-bottom: 10px;
		border-radius: 50px;
	}

	@if(!empty($newsInfo->meta_sticker) && !empty($newsInfo->metaStickerInfo) && $newsInfo->metaStickerInfo->photocard_status == 1)
	#photoCardModal .cartBody{
		height: 1125px !important;
	}
	@endif
</style>


<div class="cartBody" id="cartBody{!! $uniqueId !!}">
	<img src="{{$b64image}}" id="photoCartThumbnail" class="newsImg">
	<div style="position: absolute;top: 0;left: 0;margin-top: 50px;font-size: 2rem;color: white;background-color: #017AC3;width: 200px;text-align: center;padding: 8px 8px 5px 8px;border-bottom-right-radius: 30px;"><p style="margin-bottom: 0px;"><span style="height: 25px;width: 5px;background-color: white;display: inline-block;margin-right: 5px;margin-top: -3px;vertical-align: middle;"></span> {!! \App\Http\Controllers\CommonController::GetBangla(date('d M, Y', strtotime($newsInfo->created_at))) !!}</p></div>

	<div style="position: absolute;top: 0;width: 100%;margin-top: 470px;height: 100px;z-index: 99;background-image: linear-gradient(#00000000, rgb(0 0 0));">
		<p style="border-bottom: 5px solid white;position: absolute;width: 100%;bottom: 0;height: 13px;"><span style="background-color: white;padding: 15px 50px;border-radius: 10px;margin-top: -20px;"><img src="{!! asset('assets/images/photoframes/logo.png') !!}" style="height: 25px;"></span></p>
	</div>
	<div class="titleMainDiv" style="background-image: url('{!! asset('assets/images/photoframes/bg.jpg') !!}')">
		<div class="titleDiv">
			<div id="draggable">
				<p class="shoulderClass" style="display: {!! empty($newsInfo->shoulder) ? 'none' : '' !!}">{!! $newsInfo->shoulder !!}</p>
				<p class="headlineClass">{!! $newsInfo->headline !!}</p>
				<p class="hangerClass" style="display: {!! empty($newsInfo->hanger) ? 'none' : '' !!}">{!! $newsInfo->hanger !!}</p>
			</div>
		</div>
		<p style="text-align: center;position: absolute;bottom: 0;width: 100%;margin-bottom: 30px;"><span style="background-color: #017AC3;color: white;padding: 5px 30px 3px 30px;border-radius: 50px;font-size: 2.5rem;">বিস্তারিত কমেন্টে</span></p>
	</div>

	@if(!empty($newsInfo->meta_sticker) && !empty($newsInfo->metaStickerInfo) && $newsInfo->metaStickerInfo->photocard_status == 1)
	<div style="position: fixed;margin-top: 995px;">
		<img src="{!! asset('assets/images/fbstickers/'.$newsInfo->metaStickerInfo->sticker) !!}" style="width: 995px;height: 130px">
	</div>
	@endif
</div>


<div style="margin-top: 30px;background-color: white;padding: 20px;border-radius: 10px">
	<div class="row">
		<div class="col-md-9 text-left">
			<div class="row">
				<div class="col-md-12 paddingR0 text-left">
					<label>Headline</label>
					<input type="text" value="{!! $newsInfo->headline !!}" class="typeHeadline form-control">
				</div>
				<div class="col-md-12 paddingR0 text-left marginT5">
					<label>Shoulder</label>
					<input type="text" value="{!! $newsInfo->shoulder !!}" class="typeShoulder form-control">
				</div>
				<div class="col-md-12 paddingR0 text-left marginT5">
					<label>Hanger</label>
					<input type="text" value="{!! $newsInfo->hanger !!}" class="typeHanger form-control">
				</div>
			</div>
		</div>
		<div class="col-md-3 text-left">
			<div class="row">
				<div class="col-md-12">
					<label>Date</label>
					<input type="text" value="{!! \App\Http\Controllers\CommonController::GetBangla(date('d M Y', strtotime($newsInfo->created_at))) !!}" class="typeDate form-control">
				</div>

				<div class="col-md-12 marginT5">
					<label>Photo (995x560)</label>
					<input type="file" accept="image/*" onchange="loadFile(event)" class="form-control browseImage">
				</div>

				<div class="col-md-12 marginT5">
					<label>Font Size</label>
					<select class="form-control selectFontSize">
						<option value="large">Large</option>
						<option value="medium">Medium</option>
						<option value="small">Small</option>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>

<button type="button" class="btn btn-lg btn-success downloadButton downloadCard{!! $uniqueId !!}">Generate & Download</button>




<!-- generate photo cart -->
<script src="{{asset('assets/js/jquery.3.3.1.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script type="text/javascript">
	$(".downloadCard{!! $uniqueId !!}").on('click', function () {
		var fileName = 'photocard-{!! $newsInfo->id !!}';
		html2canvas(document.getElementById("cartBody{!! $uniqueId !!}")).then(function (canvas) {
			var anchorTag = document.createElement("a");
			document.body.appendChild(anchorTag);
			anchorTag.download = fileName+".png";
			anchorTag.href = canvas.toDataURL();
			anchorTag.target = '_blank';
			anchorTag.click();
		});
	});
</script>

<script type="text/javascript">
	$('.typeShoulder').keyup(function(e){
		e.preventDefault();
		var typeShoulder = $('.typeShoulder').val();
		$('.shoulderClass').html(typeShoulder);
		if(typeShoulder.length > 0){
			$('.shoulderClass').show();
		}else{
			$('.shoulderClass').hide();
		}
	});

	$('.typeHeadline').keyup(function(e){
		e.preventDefault();
		var typeHeadline = $('.typeHeadline').val();
		$('.headlineClass').html(typeHeadline);
	});

	$('.typeHanger').keyup(function(e){
		e.preventDefault();
		var typeHanger = $('.typeHanger').val();
		$('.hangerClass').html(typeHanger);
		if(typeHanger.length > 0){
			$('.hangerClass').show();
		}else{
			$('.hangerClass').hide();
		}
	});

	$('.typeDate').keyup(function(e){
		e.preventDefault();
		var typeDate = $('.typeDate').val();
		$('.dateClass').html(typeDate);
		if(typeDate.length > 0){
			$('.dateClass').show();
		}else{
			$('.dateClass').hide();
		}
	});

	$('.selectFontSize').on('change', function(e){
		e.preventDefault();
		var fontSize = $('.selectFontSize').val();
		if(fontSize == 'large'){
			$('.headlineClass').css({'font-size' : '6rem', 'line-height' : '8rem'});
			$('.shoulderClass').css({'font-size' : '4rem', 'line-height' : '6rem'});
			$('.hangerClass').css({'font-size' : '4rem', 'line-height' : '6rem'});
		}
		if(fontSize == 'medium'){
			$('.headlineClass').css({'font-size' : '5rem', 'line-height' : '7rem'});
			$('.shoulderClass').css({'font-size' : '3rem', 'line-height' : '4.5rem'});
			$('.hangerClass').css({'font-size' : '3rem', 'line-height' : '4.5rem'});
		}
		if(fontSize == 'small'){
			$('.headlineClass').css({'font-size' : '3.5rem', 'line-height' : '5rem'});
			$('.shoulderClass').css({'font-size' : '2.5rem', 'line-height' : '3.5rem'});
			$('.hangerClass').css({'font-size' : '2.5rem', 'line-height' : '3.5rem'});
		}
	});
</script>

<script type="text/javascript">
	var loadFile = function(event) {
		var reader = new FileReader();
		reader.readAsDataURL(event.target.files[0]); 
		reader.onloadend = function() {
			var base64data = reader.result;                
			$('.newsImg').attr('src', base64data);
		}
	};
</script>

<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script>
	$(function(){
		$('#photoCardModal #draggable').draggable();
	});
</script>