<div class="modal" id="filter-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filters</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="text-center">BOOKED WITH:</div>
                        <div class="row">
                            <div class="col-1">
                                <a href="#" data-class="closer-filter-chbx" data-all="1" class="all-btn badge badge-dark">ALL</a>
                            </div>
                            <div class="col-11 text-left">
                                @foreach($tmfsales as $tmfsales_el)
                                    @if(\Illuminate\Support\Facades\Auth::user()->sales_calls)
                                        <label class="mr-3"><input type="checkbox" data-user="{{$tmfsales_el->LongID}}" class="closer-filter-chbx" value="{{$tmfsales_el->ID}}" {{\Illuminate\Support\Facades\Auth::user()->ID==$tmfsales_el->ID?'checked':''}}> {{$tmfsales_el->FirstName}} {{$tmfsales_el->LastName}}</label>
                                    @else
                                        <label class="mr-3"><input type="checkbox" data-user="{{$tmfsales_el->LongID}}" class="closer-filter-chbx" value="{{$tmfsales_el->ID}}" checked> {{$tmfsales_el->FirstName}} {{$tmfsales_el->LastName}}</label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs" id="filters-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="closing-calls-tab" data-toggle="tab" href="#closing-calls" role="tab" aria-controls="closing-calls" aria-selected="true"><div class="d-inline-block mr-2">Closing Calls</div><input style="display: inline-block;" type="checkbox" class="booking-type-filter" value="cc" checked/></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="group-calls-tab" data-toggle="tab" href="#group-calls" role="tab" aria-controls="group-calls" aria-selected="false"><div class="d-inline-block mr-2">Group Calls</div><input style="display: inline-block;" type="checkbox" class="booking-type-filter" value="gc" checked/></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="oe-calls-tab" data-toggle="tab" href="#oe-calls" role="tab" aria-controls="oe-calls" aria-selected="false"><div class="d-inline-block mr-2">OE Calls</div><input style="display: inline-block;" type="checkbox" class="booking-type-filter" value="oec" checked/></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="sou-calls-tab" data-toggle="tab" href="#sou-calls" role="tab" aria-controls="sou-calls" aria-selected="false"><div class="d-inline-block mr-2">SOU Calls</div><input style="display: inline-block;" type="checkbox" class="booking-type-filter" value="souc" checked/></a>
                    </li>
                </ul>
                <div class="tab-content" id="filter-tabs-content">
                    <div class="tab-pane fade show active" id="closing-calls" role="tabpanel" aria-labelledby="closing-calls-tab">
                        <div class="p-3">
                            <div class="closing-types">
                                <div class="row mb-3">
                                    <div class="col-1">
                                        <a href="#" data-class="closing-call-type" data-all="1" class="all-btn badge badge-dark">ALL</a>
                                    </div>
                                    <div class="col-5">
                                        <div>
                                            <label class="mb-1">
                                                <input type="checkbox" class="closing-call-type" value="future-call" checked> <span class="badge" style="background: {{\App\classes\postboombookings\BookingItemBorderColor::futureCall()}}">Future Calls</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="mb-1">
                                                <input type="checkbox" class="closing-call-type" value="no-reason-entered" checked> <span class="badge" style="background: {{\App\classes\postboombookings\BookingItemBorderColor::noReasonEntered()}}">No Reason Entered</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="checkbox" class="closing-call-type" value="no-show" checked> <span class="badge" style="background: {{\App\classes\postboombookings\BookingItemBorderColor::noShow()}}">No Show</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <label class="mb-1">
                                                <input type="checkbox" class="closing-call-type" value="follow-up-scheduled" checked> <span class="badge" style="background: {{\App\classes\postboombookings\BookingItemBorderColor::followUpScheduled()}}">Follow-Up Scheduled</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="mb-1">
                                                <input type="checkbox" class="closing-call-type" value="other-no-boom-reasons" checked> <span class="badge" style="background: {{\App\classes\postboombookings\BookingItemBorderColor::otherReason()}}">Other No-Boom Reasons</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <input type="checkbox" class="closing-call-type" value="boom" checked> <span class="badge" style="background: {{\App\classes\postboombookings\BookingItemBorderColor::boom()}}">BOOM</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-4"></label>
                                <div class="col-8">
                                    <a href="#" data-class="closeable-filter-chbx" data-all="1" class="all-btn badge badge-dark mr-3">ALL</a>
                                    <label class="mr-3">
                                        <input type="checkbox" class="closeable-filter-chbx" value="1" checked> YES
                                    </label>
                                    <label class="mr-3">
                                        <input type="checkbox" class="closeable-filter-chbx" value="0" checked> MAYBE
                                    </label>
                                    <label>
                                        <input type="checkbox" class="closeable-filter-chbx" value="-1" checked> NO
                                    </label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-4">Bookings from:</label>
                                <div class="col-8">
                                    <label><a href="#" data-class="cc-from-filter-chbx" data-all="1" class="all-btn badge badge-dark mr-3">ALL</a></label>
                                    <label class="mr-3">
                                        <input type="checkbox" class="cc-from-filter-chbx" value="ga" checked> GA
                                    </label>
                                    <label class="mr-3">
                                        <input type="checkbox" class="cc-from-filter-chbx" value="yt" checked> YouTube
                                    </label>
                                    <label>
                                        <input type="checkbox" class="cc-from-filter-chbx" value="other" checked> Other
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="group-calls" role="tabpanel" aria-labelledby="group-calls-tab">Coming Soon...</div>
                    <div class="tab-pane fade" id="oe-calls" role="tabpanel" aria-labelledby="oe-calls-tab">Coming Soon...</div>
                    <div class="tab-pane fade" id="sou-calls" role="tabpanel" aria-labelledby="sou-calls-tab">Coming Soon...</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="filter-apply-btn">Apply Filters</button>
            </div>
        </div>
    </div>
</div>