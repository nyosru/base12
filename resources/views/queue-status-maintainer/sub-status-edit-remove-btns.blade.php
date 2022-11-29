<span class="float-right">
    <a href="#" class="edit-sub-status-context-menu text-{{(($queue_status_obj->standartContextMenuItemRows->count() || $queue_status_obj->customContextMenuItemRows->count())?'success':'secondary')}}" data-id="{{$queue_status_obj->id}}"><i class="fas fa-bars"></i></a>
    <a href="#" class="edit-sub-status text-primary ml-3" data-id="{{$queue_status_obj->id}}"><i class="fas fa-pencil-alt"></i></a>
    @if($queue_status_obj->removable)
        <a href="#" class="del-sub-status text-danger ml-3" data-id="{{$queue_status_obj->id}}"><i class="fas fa-times"></i></a>
    @endif
</span>