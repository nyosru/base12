<?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($value): ?>
        <span class="badge <?php echo e($key); ?> <?php echo e(($loop->first?'':'ml-1')); ?>"><?php echo e($value); ?></span>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/tmf-reg-queue/badges.blade.php ENDPATH**/ ?>