<li class="nav-item d-flex align-items-center">
    <div class="row ml-3">
        <div class="col-md-12">
            <select id="queue-type" class="form-control w-auto">
                <?php $__currentLoopData = $queue_type_objs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $queue_type_obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($queue_type_obj->id); ?>" <?php echo e(session('queue-type-id')?(session('queue-type-id')==$queue_type_obj->id?'selected':''):''); ?>><?php echo e($queue_type_obj->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
</li>
<li class="nav-item ml-3">
    <a class="nav-link" href="#" id="search-link">Search <i class="fas fa-search"></i></a>
</li>
<li class="nav-item d-flex align-items-center">
    <div class="row ml-3">
        <div class="col-md-12">
            <label class="mb-0"><input type="checkbox" name="group-by-client" value="1"> Group by Client</label>
        </div>
    </div>
</li>
<li class="nav-item d-flex align-items-center">
    <div class="row ml-3">
        <div class="col-md-12">
            <label class="mb-0"><input type="checkbox" id="claimed-by-me-only-chbx" value="1" <?php echo e(session('claimed-by-me')?'checked':''); ?>> Claimed by me Only</label>
        </div>
    </div>
</li>
<li class="nav-item d-flex align-items-center">
    <div class="row ml-3">
        <div class="col-md-12">
            <label class="mb-0"><input type="checkbox" id="review-requested-only-chbx" value="1" <?php echo e(session('review-requested-only')?'checked':''); ?>> Review Requested Only</label>
        </div>
    </div>
</li>

<?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/queue/left-nav-bar.blade.php ENDPATH**/ ?>