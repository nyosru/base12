@foreach($tmf_reg_queue_root_status_obj->tmfRegQueueStatusRows()->orderBy('place_id','asc')->get() as $tmf_reg_queue_status_obj)
    @if($loop->index)
        <li class="list-group-item {{$status_type}}" @include('tmf-reg-queue-status-maintainer.sub-status-data-attrs')>
            {{$tmf_reg_queue_status_obj->name}} @include('tmf-reg-queue-status-maintainer.sub-status-edit-remove-btns')
        </li>
    @else
        <li class="list-group-item {{$status_type}} active"  aria-current="true"
                @include('tmf-reg-queue-status-maintainer.sub-status-data-attrs')>
            {{$tmf_reg_queue_status_obj->name}} @include('tmf-reg-queue-status-maintainer.sub-status-edit-remove-btns')
        </li>
    @endif
@endforeach