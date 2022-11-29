<div class="modal" id="new-sub-status-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="new-status" class="col-md-3">Status Type:</label>
                    <div class="col-md-9">
                        <select id="queue-status-type" class="form-control w-auto">
                            @foreach($queue_status_type_objs as $queue_status_type_obj)
                                <option value="{{$queue_status_type_obj->id}}">{{$queue_status_type_obj->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="new-status" class="col-md-3">TMFQ Status:</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="new-sub-status"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="root-status" class="col-md-3">TMFQ Root:</label>
                    <div class="col-md-9">
                        <select class="form-control" id="root-status" style="width: auto;"></select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="global-status" class="col-md-3">Dashboard Global Status:</label>
                    <div class="col-md-9">
                        <select class="form-control" id="global-status" style="width: auto;">
                            @foreach(\App\DashboardGlobalStatus::orderBy('status_order_index','asc')->get() as $el)
                                <option value="{{$el->id}}">{{$el->status_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="dashboard-status" class="col-md-3">Dashboard Status:</label>
                    <div class="col-md-9">
                        <select class="form-control" id="dashboard-status" style="width: auto;">
                            @foreach(\App\CipostatusStatusFormalized::where('service_flag',0)
                                        ->orderBy('status_order','asc')
                                        ->orderBy('substatus_order','asc')->get() as $el)
                                <option value="{{$el->id}}">{!! ($el->substatus_order?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'') !!}{{$el->status}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @foreach($flags_prefixes as $flag_prefix)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div><span class="{{$flag_prefix['class']}}">{{ucfirst($flag_prefix['caption'])}}</span> flag settings:</div>
                            {!! $flag_settings->html($flag_prefix['caption']) !!}
                        </div>
                    </div>
                @endforeach
                <div class="row">
                    <div class="col-md-12">
                        <label for="description">Client Update Message:</label>
                        <textarea class="form-control" id="description" rows="4" style="resize: vertical"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-sub-status-btn"><i class="fas fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>