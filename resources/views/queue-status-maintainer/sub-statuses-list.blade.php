@foreach($queue_root_status_obj->queueStatusRows()->orderBy('place_id','asc')->get() as $queue_status_obj)
    @if($loop->index)
        <li class="list-group-item {{$status_type}}" @include('queue-status-maintainer.sub-status-data-attrs')>
            {{$queue_status_obj->name}} @include('queue-status-maintainer.sub-status-edit-remove-btns')</li>
    @else
        <li class="list-group-item {{$status_type}} active"  aria-current="true"
                @include('queue-status-maintainer.sub-status-data-attrs')>
            {{$queue_status_obj->name}} @include('queue-status-maintainer.sub-status-edit-remove-btns')</li>
    @endif
@endforeach