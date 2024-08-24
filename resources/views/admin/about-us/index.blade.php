@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">About Us</h1>
                    </div>
                    <div class="col-sm-6">
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
                    @if($aboutUs)
                    <section class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>Title</th>
                                                    <td>{{ $aboutUs->title }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <td>{!! $aboutUs->description !!}</td>
                                                </tr>
                                                <tr>
                                                    <th>Image</th>
                                                    <td>
                                                        @if ($aboutUs->image)
                                                            <img src="{{ asset('public/uploads/about-us/' . $aboutUs->image) }}" width="200px" height="141px">
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Total Projects</th>
                                                    <td>{{ $aboutUs->projects }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Revenues</th>
                                                    <td>{{ $aboutUs->revenues }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Awards</th>
                                                    <td>{{ $aboutUs->awards }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Delivery</th>
                                                    <td>{!!  $aboutUs->delivery !!}</td>
                                                </tr>
                                                <tr>
                                                    <th>Payment</th>
                                                    <td>{!! $aboutUs->payment !!}</td>
                                                </tr>
                                                <tr>
                                                    <th>Customer Support</th>
                                                    <td>{!! $aboutUs->support !!}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('about-us.edit', $aboutUs->id) }}"
                                    class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </section>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection