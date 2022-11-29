<div class="modal" id="add-edit-category-modal" tabindex="-1" role="dialog">
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
                    <label class="col-3" for="portal-section">Category Name:</label>
                    <div class="col-9">
                        <input type="text" class="form-control" id="category-name"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-3" for="portal-section">Bg Color:</label>
                    <div class="col-9">
                        <input type="text" class="form-control" id="bg-color"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2 text-left">
                        <strong class="mr-1">View Access:</strong> 
                    </div>
                    <div class="col-10 text-left">
                        <label class="mr-1">
                            <input type="checkbox" data-class="view-access-filter-chbx" data-all="1" class="view-access-all-filter-chbx all-btn"> ALL
                        </label>
                        <?php $__currentLoopData = \App\EosMember::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eos_member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="mr-1">
                                <input type="checkbox" class="view-access-filter-chbx eos-group" value="<?php echo e($eos_member->id); ?>"> <?php echo e($eos_member->name); ?>

                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = \App\Tmfsales::where('Visible',1)->whereNotIn('ID',[65,70])->orderBy('Level','desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tmfsales): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="mr-1">
                                <input type="checkbox" class="view-access-filter-chbx tmfsales" data-groups="<?php echo e(json_encode($tmfsales->tmfsalesEosMemberRows->pluck('eos_member_id')->toArray())); ?>" value="<?php echo e($tmfsales->ID); ?>"> <?php echo e($tmfsales->FirstName); ?> <?php echo e($tmfsales->LastName); ?>

                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 text-left">
                        <strong class="mr-1">Admin Access:</strong> 
                    </div>
                    <div class="col-10 text-left">
                        <?php $__currentLoopData = \App\Tmfsales::where('Visible',1)->orderBy('Level','desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tmfsales): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="mr-1">
                                <input type="checkbox" class="admin-access-filter-chbx" value="<?php echo e($tmfsales->ID); ?>"> <?php echo e($tmfsales->FirstName); ?> <?php echo e($tmfsales->LastName); ?>

                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="save-category-btn">Save</button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/homepagemaintainer/add-edit-category-modal.blade.php ENDPATH**/ ?>