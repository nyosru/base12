@foreach($tmf_reg_queue_root_status_objs as $tmf_reg_queue_root_status_obj)
    <option value="{{$tmf_reg_queue_root_status_obj->id}}">{{$tmf_reg_queue_root_status_obj->name}}</option>
@endforeach