//Text-Editor
$(document).ready(function() {
  $('#text-editor').summernote({
   callbacks: {
    onImageUpload: function(image) {
      uploadImage(image[0]);
    }
  }, 
  toolbar: [
  ['formattext', ['formattext', 'clear']],
  ['style', ['bold', 'italic', 'underline']],
  // ['font', ['strikethrough', 'superscript', 'subscript']],
  // ['fontsize', ['fontsize']],
  ['color', ['color']],
  ['para', ['ul', 'ol', 'paragraph']],
  // ['height', ['height']],
  ['Insert', ['link', 'picture', 'video', 'embed', 'table', 'hr']],
  ['mybutton', ['readmore', 'searchheadline', 'quote1', 'highlighter1']],
  ['Misc', ['fullscreen', 'codeview']],
  // ['mybutton', ['highlight']]
  ],
  popover: {
    image: [
    ['custom', ['captionIt']],
    ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
    ['float', ['floatLeft', 'floatRight', 'floatNone']],
    ['remove', ['removeMedia']]
    ]
  },
  captionIt:{
    icon:'<i class="note-icon-pencil"/>',
    figureClass:'image-container',
    figcaptionClass:'image-caption'
  },
  height: 280,                 
  minHeight: null,             
  maxHeight: null,
  buttons: {
    highlight: HighlightButton,
    formattext: FormatTextButton,
    embed: Embed,
    readmore: Readmore,
    searchheadline: searchHeadline,
    quote1: Quote1,
    highlighter1: Highlighter1
  },
  focus: false,
  insertTableMaxSize: {
   col: 50,
   row: 50
 }
});

  $('#text-editor').summernote();
  $('.note-current-fontsize').text();

});

    //Custom Button
    var HighlightButton = function (context) {
      var ui = $.summernote.ui;
      var button = ui.button({
        contents: '<i class="fa fa-certificate"/>',
        tooltip: 'Highlight',
        click: function () {
         var node = document.createElement('span');
         node.innerHTML = '<div style="padding:10px;background-color:#f5f5f5;margin:10px 0 10px 15px;float:right;width:300px"><h4 style="font-weight:bold">HIGHLIGHTS</h4><ul style=padding-left:15px><li style=color:#000;margin-bottom:5px;font-size:15px;font-weight:400>Write your highlight point</ul></div>';
         context.invoke('editor.insertNode', node);
       }
     });
      return button.render();
    }


    var Embed = function (context) {
      var ui = $.summernote.ui;
      var button = ui.button({
        contents: '<i class="fa fa-clipboard"/>',
        tooltip: 'Embed',
        click: function () {
          $('#text-editor').summernote('editor.saveRange');
          $('#embedModal').modal('show');
        }
      });
      return button.render();
    }

    $('.clickEmbedButton').click(function(context){
      var embedCodeDiv = $(".embedCodeDiv").val();
      var node = document.createElement('span');
      node.innerHTML = embedCodeDiv;
      $('#text-editor').summernote('editor.restoreRange');
      $('#text-editor').summernote('editor.focus');
      $('#text-editor').summernote('editor.insertNode', node);
      $('#embedModal .embedCodeDiv').val('');
      $('#embedModal').modal('hide');
    });

    //readmore Button
    var Readmore = function (context) {
      var ui = $.summernote.ui;
      var button = ui.button({
        contents: '<i class="fa fa-tags"/>',
        tooltip: 'Read More',
        click: function () {
         var node = document.createElement('span');
         node.innerHTML = '<div class="detailReadMoreDiv" style="background-color: rgb(242 242 242);border-radius: 5px;"><p style="padding: 10px !important;text-align: left !important;background-color: rgb(194 218 245);border-top-left-radius: 5px;border-top-right-radius: 5px;margin-bottom: 0px !important;padding-left: 20px !important;font-weight: bold !important;">আরও পড়ুন</p><ul style="padding: 5px 20px 10px 40px;"><li style="margin: 10px 0px;color: #034974;border-bottom: 1px dashed #034974;"><br></li></ul></div>';
         context.invoke('editor.insertNode', node);
       }
     });
      return button.render();
    }

    var searchHeadline = function (context) {
      var ui = $.summernote.ui;
      var button = ui.button({
        contents: '<i class="fa fa-search"/>',
        tooltip: 'Search Headline',
        click: function () {
          $('#text-editor').summernote('editor.saveRange');
          $('#searchModal').modal('show');
          $('#searchModal .modal-body .embedNewsId').val('');
          $('#searchModal .modal-body .embedNews').val('');
        }
      });
      return button.render();
    }

    $('.clickAddNewsButton').click(function(context){
      var embedNews = $(".embedNews").val();
      var node = document.createElement('span');
      node.innerHTML = embedNews;
      $('#text-editor').summernote('editor.restoreRange');
      $('#text-editor').summernote('editor.focus');
      $('#text-editor').summernote('editor.insertNode', node);
      $('#searchModal .embedNews').val('');
      $('#searchModal').modal('hide');
    });


    //quote1
    var Quote1 = function (context) {
      var ui = $.summernote.ui;
      var button = ui.button({
        contents: '<i class="fa fa-quote-left"/>',
        tooltip: 'Quote Design 1',
        click: function () {
         var node = document.createElement('span');
         node.innerHTML = '<div class="quote1"><blockquote><h3>Quote here..</h3><p>Person here..</p></blockquote></div>';
         context.invoke('editor.insertNode', node);
       }
     });
      return button.render();
    }

    var Highlighter1 = function (context) {
      var ui = $.summernote.ui;
      var button = ui.button({
        contents: '<i class="fa fa-certificate"/>',
        tooltip: 'Highlighter 1',
        click: function () {
         var node = document.createElement('span');
         node.innerHTML = '<div class="highlighter1"><h3>Type here..</h3></div>';
         context.invoke('editor.insertNode', node);
       }
     });
      return button.render();
    }


    var FormatTextButton = function (context) {
      var ui = $.summernote.ui;
      var button = ui.button({
        contents: '<i class="fa fa-magic"/>',
        tooltip: 'Remove Blank Lines',
        click: function () {
          var textareaValue = $('#text-editor').summernote('code').toString();
          textareaValue = textareaValue.replaceAll('<p><br></p>','').trim();
          textareaValue = textareaValue.replaceAll('<br>','').trim();
          $('#text-editor').summernote('code', textareaValue);
        }
      });
      return button.render();
    }


    //Color Picker
    $("#headline_color").change(function() {
      $( "#headline_color_input").val($("#headline_color" ).val()); 
    });

    $("#hanger_color").change(function() {
      $( "#hanger_color_input").val($("#hanger_color" ).val()); 
    });

    $("#shoulder_color").change(function() {
      $( "#shoulder_color_input").val($("#shoulder_color" ).val()); 
    });


    //Article Photos
    $(document).ready(function() {
      var max_fields      = 50; 
      var wrapper         = $(".appended_tr"); 
      var add_button      = $(".add_more_photo"); 
      var x = 1; 
      $(add_button).click(function(e){ 
        e.preventDefault();
        if(x < max_fields){ 
          x++; 
          $(wrapper).append('<tr><td><div class="fileupload fileupload-new marginB0" data-provides="fileupload"><span class="fileupload-preview fileupload-exists thumbnail marginB0" style="max-width: 75px; max-height: 75px;"></span> <label class="btn btn-primary btn-file btn-sm"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span><input type="file" name="image[]"></label> <a href="#" class="btn fileupload-exists btn-default btn-sm" data-dismiss="fileupload"> <i class="fa fa-times"></i> Remove</a></span></div></td><td><input class="form-control" name="image_caption[]" placeholder="Image Caption"></td></td><td><i class="fa fa-trash-o fa-2x text-dark remove_field"></i></td></tr>');
        }
      });
      $(wrapper).on("click",".remove_field", function(e){ 
        e.preventDefault(); $(this).closest('tr').remove(); x--;
      })
    });


    // create Preview 
    $(document).ready(function() {
      $("#image").on('change', function() {
        var countFiles = $(this)[0].files.length;
        var imgPath = $(this)[0].value;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var image_holder = $("#modal-image-container");
        image_holder.empty();
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
          if (typeof(FileReader) != "undefined") {
            for (var i = 0; i < countFiles; i++) 
            {
              var reader = new FileReader();
              reader.onload = function(e) {
                $("<img />", {
                  "src": e.target.result,
                  "class": "thumb-image img-responsive",
                  "width": "100%"
                }).appendTo(image_holder);
              }
              image_holder.show();
              reader.readAsDataURL($(this)[0].files[i]);
            }
          } else {
            alert("This browser does not support FileReader.");
          }
        }
      });
    });
