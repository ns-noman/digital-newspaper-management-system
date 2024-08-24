@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="form-group col-sm-6">
                        <h1 class="m-0">Basic Info</h1>
                    </div>
                    <div class="form-group col-sm-6">
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
                    <div class="form-group col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Form</h3>
                            </div>
                            <form action="{{ route('basic-infos.update', $basicInfo->id)}}" method="POST" enctype="multipart/form-data">
                              @csrf
                              @method('put')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label class="form-label">SiteName*</label>
                                            <input type="text" class="form-control" id="SiteName" name="SiteName"
                                                value="{{ $basicInfo->SiteName }}" placeholder="SiteName" required>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label class="form-label">HomePageTitle*</label>
                                            <input type="text" class="form-control" id="HomePageTitle" name="HomePageTitle"
                                                value="{{ $basicInfo->HomePageTitle }}" placeholder="HomePageTitle" required>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label class="form-label">MetaTag*</label>
                                            <input type="text" class="form-control" id="MetaTag" name="MetaTag"
                                                value="{{ $basicInfo->MetaTag }}" placeholder="MetaTag" required>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-label">MetaDescription*</label>
                                            <textarea class="form-control" id="MetaDescription" name="MetaDescription" cols="30" rows="3" placeholder="MetaDescription" required>{{ $basicInfo->MetaDescription }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-label">GoogleMap*</label>
                                            <textarea class="form-control" id="GoogleMap" name="GoogleMap" cols="30" rows="3" placeholder="GoogleMap" required>{{ $basicInfo->GoogleMap }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-label">GoogleAnalytics*</label>
                                            <textarea class="form-control" id="GoogleAnalytics" name="GoogleAnalytics" cols="30" rows="3" placeholder="GoogleAnalytics" required>{{ $basicInfo->GoogleAnalytics }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-label">Address*</label>
                                            <textarea class="form-control" id="Address" name="Address" cols="30" rows="3" placeholder="Address" required>{{ $basicInfo->Address }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label class="form-label">SiteContact*</label>
                                            <input type="text" class="form-control" id="SiteContact" name="SiteContact"
                                                value="{{ $basicInfo->SiteContact }}" placeholder="SiteContact" required>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label class="form-label">SiteEmail*</label>
                                            <input type="SiteEmail" class="form-control" id="SiteEmail" name="SiteEmail"
                                                value="{{ $basicInfo->SiteEmail }}"placeholder="SiteEmail" required>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label class="form-label">Currency*</label>
                                            <input type="Currency" class="form-control" id="Currency" name="Currency"
                                                value="{{ $basicInfo->Currency }}"placeholder="Currency" required>
                                        </div>

                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label for="FavIcon" class="form-label">FavIcon</label>
                                            <input type="file" name="FavIcon" class="form-control">
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label for="SiteBanner" class="form-label">SiteBanner</label>
                                            <input type="file" name="SiteBanner" class="form-control">
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label for="Logo" class="form-label">Logo</label>
                                            <input type="file" name="Logo" class="form-control">
                                        </div>

                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label for="SiteFaceBook" class="form-label">SiteFaceBook Link</label>
                                            <input type="text" class="form-control" id="SiteFaceBook" name="SiteFaceBook" placeholder="SiteFaceBook" value="{{ $basicInfo->SiteFaceBook }}"> 
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label for="SiteTwitter" class="form-label">SiteTwitter</label>
                                            <input type="text" class="form-control" id="SiteTwitter" name="SiteTwitter" placeholder="SiteTwitter" value="{{ $basicInfo->SiteTwitter }}"> 
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label for="SiteGooglePlus" class="form-label">SiteGooglePlus</label>
                                            <input type="text" class="form-control" id="SiteGooglePlus" name="SiteGooglePlus" placeholder="SiteGooglePlus" value="{{ $basicInfo->SiteGooglePlus }}"> 
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label for="SiteYouTube" class="form-label">SiteYouTube</label>
                                            <input type="text" class="form-control" id="SiteYouTube" name="SiteYouTube" placeholder="SiteYouTube" value="{{ $basicInfo->SiteYouTube }}"> 
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label for="SiteLinkdin" class="form-label">SiteLinkdin</label>
                                            <input type="text" class="form-control" id="SiteLinkdin" name="SiteLinkdin" placeholder="SiteLinkdin" value="{{ $basicInfo->SiteLinkdin }}"> 
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
    $('#MetaDescription').summernote({
        placeholder: 'Meta Description',
        tabsize: 2,
        height: 100
    });
    $('#GoogleMap').summernote({
        placeholder: 'Google Map',
        tabsize: 2,
        height: 100
    });
    $('#GoogleAnalytics').summernote({
        placeholder: 'Google Analytics',
        tabsize: 2,
        height: 100
    });
    $('#Address').summernote({
        placeholder: 'Address',
        tabsize: 2,
        height: 100
    });
</script>
@endsection