@foreach($tmf_filing_queue_root_status_objs as $tmf_filing_queue_root_status_obj)
    <option value="{{$tmf_filing_queue_root_status_obj->id}}">{{$tmf_filing_queue_root_status_obj->name}}</option>
@endforeach