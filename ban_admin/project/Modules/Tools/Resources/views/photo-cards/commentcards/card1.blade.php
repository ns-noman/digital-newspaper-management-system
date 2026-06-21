<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Bengali:wght@100..900&display=swap" rel="stylesheet">
<link href="{{asset('assets/css/text-editor.css')}}" rel="stylesheet">

<style type="text/css">
	#generateCardModal p{
		font-family: 'Noto Serif Bengali','SolaimanLipi';
	}
	#generateCardModal span{
		font-family: 'Noto Serif Bengali','SolaimanLipi';
	}
	#generateCardModal .cartBody{
		width: 1000px !important;height: 1000px !important; margin: 0 auto;position: relative;
	}
	#generateCardModal .cartBody{
		width: 1000px;margin: 0 auto;position: relative;
	}
	#generateCardModal .cartBody .frameImg{
		z-index: 10;position: relative;
	}
	#generateCardModal .cartBody .newsImg{
		position: absolute;left: 0;top: 0;width: 1000px;
	}
	#generateCardModal .cartBody .titleMainDiv{
		position: absolute;top: 0;margin-top: 560px;text-align: center;width: 100%;height: 435px;z-index: 11
	}
	#generateCardModal .cartBody .titleDiv{
		width: 100%;position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);padding: 50px;
	}
	#generateCardModal .cartBody .shoulderClass{
		color: black;font-size: 4rem;line-height: 6rem;font-weight: bold;margin-bottom: 0px;text-align: left;
	}
	#generateCardModal .cartBody .hangerClass{
		color: black;font-size: 4rem;line-height: 6rem;margin-bottom: 0px;text-align: left;
	}
	#generateCardModal .cartBody .headlineClass{
		margin-bottom: 0px;color: black;font-weight: bold;font-size: 5rem;line-height: 7rem;
	}
	#generateCardModal .downloadButton{
		margin-top: 20px;
		margin-bottom: 10px;
		border-radius: 50px;
	}
	#generateCardModal .bgColorStory{
		width: 1000px;height: 1000px;
	}
</style>


<div class="cartBody" id="cartBody1" style="overflow: hidden;">
	<div class="bgColorStory" style="background-image: url({!! asset('assets/images/photoframes/commentcardlayout-1.jpg') !!});">

		<p style="text-align: center;width: 314px; margin-top: 220px;position: absolute;top: 0;"><img src="{!! asset('assets/images/photoframes/logo.png') !!}" style="width: 280px;"></p>

		<div id="draggable" style="width: 450px;margin-top: 160px;position: absolute;cursor: all-scroll;right: 0;margin-right: 50px;text-align: left;">
			<div class="textDiv">
				<p class="headlineClass" style="color: black;font-weight: bold;text-align: left;"></p>
			</div>
		</div>

		<div id="draggable2" style="min-width: 460px;position: absolute;bottom: 0;left: 0;margin-left: 500px;cursor: all-scroll;margin-bottom: 110px;">
			<div style="margin-top: 30px;border-bottom: 5px solid #0f79c1;">
				<p class="shoulderClass"></p>
				<p class="hangerClass"></p>
			</div>
		</div>
		<div style="width: 400px;position: absolute;bottom: 0;left: 0;cursor: all-scroll;">
			<img src="" id="outputImage" class="" style="z-index: 9;width: 100%;border: 8px solid #ffffff;">
		</div>

		<p style="position: absolute;bottom: 0;margin-left: 495px;font-size: 2.5rem;color: #595959;"><i class="fa fa-globe"></i> {!! str_replace(['https://', '/', 'www.'], '', $settingsInfo->domain) !!}</p>
	</div>
</div>


<div style="margin-top: 30px;background-color: white;padding: 20px;border-radius: 10px">
	<div class="row">
		<div class="col-md-6 text-left">
			<div class="row">
				<div class="col-md-12 text-left">
					<label>Title</label>
					<textarea type="text" value="" rows="3" class="typeHeadline form-control"></textarea>
				</div>
				<div class="col-md-6 text-left paddingR0" style="margin-top: 10px">
					<label>Sub Title 1</label>
					<input type="text" value="" class="typeShoulder form-control">
				</div>
				<div class="col-md-6 text-left" style="margin-top: 10px">
					<label>Sub Title 2</label>
					<input type="text" value="" class="typeHanger form-control">
				</div>
			</div>
		</div>
		
		<div class="col-md-3 text-left paddingR0" style="margin-top: 10px">
			<label>Browse Photo (400x500)</label>
			<input type="file" accept="image/*" onchange="loadFile(event)" class="form-control browseImage">
		</div>
		<div class="col-md-3 text-left" style="margin-top: 10px">
			<label>Font Size</label>
			<select class="form-control selectFontSize">
				<option value="large">Large</option>
				<option value="medium">Medium</option>
				<option value="small">Small</option>
			</select>
		</div>
		<div class="col-md-3 text-left" style="margin-top: 10px">
			<label>Font Color</label>
			<input type="color" class="form-control" id="fontcolor" name="fontcolor" value="white"><br>
		</div>
	</div>
</div>

<button type="button" class="btn btn-lg btn-success downloadButton downloadCart2">Generate & Download</button>



<!-- generate photo cart -->
<script src="{{asset('assets/js/jquery.3.3.1.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script type="text/javascript">
	$(".downloadCart2").on('click', function () {
		var fileName = 'photocart-1';
		html2canvas(document.getElementById("cartBody1")).then(function (canvas) {
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

	$('.selectFontSize').on('change', function(e){
		e.preventDefault();
		var fontSize = $('.selectFontSize').val();
		if(fontSize == 'large'){
			$('.headlineClass').css({'font-size' : '5rem', 'line-height' : '7rem'});
			$('.shoulderClass').css({'font-size' : '4rem', 'line-height' : '6rem'});
			$('.hangerClass').css({'font-size' : '4rem', 'line-height' : '6rem'});
		}
		if(fontSize == 'medium'){
			$('.headlineClass').css({'font-size' : '4rem', 'line-height' : '6rem'});
			$('.shoulderClass').css({'font-size' : '3rem', 'line-height' : '4.5rem'});
			$('.hangerClass').css({'font-size' : '3rem', 'line-height' : '4.5rem'});
		}
		if(fontSize == 'small'){
			$('.headlineClass').css({'font-size' : '3rem', 'line-height' : '4.5rem'});
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
			$('#outputImage').attr('src', base64data);
		}
	};
</script>

<script type="text/javascript">
	document.getElementById("fontcolor").onchange = function() {
		var fontColor = this.value;
		$('.headlineClass').css({'color' : fontColor});
		$('.shoulderClass').css({'color' : fontColor});
		$('.hangerClass').css({'color' : fontColor});
	}
</script>

<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script>
	$(function(){
		$('#draggable').draggable();
		$( "#draggable2" ).draggable();
	});
	$('#draggable').draggable();
	$( "#draggable2" ).draggable();
</script>