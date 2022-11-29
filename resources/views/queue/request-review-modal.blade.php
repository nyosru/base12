<div class="modal" id="request-review-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request Review?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label class="d-block mb-3">
                    <input type="checkbox" id="notify-request-review-chbx" checked> Send notification into queue group
                </label>
                <label for="review-message">Message:</label>
                <textarea class="form-control" id="review-message" style="resize: vertical" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="request-review-yes-btn">Yes</button>
            </div>
        </div>
    </div>
</div>