<div class="modal" id="notes-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Notes</h5>
                <button class="btn btn-sm btn-success ml-3" id="new-note-btn"><i class="fas fa-plus"></i> Add TimeStamp</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <textarea id="notes" class="form-control" rows="10" style="resize: vertical"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="save-notes-btn">Save Changes</button>
            </div>
        </div>
    </div>
</div>
