<div class="modal" id="select-month-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Month</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <select class="form-control mr-3" id="month" style="width: auto;display: inline-block;">
                            <?php for($i = 1; $i < 13; $i++): ?>
                                <option value="<?php echo e($i); ?>"><?php echo e((new \DateTime($today->format('Y').'-'.($i<10?'0':'').$i.'-01'))->format('F')); ?></option>
                            <?php endfor; ?>
                        </select>
                        <select class="form-control" id="year" style="width: auto;display: inline-block;">
                            <?php for($i = 2018; $i <= $today->format('Y'); $i++): ?>
                                <option value="<?php echo e($i); ?>" <?php if($i==$today->format('Y')): ?> selected <?php endif; ?>><?php echo e($i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="select-month-btn">Select</button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/payments-calendar/select-month-modal.blade.php ENDPATH**/ ?>