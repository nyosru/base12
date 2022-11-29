<div class="modal" id="noboom-reason-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">NoBOOM Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="notes">Notes <a href="#" class="btn btn-sm btn-success ml-1" id="add-date">Add Date</a></label>
                        <textarea id="notes" class="form-control" rows="10"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="no-boom-reason" class="col-3 control-label">No BOOM reason:</label>
                    <div class="col-md-9">
                        <select id="no-boom-reason" class="form-control">
                            <option value="">Select or enter reason</option>
                            @foreach(\App\NotBoomReason::whereNotIn('reason',['Legacy','UNKNOWN'])->orderBy('reason','asc')->get() as $el)
                                <option value="{{$el->id}}">{{$el->reason}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="lead-temp" class="col-3 control-label">Lead:</label>
                    <div class="col-9">
                        <div class="row">
                            <div class="col-4 text-center">
                                <div><b>Temperature</b></div>
                                <div style="white-space: nowrap">
                                    Cold <input type="radio" name="lead-temp" value="1"/>
                                    <input type="radio" name="lead-temp" value="2"/>
                                    <input type="radio" name="lead-temp" value="3"/>
                                    <input type="radio" name="lead-temp" value="4"/>
                                    <input type="radio" name="lead-temp" value="5"/> Hot
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div><b>Needs a TM</b></div>
                                <div>
                                    <div class="switch-top2" style="margin: auto">
                                        <input type="radio" class="inactive-closers-input" name="lead-need-tm" value="1" id="lead-need-tm-1">
                                        <label for="lead-need-tm-1" class="switch-top2-label switch-top2-label-off">YES</label>
                                        <input type="radio" class="inactive-closers-input" name="lead-need-tm" value="0" id="lead-need-tm-0" checked>
                                        <label for="lead-need-tm-0" class="switch-top2-label switch-top2-label-on">NO</label>
                                        <span class="switch-top2-selection"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div><b>Knows TMF Offer</b></div>
                                <div>
                                    <div class="switch-top2" style="margin: auto">
                                        <input type="radio" class="inactive-closers-input" name="lead-knows-tmf-offer" value="1" id="lead-knows-tmf-offer-1">
                                        <label for="lead-knows-tmf-offer-1" class="switch-top2-label switch-top2-label-off">YES</label>
                                        <input type="radio" class="inactive-closers-input" name="lead-knows-tmf-offer" value="0" id="lead-knows-tmf-offer-0" checked>
                                        <label for="lead-knows-tmf-offer-0" class="switch-top2-label switch-top2-label-on">NO</label>
                                        <span class="switch-top2-selection"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-3">Closeable:</label>
                    <div class="col-9">
                        <div class="row">
                            <div class="col-4">
                                <div class="switch-top" style="margin:6px auto auto auto;">
                                    <input type="radio" class="ready-option-input" name="closeable-option" value="1" id="closeable-1" checked>
                                    <label for="closeable-1" class="switch-top-label switch-top-label-off">YES</label>
                                    <input type="radio" class="ready-option-input" name="closeable-option" value="0" id="closeable-0">
                                    <label for="closeable-0" class="switch-top-label switch-top-label-on">MAYBE</label>
                                    <input type="radio" class="ready-option-input" name="closeable-option" value="-1" id="closeable--1">
                                    <label for="closeable--1" class="switch-top-label switch-top-label-three">NO</label>
                                    <span class="switch-top-selection"></span>
                                </div>
                            </div>
                            <div class="col-8 text-right" id="reminder-block">
                                <label style="position: relative;top:-32px;">Remind:</label>
                                <div class="switch-top3" style="margin:6px auto auto auto;display: inline-block">
                                    <input type="radio" class="remind-in-input" name="remind-in-option" value="-1" id="remind-in-option--1">
                                    <label for="remind-in-option--1" class="switch-top3-label switch-top3-label-one">NO</label>
                                    <input type="radio" class="remind-in-input" name="remind-in-option" value="7" id="remind-in-option-7" checked>
                                    <label for="remind-in-option-7" class="switch-top3-label switch-top3-label-two">7d</label>
                                    <input type="radio" class="remind-in-input" name="remind-in-option" value="14" id="remind-in-option-14">
                                    <label for="remind-in-option-14" class="switch-top3-label switch-top3-label-three">14d</label>
                                    <input type="radio" class="remind-in-input" name="remind-in-option" value="30" id="remind-in-option-30">
                                    <label for="remind-in-option-30" class="switch-top3-label switch-top3-label-four">30d</label>
                                    <input type="radio" class="remind-in-input" name="remind-in-option" value="100" id="remind-in-option-100">
                                    <label for="remind-in-option-100" class="switch-top3-label switch-top3-label-five">CUSTOM</label>
                                    <span class="switch-top3-selection"></span>
                                    <div id="reminder-date-text">&nbsp;</div>
                                </div>
                                <div id="calendar-popup">
                                    <div id="datepicker"></div>
                                </div>
{{--                                <select id="closeable-remind" class="form-control">
                                    <option value="7">Remind Again in 7 days</option>
                                    <option value="14">Remind Again in 14 days</option>
                                    <option value="30">Remind Again in 30 days</option>
                                </select>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3" id="no-boom-reason-text-block">
                    <label for="no-boom-reason-text" class="col-3 control-label">No Boom Reason Description:</label>
                    <div class="col-9">
                        <textarea class="form-control" rows="5" id="no-boom-reason-text"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="call-record-url" class="col-3 control-label">Call record url:</label>
                    <div class="col-9">
                        <input type="text" id="call-record-url" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="noboom-reason-save-data">Save Changes</button>
            </div>
        </div>
    </div>
</div>
