<div class="modal" id="calls-history-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Calls History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 500px;overflow-x: hidden;overflow-y: auto;">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="row">
                            <label for="client-name-filter" class="col-md-3">Client Name:</label>
                            <div class="col-md-9">
                                <input type="text" id="client-name-filter" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label for="sdr-name-filter" class="col-md-3">SDR:</label>
                            <div class="col-md-9">
                                <select id="sdr-name-filter" class="form-control" style="width: auto">
                                    <option value="-1">ALL</option>
                                    @foreach(\App\Tmfsales::whereIn('ID',[104,116])->get() as $el)
                                        <option value="{{$el->ID}}">{{$el->FirstName}} {{$el->LastName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="history-table"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
