<div class="overflow-auto">

    <table class="table table-bordered">
        <thead>
        <tr>
            <th class="text-center"><?php echo e($type_caption); ?></th>
            <th colspan="2"
                class="text-center bold-border-left bold-border-right"><?php echo implode('</th><th colspan="2" class="text-center bold-border-left bold-border-right">',$table_th); ?></th>
            <th colspan="2" class="text-center bold-border-left bold-border-right total">Total</th>
        </tr>
        <tr>
            <th></th>
            <?php $__currentLoopData = $table_th; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <th class="text-center bold-border-left num">#</th>
                <th class="text-center bold-border-right">%</th>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <th class="text-center num bold-border-left total">#</th>
            <th class="text-center bold-border-right total">%</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center"><?php echo e($type->name); ?></td>
                <?php $__currentLoopData = $table_th; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m_index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <td class="text-center num bold-border-left" title="<?php echo e($type->name); ?>"><?php echo isset($data[$type->name][$m_index])?($data[$type->name][$m_index]['num']?$data[$type->name][$m_index]['num']:'<span class="zero">0</span>'):'<span class="zero">0</span>'; ?></td>
                    <td class="text-right num-percent bold-border-right" title="<?php echo e($type->name); ?>">
                        <?php if(isset($data[$type->name][$m_index]) && $data[$type->name][$m_index]['num']>0): ?>
                            <?php if($data['total'][$m_index]): ?>
                                <?php if($data[$type->name][$m_index]['num']): ?>
                                    <?php echo e(number_format(100*$data[$type->name][$m_index]['num']/$data['total'][$m_index]['num'],2)); ?>%
                                <?php else: ?>
                                    <span class="zero">0%</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="zero">N/A</span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="zero">0%</span>
                        <?php endif; ?>
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <td class="text-center num bold-border-left total"  title="<?php echo e($type->name); ?>"><?php echo isset($total_rows_n[$type->name])?($total_rows_n[$type->name]?$total_rows_n[$type->name]:'<span class="zero">0</span>'):'<span class="zero">0</span>'; ?></td>
                <td class="text-right num-percent bold-border-right total"  title="<?php echo e($type->name); ?>"><?php echo isset($total_rows_n[$type->name])?(abs($total_rows_n[$type->name])>0?number_format(100*$total_rows_n[$type->name]/$total_amount_n,2):'<span class="zero">0</span>'):'<span class="zero">0</span>'; ?>

                    %
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td class="text-center font-weight-bold total">TOTAL</td>
            <?php $__currentLoopData = $table_th; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m_index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <td class="text-center num font-weight-bold bold-border-left total"><?php echo ($data['total'][$m_index]['num']?$data['total'][$m_index]['num']:'<span class="zero">0</span>'); ?></td>
                <td class="bold-border-right total"></td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <td class="text-center num font-weight-bold bold-border-left total"><?php echo (abs($total_amount_n)>0?$total_amount_n:'<span class="zero">0</span>'); ?></td>
            <td class="bold-border-right total"></td>
        </tr>
        </tbody>
    </table>
</div>
<?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/tmf-revenue-breakdown/tabs/ct-bs-pt-public.blade.php ENDPATH**/ ?>