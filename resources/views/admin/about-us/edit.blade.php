@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="form-group col-sm-6">
                        <h1 class="m-0">About Us</h1>
                    </div>
                    <div class="form-group col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">About Us</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="form-group col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Form</h3>
                            </div>
                            <form action="{{ url('/admin/about-us/'. $aboutUs->id)}}" method="POST" enctype="multipart/form-data">
                              @csrf
                              @method('PATCH')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-label">Title*</label>
                                            <input type="text" class="form-control" id="title" name="title" value="{{ $aboutUs->title }}" placeholder="Title" required>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-label">Image (585 X 444)*</label>
                                            <input type="file" class="form-control" id="image" name="image" value="{{ $aboutUs->image }}" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-label">Description*</label>
                                            <textarea id="description" name="description" class="form-control" required>{{ $aboutUs->description }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                            <label class="form-label">Projects*</label>
                                            <input type="number" class="form-control" id="projects" name="projects" value="{{ $aboutUs->projects }}" placeholder="Projects" required>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                            <label class="form-label">Revenues*</label>
                                            <input type="number" class="form-control" id="revenues" name="revenues" value="{{ $aboutUs->revenues }}" placeholder="Revenues" required>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                            <label class="form-label">Awards*</label>
                                            <input type="number" class="form-control" id="awards" name="awards" value="{{ $aboutUs->awards }}" placeholder="Awards" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-label">Delivery*</label>
                                            <textarea id="delivery" name="delivery" class="form-control" required>{{ $aboutUs->delivery }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-label">Payment*</label>
                                            <textarea id="payment" name="payment" class="form-control" required>{{ $aboutUs->payment }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-label">Support*</label>
                                            <textarea id="support" name="support" class="form-control" required>{{ $aboutUs->support }}</textarea>
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
$(document).ready(function(){
    $('#description').summernote({
        placeholder: 'Product Description',
        tabsize: 2,
        height: 100
    });
    $('#delivery').summernote({
        placeholder: 'Delivery',
        tabsize: 2,
        height: 100
    });
    $('#payment').summernote({
        placeholder: 'Payment',
        tabsize: 2,
        height: 100
    });
    $('#support').summernote({
        placeholder: 'Support',
        tabsize: 2,
        height: 100
    });
});
</script>
@endsection
