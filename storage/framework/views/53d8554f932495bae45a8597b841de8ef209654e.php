<div class="modal" id="edit-flags-values-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Flags Values</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="warning-at" class="col-md-3">Warning at:</label>
                    <div class="col-md-9">
                        <div class="form-group">
                            <div class="input-group date" id="warning-at-datetimepicker" data-target-input="nearest">
                                <input type="text" id="warning-at" class="form-control datetimepicker-input" data-target="#warning-at-datetimepicker"/>
                                <div class="input-group-append" data-target="#warning-at-datetimepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="warning-at" class="col-md-3">Danger at:</label>
                    <div class="col-md-9">
                        <div class="form-group">
                            <div class="input-group date" id="danger-at-datetimepicker" data-target-input="nearest">
                                <input type="text" id="danger-at" class="form-control datetimepicker-input" data-target="#danger-at-datetimepicker"/>
                                <div class="input-group-append" data-target="#danger-at-datetimepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="save-flag-values-btn">Save changes</button>
            </div>
        </div>
    </div>
</div><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/queue/edit-flags-values-modal.blade.php ENDPATH**/ ?>