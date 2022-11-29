<div class="modal" id="search-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Search TMs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <label for="client_fn" class="col-md-2">Client:</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="client_fn"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label for="tm" class="col-md-2">TM:</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="tm"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 text-center">
                        <label><input type="checkbox" id="show-not-in-queue" value="1"> Also show TMs that are not currently in the TM Filing Queue</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-sm btn-success" id="search-btn">Search</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center" id="search-results-block">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/tmf-filing-queue/search-modal.blade.php ENDPATH**/ ?>