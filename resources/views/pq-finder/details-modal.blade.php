<div class="modal fade" id="details-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-2">Client: <span id="client-fn"></span></div>
                <div class="mb-2">Email: <span id="client-email"></span></div>
                <div class="mb-2">Phone: <span id="client-phone"></span></div>
                <div class="mb-2">Status: <span id="current-status"></span></div>
                <div class="mb-2" id="booking-info-block"></div>
                <div class="mb-2">From: <span id="rd-from"></span></div>
                <div class="mb-2">First Page: <span id="rd-first-page"></span></div>
                <div class="mb-2">Offer: <span id="rd-offer"></span></div>
                <div class="mb-2" style="max-height: 250px;overflow-y: auto;overflow-x: hidden" id="prospect-answers"></div>
                <div class="mb-2">
                    <textarea id="users-notes" class="form-control" rows="7" readonly></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->