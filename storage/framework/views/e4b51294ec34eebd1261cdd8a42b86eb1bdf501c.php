<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client=>$data_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $result=[
            'badge-success'=>0,
            'badge-warning'=>0,
            'badge-danger'=>0
        ];

        foreach($data_val as $el){
                if ($tmf_filing_queue_status->deadline_warning_hours > 0 && $tmf_filing_queue_status->deadline_overdue_hours > 0) {
                    $index='badge-success';
                    if (($el['pending_in_this_status_delta'] > $tmf_filing_queue_status->deadline_warning_hours * 3600) &&
                        ($el['pending_in_this_status_delta'] < $tmf_filing_queue_status->deadline_overdue_hours * 3600))
                        $index = 'badge-warning';
                    elseif ($el['pending_in_this_status_delta'] > $tmf_filing_queue_status->deadline_overdue_hours * 3600)
                        $index = 'badge-danger';
                    $result[$index]++;
                }
        }
    ?>
    <div class="accordion" id="client-tms-block">
        <div class="card">
            <div class="card-header" id="client-tms-block-<?php echo e($loop->index); ?>">
                <h2 class="mb-0">
                    <button class="d-flex align-items-center btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-<?php echo e($loop->index); ?>" aria-expanded="false" aria-controls="collapse-<?php echo e($loop->index); ?>">
                        <div class="flex-grow-1 mr-2">
                            <?php echo e($client); ?> [<?php echo e(count($data_val)); ?>]
                        </div>
                        <div class="flex-shrink-1">
                        <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($val): ?>
                                    <span class="badge <?php echo e($key); ?> ml-1"><?php echo e($val); ?></span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </button>
                </h2>
            </div>
            <div id="collapse-<?php echo e($loop->index); ?>" class="collapse" aria-labelledby="client-tms-block-<?php echo e($loop->index); ?>" data-parent="#client-tms-block">
                <div class="card-body">
                    <table class="table table-bordered item-table" id="item-table-<?php echo e($loop->index); ?>" style="border-collapse: collapse !important;width: 100%">
                        <thead>
                        <tr>
                            <th class="text-left">Trademark</th>
                            <th class="text-center"><img src="http://mincovlaw.com/images/icons/cipo_uspto.jpg" style="width: 20px;height: 12px;"></th>
                            <th class="text-center">🏁</th>
                            <th class="text-center">Time since</th>
                            <th class="text-center">Pending in<br/>this status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $data_val; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="item-row sub-status-tm"
                                data-dashboard-id="<?php echo e($el['dashboard']->id); ?>"
                                data-tmoffer-login="<?php echo e(($el['tmoffer']?$el['tmoffer']->Login:'')); ?>"
                                data-tmoffer-id="<?php echo e(($el['tmoffer']?$el['tmoffer']->ID:'')); ?>"
                                <?php if(in_array(\Illuminate\Support\Facades\Auth::user()->ID,[1])): ?>
                                data-addy-note="<?php echo e(($el['tmoffer']?\App\classes\ThankYouCardSentTextGetter::run($el['tmoffer']->ID):'[]')); ?>"
                                <?php endif; ?>
                                data-trigger="<?php echo e($el['time_since_caption']); ?>"
                            >
                                <td class="text-center
            <?php if($tmf_filing_queue_status->deadline_warning_hours>0 && $tmf_filing_queue_status->deadline_overdue_hours>0): ?>
                                <?php echo e((($el['pending_in_this_status_delta']>$tmf_filing_queue_status->deadline_warning_hours*3600) && ($el['pending_in_this_status_delta']<$tmf_filing_queue_status->deadline_overdue_hours*3600))?'bg-warning':''); ?>

                                <?php echo e(($el['pending_in_this_status_delta']>$tmf_filing_queue_status->deadline_overdue_hours*3600)?'bg-danger':''); ?>

                                <?php endif; ?>" style="height: 100px;padding: 0.32rem">
                                    <div style="background: white;border:1px solid #565656;border-radius: 5px;height: 100%;">
                                        <table style="height: 100%;width: 100%;border: none">
                                            <tr>
                                                <td style="text-align: center;vertical-align: middle;border: none">
                                                    <strong><?php echo $el['mark']; ?></strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                                <td class="text-center align-middle" title="<?php echo e($el['country']); ?>"><?php echo $el['flag']; ?> <span style="opacity: 0;position: absolute;left: 0;"><?php echo e($el['country']); ?></span></td>
                                <td class="text-center align-middle" style="white-space: nowrap" <?php if(strlen($el['boom_when_by'])): ?> title="<?php echo e($el['boom_when_by']); ?>" <?php endif; ?>><?php echo $el['time_since_caption_icon']; ?><span style="position: absolute;opacity: 0"><?php echo strlen($el['time_since_caption'])?$el['time_since_caption']:'N/A'; ?></span></td>
                                <td class="text-center align-middle" style="white-space: nowrap" data-order="<?php echo e($el['time_since_delta']); ?>"><?php echo $el['time_since_formatted']; ?></td>
                                <td class="text-center align-middle" style="white-space: nowrap" data-order="<?php echo e($el['pending_in_this_status_delta']); ?>"><?php echo $el['pending_in_this_status']; ?></td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/tmf-filing-queue/client-tms-list.blade.php ENDPATH**/ ?>