@foreach($queue_root_status_objs as $queue_root_status_obj)
    <option value="{{$queue_root_status_obj->id}}">{{$queue_root_status_obj->name}}</option>
@endforeach