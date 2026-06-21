<option value="" data-upatitle="">--Select Upazila--</option>
@if(!empty($upazilas) && (count($upazilas)>0))
@foreach($upazilas as $list)
<option value="{{$list->id}}" data-upatitle="{{$list->display_name}}">{{$list->display_name}}</option>
@endforeach
@endif