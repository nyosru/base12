<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat_caption=>$stat_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
    $suffix='';
    switch ($stat_caption){
        case 'Total Bookings':
            if($data['Successful calls']['count'])
                $suffix=sprintf(' (%s%%)',round(100*$data[$stat_caption]['count']/$data['Successful calls']['count'],2));
            else
                $suffix='N/A';
        break;
        case 'BOOMS':
        $suffix=sprintf(' (%d TMs)',$data[$stat_caption]['tms-count']);
        break;
    }
    ?>
    <?php echo e($stat_caption); ?>: <?php echo e($stat_details['count']); ?><?php echo e($suffix); ?> (<a href="#" class="stat-details" data-action="<?php echo e($stat_caption); ?>" data-ids="<?php echo e(json_encode($stat_details['ids'])); ?>">details</a>)<br/>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
BOOM Rate: <?php echo e(($data['Total Bookings']['count']-$data['Future Bookings']['count'])?round(100*$data['BOOMS']['count']/($data['Total Bookings']['count']-$data['Future Bookings']['count']),2):'N/A'); ?>%<br/>
BOOM Rate Minus No-Shows: <?php echo e(($data['Total Bookings']['count']-$data['Future Bookings']['count']-$data['No-Shows']['count'])?round(100*$data['BOOMS']['count']/($data['Total Bookings']['count']-$data['Future Bookings']['count']-$data['No-Shows']['count']),2):'N/A'); ?>%<?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/pq-stats/stats.blade.php ENDPATH**/ ?>