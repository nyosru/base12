<div class="modal" id="email-form-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 450px;overflow-x: hidden;overflow-y: scroll">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <label for="dear" class="col-md-2">Dear:</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="dear"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label for="email" class="col-md-2">Email:</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="email"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <label for="from" class="col-md-2">From:</label>
                            <div class="col-md-10">
                                <select id="from" class="form-control">
                                    @foreach($tmfsales as $tmfsale_row)
                                        <option value="{{$tmfsale_row->ID}}"
                                                @if($tmfsale_row->ID==Auth::user()->ID) selected @endif>{{$tmfsale_row->FirstName}} {{$tmfsale_row->LastName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row" id="payments-methods">
                            <label for="pay-by" class="col-md-2">By:</label>
                            <div class="col-md-9">
                                <select id="pay-by" class="form-control">
                                    <option value="cc">Credit card</option>
                                    <option value="paypal">Paypal</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="row">
                            <label for="subj" class="col-md-1">Subj:</label>
                            <div class="col-md-11">
                                <input type="text" class="form-control" id="subj"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="email-text-block">
                    <textarea id="email-text"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success" id="send-email-btn">Send Email</button>
                <button class="btn btn-success" id="schedule-email-btn">Schedule</button>
            </div>
        </div>
    </div>
</div>
