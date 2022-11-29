<?php $__env->startSection('content'); ?>

    <div class="container-fluid">

        <div class="row">
            <div class="col-12 bg-info">
                <h1>Платежи</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-6 col-sm-4">
                <h2>Добавить</h2>

                

                <form action="<?php echo e(route('job.pays.create')); ?>" method="post">
                    <?php echo csrf_field(); ?>

                    job_client_id <br />
                    <select name="job_client_id">
                        <option value="">select</option>
                        <?php $__currentLoopData = $d_job_client_id; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($vv->id); ?>"><?php echo e($vv->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <br />
                    job_jobs_id <br />
                    <select name="job_jobs_id">
                        <option value="">select</option>
                        <?php $__currentLoopData = $d_job_jobs_id; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($vv->id); ?>">#<?php echo e($vv->id); ?> <?php echo e($vv->kooperativ ?? ''); ?> #
                                <?php echo e($vv->nomer ?? ''); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <br/>
                    date <br />
                    <input type="date" name="date" value="<?php echo e(date('Y-m-d')); ?>" id=""> <br />

                    amount <br />
                    <input type="text" name="amount" id=""> <br />

                    comment <br />
                    <textarea name="comment" id=""></textarea> <br />

                    status <br />
                    <select name="status">
                        <option value="ok">ok</option>
                    </select>
                    <br />

                    
                    <br />
                    <br />

                    <button type="submit">Добавить</button>

                </form>


            </div>
            <div class="col-6 col-sm-8">

                <table class="table">
                    <thead>
                        <?php $__currentLoopData = $data_head; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pole): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($pole == 'client_id' || $pole == 'job_id' || $pole == 'job_kooperative' || $pole == 'job_nomer'): ?>
                            <?php else: ?>
                                <th><?php echo e($pole); ?></th>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <?php $__currentLoopData = $data_head; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pole): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($pole == 'client_id' || $pole == 'job_id' || $pole == 'job_kooperative' || $pole == 'job_nomer'): ?>
                                    <?php else: ?>
                                        <td><?php echo e($cl->{$pole}); ?></td>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    

<?php $__env->stopSection(); ?>

<?php echo $__env->make('job::app.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/base12/data/www/site/app/Modules/Job/Resources/views/pays.blade.php ENDPATH**/ ?>