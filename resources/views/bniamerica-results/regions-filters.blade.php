@foreach($objs as $obj)
    <label class="mr-3 text-nowrap">
        <input type="checkbox" class="region-chbx" value="{{$obj->region_id}}" checked> {{$obj->region_id}}
    </label>
@endforeach