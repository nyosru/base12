<?php $__env->startSection('title'); ?>
    PQ Finder
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        PQ Finder
                    </div>
                    <div class="card-body">
                        
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
                            <div class="mb-3 text-center">
                                <button class="btn btn-success" id="show-stat-btn">SHOW</button>
                            </div>
                        <div class="text-center">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item pt-1 pb-1">
                                    <div class="d-table">
                                        <div class="d-table-row">
                                            <div class="d-table-cell align-middle p-1 pr-2 border-right" style="line-height: 1;width: 80px;">Request date</div>
                                            <div class="d-table-cell align-middle p-1 border-right" style="width: 250px;">
                                                Prospect
                                            </div>
                                            <div class="d-table-cell align-middle p-1 border-right" style="width: 150px;">
                                                SDR
                                            </div>
                                            <div class="d-table-cell align-middle p-1 border-right" style="width: 450px;">
                                                Current Status
                                            </div>
                                            <div class="d-table-cell align-middle p-1" style="width: 50px;">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div style="max-height: 450px;overflow-x: hidden;overflow-y: auto">
                                <ul class="list-group list-group-flush" id="result-block"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modals'); ?>
    <?php echo $__env->make('pq-finder.details-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('external-jscss'); ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.12.0/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link href="https://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://trademarkfactory.com/js/moment-timezone-with-data.js"></script>

    <?php echo $__env->make('pq-finder.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/pq-finder/index.blade.php ENDPATH**/ ?>