@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Pages</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pages</li>
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
                            <form action="{{ isset($data['item']) ? route('pages.update',$data['item']->id) : route('pages.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['item']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Caption*</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->PageName : null }}" type="text" class="form-control" name="PageName" placeholder="Caption" required>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Priority</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->Priority : null }}" type="number" step="1" class="form-control" name="Priority" placeholder="0.00">
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Meta Tag</label>
                                            <textarea class="form-control" id="MetaTag" name="MetaTag" cols="30" rows="3" placeholder="Meta Tag" required>{{ isset($data['item']) ? $data['item']->MetaTag  : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Meta Description</label>
                                            <textarea class="form-control" id="MetaDescription" name="MetaDescription" cols="30" rows="3" placeholder="Meta Description" required>{{ isset($data['item']) ? $data['item']->MetaDescription  : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-label">Detail*</label>
                                            <textarea class="form-control" id="Detail" name="Detail" cols="30" rows="3" placeholder="Detail" required>{{ isset($data['item']) ? $data['item']->Detail  : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-label">Summary*</label>
                                            <textarea class="form-control" id="Summary" name="Summary" cols="30" rows="3" placeholder="Summary" required>{{ isset($data['item']) ? $data['item']->Summary  : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label>Is Active *</label>
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
    $('#Summary').summernote({
        placeholder: 'Summary',
        tabsize: 2,
        height: 100
    });
    $('#Detail').summernote({
        placeholder: 'Detail',
        tabsize: 2,
        height: 100
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