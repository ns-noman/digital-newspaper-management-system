@extends('layouts.app')
@section('title', 'Todayspaper New News')
@push('top-scripts')
<link href="{{asset('assets/css/text-editor.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/chosen.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/bootstrap-tagsinput.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/bootstrap-fileupload.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" />
<style type="text/css">
	.bootstrap-tagsinput{
		width: 100%
	}
	.datetimepicker{
		/*margin-top: -260px !important;*/
		margin-left: -50px !important
	}
	.fileinput .btn-file{
		padding: 0px !important;
		margin: 0px !important;
	}
	.fileinput .btn-file .fileinput-new{
		padding: 9px !important;
		margin-bottom: 0px !important;
	}
	.note-editor{
		margin-bottom: 0px !important;
	}
	.chosen-container .chosen-single{
		height: 34px !important;
		padding-top: 5px !important;
	}
</style>
@endpush

@section('content')

<section class="vbox">
	<section class="scrollable padder">
		<br>

		@if(session('message'))
		<div class="alert alert-danger text-center alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>{{session('message')}} </strong>
		</div>
		@endif

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


		<form class="form-horizontal" method="post" action="{{route('Todayspaper Store')}}" enctype="multipart/form-data">
			{{csrf_field()}}

			<section class="panel panel-default">
				<header class="panel-heading font-bold">Todayspaper News | New News</header>
				<div class="panel-body">

					<div class="row">
						<div class="col-md-4">
							<div class="form-group" style="margin-bottom: 0px"> 
								<label class="col-sm-12">Todayspaper Date *</label> 
								<div class="col-sm-12">                               
									<div class="input-group date publishDatePick" data-date-format="yyyy-mm-dd"> 
										<input type="text" name="publish_date" value="{{date('Y-m-d')}}" class="form-control" required=""> 
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
									</div> 
								</div> 
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group" style="margin-bottom: 0px">
								<label class="col-sm-12">Category *</label>
								<div class="col-sm-12">
									<select style="width:100%" name="categories" class="chosen-select onlinecategory" id="category" required="">
										@if(!empty($categories) && (count($categories)>0))
										@foreach($categories as $category)
										<option value="{{$category->id}}"	class="optionGroup">{{$category->display_name}}</option>

										@if(!empty($category->childCategoriesActive) && (count($category->childCategoriesActive)>0))
										@foreach($category->childCategoriesActive as $subcategory)
										<option value="{{$subcategory->id}}" class="optionChild">{{$subcategory->display_name}}</option>
										@endforeach
										@endif

										@endforeach
										@endif
									</select>
								</div>
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group" style="margin-bottom: 0px">
								<label class="col-sm-12">No of News</label>
								<div class="col-sm-12">
									<input type="number" class="form-control no_of_news" value="10">
								</div>
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group" style="margin-bottom: 0px">
								<label class="col-sm-12">--</label>
								<div class="col-sm-12">
									<button type="button" class="btn btn-primary generateNewsBox">Generate</button>
								</div>
							</div>
						</div>
					</div>

				</div>
			</section>

			<div class="newsBox"></div>

			<div class="line line-dashed b-b line-lg pull-in"></div>
			<div class="form-group">
				<div class="col-md-12">
					<div class="pull-right">
						<a href="{{route('Todayspaper')}}" class="btn btn-danger">Cancel</a>
						<button type="button" class="btn btn-success clickPublish">Save</button>
						<button type="submit" class="btn btn-success publish" style="display: none;">Saving</button>
					</div>
				</div>
			</div>
		</form>
	</section>
</section>


<input type="hidden" class="newsCountNumber" value="0">
@endsection

@push('bottom-scripts')
<script src="{{asset('assets/js/plugins/text-editor.min.js?v=1.10')}}"></script>
<script src="{{asset('assets/js/plugins/chosen.jquery.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-fileupload.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/jasny-bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/summernote-image-captionit.js')}}"></script>
<script src="{{asset('assets/js/pages/article.js?v=1.8')}}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker.min.js') }}" ></script>

<script type="text/javascript">
	$('.publishDatePick').datetimepicker({
		todayBtn:  1,
		autoclose: 1,
		minView: 2
	});
	$('.form-date').datetimepicker({
		locale: 'ru',
		startDate: new Date(),
	});

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	function uploadImage(image){
		var data = new FormData();
		data.append("image", image);
		$.ajax({
			url: '{{URL("ajax/text-editor/image/")}}',
			cache: false,
			contentType: false,
			processData: false,
			data: data,
			type: "post",
			success: function(url) {
				var image = $('<img>').attr('src', url).attr('class', 'img-responsive');
				$('#text-editor').summernote("insertNode", image[0]);
			},
		});
	}
</script>


<script type="text/javascript">
	$(document).ready(function() {
		var wrapper = $(".newsBox"); 
		var add_button = $(".generateNewsBox");
		$(add_button).click(function(e){
			var no_of_news = $('.no_of_news').val();
			var newsCountNumber = $('.newsCountNumber').val();
			$('.newsCountNumber').val(parseInt(newsCountNumber)+parseInt(no_of_news));
			window.newsCountNumberGlobal = parseInt(newsCountNumber)+parseInt(no_of_news);
			e.preventDefault();
			for(var i=1; i<=no_of_news; i++){
				var newsNumber = parseInt(newsCountNumber)+parseInt(i);
				$(wrapper).append('<section class="panel panel-default"><header class="font-bold panel-heading">News '+newsNumber+'</header><div class="panel-body"><div class="row"><div class="col-md-5"><div class="form-group"><label class="col-sm-2 control-label">Headline</label><div class="col-sm-10"><input id="headline" name="headline[]" class="form-control headline'+newsNumber+'" data-converttoclass="headline'+newsNumber+'"></div></div><div class="form-group"><label class="col-sm-2 control-label">Shoulder</label><div class="col-sm-10"><input id="shoulder" name="shoulder[]" class="form-control shoulder'+newsNumber+'" data-converttoclass="shoulder'+newsNumber+'"></div></div><div class="form-group"><label class="col-sm-2 control-label">Hanger</label><div class="col-sm-10"><input id="hanger" name="hanger[]" class="form-control hanger'+newsNumber+'" data-converttoclass="hanger'+newsNumber+'"></div></div><div class="form-group"><label class="col-sm-2 control-label">Reporter</label><div class="col-sm-10"><input id="reporter" name="reporter[]" class="form-control reporter'+newsNumber+'" data-converttoclass="reporter'+newsNumber+'"></div></div><div class="form-group"><label class="col-sm-2 control-label">(995x560) Photo</label><div class="col-sm-10 table-responsive"><table class="appended_tr table table-bordered" style="margin-bottom:0px"><tr><td><div class="fileupload-new fileupload" data-provides="fileupload"><span class="fileupload-exists fileupload-preview thumbnail" style="max-width:75px;max-height:75px"></span> <label class="btn btn-sm btn-file btn-primary"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span> <span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span> <input id="image" name="image[]" type="file"></label> <a class="fileupload-exists btn btn-default btn-sm" data-dismiss="fileupload" href="#"><i class="fa fa-times"></i> Remove</a></div><td><input type="text" id="image_caption" name="image_caption[]" class="form-control imageCaption'+newsNumber+'" data-converttoclass="imageCaption'+newsNumber+'" placeholder="Image Caption" /></table></div></div></div><div class="col-md-7"><textarea class="form-control bijoyToUni newsBody'+newsNumber+'" data-converttoclass="newsBody'+newsNumber+'" rows="12" name="body[]" placeholder="News Body"></textarea></div></div></div></section>');
			}
		});
		$(wrapper).on("click",".remove_field_file", function(e){ 
			e.preventDefault(); $(this).closest('tr').remove(); x--;
		})
	});
</script>

<script src="{{ asset('assets/vendors/unitobijoy/bijoy2uni.js') }}" ></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".newsBox").on("paste", '.bijoyToUni', function(e){
			var convertToClass = $(this).data('converttoclass');
			var text = e.originalEvent.clipboardData.getData('Text');
			var textArray = text.split(/\r?\n/);
			setTimeout(function () {
				var fieldText = $('.'+convertToClass).val();
				$.each(textArray, function( index, value ) {
					var convertedText = ConvertFromTextArea(value);
					fieldText = fieldText.replace(value, convertedText);
				});
				$('.'+convertToClass).val(fieldText);
			},200);
		});

		$('.clickPublish').click(function(){
		$('.clickPublish').html('Saving..');

		for(var i=1; i<=newsCountNumberGlobal; i++){
			var text = $('.newsBody'+i).val();
			$('.newsBody'+i).summernote({
				placeholder: '',
				height: 200,
				toolbar: [
				["style", ["none"]],
				["font", ["bold", "underline", "clear"]],
				["color", ["color"]],
				["para", ["ul", "ol", "paragraph"]],
				["view", ["fullscreen", "codeview", "help"]]
				],
			});

			var textArrayHtml = text.split(/\r?\n/);
			var convertedTextHtml = '';
			$.each(textArrayHtml, function( index1, value1 ) {
				convertedTextHtml = convertedTextHtml+'<p>'+value1+'</p>';
			});
			$('.newsBody'+i).summernote('code', convertedTextHtml);
		}

		setTimeout(function () {
			$('.publish').click();
		},400);

	});

	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$(".newsBoxCheck").on("paste", function(e){

			var text = e.originalEvent.clipboardData.getData('Text');
			text = ConvertFromTextArea(text);
			e.target.value = text;
			const element = $('.newsBoxCheck');
			const caretPos = element[0].selectionStart;
			const textAreaTxt = element.val();
			const txtToAdd = "stuff";

			element.val(textAreaTxt.substring(0, caretPos) + textAreaTxt.substring(caretPos) );

			// var clipboardData = e.clipboardData || e.originalEvent.clipboardData || window.clipboardData;
			// var text = clipboardData.getData('text');
			// text = ConvertFromTextArea(text);
			// e.target.value = text;
			// e.preventDefault();  
			// document.body.removeChild(clipboardData.getData('text'))   

			// e.preventDefault();
			// var convertedText = ConvertFromTextArea(data);
			// var fieldText = $('.newsBoxCheck').val();
			// $('.newsBoxCheck').val(fieldText+convertedText);
			// console.log(convertedText)
		});
	});
</script>
@endpush
