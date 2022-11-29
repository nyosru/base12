@foreach($queue_root_status_objs as $queue_root_status_obj)
    @if($loop->index)
        <li class="list-group-item {{$status_type}}" data-id="{{$queue_root_status_obj->id}}">{{$queue_root_status_obj->name}} @include('queue-status-maintainer.root-status-edit-remove-btns')</li>
    @else
        <li class="list-group-item {{$status_type}} active" aria-current="true" data-id="{{$queue_root_status_obj->id}}">{{$queue_root_status_obj->name}} @include('queue-status-maintainer.root-status-edit-remove-btns')</li>
    @endif
@endforeach