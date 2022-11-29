<?php $__env->startSection('title'); ?>
    Trends
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Trends
                        <a href="/ops-snapshot" class="float-right mr-3">Snapshot</a>
                        <a href="/ops-period" class="float-right mr-3">Period Page</a>
                    </div>

                    <div class="card-body">
                        <div class="mb-3 text-center">
                            <label class="mr-3"><input type="checkbox" class="country-chbx" value="Canada" checked/> Canada</label>
                            <label class="mr-3"><input type="checkbox" class="country-chbx" value="United States" checked/> United States</label>
                            <label class="mr-3"><input type="checkbox" class="country-chbx" value="Others" checked/> Other</label>
                        </div>
                        <div class="mb-3 text-center">
                            <span class="mr-2">
                                <span class="mr-3">Last:</span>
                                <span id="days">
                                    <a href="#" class="last-el mr-1" data-value="3">3</a>
                                    <a href="#" class="last-el mr-1" data-value="4">4</a>
                                    <span class="mr-1 font-weight-bold selected-day">6</span>
                                    <a href="#" class="last-el mr-1" data-value="10">10</a>
                                    <a href="#" class="last-el mr-1" data-value="12">12</a>
                                </span>
                            </span>
                            <span id="periods">
                                <a href="#" class="last-period mr-1" data-value="Weeks">Weeks</a>
                                <span class="mr-1 font-weight-bold selected-period">Months</span>
                                <a href="#" class="last-period mr-1" data-value="Quarters">Quarters</a>
                                
                            </span>
                        </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <?php $__currentLoopData = $ops_snapshot_title_group_objs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ops_snapshot_title_group_obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link <?php echo e(($loop->index==0?'active':'')); ?>" id="tc<?php echo e($ops_snapshot_title_group_obj->id); ?>-tab" data-toggle="tab" href="#tc<?php echo e($ops_snapshot_title_group_obj->id); ?>" role="tab"
                                       aria-controls="tc<?php echo e($ops_snapshot_title_group_obj->id); ?>" aria-selected="<?php echo e(($loop->index==0?'true':'false')); ?>"><?php echo e($ops_snapshot_title_group_obj->name); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <?php $__currentLoopData = $ops_snapshot_title_group_objs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ops_snapshot_title_group_obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="tab-pane <?php echo e(($loop->index==0?'active':'fade')); ?>" id="tc<?php echo e($ops_snapshot_title_group_obj->id); ?>" role="tabpanel" aria-labelledby="tc<?php echo e($ops_snapshot_title_group_obj->id); ?>-tab">
                                    <div class="row p-3">
                                        <div class="col-12">
                                            <?php $__currentLoopData = $tchart->getDatasets(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dataset_el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(\App\OpsSnapshotTitle::find(array_values($dataset_el)[0]['trends_chart_id'])->ops_snapshot_title_group_id==$ops_snapshot_title_group_obj->id): ?>
                                                    <div id="tc<?php echo e($loop->index); ?>-content">
                                                        <canvas id="tc<?php echo e($loop->index); ?>-canvas"></canvas>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('external-jscss'); ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <script src="https://trademarkfactory.com/js/Chart.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
    <link rel="stylesheet" type="text/css" href="/datatables/datatables.min.css"/>
    <script type="text/javascript" src="/datatables/datatables.min.js"></script>
    <?php echo $__env->make('ops-trends.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('ops-trends.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modals'); ?>
    <?php echo $__env->make('ops-trends.details-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div style="position: fixed; top: 15px; right: 15px;">

        <!-- Then put toasts within -->
        <div class="toast" role="alert" aria-live="polite" aria-atomic="true" data-delay="1500" data-animation="true" style="width: 350px;">
            <div class="toast-header">
                <img src="/img/magentatmf.png" style="width: 16px;height: 16px;" class="rounded mr-2">
                <strong class="mr-auto">System Message</strong>
                <small class="text-muted">just now</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Saved
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/ops-trends/index.blade.php ENDPATH**/ ?>