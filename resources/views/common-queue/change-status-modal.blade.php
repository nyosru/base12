<div class="modal" id="change-status-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! $queue_painter->accordion($queue_type_id)!!}
            </div>
            <div class="modal-footer">
                @if($show_tss_list)
                <select class="form-control d-inline-flex tss-list" style="max-width: 300px;"></select>
                @else
                    <input type="hidden" class="tss-list" value=""/>
                @endif
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="apply-status-btn"><i class="fas fa-check"></i> Apply</button>
            </div>
        </div>
    </div>
</div>