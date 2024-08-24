@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Tags</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tags</li>
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
                            <form action="{{ isset($data['item']) ? route('tags.update',$data['item']->id) : route('tags.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['item']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Tag Title*</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->Caption : null }}" type="text" class="form-control" name="Caption" placeholder="Category Name" required>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Priority*</label>
                                            <input step="1" value="{{ isset($data['item']) ? $data['item']->Priority : null }}" type="number" class="form-control" name="Priority" placeholder="0.00" required>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>Is Trending *</label>
                                            <select name="IsTrend" id="IsTrend" class="form-control">
                                                <option @selected(($data['item']->IsTrend ?? null) == 'Yes') value="Yes">Yes</option>
                                                <option @selected(($data['item']->IsTrend ?? null) == 'No') value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
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