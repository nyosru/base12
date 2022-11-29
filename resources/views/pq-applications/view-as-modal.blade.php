<div class="modal fade" id="view-as-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View As...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <select id="view-as-tmfsales" class="form-control" style="width: auto;margin: auto">
                    @foreach(\App\Tmfsales::where('sales_calls',1)->where('Visible',1)->orWhereIn('ID',[1,53])->orWhere('Position','Client Success Representative')->orderBy('ID','desc')->get() as $tmfsales)
                        <option value="{{$tmfsales->ID}}" {{$tmfsales->ID==session('current_user')?'selected':''}}>{{$tmfsales->FirstName}} {{$tmfsales->LastName}}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="apply-btn">Apply</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->b