<select class="days-select mr-2" data-root-id="<?php echo e($el->id); ?>">
    <?php $__currentLoopData = $days_select_arr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($day); ?>" <?php echo e($selected_day==$day?'selected':''); ?>><?php echo e($day); ?> days</option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/queue/days-select.blade.php ENDPATH**/ ?>