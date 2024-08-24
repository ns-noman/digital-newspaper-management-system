@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Reporters</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Reporters</li>
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
                            <form action="{{ isset($data['item']) ? route('reporters.update',$data['item']->id) : route('reporters.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['item']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                            <label>Reporter Name*</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->ReporterName : null }}" type="text" class="form-control" name="ReporterName" placeholder="Writer Name" required>
                                        </div>
                                        <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                            <label>Contact</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->Contact : null }}" type="number" step="1" class="form-control" name="Contact" placeholder="01XXXXXXXXX">
                                        </div>
                                        <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                            <label>Email*</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->Email : null }}" type="text" class="form-control" name="Email" placeholder="Email" required>
                                        </div>
                                        <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                            <label>Web Link</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->WebLink : null }}" type="text" class="form-control" name="WebLink" placeholder="Web Link">
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-label">Address*</label>
                                            <textarea class="form-control" id="Address" name="Address" cols="30" rows="3" placeholder="Address" required>{{ isset($data['item']) ? $data['item']->Address  : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-label">Notes*</label>
                                            <textarea class="form-control" id="Notes" name="Notes" cols="30" rows="3" placeholder="Notes" required>{{ isset($data['item']) ? $data['item']->Notes  : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Is Active *</label>
                                            <select name="IsActive" id="IsActive" class="form-control">
                                                <option @selected(($data['item']->IsActive ?? null) === 1) value="1">Active</option>
                                                <option @selected(($data['item']->IsActive ?? null) === 0) value="0">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Image (1:1)</label>
                                            <label class="col-md-3" style="cursor:pointer">
                                                @php
                                                    $imgUrl = asset('public/uploads/reporters/placeholder.png');
                                                    if((isset($data['item']) && $data['item']->Image!=null)) $imgUrl = asset('public/uploads/reporters/'.$data['item']->Image) 
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
    $('#Address').summernote({
        placeholder: 'Address',
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