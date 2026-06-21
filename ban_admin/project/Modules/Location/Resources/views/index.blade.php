@extends('layouts.app')
@section('title', 'Location')

@push('top-scripts')
    <link href="{{asset('assets/css/jasny-bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <section class="vbox">
        <section class="scrollable padder">
            <div class="m-b-md"></div>

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

            <section class="panel panel-default">
                <header class="panel-heading font-bold">Location
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#createModal" class="btn btn-success btn-xs pull-right"> <i class="fa fa-plus-circle"></i> New Location</a>
                    <select name="paginationAmount" class="input-sm form-control input-s-sm inline v-middle pull-right paginationAmount" style="margin-right: 10px;padding: 2px 5px;height: 23px;width: 100px">
                        <option value="10">Row- 10</option>
                        <option value="50" {{isset($_GET['paginationAmount']) && $_GET['paginationAmount'] == 50 ? 'selected' : Null}}>Row- 50</option>
                        <option value="100" {{isset($_GET['paginationAmount']) && $_GET['paginationAmount'] == 100 ? 'selected' : Null}}>Row- 100</option>
                        <option value="200" {{isset($_GET['paginationAmount']) && $_GET['paginationAmount'] == 200 ? 'selected' : Null}}>Row- 200</option>
                        <option value="300" {{isset($_GET['paginationAmount']) && $_GET['paginationAmount'] == 300 ? 'selected' : Null}}>Row- 300</option>
                    </select>
                </header>

                <div class="row wrapper">
                    <form method="get">
                        <input type="hidden" name="search" value="yes">
                        <input type="hidden" name="paginationAmount" value="{{isset($_GET['paginationAmount']) && !empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : 10}}">

                        <div class="col-sm-2 m-b-xs">
                            <input name="title" type="text" class="input-sm form-control" value="{{!empty($_GET['title']) ? $_GET['title'] : ''}}" placeholder="Title" autocomplete="off" />
                        </div>
                        <div class="col-sm-1 m-b-xs" style="padding-left: 0px">
                            <button class="btn btn-sm btn-default btn-block">Search</button>
                        </div>
                    </form>
                </div>

                <form method="post" action="{{route('Location Bulk Update')}}">
                    {{csrf_field()}}
                    <div class="table-responsive">
                        <table class="table table-striped b-t b-light table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="20">
                                    <label class="checkbox m-l m-t-none m-b-none i-checks">
                                        <input type="checkbox"><i></i>
                                    </label>
                                </th>
                                <th>SL</th>
                                <th width="400">Title</th>
                                <th width="400">Display Name</th>
                                <th width="400">Division</th>
                                <th width="400">District</th>
                                <th width="400">Type</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Status</th>
                                <th width="100">Action</th>
                            </tr>
                            </thead>
                            <tbody class="dragAndDrop">
                            @if(!empty($lists) && (count($lists)>0))
                                @foreach($lists as $key => $list)
                                    <tr>
                                        <td>
                                            <label class="checkbox m-l m-t-none m-b-none i-checks">
                                                <input type="checkbox" name="ids[]" value="{{$list->id}},{{$list->id}}"><i></i>
                                            </label>
                                        </td>
                                        <td>{!! isset($_GET['page']) && !empty($_GET['page']) ? (($_GET['page']-1)*10)+($key+1) : $key + 1 !!}</td>
                                        <td>{!! $list->title !!}</td>
                                        <td>{!! $list->display_name !!}</td>
                                        <td>{!! !empty($list->division) ? $list->divisionInfo->display_name : '' !!}</td>
                                        <td>{!! !empty($list->district) ? $list->districtInfo->display_name : '' !!}</td>
                                        <td>{!! $list->type  !!}</td>
                                        <td>{{!empty($list->createdBy) ? $list->createdBy->name : ''}}<br>{{$list->created_at}}</td>
                                        <td>@if(!empty($list->updated_at)){{$list->updatedBy->name}}<br>{{$list->updated_at}}@endif</td>
                                        <td>{{$list->status == 1 ? 'Active' : 'Inactive'}}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-xs openeditModal" data-toggle="modal" data-target="#editModal" data-id="{{$list->id}}" data-title="{{$list->title}}" data-display="{{$list->display_name}}" data-division-update="{{ $list->division }}" data-district-update="{{$list->district}}" data-type="{{($list->type == 'division') ? 1 : (($list->type == 'district')  ? 2 : 3)}}" data-status="{{$list->status}}"><i class="fa fa-edit" title="Edit"></i></button>
                                            <a href="{{route('Location Delete', $list->id)}}" class="btn btn-danger btn-xs delete" onclick="return confirm('Are you sure you want to  delete?');"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="7" class="text-center">No Data</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-4">
                                <select class="input-sm form-control input-s-sm inline v-middle bulkAction" name="bulkStatus" required="">
                                    <option value="">Select</option>
                                    <option value="" class="optionGroup" disabled="">Status</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                    <option value="-1">Remove</option>
                                    <!-- <option value="" class="optionGroup" disabled="">Other Options</option>
                                    <option value="swapOrder">Swap Order</option> -->
                                </select>
                                <button type="submit" class="btn btn-sm btn-default">Apply</button>
                            </div>
                            @if(!empty($lists) && count($lists)>0)
                                <div class="col-sm-8 text-right customPaginationStyle">
                                    {{$lists->appends(request()->input())->links()}}
                                </div>
                            @endif
                        </div>
                    </footer>
                </form>

            </section>
        </section>
    </section>

    <!-- create modal -->
    <div id="createModal" class="modal fade" role='dialog'>
        <div class="modal-dialog">
            <div class="content">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add New Location</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" class="form-horizontal" method="post" action="{{route('Location Store')}} " enctype="multipart/form-data">
                            {{csrf_field()}}

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><b>Type *</b></label>
                                <div class="col-sm-8">
                                    <select class="form-control locationType" name="type" required="">
                                        <option value="1">Division</option>
                                        <option value="2">District</option>
                                        <option value="3">Upazila</option>
                                    </select>
                                    @if($errors->has('type'))
                                        <span class="help-block">{{ $errors->first('type') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group forDivision">
                                <label class="col-sm-3 control-label"><b>Division *</b></label>
                                <div class="col-sm-8">
                                    <select class="form-control selectDivision" name="division_id">
                                        <option value="">-Division-</option>
                                        @if(!empty($divisions) && (count($divisions)>0))
                                            @foreach($divisions as $key => $division)
                                                <option data-division= "{!! $division->display_name !!}" value="{!! $division->id !!}">{!! $division->display_name !!}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->has('division_id'))
                                        <span class="help-block">{{ $errors->first('division_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group forDistrict">
                                <label class="col-sm-3 control-label"><b>District *</b></label>
                                <div class="col-sm-8">
                                    <select class="form-control selectDistrict" name="district_id">
                                        <option value="">-District-</option>
                                    </select>
                                    @if($errors->has('district_id'))
                                        <span class="help-block">{{ $errors->first('district_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 text-right">
                                    <label class="control-label"><b>Title*</b></label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="title" required="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 text-right">
                                    <label class="control-label"><b>Display Name*</b></label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="display_name" required="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 text-right">
                                    <label class="control-label"><b>Status *</b></label>
                                </div>
                                <div class="col-sm-8">
                                    <select  class="form-control" name="status" required="">
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-8  col-sm-offset-3">
                                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- edit modal -->
    <div id="editModal" class="modal fade" role='dialog'>
        <div class="modal-dialog modal-md">
            <div class="content">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Author</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" class="form-horizontal" method="post" action="{{route('Location Update')}} " enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" id="id" name="id">

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><b>Type *</b></label>
                                <div class="col-sm-8">
                                    <select class="form-control locationTypeUpdate" name="type" id="type">
                                        <option value="1">Division</option>
                                        <option value="2">District</option>
                                        <option value="3">Upazila</option>
                                    </select>
                                    @if($errors->has('type'))
                                        <span class="help-block">{{ $errors->first('type') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group forDivisionUpdate">
                                <label class="col-sm-3 control-label"><b>Division *</b></label>
                                <div class="col-sm-8">
                                    <select class="form-control selectDivisionUpdate" name="division_id" id="division_id">
                                        @if(!empty($divisions) && (count($divisions)>0))
                                            @foreach($divisions as $key => $division)
                                                <option data-division= "{!! $division->display_name !!}" value="{!! $division->id !!}">{!! $division->display_name !!}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->has('division_id'))
                                        <span class="help-block">{{ $errors->first('division_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group forDistrictUpdate">
                                <label class="col-sm-3 control-label"><b>District *</b></label>
                                <div class="col-sm-8">
                                    <select class="form-control selectDistrictUpdate" name="district_id" id="district_id">
                                        <option data-district="" value="">-District-</option>
                                    </select>
                                    @if($errors->has('district_id'))
                                        <span class="help-block">{{ $errors->first('district_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 text-right">
                                    <label class="control-label"><b>Title*</b></label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="title" id="title"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 text-right">
                                    <label class="control-label"><b>Display Name*</b></label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="display_name" id="display_name"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-3 text-right">
                                    <label class="control-label"><b>Status *</b></label>
                                </div>
                                <div class="col-sm-8">
                                    <select class="form-control" name="status" id="status">
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                        <option value="-1">Remove</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-8  col-sm-offset-3">
                                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('bottom-scripts')
    <script src="{{asset('assets/js/plugins/bootstrap-fileupload.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.3.3.1.js')}}"></script>

    <!--Create Location-->
    <script type="text/javascript">

        $('.forDivision').hide();
        $('.forDistrict').hide();

        $('.locationType').change(function(e){
            e.preventDefault();

            var locationType = $(this).val();

            if(locationType == 1){
                $('.forDivision').hide();
                $('.forDistrict').hide();
            }
            if(locationType == 2){
                $('.forDivision').show();
                $('.forDistrict').hide();
            }
            if(locationType == 3){
                $('.forDivision').show();
                $('.forDistrict').show();
            }
        })

        <!-- ajax load districts -->
        jQuery(document).ready(function () {
            $(".selectDivision").on("change", function (e) {
                e.preventDefault();

                var divisionId = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: '{{URL("location/ajax/load/districts")}}' + "/" + divisionId,
                    success: function (data) {
                        if (data != '') {
                            $('.selectDistrict').find('option').remove().end();
                            $('.selectDistrict').append('<option>Select District...</option>');
                            $.each(data, function (key, value) {
                                var row = $('<option data-district="' + value.display_name + '" value="' + value.id + '">' + value.display_name + '</option>');
                                $('.selectDistrict').append(row);
                            });
                        }
                    }
                });
            });
        });

    </script>
    <!--Update Location-->
    <script type="text/javascript">
        jQuery(document).ready(function () {

            $(".openeditModal").click(function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'GET',
                    url: '{{URL("location/ajax/load/districts")}}' + "/" + $(this).data('division-update'),
                    success: function (data) {
                        if (data != '') {
                            $('.selectDistrictUpdate').find('option').remove().end();
                            $.each(data, function (key, value) {
                                var row = $('<option data-district="' + value.display_name + '" value="' + value.id + '">' + value.display_name + '</option>');
                                $('.selectDistrictUpdate').append(row);
                            });
                        }
                    }
                });

                if($(this).data('type') == 1){
                    $('.forDivisionUpdate').hide();
                    $('.forDistrictUpdate').hide();
                }
                if($(this).data('type') == 2){
                    $('.forDivisionUpdate').show();
                    $('.forDistrictUpdate').hide();
                }
                if($(this).data('type') == 3){
                    $('.forDivisionUpdate').show();
                    $('.forDistrictUpdate').show();
                }

                var id = $(this).data('id');
                var title = $(this).data('title');
                var display_name = $(this).data('display');
                var division = $(this).data('division-update');
                var district = $(this).data('district-update');
                var locationtype = $(this).data('type');
                var status = $(this).data('status');

                $('.modal-body #id').val(id);
                $('.modal-body #title').val(title);
                $('.modal-body #display_name').val(display_name);
                $('.modal-body #division_id').val(division);
                $('.modal-body #district_id').val(district);
                $('.modal-body #type').val(locationtype);
                $('.modal-body #status').val(status);


                $('.locationTypeUpdate').change(function(e){
                    e.preventDefault();
                    var locationType = $(this).val();

                    if(locationType == 1){
                        $('.forDivisionUpdate').hide();
                        $('.forDistrictUpdate').hide();
                    }
                    if(locationType == 2){
                        $('.forDivisionUpdate').show();
                        $('.forDistrictUpdate').hide();
                    }
                    if(locationType == 3){
                        $('.forDivisionUpdate').show();
                        $('.forDistrictUpdate').show();
                    }
                });

                <!-- ajax load districts for update -->

                $(".selectDivisionUpdate").on("change", function (e) {
                    e.preventDefault();
                    var divisionId = $(this).val();

                    $.ajax({
                        type: 'GET',
                        url: '{{URL("location/ajax/load/districts")}}' + "/" + divisionId,
                        success: function (data) {
                            if (data != '') {
                                $('.selectDistrictUpdate').find('option').remove().end();
                                $('.selectDistrictUpdate').append('<option>Select District...</option>');
                                $.each(data, function (key, value) {
                                    var row = $('<option data-district="' + value.display_name + '" value="' + value.id + '">' + value.display_name + '</option>');
                                    $('.selectDistrictUpdate').append(row);
                                });
                            }
                        }
                    });
                });

            });
        });

    </script>

    <!-- pagination -->
    <script type="text/javascript">
        $('.paginationAmount').on('change',function(){
            var paginationAmount = $('.paginationAmount').val();
            var existingPaginationAmount = '{{!empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : ''}}';

            var refreshUrl = '{{Request::fullUrl()}}';
            if(existingPaginationAmount != ''){
                refreshUrl = refreshUrl.replace("paginationAmount="+existingPaginationAmount, "paginationAmount="+paginationAmount);
            }else{
                refreshUrl = refreshUrl+'?paginationAmount='+paginationAmount;
            }
            refreshUrl = refreshUrl.replaceAll("amp;", "");
            window.location = refreshUrl;
        })
    </script>

    <!-- drag and drop -->
    <script src="{{asset('assets/vendors/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>
    <script type="text/javascript">
        $('.bulkAction').change(function(){
            var bulkAction = $('.bulkAction').val();
            if(bulkAction == 'swapOrder'){
                $('.checkbox').find(':checkbox').attr('checked', 'checked');
                $('.dragAndDrop').sortable();
            }else{
                $('.checkbox').find(':checkbox').removeAttr('checked');
            }
        });
    </script>
@endpush

