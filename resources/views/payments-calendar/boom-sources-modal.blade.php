<div class="modal" id="boom-sources-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Boom Sources</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach($boom_sources as $el)
                        <div class="col-4">
                            <label>
                                @if(Auth::user()->sales_calls)
                                    <input type="checkbox" class="boom-source-chbx" value="{{$el->ID}}" {{Auth::user()->ID==$el->ID?'checked':''}}> {{$el->FirstName.' '.$el->LastName}}
                                @else
                                    <input type="checkbox" class="boom-source-chbx" value="{{$el->ID}}" checked> {{$el->FirstName.' '.$el->LastName}}
                                @endif
                            </label>
                        </div>
                    @endforeach
                        <div class="col-4">
                            <label>
                                <input type="checkbox" class="boom-source-chbx" value="-1" {{Auth::user()->sales_calls?'':'checked'}}> Auto-Boom
                            </label>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="apply-bs-filter-btn">Apply Filter</button>
            </div>
        </div>
    </div>
</div>
