<div class="card" data-id="<?php echo e($hp_category->id); ?>">
    <div class="card-header" id="section-<?php echo e($hp_category->id); ?>">
        <?php if($user_superadmin): ?>
            <i class="fas fa-arrows-alt move-section-btn" title="Move Section" style="color: #aaa;position:absolute;left: 7px;top:21px;font-size:17px;cursor: grab"></i>
            <h2 class="mb-0 ml-2">
        <?php else: ?>
        <h2 class="mb-0">
        <?php endif; ?>
            <button class="btn btn-link btn-block text-left <?php if(!$loop->first): ?>collapsed <?php endif; ?>" type="button" data-toggle="collapse" data-target="#collapse-<?php echo e($hp_category->id); ?>" aria-expanded="<?php echo e($loop->first?"true":"false"); ?>" aria-controls="collapse-<?php echo e($hp_category->id); ?>">
                <?php echo e($hp_category->name); ?> [<span class="url-count"></span>]
            </button>
        </h2>
        <div style="position: absolute;right: 5px;top:13px;">
            <div class="dropdown">
                <a class="btn btn-default dropdown-toggle" style="color: #777" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-align-justify"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <a href="#" class="dropdown-item add-new-item-btn" title="Add New Link" data-id="<?php echo e($hp_category->id); ?>"><i class="fas fa-plus"></i> Add New Link</a>
                    <?php if($user_superadmin): ?>
                        <a href="#" class="dropdown-item edit-category-btn"
                           data-name="<?php echo e($hp_category->name); ?>"
                           data-bg-color="<?php echo e($hp_category->bg_color); ?>"
                           data-view-access-all="<?php echo e($hp_category->view_access_all); ?>"
                           data-admin-access="<?php echo e(json_encode($hp_category->homepageCategoryAccessTmfsalesRows()->where('homepage_category_access_type_id',1)->get()->pluck('tmfsales_id')->toArray())); ?>"
                           data-view-access="<?php echo e(json_encode($hp_category->homepageCategoryAccessTmfsalesRows()->where('homepage_category_access_type_id',2)->get()->pluck('tmfsales_id')->toArray())); ?>"
                           data-view-access-group="<?php echo e(json_encode($hp_category->homepageCategoryGroupAccessRows()->where('homepage_category_access_type_id',2)->get()->pluck('eos_member_id')->toArray())); ?>"
                           title="Edit Category Name" data-id="<?php echo e($hp_category->id); ?>"><i class="fas fa-pencil-alt"></i> Edit Category</a>
                        <a href="#" class="dropdown-item del-category-btn" title="Remove category" data-id="<?php echo e($hp_category->id); ?>"><i class="fas fa-times"></i> Delete Category</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div id="collapse-<?php echo e($hp_category->id); ?>" class="collapse <?php echo e($loop->first?"show":""); ?>" aria-labelledby="section-<?php echo e($hp_category->id); ?>" data-parent="#root-block">
        <div class="card-body" data-category-id="<?php echo e($hp_category->id); ?>" style="max-height: 600px;overflow-y: auto;overflow-x: hidden">
            <?php echo $__env->make('homepagemaintainer.category-items-table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/homepagemaintainer/root-block.blade.php ENDPATH**/ ?>