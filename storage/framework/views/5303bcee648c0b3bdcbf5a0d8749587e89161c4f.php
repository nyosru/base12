<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center">Status</th>
            <th class="text-center">#</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-left" <?php echo $el['border-top']?'style="border-top:2px solid black;"':''; ?>><?php echo $el['caption']; ?></td>
                <td class="text-center font-<?php echo e($el['font-style']); ?>" <?php echo $el['border-top']?'style="border-top:2px solid black;"':''; ?>><a href="#" class="show-details" data-ids="<?php echo e(json_encode($el['obj']->getUnfilteredDashboardIds())); ?>" title="<?php echo e((count($el['obj']->getUnfilteredDashboardIds())-$el['obj']->getNum())?'+ '.(count($el['obj']->getUnfilteredDashboardIds())-$el['obj']->getNum()).' hidden marks':''); ?>"><?php echo e($el['obj']->getNum()); ?></a></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/ops-period/result-table.blade.php ENDPATH**/ ?>