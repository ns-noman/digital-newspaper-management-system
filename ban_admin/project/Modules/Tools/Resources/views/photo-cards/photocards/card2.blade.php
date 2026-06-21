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
		width: 995px;margin: 0 auto;position: relative;
	}
	#photoCardModal .cartBody{
		width: 995px;margin: 0 auto;position: relative;
	}
	#photoCardModal .cartBody .frameImg{
		z-index: 10;position: relative;
	}
	#photoCardModal .cartBody .newsImg{
		position: absolute;left: 0;top: 0;width: 100%;z-index: 99;
		margin-top: 46px;
		width: 888px;
		margin-left: 54px;
	}
	#photoCardModal .cartBody .titleMainDiv{
		position: absolute;top: 0;margin-top: 600px;text-align: center;width: 100%;height: 310px;z-index: 11;cursor: all-scroll;
	}
	#photoCardModal .cartBody .titleDiv{
		width: 100%;position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);padding: 50px;
	}
	#photoCardModal .cartBody .shoulderClass{
		color: rgb(117 220 72);font-size: 4rem;line-height: 6rem;
	}
	#photoCardModal .cartBody .hangerClass{
		color: #afafaf;font-size: 4rem;line-height: 6rem;
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
	<img src="{{asset('assets/images/photoframes/cardframe-2.png')}}" class="frameImg">
	<img src="{{$b64image}}" id="photoCartThumbnail" class="newsImg">
	<span style="position: absolute;z-index: 999;left: 0;border-radius: 5px;background-color: white;padding: 3px;margin-top: 520px;margin-left: 357px">
		<img src="{!! asset('assets/images/photoframes/logo-white.png') !!}" style="background-color: #a40202;width: 280px;padding: 10px;border-radius: 10px;">
	</span>
	<div id="draggable" class="titleMainDiv">
		@if(!empty($authorPhotos))
		<div class="titleDiv" style="display: flex;flex-wrap: wrap;">
			<div style="width: 25%;float: left;padding-right: 20px">
				@if(!empty($authorPhotos))
				<img src="{{ $authorPhotos }}" style="border-radius: 50%;border: 10px solid #e8e8e8;z-index: 99;width: 120px">
				<p style="font-size: 2.3rem;border: 1px solid #ffffff;border-radius: 10px;color: white;padding: 5px;box-shadow: 0px 0px 6px rgb(107 86 86 / 55%);margin-top: 10px;margin-bottom: 0px;">{!! $authorNames !!}</p>
				@endif
			</div>
			<div style="width: 75%;float: right;border-left: 5px solid white;text-align: left;padding-left: 20px;display: grid;align-items: center;">
				<p class="shoulderClass" style="display: {!! empty($newsInfo->shoulder) ? 'none' : '' !!}">{!! $newsInfo->shoulder !!}</p>
				<p class="headlineClass">{!! $newsInfo->headline !!}</p>
				<p class="hangerClass" style="display: {!! empty($newsInfo->hanger) ? 'none' : '' !!}">{!! $newsInfo->hanger !!}</p>
			</div>
		</div>
		@else
		<div class="titleDiv">
			<p class="shoulderClass" style="display: {!! empty($newsInfo->shoulder) ? 'none' : '' !!}">{!! $newsInfo->shoulder !!}</p>
			<p class="headlineClass">{!! $newsInfo->headline !!}</p>
			<p class="hangerClass" style="display: {!! empty($newsInfo->hanger) ? 'none' : '' !!}">{!! $newsInfo->hanger !!}</p>
		</div>
		@endif

		<p style="position: absolute;bottom: 0;margin-bottom: -49px;width: 100%;text-align: left;z-index: 999;color: white;margin-left: 25px;">
			<span class="dateClass" style="font-size: 2.7rem;padding: 4px 15px;border-top-left-radius: 20px;border-top-right-radius: 20px;">{!! \App\Http\Controllers\CommonController::GetBangla(date('d M Y', strtotime($newsInfo->created_at))) !!}</span>
			<span class="dateClass" style="font-size: 2.7rem;padding: 4px 15px;border-top-left-radius: 20px;border-top-right-radius: 20px;"><i class="fa fa-globe"></i> {!! str_replace(['https://', '/', 'www.'], '', $settingsInfo->domain) !!}</span>
		</p>
	</div>

	@if(!empty($newsInfo->meta_sticker) && !empty($newsInfo->metaStickerInfo) && $newsInfo->metaStickerInfo->photocard_status == 1)
	<div>
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