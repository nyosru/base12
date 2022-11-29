<?php if($tmoffer_actions_history_objs->count()): ?>
    <table class="table">
        <thead>
            <tr>
                <th class="text-left">Date and time, PST</th>
                <th class="text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $tmoffer_actions_history_objs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-left"><?php echo e((\DateTime::createFromFormat('Y-m-d H:i:s',$el->created_at))->format('Y-m-d \@ g:ia')); ?></td>
                    <td class="text-left"><?php echo $el->action_descr; ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="text-center">EMPTY</div>
<?php endif; ?><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/post-boom-bookings-calendar/tmoffer-actions-history.blade.php ENDPATH**/ ?>