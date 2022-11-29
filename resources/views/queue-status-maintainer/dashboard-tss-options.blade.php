@foreach($cipostatus_status_formalized_tss_objs as $obj)
    <option value="{{$obj->id}}">{{$obj->template_name}}</option>
@endforeach
@foreach($global_status_tss_objs as $obj)
    <option value="{{$obj->id}}">{{$obj->template_name}}</option>
@endforeach