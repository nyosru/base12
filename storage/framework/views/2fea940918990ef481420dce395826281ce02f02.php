<?php $__env->startSection('title'); ?>
    PQ Stats
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        PQ Stats
                    </div>
                    <div class="card-body">
                        
                            <?php echo csrf_field(); ?>
                            <div class="text-center" style="margin-bottom:15px;">
                                <?php echo $months_btns . $q_btns;?>
                                <button class="btn btn-sm btn-info y-btn" style="margin-right: 7px;color:white;">Y</button>
                                <?php echo $y_select;?>
                            </div>
                            <div class="text-center mb-3">
                                <label class="mr-3"><input type="radio" name="date_type_filter" id="pq-request-rb"
                                                           value="pq-request" checked/> PQ Request</label>
                                <label class="mr-3"><input type="radio" name="date_type_filter" id="booking-confirmed-rb"
                                                           value="booking-confirmed"/> Booking Confirmed</label>
                                <label class="mr-3" style="font-weight: normal;">
                                    From Date: <input type="text" id="from_date" name="from_date" class="form-control"
                                                      placeholder="YYYY-MM-DD" value=""
                                                      style="width: 130px;display: inline-block">
                                </label>
                                <label style="font-weight: normal;">
                                    To Date: <input type="text" id="to_date" name="to_date" class="form-control" placeholder="YYYY-MM-DD"
                                                    value="<?php echo date('Y-m-d');?>"
                                                    style="width: 130px;display: inline-block">
                                </label>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <div class="row">
                                        <label for="name" class="col-3">Name:</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="name" name="name"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <label for="email" class="col-3">Email:</label>
                                        <div class="col-9">
                                            <input type="email" class="form-control" id="email" name="email"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <label for="phone" class="col-3">Phone:</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="phone" name="phone"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <table>
                                        <tr>
                                            <td style="white-space: nowrap;padding: 3px;vertical-align: top;">Lead Status:
                                            </td>
                                            <td style="padding: 3px;vertical-align: top;">
                                                <a href="#" data-class="lead-status-filter-chbx" data-all="1"
                                                   class="all-btn badge badge-dark mr-3">ALL</a>
                                                <?php $__currentLoopData = \App\LeadStatus::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label class="mr-3">
                                                        <input type="checkbox" class="lead-status-filter-chbx" name="lead_statuses[]"
                                                               value="<?php echo e($el->id); ?>" checked=""> <?php echo e($el->name); ?>

                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <label class="mr-3">
                                                    <input type="checkbox" class="lead-status-filter-chbx" name="lead_statuses[]"
                                                           value="-1" checked=""> UNCLAIMED
                                                </label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <table>
                                        <tr>
                                            <td style="white-space: nowrap;padding: 3px;vertical-align: top;">SDR:</td>
                                            <td style="padding: 3px;vertical-align: top;">
                                                <a href="#" data-class="sdr-filter-chbx" data-all="1"
                                                   class="all-btn badge badge-dark mr-3">ALL</a>
                                                <?php $__currentLoopData = \App\Tmfsales::whereIn('Level',[6,9])->where('ID','!=',53)->where('Visible',1)->orderBy('Level','desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tmfsales_el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label class="<?php echo e($loop->index?'ml-3':''); ?>">
                                                        <input type="checkbox" class="sdr-filter-chbx" name="sdrs[]" value="<?php echo e($tmfsales_el->ID); ?>" checked="">
                                                        <?php echo e($tmfsales_el->FirstName); ?>

                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <table>
                                        <tr>
                                            <td style="white-space: nowrap;padding: 3px;vertical-align: top;">From:</td>
                                            <td style="padding: 3px;vertical-align: top;">
                                                <a href="#" data-class="from-filter-chbx" data-all="1"
                                                   class="all-btn badge badge-dark mr-3">ALL</a>
                                                <label class="mr-3">
                                                    <input type="checkbox" class="from-filter-chbx" name="came_from[]" value="FB Paul LaMarca Ad" checked="">
                                                    Paul LaMarca FB Ad
                                                </label>
                                                <label class="mr-3">
                                                    <input type="checkbox" class="from-filter-chbx" name="came_from[]" value="FB Paul LaMarca Ad 1" checked="">
                                                    Paul LaMarca FB Ad 1
                                                </label>
                                                <label class="mr-3">
                                                    <input type="checkbox" class="from-filter-chbx" name="came_from[]" value="FB Paul LaMarca Ad 2" checked="">
                                                    Paul LaMarca FB Ad 2
                                                </label>
                                                <label class="mr-3">
                                                    <input type="checkbox" class="from-filter-chbx" name="came_from[]" value="Instagram" checked="">
                                                    Instagram
                                                </label>
                                                <label class="mr-3">
                                                    <input type="checkbox" class="from-filter-chbx" name="came_from[]" value="Other" checked="">
                                                    Other
                                                </label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="mb-3 text-center">
                                <button class="btn btn-success" id="show-stat-btn">SHOW</button>
                            </div>
                        
                        <div class="text-center">
                            <div class="d-inline-block m-auto text-left" id="result-block"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modals'); ?>
    <?php echo $__env->make('pq-stats.details-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('pq-stats.client-data-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('external-jscss'); ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.12.0/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link href="https://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://trademarkfactory.com/js/moment-timezone-with-data.js"></script>

    <?php echo $__env->make('pq-stats.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/pq-stats/index.blade.php ENDPATH**/ ?>