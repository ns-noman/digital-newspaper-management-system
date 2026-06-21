<option value="" data-distitle="">--Select District--</option>
@if(!empty($districts) && (count($districts)>0))
@foreach($districts as $districtList)
<option value="{{$districtList->id}}" data-distitle="{{$districtList->display_name}}">{{$districtList->display_name}}</option>
@endforeach
@endif