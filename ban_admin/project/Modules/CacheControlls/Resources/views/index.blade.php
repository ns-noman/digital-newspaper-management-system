@extends('layouts.app')
@section('title', 'Cache Clear | Links')

@push('top-scripts')
    <link href="{{asset('assets/css/jasny-bootstrap.min.css')}}" rel="stylesheet">
    <style type="text/css">
        .bootstrap-tagsinput {
            width: 100%
        }

        .datetimepicker {
            margin-left: -50px !important
        }

        .fileinput .btn-file {
            padding: 0px !important;
            margin: 0px !important;
        }

        .fileinput .btn-file .fileinput-new {
            padding: 9px !important;
            margin-bottom: 0px !important;
        }
    </style>
@endpush

@section('content')

    <section class="vbox">
        <section class="scrollable padder">
            <br>
            <div class="success-msg"></div>
            <div class="failure-msg"></div>

            <section class="panel panel-default">
                <header class="panel-heading font-bold">Cache Clear | Links</header>
                <div class="panel-body">
<!--                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span>
                        <input type="text" class="form-control url" name="url[]" placeholder="Place The Url Here">
                    </div>-->
                    <div class="field_wrapper">
                        <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span>
                        <input type="text" class="form-control article" name="article[]" placeholder="Place The Url Here" value=""/>
                        <span class="input-group-addon add_button" style="cursor:pointer;"><i class="glyphicon glyphicon-plus"></i></span>
                        </div>
                    </div>
                    <hr>
                    <button class="btn btn-success pull-right submit-btn">Clear Now</button>
                </div>

            </section>
        </section>
    </section>
@endsection
@push('bottom-scripts')
    <script src="{{asset('assets/js/jquery.3.3.1.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // var fieldNumber = 1; //Add unique name field
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = ('.field_wrapper'); //Input field wrapper
            $(addButton).click(function () { //Once add button is clicked
                var fieldHTML = '<div class="input-group m-t-xs m-b-xs"><span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span><input type="text" class="form-control article" name="article[]" placeholder="Place The Url Here" value=""/><span class="input-group-addon remove_button" style="cursor:pointer;"><i class="glyphicon glyphicon-minus"></i></span></div>'; //New input field html
                var theWrapper = $(this).closest(wrapper);
                var numOfChildren = theWrapper.children().length;
                if (numOfChildren < maxField) { //Check maximum number of input fields
                    theWrapper.append(fieldHTML);
                }
                // fieldNumber += 1;
            });
            $(wrapper).on('click', '.remove_button', function (e) { //Once remove button is clicked
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter

            });
        });

        //Cache Clear Script

        $('.submit-btn').click(function(e){
            e.preventDefault();

            var articles = [];


            $('input[name^=article]').each(function(){
                articles.push($(this).val());
            });
            $.ajaxSetup({
                cache: false
            });
            $.ajax({
                type    :   "get",
                url     :   "{{route('newsCacheClear')}}",
                data    :   {
                    'articles' : articles
                },
                dataType: "json",
                success: function (data) {
                    $.each(data.cache_data, function( key, value ) {
                        var jsonObj = JSON.parse(value);
                        var id = jsonObj.key;
                        var status = jsonObj.status;
                        var successHTML = '<div class="alert alert-success text-center alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Content: [' + id + '], ' + 'status: [' + status + ']</strong></div>';
                        var failureHTML = '<div class="alert alert-danger text-center alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Content: [' + id + '], ' + 'status: [' + status + ']</strong></div>';
                        if(status == true){
                            $('.success-msg').append(successHTML);
                        }
                        if(status == false){
                            $('.failure-msg').append(failureHTML);
                        }
                        $(".alert-dismissable a").click(function() {
                            location.reload();
                        });
                    });
                },
                error  : function () {
                    alert("Oops something went wrong.");
                }
            });
        });

    </script>
@endpush
