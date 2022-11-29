<?php $__env->startSection('content'); ?>

    <h2><?php echo $__env->yieldContent('content-head'); ?></h2>
    <?php echo $__env->make('billiard::pages.'.$page, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    

    
    


<?php $__env->stopSection(); ?>

<?php echo $__env->make('billiard::app.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/base12/data/www/site/app/Modules/Billiard/Resources/views/page-page.blade.php ENDPATH**/ ?>