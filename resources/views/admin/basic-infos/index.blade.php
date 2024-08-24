@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Basic Info</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Basic Info</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @if($basicInfo)
                    <section class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>SiteName</th>
                                                    <td>{{ $basicInfo->SiteName }}</td>
                                                </tr>
                                                <tr>
                                                    <th>HomePageTitle</th>
                                                    <td>{{ $basicInfo->HomePageTitle }}</td>
                                                </tr>
                                                <tr>
                                                    <th>MetaDescription</th>
                                                    <td>{{ $basicInfo->MetaDescription }}</td>
                                                </tr>
                                                <tr>
                                                    <th>SiteBanner</th>
                                                    <td>{{ $basicInfo->SiteBanner }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Logo</th>
                                                    <td>
                                                        @if ($basicInfo->Logo)
                                                            <img src="{{ asset('public/uploads/basic-info/' . $basicInfo->Logo) }}" height="29px" width="141px">
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>FavIcon</th>
                                                    <td>
                                                        @if ($basicInfo->FavIcon)
                                                            <img src="{{ asset('public/uploads/basic-info/' . $basicInfo->FavIcon) }}" height="29px" width="141px">
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>SiteContact</th>
                                                    <td>{{ $basicInfo->SiteContact }}</td>
                                                </tr>
                                                <tr>
                                                    <th>SiteEmail</th>
                                                    <td>{{ $basicInfo->SiteEmail }}</td>
                                                </tr>
                                                <tr>
                                                    <th>SiteTwitter</th>
                                                    <td>{{ $basicInfo->SiteTwitter }}</td>
                                                </tr>
                                                <tr>
                                                    <th>SiteFaceBook</th>
                                                    <td>{{ $basicInfo->SiteFaceBook }}</td>
                                                </tr>
                                                <tr>
                                                    <th>SiteGooglePlus</th>
                                                    <td>{{ $basicInfo->SiteGooglePlus }}</td>
                                                </tr>
                                                <tr>
                                                    <th>SiteYouTube</th>
                                                    <td>{{ $basicInfo->SiteYouTube }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Currency</th>
                                                    <td>{!! $basicInfo->Currency !!}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td>{!! $basicInfo->Address !!}</td>
                                                </tr>
                                                <tr>
                                                    <th>GoogleMap</th>
                                                    <td>{!! $basicInfo->GoogleMap !!}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('basic-infos.edit', $basicInfo->id) }}"class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </section>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection