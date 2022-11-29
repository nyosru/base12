<div class="modal" id="change-closer-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Closer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="new-closer" class="col-3">Closer:</label>
                    <div class="col-9">
                        <select class="form-control" id="new-closer">
                            @foreach($closers as $closer)
                                <option value="{{$closer->ID}}">{{$closer->FirstName}} {{$closer->LastName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="change-closer-save-btn">Save Changes</button>
            </div>
        </div>
    </div>
</div>
