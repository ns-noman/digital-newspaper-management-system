@extends('layouts.admin.master')
@section('content')
    <style>
        input[type="number"]{
            text-align: right;
        }
        .form-group{
            padding: 2px;
            margin: 0px;
        }
        .form-control{
            margin: 0px;
        }
        label{
            margin-top: 2px;
            margin-bottom: 0px;
        }
    </style>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">News</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">News</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ $data['title'] }} Form</h3>
                            </div>
                            <form action="{{ isset($data['item']) ? route('news.update',$data['item']->id) : route('news.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['item']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label>Custom URL*</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->TileUrl : null }}" type="text" class="form-control" name="TileUrl" placeholder="Custom URL" required>
                                        </div>

                                        <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                            <label>Category*</label>
                                            <select name="ParentCategoryID" id="ParentCategoryID" class="form-control select2" required>
                                                @foreach($data['categories'] as $key => $category)
                                                    <option  @isset($data['item']) @if( $data['item']->ParentCategoryID == $category->id ) selected @endif @endisset value="{{ $category->id }}">{{ $category->Caption }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                            <label>Sub Category</label>
                                            <select name="SubCategoryID" id="SubCategoryID" class="form-control select2">
                                                <option value="0">Select Sub-Category</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                            <label>Today's Paper</label>
                                            <select name="TodaysCategory" id="TodaysCategory" class="form-control select2">
                                                @foreach($data['todaylist'] as $key => $tdylist)
                                                    <option  @isset($data['item']) @if( $data['item']->ParentCategoryID == $tdylist->id ) selected @endif @endisset value="{{ $tdylist->id }}">{{ $tdylist->Caption }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                            <label>Tag</label>
                                            <select class="select2" name="TagWord[]" id="TagWord" class="form-control" multiple="multiple" data-placeholder="Tag" style="width: 100%;">
                                                @foreach($data['tags'] as $key => $tag)
                                                    <option  @isset($data['item']) @if( $data['item']->TagWord == $tag->Caption ) selected @endif @endisset value="{{ $tag->Caption }}">{{ $tag->Caption }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Shoulder</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->NewsShoulder : null }}" type="text" class="form-control" name="NewsShoulder" placeholder="Shoulder">
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Hanger</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->NewsHanger : null }}" type="text" class="form-control" name="NewsHanger" placeholder="Hanger">
                                        </div>

                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Post Title*</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->NewsTitle : null }}" type="text" class="form-control" name="NewsTitle" placeholder="Post Title" required>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label class="form-label">Home Page Title *</label>
                                            <input class="form-control" id="HomepageTitle" name="HomepageTitle" placeholder="Home Page Title" value="{{ isset($data['item']) ? $data['item']->HomepageTitle  : null }}" required>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label class="form-label">Share Title*</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->ShareTitle  : null }}" class="form-control" id="ShareTitle" type="text" name="ShareTitle" placeholder="Share Title" required>
                                        </div>

                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label class="form-label">Credit line</label>
                                            <input class="form-control" id="NewsSource" placeholder="Credit line" name="NewsSource" value="{{ isset($data['item']) ? $data['item']->NewsSource  : null }}">
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Source</label>
                                            <select class="select2" name="ReporterName" class="form-control" data-placeholder="Source" style="width: 100%;">
                                                @foreach($data['reporters'] as $key => $reporter)
                                                    <option  @isset($data['item']) @if( $data['item']->ReporterName == $reporter->ReporterName ) selected @endif @endisset value="{{ $reporter->ReporterName }}">{{ $reporter->ReporterName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Schedule</label>
                                            <input class="form-control" id="Date" name="Date" value="{{ isset($data['item']) ? $data['item']->Date  : date("Y-m-d H:i:s") }}" type="datetime-local">
                                        </div>
                                        <div class="form-group col-sm-6 col-md-2 col-lg-2">
                                            <label>Is Top*</label>
                                            <select name="IsTop" id="IsTop" class="form-control" required>
                                                <option @selected(($data['item']->IsTop ?? null) == 1) value="1">Yes</option>
                                                <option @selected(($data['item']->IsTop ?? null) == 0) value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-2 col-lg-2">
                                            <label>Priority</label>
                                            <input placeholder="0.00" step="1" type="number" class="form-control" id="Priority" name="Priority" value="{{ isset($data['item']) ? $data['item']->Priority  : 15 }}">
                                        </div>
                                        <div class="form-group col-sm-6 col-md-2 col-lg-2">
                                            <label>Selected</label>
                                            <select name="IsSeleted" id="IsSeleted" class="form-control">
                                                <option @selected(($data['item']->IsSeleted ?? null) == 1) value="1">Yes</option>
                                                <option @selected(($data['item']->IsSeleted ?? null) == 0) value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-2 col-lg-2">
                                            <label>Selected Priority</label>
                                            <input placeholder="0.00" step="1" type="number" class="form-control" id="SelectedPriority" name="SelectedPriority" value="{{ isset($data['item']) ? $data['item']->SelectedPriority  : 13 }}">
                                        </div>
                                        <div class="form-group col-sm-6 col-md-2 col-lg-2">
                                            <label>Editor Choice*</label>
                                            <select name="IsEditorChoice" id="IsEditorChoice" class="form-control" required>
                                                <option @selected(($data['item']->IsEditorChoice ?? null) == 1) value="1">Yes</option>
                                                <option @selected(($data['item']->IsEditorChoice ?? null) == 0) value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-2 col-lg-2">
                                            <label>Editor Choice Priority</label>
                                            <input placeholder="0.00" step="1" type="number" class="form-control" id="EditorChoicePriority" name="EditorChoicePriority" value="{{ isset($data['item']) ? $data['item']->EditorChoicePriority  : 13 }}">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-label">Detail*</label>
                                            <textarea class="form-control" id="DetailNews" name="DetailNews" placeholder="DetailNews" required>{{ isset($data['item']) ? $data['item']->DetailNews  : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-label">Summary</label>
                                            <textarea class="form-control" id="NewsSummary" name="NewsSummary" cols="30" rows="2" placeholder="News Summery">{{ isset($data['item']) ? $data['item']->NewsSummary  : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-8 col-md-8 col-lg-8" style="width: 100px; height: 100px;">
                                            <label>Detail</label>
                                            <select name="ImageShow" id="ImageShow" class="form-control" style="height: 80px;">
                                                <option @selected(($data['item']->ImageShow ?? null) === 1) value="1">Yes</option>
                                                <option @selected(($data['item']->ImageShow ?? null) === 0) value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4" style="width: 100px; height: 100px;">
                                             <div class="d-flex flex-column align-items-center" style="width: 80px; height: 80px;">
                                                <label class="mt-auto">Image</label>
                                                <label class="w-80 h-80" style="cursor:pointer">
                                                    @php
                                                        $imgUrl = asset('public/uploads/news/placeholder.png');
                                                        if((isset($data['item']) && $data['item']->Image!=null)) $imgUrl = asset('public/uploads/news/'.$data['item']->Image) 
                                                    @endphp
                                                    <img id="image_view" style="max-width:100%" class="img-thumbnail" src="{{ $imgUrl }}">
                                                    <input id="Image" name="Image" style="display:none" onchange="profile(this);" type="file" accept="image/*">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-label">Caption Heading</label>
                                            <textarea class="form-control" id="CaptionHeading" name="CaptionHeading" cols="30" rows="2" placeholder="Caption -- Heading">{{ isset($data['item']) ? $data['item']->CaptionHeading  : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-label">Caption Source</label>
                                            <textarea class="form-control" id="ImageTitle" name="ImageTitle" cols="30" rows="2" placeholder="Caption -- Source">{{ isset($data['item']) ? $data['item']->ImageTitle  : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-2 col-md-2 col-lg-2">
                                            <label>ALT Tag</label>
                                            <input placeholder="ALT Tag" type="text" class="form-control" id="ImageTag" name="ImageTag" value="{{ isset($data['item']) ? $data['item']->ImageTag  : null }}" required>
                                        </div>
                                        <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                            <label>Writer</label>
                                            <select class="select2" name="WriterID" class="form-control" data-placeholder="Writer" style="width: 100%;">
                                                @foreach($data['writers'] as $key => $writer)
                                                    <option  @isset($data['item']) @if( $data['item']->WriterID == $writer->id ) selected @endif @endisset value="{{ $writer->id }}">{{ $writer->WriterName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-7 col-md-7 col-lg-7">
                                            <label>Related Post</label>
                                            <select id="RelatedNews" name="RelatedNews[]" class="form-control" multiple="multiple" data-placeholder="Source" style="width: 100%;">
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                            <label>Recent*</label>
                                            <select name="IsRecent" id="IsRecent" class="form-control">
                                                <option @selected(($data['item']->IsRecent ?? null) === 1) value="1">Yes</option>
                                                <option @selected(($data['item']->IsRecent ?? null) === 0) value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                            <label>Is Breaking?</label>
                                            <select name="IsBreaking" id="IsBreaking" class="form-control">
                                                <option @selected(($data['item']->IsBreaking ?? null) === 1) value="1">Yes</option>
                                                <option @selected(($data['item']->IsBreaking ?? null) === 0) value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                            <label>Breaking Time</label>
                                            <input class="form-control" id="BreakingTime" name="BreakingTime" value="{{ isset($data['item']) ? $data['item']->BreakingTime  : date("Y-m-d H:i:s", time() + 3600) }}" type="datetime-local">
                                            {{-- date('Y-m-d h:i:s', (time()+3600)) --}}
                                        </div>
                                        <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                            <label>Is Active*</label>
                                            <select name="IsActive" id="IsActive" class="form-control">
                                                <option @selected(($data['item']->IsActive ?? null) === 1) value="1">Active</option>
                                                <option @selected(($data['item']->IsActive ?? null) === 0) value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#RelatedNews').select2({
            placeholder: 'Source',
            ajax: {
                url: '{{ route("news.related-news") }}',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term, // Search term
                        page: params.page || 1 // Pagination
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.items,  // The array of items returned from the server
                        pagination: {
                            more: data.pagination.more  // Whether there are more results to load
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 1,  // Minimum characters required to trigger the search
            multiple: true  // Allow multiple selections
        });
    });


    $(document).ready(function(){
        loadSubCat();
        $('#ParentCategoryID').change(function(){
            loadSubCat();
        });
    });

    function loadSubCat() {
        $.ajax({
            url: '{{ route("galleries.load-subcategories", ":id") }}'.replace(':id', $("#ParentCategoryID").val()),
            method: 'GET',
            dataType: 'JSON',
            success: function(res){
                let SubCategoryID = 0;
                let options = `<option value="0">Select Sub-Category</option>`;
                SubCategoryID = "{{ isset($data['item']) ? $data['item']->SubCategoryID : 0 }}";
                if(SubCategoryID){
                    res.forEach((element)=>{
                        options += `<option ${element.id == SubCategoryID? 'selected' : null} value="${element.id}">${element.Caption}</option>`;
                    });
                }else{
                    res.forEach((element)=>{
                        options += `<option  value="${element.id}">${element.Caption}</option>`;
                    });
                }
                $('#SubCategoryID').html(options);
            }
        });
    }
    $('#DetailNews').summernote({
        placeholder: 'News Details',
        tabsize: 2,
        height: 150
    });

    function profile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image_view').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script> 
@endsection