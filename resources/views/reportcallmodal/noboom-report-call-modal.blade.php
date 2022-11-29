<div class="row mb-3">
    <label for="no-boom-reason" class="col-3 control-label">No BOOM reason:</label>
    <div class="col-md-9">
        <select id="no-boom-reason" class="form-control">
            <option value="">Select or enter reason</option>
            @foreach(\App\NotBoomReason::whereNotIn('reason',['Legacy','UNKNOWN'])->orderBy('reason','asc')->get() as $el)
                <option value="{{$el->id}}" {{($not_boom_reason_id && $not_boom_reason_id==$el->id)?'selected':''}} data-email="{{$el->email_template_name?1:0}}">{{$el->reason}}</option>
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
    <label class="col-3">Closeable:</label>
    <div class="col-9">
        <div class="row">
            <div class="col-4">
                <div class="switch-top" style="margin:6px auto auto auto;">
                    <input type="radio" class="ready-option-input" name="closeable-option" value="1" id="closeable-1" {{$tmoffer->closable==1?'checked':''}}>
                    <label for="closeable-1" class="switch-top-label switch-top-label-off">YES</label>
                    <input type="radio" class="ready-option-input" name="closeable-option" value="0" id="closeable-0" {{$tmoffer->closable==0?'checked':''}}>
                    <label for="closeable-0" class="switch-top-label switch-top-label-on">MAYBE</label>
                    <input type="radio" class="ready-option-input" name="closeable-option" value="-1" id="closeable--1"  {{$tmoffer->closable==-1?'checked':''}}>
                    <label for="closeable--1" class="switch-top-label switch-top-label-three">NO</label>
                    <span class="switch-top-selection"></span>
                </div>
            </div>
            <div class="col-8 text-right" id="reminder-block" style="{{$tmoffer->closable==-1?'display:none':''}}">
                <label style="position: relative;top:-32px;">Remind:</label>
                <div class="switch-top3" style="margin:6px auto auto auto;display: inline-block">
                    <input type="radio" class="remind-in-input" name="remind-in-option" value="-1" id="remind-in-option--1">
                    <label for="remind-in-option--1" class="switch-top3-label switch-top3-label-one">NO</label>
                    <input type="radio" class="remind-in-input" name="remind-in-option" value="7" id="remind-in-option-7" {{!$tmoffer->closeable_notification_at?'checked':''}}>
                    <label for="remind-in-option-7" class="switch-top3-label switch-top3-label-two">7d</label>
                    <input type="radio" class="remind-in-input" name="remind-in-option" value="14" id="remind-in-option-14">
                    <label for="remind-in-option-14" class="switch-top3-label switch-top3-label-three">14d</label>
                    <input type="radio" class="remind-in-input" name="remind-in-option" value="30" id="remind-in-option-30">
                    <label for="remind-in-option-30" class="switch-top3-label switch-top3-label-four">30d</label>
                    <input type="radio" class="remind-in-input" name="remind-in-option" value="100" id="remind-in-option-100" {{$tmoffer->closeable_notification_at?'checked':''}}>
                    <label for="remind-in-option-100" class="switch-top3-label switch-top3-label-five">CUSTOM</label>
                    <span class="switch-top3-selection"></span>
                    <div id="reminder-date-text" data-reminder-date="{{$reminder_date}}">{{$reminder_date_text}}</div>
                </div>
                <div id="calendar-popup">
                    <div id="datepicker"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-3" id="no-boom-reason-text-block">
    <label for="no-boom-reason-text" class="col-3 control-label">No Boom Reason Description:</label>
    <div class="col-9">
        <textarea class="form-control" rows="5" id="no-boom-reason-text">{{$not_boom_reason_text}}</textarea>
    </div>
</div>
<div class="row mb-3">
    <label for="call-record-url" class="col-3 control-label">Call record url:</label>
    <div class="col-9">
        <input type="text" data-tmf-booking-id="{{$tmf_booking_id}}" id="call-record-url" class="form-control" value="{{$call_record_url}}">
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div id="notes-text">
            Your No-Boom Reason Description will be automatically added to Notes once you Save Changes. <button class="btn btn-sm btn-success" id="view-edit-notes-btn">View/Edit Notes</button>
        </div>
        <div id="notes-block" style="display: none">
            <label for="notes">Notes <a href="#" class="btn btn-sm btn-success ml-1" id="add-date">Add Date</a></label>
            <textarea id="notes" class="form-control" rows="10">{{$tmoffer->Notes}}</textarea>
        </div>
    </div>
</div>
