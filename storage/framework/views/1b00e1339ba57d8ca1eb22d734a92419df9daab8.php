<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="row" style="padding: 10px 0;">
            <div class="col-12 bg-info">
                <h2>Клиенты</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-4">

                <h3>Добавить</h3>

                <form action="<?php echo e(route('job.client.create')); ?>" method="post">
                    <?php echo csrf_field(); ?>

                    name <br />
                    <input type="text" name="name" id=""> <br />

                    phone <br />
                    <input type="text" name="phone" id=""> <br />

                    phone2 <br />
                    <input type="text" name="phone2" id=""> <br />
                    phone2_name <br />
                    <input type="text" name="phone2_name" id=""> <br />
                    comment <br />
                    <textarea name="comment"></textarea>

                    <br />
                    <br />

                    <button type="submit">Добавить</button>

                </form>


            </div>
            <div class="col-12 col-sm-8">

                <table class="table">
                    <thead>
                        <?php $__currentLoopData = $clients_head; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pole): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th><?php echo e($pole); ?></th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <?php $__currentLoopData = $clients_head; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pole): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td>
                                        <?php if(
                                            strpos($pole, 'phone') !== false &&
                                            strpos($pole, 'name') === false
                                            ): ?>
                                            <a href="tel:<?php echo e($cl->{$pole}); ?>"><?php echo e($cl->{$pole}); ?></a>
                                        <?php else: ?>
                                            <?php echo e($cl->{$pole}); ?>

                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    

<?php $__env->stopSection(); ?>

<?php echo $__env->make('job::app.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/base12/data/www/site/app/Modules/Job/Resources/views/clients.blade.php ENDPATH**/ ?>