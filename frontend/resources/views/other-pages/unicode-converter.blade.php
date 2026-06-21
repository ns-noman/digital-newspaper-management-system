@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : 'Unicode to Bijoy Bangla Converter - '.$settingsInfo->newspaper_name !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'Unicode to Bijoy Bangla Converter - '.$settingsInfo->newspaper_name !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'Unicode to Bijoy Bangla Converter - '.$settingsInfo->newspaper_name !!}" />
<meta name="description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : 'Unicode to Bijoy Converter is the best web tool. You can easily convert your Unicode font to Bijoy font with this tool. Using this tool, you’ll enjoy it for sure.' !!}" />
<meta property="og:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : 'Unicode to Bijoy Converter is the best web tool. You can easily convert your Unicode font to Bijoy font with this tool. Using this tool, you’ll enjoy it for sure.' !!}" />
<meta name="twitter:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : 'Unicode to Bijoy Converter is the best web tool. You can easily convert your Unicode font to Bijoy font with this tool. Using this tool, you’ll enjoy it for sure.' !!}" />
<meta name="keywords" content="{!! !empty($pageInfo) ? $pageInfo->meta_keywords : 'unicode converter, unicode, bijoy converter, avro converter, bangla converter, bangla unicode converter, ইউনিকোড কনভার্টার, বাংলা কনভার্টার, বিজয় কনভার্টার, অভ্র কনভার্টার' !!}" />
<meta property="og:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : asset('uploads/settings/'.$settingsInfo->default_img_1) !!}" />
<meta name="twitter:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : asset('uploads/settings/'.$settingsInfo->default_img_1) !!}" />
<meta property="og:type" content="website" />
<meta name="robots" content="index, follow" />
{!! !empty($pageInfo) ? $pageInfo->header_code : '' !!}
@endpush

@push('css')
<link type="text/css" href="{{asset('assets/vendors/unicode-converter/css/main.css?v=1.6')}}" rel="stylesheet">
<script type="text/javascript" src="{{asset('assets/vendors/unicode-converter3/bijoy2uni.js?v=1.3')}}"></script>
<script type="text/javascript" src="{{asset('assets/vendors/unicode-converter3/unitobijoy.js?v=1.4')}}"></script>

<style type="text/css">
	.desktopHeaderDiv{
		display: none !important;
	}
	textarea{
		background-color: #e8fbe7;
		scrollbar-color: #d6d6d6 #e5f5e4;
	}
	.bgCLight{
		background-color: #e8fbe7;
	}
	body{
		background-color: #e8fbe7;
	}
</style>
@endpush

@section('content')
<!-- desktop version and mobile start -->
<!-- header 2 -->
<div class="bgBrand converterHeaderDiv hidden-xs">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<div style="height: 70px;background-color: #0e6395;display: flex;align-items: center;justify-content: center;">
					<a href="{{url('/')}}"><img src="{{asset('uploads/settings/'.$settingsInfo->logo_2)}}" alt="Logo" height="15"></a>
				</div>
			</div>
			<div class="col-md-10 padding0">
				<div style="height: 70px;display: flex;align-items: center;justify-content: center;">
					@if(!empty($links) && (count($links)>0))
					@foreach($links as $link)
					<a target="_blank" {!! !empty($link->link) ? 'rel="nofollow"' : '' !!} href="{{!empty($link->link) ? $link->link : url('links/'.$link->slug)}}" style="background-color: #0e6395;" class="colorWhite hoverBlack title1_6 textDecorationNone paddingTB5 paddingLR10 displayInlineBlock borderRadius5 margin5 text-center">{!! $link->title !!}</a>
					@endforeach
					@endif
					<span aria-label="Theme Color" title="Theme Color" class="desktopSearchIcon colorBlack marginL10 shadow1 displayInlineBlock clickToThemeMode cursorPointer" style="border-radius: 50%;height: 23px;width: 23px;vertical-align: middle;text-align: center;margin-top: -1px;"><i class="fa fa-moon" style="font-size: 2rem;vertical-align: middle;margin-top: -4px;"></i></span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container marginT0 borderC1B1 visible-xs">
	<div class="row">
		<div class="col-xs-12 paddingLR15 margin0">
			<div class="mobileHeaderCategoryDiv">
				<a class="mobileTrendingTopicItem" href="{{url('/')}}">হোম</a>
				@if(!empty($links) && (count($links)>0))
				@foreach($links as $link)
				<a class="mobileTrendingTopicItem" target="_blank" href="{{!empty($link->link) ? $link->link : url('links/'.$link->slug)}}">{!! $link->title !!}</a>
				@endforeach
				@endif
			</div>
		</div>
	</div>
</div>
<!-- end header 2 -->

<div class="bgCLight marginT90 xs-marginT0">
	<div class="container paddingT0">
		<div class="row">

			<!-- header -->
			<div class="col-sm-12 col-md-12 marginB20 hidden-xs">
				<h1 class="desktopCategoryTitle title11"><strong><span style="font-family: sans-serif">UNICODE TO BIJOY CONVERTER</span> &nbsp;<span style="font-family: sans-serif"><i style="font-size: 1.8rem !important" class="fa fa-grip-lines-vertical"></i></span>&nbsp;  <span class="title11">বাংলা ফন্ট কনভার্টার</span></strong></h1>
				<p class="colorBlack" style="font-family: sans-serif">Looking for a Unicode to Bijoy font converter? {!! $settingsInfo->newspaper_name !!} Bangla Converter offers you Unicode to Bijoy, Bijoy to Unicode, Ansi to Unicode, Unicode to Ansi, Avro to Bijoy, Bijoy to Avro easy conversion with voice type.</p>
			</div>
			<div class="col-sm-12 col-md-12 paddingLR20 marginB15 visible-xs paddingT20">
				<h1 class="sectionTitle title12"><strong><span style="font-family: sans-serif">UNICODE TO BIJOY CONVERTER</span> &nbsp;<span style="font-family: sans-serif"><i style="font-size: 1.8rem !important" class="fa fa-grip-lines-vertical"></i></span>&nbsp;  <span class="title12">বাংলা ফন্ট কনভার্টার</span></strong></h1>
			</div>
			<!-- end header -->

			<!-- voice control -->
			<div class="col-sm-12 col-md-12 positionRelative" style="z-index: 9;margin-bottom: 10px">
				<button type="button" class="btn btn-success clickMicrophoneStartGeneralMessage" id="startRecordingGeneralMessage"><i class="fa fa-microphone"></i> Click & Speak Bangla</button>
				<button style="display: none;" type="button" class="btn btn-danger clickMicrophoneStopGeneralMessage" id="stopRecordingGeneralMessage"><i class="fa fa-microphone-slash"></i> Click To Stop</button>
			</div>
			<!-- end voice control -->

			<!-- convert area -->
			<div class="col-sm-12 col-md-12 positionRelative" style="z-index: 9;">
				<div class="marginB20">
					<table width="100%" border="0" align="center" bgcolor="#F4F4F4">
						<tbody>
							<tr>
								<td width="100%" align="center">
									<table width="100%" border="0">
										<tbody>
											<tr>
												<td colspan="2">
													<div class="bgAsh positionRelative">
														<textarea class="unicode_textarea borderRadius0Imp audioTextMessage unicodeLocalStorage" id="EDT" name="textarea" autofocus="autofocus" value="" placeholder="ইউনিকোডে লেখা পেস্ট করুন"></textarea>
														<div class="bg1 positionAbsolute padding10 colorBlackImp" style="bottom: 0;right:0;margin-bottom: 7px;margin-right: 1px;border-radius: 8px;">
															<span>Word: <span class="unicode_textarea_word_count">0</span></span> | <span>Character: <span class="unicode_textarea_chr_count">0</span></span>
														</div>
													</div>
												</td>
											</tr>
											<tr class="bgAsh">
												<td colspan="2" align="center" height="60px" valign="middle">
													<div class="convert_button_left convertButtonDiv borderRadius0Imp">
														<button type="button" class="bijoy_button btn btn-primary xs-marginT5 borderRadius0Imp"><i class="fa fa-arrow-down"></i> Unicode To Bijoy</button>
														<button type="button" class="unicode_button btn btn-success xs-marginT5 borderRadius0Imp"><i class="fa fa-arrow-up"></i> Bijoy To Unicode</button>
														<button type="button" class="reset_button btn btn-danger xs-marginT5 borderRadius0Imp clickClearGeneralMessage" onclick="ClearInput();"><i class="fa fa-refresh"></i> Clear</button>
													</div>
												</td>
											</tr>
											<tr>
												<td colspan="2">
													<div>
														<input readonly="" type="hidden" name="CharsTyped" size="2" value="0">
														<input readonly="" type="hidden" name="WordsTyped" size="3" value="0">
														<input readonly="" type="hidden" name="CharsLeft" size="8" value="100000">
														<input readonly="" type="hidden" name="WordsLeft" size="8" value="100000">
													</div>
												</td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<div class="positionRelative">
														<textarea style="font-family: SutonnyMJ" class="bijoy_textarea borderRadius0Imp bijoyLocalStorage" id="CONVERTEDT" autofocus="autofocus" value="" placeholder="বিজয় কি-বোর্ডে লেখা পেস্ট করুন"></textarea>
														<div class="bg1 positionAbsolute padding10 colorBlackImp" style="bottom: 0;right:0;margin-bottom: 7px;margin-right: 1px;border-radius: 8px;">
															<span>Word: <span class="bijoy_textarea_word_count">0</span></span> | <span>Character: <span class="bijoy_textarea_chr_count">0</span></span>
														</div>
													</div><br>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- end convert area -->

			<div class="col-sm-12 col-md-12 text-center">
				<!-- sharethis -->
				<div class="sharethis-inline-share-buttons st-center displayInline" style="text-align: center !important;" data-url="{!! Request::url() !!}"></div>
			</div>

		</div>
	</div>
</div>
<!-- desktop and mobile version end -->
@endsection


@push('js')
<!-- voice to text -->
<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function () {
		const recognition = new webkitSpeechRecognition();
		recognition.lang = 'bn-BD';
		const startRecordingButtonGeneralMessage = document.getElementById('startRecordingGeneralMessage');
		const stopRecordingButtonGeneralMessage = document.getElementById('stopRecordingGeneralMessage');
		const transcriptionElementGeneralMessage = document.getElementById('EDT');
		startRecordingButtonGeneralMessage.addEventListener('click', function () {
			if ('webkitSpeechRecognition' in window) {
				recognition.start();
				recognition.onresult = function (event) {
					const result = event.results[0][0].transcript;
					transcriptionElementGeneralMessage.textContent = transcriptionElementGeneralMessage.textContent+' '+result;
				};
				recognition.onend = function () {
					var end = $('.clickMicrophoneStartGeneralMessage').data('end');
					if(end != 1){
						$('#startRecordingGeneralMessage').click();
						console.log('Recognition restarted');
					}else{
						console.log('Recognition end');
						$('.clickMicrophoneStartGeneralMessage').show();
						$('.clickMicrophoneStopGeneralMessage').hide();
					}
				};
				recognition.onerror = function (event) {
					console.error('Recognition error:', event.error);
				};
			} else {
				alert('Web Speech API is not supported in this browser.');
			}
		});
		stopRecordingButtonGeneralMessage.addEventListener('click', function () {
			if ('webkitSpeechRecognition' in window) {
				recognition.stop();
			} 
		});
	});

	$('.clickMicrophoneStartGeneralMessage').click(function(){
		$('.clickMicrophoneStartGeneralMessage').hide();
		$('.clickMicrophoneStopGeneralMessage').show();
	});

	$('.clickMicrophoneStopGeneralMessage').click(function(){
		$('.clickMicrophoneStartGeneralMessage').show();
		$('.clickMicrophoneStopGeneralMessage').hide();
		$('.clickMicrophoneStartGeneralMessage').attr('data-end', 1);
	});
</script>

<!-- clear fields -->
<script type="text/javascript">
	function ClearInput(){
		document.getElementById("EDT").value='';
		document.getElementById("CONVERTEDT").value='';
		document.getElementById("EDT").focus();
	}
</script>

<!-- field data to localstorage -->
<script type="text/javascript">
	var unicodeTextData = localStorage.getItem("unicodeTextData");
	$('.unicodeLocalStorage').val(unicodeTextData);

	$('.unicodeLocalStorage').keyup(function() {
		var unicodeTextData = this.value;
		localStorage.setItem("unicodeTextData", unicodeTextData);
		countCharacter('unicode');
	});

	var bijoyTextData = localStorage.getItem("bijoyTextData");
	$('.bijoyLocalStorage').val(bijoyTextData);

	$('.bijoyLocalStorage').keyup(function() {
		var bijoyTextData = this.value;
		localStorage.setItem("bijoyTextData", bijoyTextData);
		countCharacter('bijoy');
	});

	$('.clickClearGeneralMessage').click(function(){
		localStorage.setItem("unicodeTextData", '');
		localStorage.setItem("bijoyTextData", '');
		countCharacter('unicode');
		countCharacter('bijoy');
	})
</script>

<!-- convert bijoy to unicode -->
<script type="text/javascript">
	$('.unicode_button').click(function(){
		var text = $('.bijoy_textarea').val();
		var convertedText = ConvertBijoyToUni(text);
		$('.unicode_textarea').val(convertedText);
		countCharacter('unicode');
		countCharacter('bijoy');
	})
</script>

<!-- convert unicode to bijoy -->
<script type="text/javascript">
	$('.bijoy_button').click(function(){
		var text = $('.unicode_textarea').val();
		var convertedText = ConvertUniToBijoy(text);
		$('.bijoy_textarea').val(convertedText);
		countCharacter('unicode');
		countCharacter('bijoy');
	})
</script>

<!-- character count -->
<script type="text/javascript">
	countCharacter('unicode');
	countCharacter('bijoy');

	function countCharacter(type){
		if(type == 'unicode'){
			var unicode_textarea_text = $('.unicode_textarea').val();
			var unicode_textarea_chr_count = unicode_textarea_text.length;
			$('.unicode_textarea_chr_count').text(unicode_textarea_chr_count);

			var unicode_textarea_word_count = unicode_textarea_text.split(' ');
			$('.unicode_textarea_word_count').text(unicode_textarea_word_count.length);
		}
		if(type == 'bijoy'){
			var bijoy_textarea_text = $('.bijoy_textarea').val();
			var bijoy_textarea_chr_count = bijoy_textarea_text.length;
			$('.bijoy_textarea_chr_count').text(bijoy_textarea_chr_count);

			var bijoy_textarea_word_count = bijoy_textarea_text.split(' ');
			$('.bijoy_textarea_word_count').text(bijoy_textarea_word_count.length);
		}
	}
</script>
@endpush