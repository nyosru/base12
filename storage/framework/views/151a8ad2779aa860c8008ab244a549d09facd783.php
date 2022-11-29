<?php $__currentLoopData = $queue_root_status_objs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="card">
    <div class="card-header d-flex align-items-center" id="root-status-<?php echo e($el->id); ?>">
        <h2 class="mb-0 flex-grow-1">
            <button class="btn btn-link btn-block text-left root-status" data-id="<?php echo e($el->id); ?>" type="button" data-toggle="collapse" data-target="#root-status-collapse-<?php echo e($el->id); ?>" aria-expanded="false" aria-controls="root-status-collapse-<?php echo e($el->id); ?>">
                <?php echo e($el->name); ?> [<span class="root-total" data-id="<?php echo e($el->id); ?>"><img src="https://trademarkfactory.imgix.net/img/loading.gif" style="height:16px;;width: 16px;"/></span>]
            </button>
        </h2>
        <div class="flex-shrink-1">
            <?php if($el->name=='Done'): ?> <?php echo $__env->make('queue.days-select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php endif; ?>
        </div>
        <?php if($el->name!='Done'): ?>
        <div class="flex-shrink-1 root-numbers-block" data-id="<?php echo e($el->id); ?>">
            <img src="https://trademarkfactory.imgix.net/img/loading.gif" style="height:16px;;width: 16px;"/>
        </div>
        <?php endif; ?>
    </div>

    <div id="root-status-collapse-<?php echo e($el->id); ?>" class="collapse" aria-labelledby="root-status-<?php echo e($el->id); ?>" data-parent="#root-statuses">
        <div class="card-body">
            <div class="list-group">
                <?php echo $__env->make('queue.sub-statuses-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/queue/root-statuses-list.blade.php ENDPATH**/ ?>