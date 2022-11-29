@foreach(\App\TmfFilingQueueStatus::where('tmf_filing_queue_root_status_id',$el->id)->orderBy('place_id','asc')->get() as $tmf_filing_queue_status_obj)
    <button type="button" class="d-flex align-items-center list-group-item list-group-item-action sub-status"
            data-id="{{$tmf_filing_queue_status_obj->id}}"
            data-root-id="{{$el->id}}">
        <div class="flex-grow-1 mr-2">{{$tmf_filing_queue_status_obj->name}} [<span class="total"
                                                                                    data-root-id="{{$el->id}}"
                                                                                    data-id="{{$tmf_filing_queue_status_obj->id}}"><img
                        src="https://trademarkfactory.imgix.net/img/loading.gif"
                        style="height:16px;;width: 16px;"/></span>]
        </div>
        <div class="flex-shrink-1 numbers-block empty" data-root-id="{{$el->id}}"
             data-id="{{$tmf_filing_queue_status_obj->id}}">
            <img src="https://trademarkfactory.imgix.net/img/loading.gif" style="height:16px;;width: 16px;"/>
        </div>
    </button>
@endforeach
