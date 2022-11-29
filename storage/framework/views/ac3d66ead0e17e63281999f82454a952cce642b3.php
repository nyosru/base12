<div class="modal" id="new-sub-status-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label for="new-status" class="col-md-3">Status Type:</label>
                    <div class="col-md-9">
                        <select id="queue-status-type" class="form-control w-auto">
                            <?php $__currentLoopData = $queue_status_type_objs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $queue_status_type_obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($queue_status_type_obj->id); ?>"><?php echo e($queue_status_type_obj->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="new-status" class="col-md-3">TMFQ Status:</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="new-sub-status"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="root-status" class="col-md-3">TMFQ Root:</label>
                    <div class="col-md-9">
                        <select class="form-control" id="root-status" style="width: auto;"></select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="global-status" class="col-md-3">Dashboard Global Status:</label>
                    <div class="col-md-9">
                        <select class="form-control" id="global-status" style="width: auto;">
                            <?php $__currentLoopData = \App\DashboardGlobalStatus::orderBy('status_order_index','asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($el->id); ?>"><?php echo e($el->status_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="dashboard-status" class="col-md-3">Dashboard Status:</label>
                    <div class="col-md-9">
                        <select class="form-control" id="dashboard-status" style="width: auto;">
                            <?php $__currentLoopData = \App\CipostatusStatusFormalized::where('service_flag',0)
                                        ->orderBy('status_order','asc')
                                        ->orderBy('substatus_order','asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($el->id); ?>"><?php echo ($el->substatus_order?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':''); ?><?php echo e($el->status); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <?php $__currentLoopData = $flags_prefixes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flag_prefix): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div><span class="<?php echo e($flag_prefix['class']); ?>"><?php echo e(ucfirst($flag_prefix['caption'])); ?></span> flag settings:</div>
                            <?php echo $flag_settings->html($flag_prefix['caption']); ?>

                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <label for="description">Client Update Message:</label>
                        <textarea class="form-control" id="description" rows="4" style="resize: vertical"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-sub-status-btn"><i class="fas fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/queue-status-maintainer/new-sub-status-modal.blade.php ENDPATH**/ ?>