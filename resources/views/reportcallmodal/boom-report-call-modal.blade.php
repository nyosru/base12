<div class="row mb-3">
    <label for="lead-temp" class="col-3 control-label">Lead:</label>
    <div class="col-9">
        <div class="row">
            <div class="col-4 text-center">
                <div><b>Temperature</b></div>
                <div style="white-space: nowrap">
                    Cold <input type="radio" name="lead-temp" value="1" {{($tmoffer->lead_temp==1?'checked':'')}}>
                    <input type="radio" name="lead-temp" value="2" {{($tmoffer->lead_temp==2?'checked':'')}}>
                    <input type="radio" name="lead-temp" value="3" {{($tmoffer->lead_temp==3?'checked':'')}}>
                    <input type="radio" name="lead-temp" value="4" {{($tmoffer->lead_temp==4?'checked':'')}}>
                    <input type="radio" name="lead-temp" value="5" {{($tmoffer->lead_temp==5?'checked':'')}}> Hot
                </div>
            </div>
            <div class="col-4 text-center">
                <div><b>Needs a TM</b></div>
                <div>
                    <div class="switch-top2" style="margin: auto">
                        <input type="radio" class="inactive-closers-input" name="lead-need-tm" value="1" id="lead-need-tm-1" {{$tmoffer->lead_need_tm==1?'checked':''}}>
                        <label for="lead-need-tm-1" class="switch-top2-label switch-top2-label-off">YES</label>
                        <input type="radio" class="inactive-closers-input" name="lead-need-tm" value="0" id="lead-need-tm-0" {{$tmoffer->lead_need_tm==0?'checked':''}}>
                        <label for="lead-need-tm-0" class="switch-top2-label switch-top2-label-on">NO</label>
                        <span class="switch-top2-selection"></span>
                    </div>
                </div>
            </div>
            <div class="col-4 text-center">
                <div><b>Knows TMF Offer</b></div>
                <div>
                    <div class="switch-top2" style="margin: auto">
                        <input type="radio" class="inactive-closers-input" name="lead-knows-tmf-offer" value="1" id="lead-knows-tmf-offer-1" {{$tmoffer->lead_knows_tmf_offer==1?'checked':''}}>
                        <label for="lead-knows-tmf-offer-1" class="switch-top2-label switch-top2-label-off">YES</label>
                        <input type="radio" class="inactive-closers-input" name="lead-knows-tmf-offer" value="0" id="lead-knows-tmf-offer-0" {{$tmoffer->lead_knows_tmf_offer==0?'checked':''}}>
                        <label for="lead-knows-tmf-offer-0" class="switch-top2-label switch-top2-label-on">NO</label>
                        <span class="switch-top2-selection"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <label>Boom Reason Description:</label>
        <textarea id="boom-reason-text" class="form-control" rows="5">{{$tmoffer_bin->boom_reason}}</textarea>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <div id="notes-text">
            Your Boom Reason Description will be automatically added to Notes once you Save Changes. <button class="btn btn-sm btn-success" id="view-edit-notes-btn">View/Edit Notes</button>
        </div>
        <div id="notes-block" style="display: none">
            <label for="notes">Notes <a href="#" class="btn btn-sm btn-success ml-1" id="add-date">Add Date</a></label>
            <textarea id="notes" class="form-control" rows="5">{{$tmoffer->Notes}}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <label for="call-record-url" class="col-3 control-label">Call record url:</label>
    <div class="col-9">
        <input type="text" data-tmf-booking-id="{{$tmf_booking_id}}" id="call-record-url" class="form-control" value="{{$call_record_url}}">
    </div>
</div>