<div class="modal" id="change-status-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Status</h5>
                <select class="form-control d-inline-flex queue-type-list" style="width: auto;position: relative;top:-4px;margin: auto">
                    @foreach($queue_type_rows as $queue_type_row)
                        <option value="{{$queue_type_row->id}}"  {{$queue_type_row->id==$queue_type_id?'selected':''}}>
                            {{$queue_type_row->name}}
                        </option>
                    @endforeach
                </select>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! $accordion !!}
            </div>
            <div class="modal-footer">
                <select class="form-control d-inline-flex tss-list" style="max-width: 300px;"></select>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="apply-status-btn"><i class="fas fa-check"></i> Apply</button>
            </div>
        </div>
    </div>
</div>