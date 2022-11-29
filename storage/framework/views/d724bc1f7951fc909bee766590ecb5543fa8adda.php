<div class="modal" id="<?php echo e($filter_modal_name); ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e($filter_modal_title); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php for($i=0;$i<=intval($objs->count()/2);$i++): ?>
                            <div><label><input type="checkbox" class="<?php echo e($filter_class); ?>" value="<?php echo e($objs[$i]->id); ?>" checked> <?php echo e($objs[$i]->name); ?></label></div>
                        <?php endfor; ?>
                    </div>
                    <div class="col-md-6">
                        <?php for($i=(intval($objs->count()/2)+1);$i<$objs->count();$i++): ?>
                            <div><label><input type="checkbox" class="<?php echo e($filter_class); ?>" value="<?php echo e($objs[$i]->id); ?>" checked/> <?php echo e($objs[$i]->name); ?></label></div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-block text-right">
                <button type="button" class="btn btn-secondary toggle-all float-left">Toggle All</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary apply-filter" data-dismiss="modal">Apply Filter</button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/tmf-revenue-breakdown/filter-modal.blade.php ENDPATH**/ ?>