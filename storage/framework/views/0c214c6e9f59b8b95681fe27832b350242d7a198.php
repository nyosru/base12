<p>It looks like we may have a problem with one or more invoice emails scheduled for <?php echo e($scheduled_date->format('F j, Y')); ?>.</p>
<?php $__currentLoopData = $tmoffers_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tmoffer_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <p style="margin-bottom: 10px;">
        <a href="https://trademarkfactory.com/mlcclients/acceptedagreements.php?login=<?php echo e($tmoffer_data['tmoffer']->Login); ?>&sbname=&sbphone=&sbtm=&sbemail=&sbnote=&date_from=&date_to=&affiliate_camefrom=&sort_by=new_logins_first&show=ALL&sbmt_btn=SEARCH&page=1" target="_blank">#<?php echo e($tmoffer_data['tmoffer']->Login); ?>'s</a>
        payment of <?php echo e($tmoffer_data['invoices_data']['current-invoice-index']+1); ?> of <?php echo e($tmoffer_data['invoices_data']['invoices']); ?> is
        on <?php echo e($payment_date->format('F j, Y')); ?>. However, according to our system, payment <?php echo e($tmoffer_data['invoices_data']['current-invoice-index']); ?> is still outstanding.
    </p>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<p>Please edit or block the scheduled emails to make sure we have addressed this properly.</p>
<p>If in doubt, discuss with Andrei.</p>


<?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/payments-calendar/scheduled-problem-email.blade.php ENDPATH**/ ?>