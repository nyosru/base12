<?php $__env->startSection('title'); ?>
    TMF Revenue Breakdown
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">TMF Revenue Breakdown</div>

                    <div class="card-body">
                        <div style="margin:auto;width:70%;">
                            <div class="text-center" style="margin-bottom:15px">
                                <?php echo $months_btns; ?><?php echo $q_btns; ?>

                                <button class="btn btn-sm btn-info y-btn" style="margin-right: 7px;color:white;">Y
                                </button>
                                <?php echo $y_select; ?>

                            </div>
                            <div class="row" style="margin:auto;margin-bottom: 15px">
                                <label style="font-weight: normal;" class="control-label col-md-6 text-right">
                                    From Date: <input type="text" id="from_date" class="form-control"
                                                      placeholder="YYYY-MM-DD" value="<?php echo e($first_date); ?>"
                                                      style="width: 130px;display: inline-block">
                                </label>
                                <label style="font-weight: normal;" class="control-label col-md-6">
                                    To Date: <input type="text" id="to_date" class="form-control"
                                                    placeholder="YYYY-MM-DD" value="<?php echo e($last_date); ?>"
                                                    style="width: 130px;display: inline-block">
                                </label>
                            </div>
                            <div class="text-center mb-5">
                                <button class="btn btn-success" id="show-data">SHOW</button>
                            </div>
                        </div>
                        <div id="result-block">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="rr-tab" data-toggle="tab" href="#rr" role="tab"
                                       aria-controls="rr" aria-selected="true">Raw Revenues</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pt-tab" data-toggle="tab" href="#pt" role="tab"
                                       aria-controls="pt" aria-selected="false">Pay Type</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="ct-tab" data-toggle="tab" href="#ct" role="tab"
                                       aria-controls="ct" aria-selected="false">Client Type</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="cs-tab" data-toggle="tab" href="#cs" role="tab"
                                       aria-controls="cs" aria-selected="false">First Sale Source</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="bs-tab" data-toggle="tab" href="#bs" role="tab"
                                       aria-controls="bs" aria-selected="false">Boom Source</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade " id="rr" role="tabpanel" aria-labelledby="rr-tab">
                                    <div class="row p-3">
                                        <div class="col-12">
                                            <div id="rr-content"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pt" role="tabpanel" aria-labelledby="pt-tab">
                                    <div class="row p-3">
                                        <div class="col-12">
                                            <?php if($view_suffix!='-public'): ?>
                                            <div class="text-center mb-3 switch-to-block" id="pt-switch-to-block">
                                                Calculating % from $. <a href="#" class="switch-to" data-to="num" data-selector="#pt-content">Switch to #</a>
                                            </div>
                                            <?php endif; ?>
                                            <div id="pt-content"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="ct" role="tabpanel" aria-labelledby="ct-tab">
                                    <div class="row p-3">
                                        <div class="col-12">
                                            <?php if($view_suffix!='-public'): ?>
                                                <div class="text-center mb-3 switch-to-block" id="ct-switch-to-block">
                                                    Calculating % from $. <a href="#" class="switch-to" data-to="num" data-selector="#ct-content">Switch to #</a>
                                                </div>
                                            <?php endif; ?>
                                            <div id="ct-content"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade show active" id="cs" role="tabpanel" aria-labelledby="cs-tab">
                                    <div class="row p-3">
                                        <div class="col-12">
                                            <?php if($view_suffix!='-public'): ?>
                                                <div class="text-center mb-3 cs-switch-to-block">
                                                    Calculating % from $. <a href="#" class="cs-switch-to" data-to="num">Switch to #</a>
                                                </div>
                                            <?php endif; ?>
                                            <div class="d-table m-auto pb-3">
                                                <div class="d-table-cell pr-3">
                                                    <label><input type="checkbox" class="nr-chbx nums-filter" value="num-n1" checked/> 1st Payments from New Clients</label><br/>
                                                    <label><input type="checkbox" class="nr-chbx nums-filter" value="num-n2" checked/> 2nd+ Payments from New Clients</label><br/>
                                                    <label><input type="checkbox" class="nums-filter" value="consultation" checked/> Consultation</label>
                                                </div>
                                                <div class="d-table-cell">
                                                    <label><input type="checkbox" class="nr-chbx nums-filter" value="num-r1" checked/> 1st Payments from Repeat Clients</label><br/>
                                                    <label><input type="checkbox" class="nr-chbx nums-filter" value="num-r2" checked/> 2nd+ Payments from Repeat Clients</label><br/>
                                                    <label><input type="checkbox" class="nums-filter" value="other-payments" checked/> Other payments</label>
                                                </div>
                                            </div>
                                            <div id="cs-content"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="bs" role="tabpanel" aria-labelledby="bs-tab">
                                    <div class="row p-3">
                                        <div class="col-12">
                                            <?php if($view_suffix!='-public'): ?>
                                                <div class="text-center mb-3 switch-to-block" id="bs-switch-to-block">
                                                    Calculating % from $. <a href="#" class="switch-to" data-to="num" data-selector="#bs-content">Switch to #</a>
                                                </div>
                                            <?php endif; ?>
                                            <div id="bs-content"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <script type="text/javascript" src="https://trademarkfactory.com/selectize/js/standalone/selectize.js"></script>
    <link rel="stylesheet" type="text/css" href="https://trademarkfactory.com/selectize/css/selectize.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <?php echo $__env->make('tmf-revenue-breakdown.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('tmf-revenue-breakdown.js-common', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modals'); ?>
    <?php echo $filter_modals; ?>

    <?php if($view_suffix!='-public'): ?>
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
        <div class="modal" id="edit-rr-types-modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Types</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-md-3">Date:</div>
                            <div class="col-md-9" id="date-caption"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">Amount:</div>
                            <div class="col-md-9" id="amount-caption"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">Client:</div>
                            <div class="col-md-9" id="client-caption"></div>
                        </div>
                        <div class="row mb-2">
                            <label for="client-type-select" class="col-md-3">Client Type:</label>
                            <div class="col-md-9">
                                <select id="client-type-select" class="form-control">
                                    <?php $__currentLoopData = $client_type_objs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client_type_obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($client_type_obj->id); ?>"><?php echo e($client_type_obj->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="pay-type-select" class="col-md-3">Pay Type:</label>
                            <div class="col-md-9">
                                <select id="pay-type-select" class="form-control">
                                    <?php $__currentLoopData = $pay_type_objs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay_type_obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($pay_type_obj->id); ?>"><?php echo e($pay_type_obj->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="client-source-select" class="col-md-3">Client Source:</label>
                            <div class="col-md-9">
                                <select id="client-source-select" class="form-control">
                                    <?php $__currentLoopData = $client_source_objs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client_source_obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($client_source_obj->id); ?>"><?php echo e($client_source_obj->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="boom-source-select" class="col-md-3">Boom Source:</label>
                            <div class="col-md-9">
                                <select id="boom-source-select" class="form-control">
                                    <?php $__currentLoopData = $boom_source_objs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $boom_source_obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($boom_source_obj->id); ?>"><?php echo e($boom_source_obj->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-block text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="ert-save-btn" data-dismiss="modal">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/tmf-revenue-breakdown/index.blade.php ENDPATH**/ ?>