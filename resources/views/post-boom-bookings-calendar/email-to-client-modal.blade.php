<div class="modal fade" id="email-to-client-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email To Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-6">
                        <div class="row">
                            <label for="my-email" class="col-md-4 control-label">Email:</label>
                            <div class="col-md-8">
                                <input type="email" id="my-email" class="form-control" value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label for="my-who" class="col-md-4 control-label">Who Sends:</label>
                            <div class="col-md-8">
                                <select id="my-who" class="form-control">
                                    @foreach(\App\Tmfsales::where('google_calendar_id','!=','')->where('Visible',1)->orderBy('ID','desc')->get() as $tmfsales)
                                        <option value="{{$tmfsales->ID}}" {{($tmfsales->ID==\Illuminate\Support\Facades\Auth::user()->ID?'selected':'')}}>{{$tmfsales->FirstName}} {{$tmfsales->LastName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <label for="my-subject" class="col-md-2 control-label">Subject:</label>
                    <div class="col-md-10">
                        <input type="text" id="my-subject" class="form-control" value=""/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <textarea id="my-message"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="email-to-client-send-btn">Send Email</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->