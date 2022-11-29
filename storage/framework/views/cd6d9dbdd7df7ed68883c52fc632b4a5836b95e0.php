<table class="table table-bordered">
    <tbody>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo $el['status']->getIcon(); ?> <?php echo e($el['status']->getName()); ?></td>
                <td><?php echo e($el['status']->getDatetime()); ?></td>
                <?php if($loop->index): ?>
                    <td><?php echo e(\App\classes\TimeFormatter::dhm($el['status']->getTimestamp()-$timestamp)); ?></td>
                <?php else: ?>
                    <td>&mdash;</td>
                <?php endif; ?>
                <?php
                    $timestamp=$el['status']->getTimestamp();
                ?>
            </tr>
            <?php if($el['owners-history']): ?>
                <?php $__currentLoopData = $el['owners-history']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dashboard_owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="pl-5"><i class="fas fa-user text-success"></i> <?php echo e($dashboard_owner->tmfsales->FirstName); ?> <?php echo e($dashboard_owner->tmfsales->LastName); ?></td>
                        <td><?php echo e($dashboard_owner->created_at); ?></td>
                        <td><?php echo e(\App\classes\TimeFormatter::dhm(\DateTime::createFromFormat('Y-m-d H:i:s',$dashboard_owner->created_at)->getTimestamp()-$timestamp)); ?></td>
                        <?php
                            $timestamp=\DateTime::createFromFormat('Y-m-d H:i:s',$dashboard_owner->created_at)->getTimestamp();
                        ?>
                    </tr>
                    <?php if($dashboard_owner->released_at): ?>
                        <tr>
                            <td class="pl-5"><i class="fas fa-user text-danger"></i> <?php echo e($dashboard_owner->tmfsales->FirstName); ?> <?php echo e($dashboard_owner->tmfsales->LastName); ?></td>
                            <td><?php echo e($dashboard_owner->released_at); ?></td>
                            <td><?php echo e(\App\classes\TimeFormatter::dhm(\DateTime::createFromFormat('Y-m-d H:i:s',$dashboard_owner->released_at)->getTimestamp()-$timestamp)); ?></td>
                            <?php
                                $timestamp=\DateTime::createFromFormat('Y-m-d H:i:s',$dashboard_owner->released_at)->getTimestamp();
                            ?>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/common-queue/tm-history.blade.php ENDPATH**/ ?>