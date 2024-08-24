@inject('authorization', 'App\Services\AuthorizationService')
@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6 text-white">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                   {{-- @if($authorization->hasMenuAccess(14)) --}}
                        <div class="col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $data['todays_records'] }}</h3>
                                    <p>Today's Post</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    {{-- @endif --}}
                    {{-- @if($authorization->hasMenuAccess(15)) --}}
                        <div class="col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $data['total_records'] }}</h3>
                                    <p>Total Post</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    {{-- @endif --}}
                </div>
            </div>
        </section>
    </div>
@endsection
