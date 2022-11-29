<span class="float-right">
    <a href="#" class="edit-sub-status text-primary <?php echo e(($tmf_reg_queue_status_obj->removable?'mr-3':'')); ?>" data-id="<?php echo e($tmf_reg_queue_status_obj->id); ?>"><i class="fas fa-pencil-alt"></i></a>
    <?php if($tmf_reg_queue_status_obj->removable): ?>
        <a href="#" class="del-sub-status text-danger" data-id="<?php echo e($tmf_reg_queue_status_obj->id); ?>"><i class="fas fa-times"></i></a>
    <?php endif; ?>
</span><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/tmf-reg-queue-status-maintainer/sub-status-edit-remove-btns.blade.php ENDPATH**/ ?>