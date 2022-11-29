@foreach($tmf_filing_queue_root_status_obj->tmfFilingQueueStatusRows()->orderBy('place_id','asc')->get() as $tmf_filing_queue_status_obj)
    @if($loop->index)
        <li class="list-group-item {{$status_type}}" @include('tmf-filing-queue-status-maintainer.sub-status-data-attrs')>
            {{$tmf_filing_queue_status_obj->name}} @include('tmf-filing-queue-status-maintainer.sub-status-edit-remove-btns')</li>
    @else
        <li class="list-group-item {{$status_type}} active"  aria-current="true"
                @include('tmf-filing-queue-status-maintainer.sub-status-data-attrs')>
            {{$tmf_filing_queue_status_obj->name}} @include('tmf-filing-queue-status-maintainer.sub-status-edit-remove-btns')</li>
    @endif
@endforeach