@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Ads</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Ads</li>
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
                            <form action="{{ isset($data['item']) ? route('my-ads.update',$data['item']->id) : route('my-ads.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['item']))
                                    @method('put')
                                @endif
                                {{-- 'AdsPositionID',
                                'AdsUrl',
                                'AdsAdsDetail',
                                'CustomerName',
                                'EndDate',
                                'EndDate',
                                'UserID',
                                'IsActive',
                                'EntryDate', --}}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Ads Position*</label>
                                            <select name="AdsPositionID" id="AdsPositionID" class="form-control" required>
                                                @foreach($data['ads_positions'] as $key => $ads_position)
                                                    <option  @isset($data['item']) @if( $data['item']->AdsPositionID == $ads_position->id ) selected @endif @endisset value="{{ $ads_position->id }}">{{ $ads_position->PositionName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>Ads Url*</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->AdsUrl : null }}" type="text" class="form-control" name="AdsUrl" placeholder="AdsUrl" required>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                            <label>CustomerName *</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->CustomerName : null }}" type="text" class="form-control" name="CustomerName" placeholder="CustomerName" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-label">AdsDetail*</label>
                                            <textarea class="form-control" id="AdsDetail" name="AdsDetail" cols="30" rows="3" placeholder="AdsDetail" required>{{ isset($data['item']) ? $data['item']->AdsDetail  : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>StartDate *</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->StartDate : null }}" type="datetime-local" class="form-control" name="StartDate" required>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label>EndDate *</label>
                                            <input value="{{ isset($data['item']) ? $data['item']->EndDate : null }}" type="datetime-local" class="form-control" name="EndDate" required>
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
    $('#AdsDetail').summernote({
        placeholder: 'AdsDetail',
        tabsize: 2,
        height: 100
    });
</script> 
@endsection