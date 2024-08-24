@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Galleries</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Galleries</li>
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
                            <form action="{{ isset($data['item']) ? route('galleries.update',$data['item']->id) : route('galleries.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['item']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Category*</label>
                                            <select name="ParentCategoryID" id="ParentCategoryID" class="form-control" required>
                                                @foreach($data['categories'] as $key => $category)
                                                    <option  @isset($data['item']) @if( $data['item']->ParentCategoryID == $category->id ) selected @endif @endisset value="{{ $category->id }}">{{ $category->Caption }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Sub Category*</label>
                                            <select name="SubCategoryID" id="SubCategoryID" class="form-control" required>
                                                <option value="">Select Sub-Category</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Title*</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->Caption : null }}" type="text" class="form-control" name="Caption" placeholder="Title" required>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Date</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->Date : null }}" type="datetime-local" class="form-control" name="Date">
                                        </div>
                                        
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Gallery Type? *</label>
                                            <select name="GalleryType" id="GalleryType" class="form-control">
                                                <option @selected(($data['item']->GalleryType ?? null) === 1) value="1">Image</option>
                                                <option @selected(($data['item']->GalleryType ?? null) === 0) value="0">Video</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Is Active *</label>
                                            <select name="IsActive" id="IsActive" class="form-control">
                                                <option @selected(($data['item']->IsActive ?? null) === 1) value="1">Active</option>
                                                <option @selected(($data['item']->IsActive ?? null) === 0) value="0">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-7 col-md-7 col-lg-7">
                                            <label class="form-label">Detail*</label>
                                            <textarea class="form-control" id="Detail" name="Detail" cols="30" rows="3" placeholder="Detail">{{ isset($data['item']) ? $data['item']->Detail  : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-5 col-md-5 col-lg-5">
                                            <label>Image (w: 620px h:415px)</label>
                                            <label class="col-md-3" style="cursor:pointer">
                                                @php
                                                    $imgUrl = asset('public/uploads/galleries/placeholder.png');
                                                    if((isset($data['item']) && $data['item']->Image!=null)) $imgUrl = asset('public/uploads/galleries/'.$data['item']->Image) 
                                                @endphp
                                                <img id="image_view" style="max-width:100%" class="img-thumbnail" src="{{ $imgUrl }}">
                                                <input id="Image" name="Image" style="display:none" onchange="profile(this);" type="file" accept="image/*">
                                            </label>
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
    $('#Notes').summernote({
        placeholder: 'Notes',
        tabsize: 2,
        height: 100
    });
    $('#Detail').summernote({
        placeholder: 'Detail',
        tabsize: 2,
        height: 100
    });
    loadSubCat();
    $('#ParentCategoryID').change(function(){
        loadSubCat();
    });
    function loadSubCat() {
        $.ajax({
            url: '{{ route("galleries.load-subcategories", ":id") }}'.replace(':id', $("#ParentCategoryID").val()),
            method: 'GET',
            dataType: 'JSON',
            success: function(res){
                let SubCategoryID = 0;
                let options = `<option value="">Select Sub-Category</option>`;
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