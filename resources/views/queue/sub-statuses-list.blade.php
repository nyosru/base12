@foreach(\App\QueueStatus::where('queue_root_status_id',$el->id)->orderBy('place_id','asc')->get() as $queue_status_obj)
    @php
        $ic
    @endphp
    <button type="button" class="d-flex align-items-center list-group-item list-group-item-action sub-status pr-1"
            data-id="{{$queue_status_obj->id}}"
            data-root-id="{{$el->id}}">
        <div class="flex-grow-1 mr-2">{{$queue_status_obj->name}} [<span class="total"
                                                                                    data-root-id="{{$el->id}}"
                                                                                    data-id="{{$queue_status_obj->id}}"><img
                        src="https://trademarkfactory.imgix.net/img/loading.gif"
                        style="height:16px;;width: 16px;"/></span>]
        </div>

        <div class="flex-shrink-1 numbers-block empty {{($queue_status_obj->queueRootStatus->name=='Done'?'d-none':'')}}" data-root-id="{{$el->id}}"
             data-id="{{$queue_status_obj->id}}">
            <img src="https://trademarkfactory.imgix.net/img/loading.gif" style="height:16px;;width: 16px;"/>
        </div>
        <div class="flex-shrink-1 ml-1" data-root-id="{{$el->id}}">
            <span title="{{$queue_status_obj->description}}">{!! $queue_status_obj->queueStatusType->icon !!}</span>
        </div>
    </button>
@endforeach
