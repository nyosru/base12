<span class="float-right">
    <a href="#" class="edit-sub-status text-primary {{($tmf_reg_queue_status_obj->removable?'mr-3':'')}}" data-id="{{$tmf_reg_queue_status_obj->id}}"><i class="fas fa-pencil-alt"></i></a>
    @if($tmf_reg_queue_status_obj->removable)
        <a href="#" class="del-sub-status text-danger" data-id="{{$tmf_reg_queue_status_obj->id}}"><i class="fas fa-times"></i></a>
    @endif
</span>