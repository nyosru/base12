<div class="accordion" id="r-statuses">
    @foreach(\App\TmfFilingQueueRootStatus::orderBy('place_id','asc')->get() as $el)
        <div class="card">
            <div class="card-header d-flex align-items-center" id="r-status-{{$el->id}}">
                <h2 class="mb-0 flex-grow-1">
                    <button class="btn btn-link btn-block text-left r-status" data-id="{{$el->id}}" type="button" data-toggle="collapse" data-target="#r-status-collapse-{{$el->id}}" aria-expanded="true" aria-controls="r-status-collapse-{{$el->id}}">
                        {{$el->name}}
                    </button>
                </h2>
            </div>

            <div id="r-status-collapse-{{$el->id}}" class="collapse" aria-labelledby="r-status-{{$el->id}}" data-parent="#r-statuses">
                <div class="card-body" style="max-height: 450px;overflow-x: hidden;overflow-y: auto;">
                    <div class="list-group">
                        @foreach(\App\TmfFilingQueueStatus::where('tmf_filing_queue_root_status_id',$el->id)->orderBy('place_id','asc')->get() as $tmf_filing_queue_status_obj)
                            <button type="button" class="d-flex align-items-center list-group-item list-group-item-action s-status"
                                    data-init-method="{{$init_method}}"
                                    data-id="{{$tmf_filing_queue_status_obj->id}}"
                                    data-root-id="{{$el->id}}">
                                <div class="flex-grow-1 mr-2">{{$tmf_filing_queue_status_obj->name}}</div>
                            </button>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
