<div class="modal fade" id="call-report-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Call Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="row mb-3">
                            <div class="col-4 text-center">
                                <div><b>Temperature</b></div>
                                <div style="white-space: nowrap">
                                    Cold <input type="radio" name="lead-temp" value="1">
                                    <input type="radio" name="lead-temp" value="2">
                                    <input type="radio" name="lead-temp" value="3" checked="">
                                    <input type="radio" name="lead-temp" value="4">
                                    <input type="radio" name="lead-temp" value="5"> Hot
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div><b>Needs a TM</b></div>
                                <div>
                                    <div class="switch-top2" style="margin: auto">
                                        <input type="radio" class="inactive-closers-input" name="lead-need-tm" value="1" id="lead-need-tm-1" checked>
                                        <label for="lead-need-tm-1" class="switch-top2-label switch-top2-label-off">YES</label>
                                        <input type="radio" class="inactive-closers-input" name="lead-need-tm" value="0" id="lead-need-tm-0">
                                        <label for="lead-need-tm-0" class="switch-top2-label switch-top2-label-on">NO</label>
                                        <span class="switch-top2-selection"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div><b>Knows TMF Offer</b></div>
                                <div>
                                    <div class="switch-top2" style="margin: auto">
                                        <input type="radio" class="inactive-closers-input" name="lead-knows-tmf-offer" value="1" id="lead-knows-tmf-offer-1" checked>
                                        <label for="lead-knows-tmf-offer-1" class="switch-top2-label switch-top2-label-off">YES</label>
                                        <input type="radio" class="inactive-closers-input" name="lead-knows-tmf-offer" value="0" id="lead-knows-tmf-offer-0">
                                        <label for="lead-knows-tmf-offer-0" class="switch-top2-label switch-top2-label-on">NO</label>
                                        <span class="switch-top2-selection"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="lead-status" class="col-md-3">Lead Status:</label>
                            <div class="col-md-9">
                                <select class="form-control" id="lead-status" style="width: auto">
                                    @foreach(\App\LeadStatus::orderBy('place_id','asc')->get() as $el)
                                        <option value="{{$el->id}}">{{$el->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                    <label for="notes">Notes <a href="#" class="btn btn-sm btn-success ml-1" id="add-date-alt">Add Date</a></label>
                                    <textarea id="notes-alt" class="form-control" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="claim-pq-btn">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->