@foreach($tmf_filing_queue_root_status_objs as $tmf_filing_queue_root_status_obj)
    @if($loop->index)
        <li class="list-group-item {{$status_type}}" data-id="{{$tmf_filing_queue_root_status_obj->id}}">{{$tmf_filing_queue_root_status_obj->name}} @include('tmf-filing-queue-status-maintainer.root-status-edit-remove-btns')</li>
    @else
        <li class="list-group-item {{$status_type}} active" aria-current="true" data-id="{{$tmf_filing_queue_root_status_obj->id}}">{{$tmf_filing_queue_root_status_obj->name}} @include('tmf-filing-queue-status-maintainer.root-status-edit-remove-btns')</li>
    @endif
@endforeach