<?php $__env->startSection('title'); ?>
    Bookings Calendar
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <ul class="dropdown-menu" id="context-menu">
    </ul>
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Bookings Calendar
                        
                        <a class="float-right export-leads-csv-link" href="#">Export Leads to CSV</a>
                        <a class="float-right mr-4" href="/bookings-search" target="_blank">Bookings Search</a>
                        <a class="float-right mr-4" href="/shopping-cart-finder" target="_blank">Shopping Cart Finder</a>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            
                            <div class="col-12 text-center">
                                <div class="filter-block booked-with d-inline-block">
                                    <div class="text-center mb-1 font-weight-bold">BOOKED WITH:</div>
                                    <div class="closers-from-filter-results text-left">
                                        <a href="#" data-class="closer-filter-chbx" data-all="1" class="all-btn badge badge-dark mr-1">ALL</a>
                                        <?php $__currentLoopData = $tmfsales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tmfsales_el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(\Illuminate\Support\Facades\Auth::user()->sales_calls): ?>
                                                <label class="mr-1 <?php echo e($tmfsales_el->Visible==0?'inactive-closer':''); ?>" title="<?php echo e($tmfsales_el->FirstName); ?> <?php echo e($tmfsales_el->LastName); ?>"><input type="checkbox" data-user="<?php echo e($tmfsales_el->LongID); ?>" class="closer-filter-chbx" value="<?php echo e($tmfsales_el->ID); ?>" <?php echo e(\Illuminate\Support\Facades\Auth::user()->ID==$tmfsales_el->ID?'checked':''); ?>> <?php echo e($tmfsales_el->LongID); ?></label>
                                            <?php else: ?>
                                                <label class="mr-1 <?php echo e($tmfsales_el->Visible==0?'inactive-closer':''); ?>" title="<?php echo e($tmfsales_el->FirstName); ?> <?php echo e($tmfsales_el->LastName); ?>"><input type="checkbox" data-user="<?php echo e($tmfsales_el->LongID); ?>" class="closer-filter-chbx" value="<?php echo e($tmfsales_el->ID); ?>" checked> <?php echo e($tmfsales_el->LongID); ?></label>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <label class="mr-1"><input type="checkbox" class="inactive-closers-filter-chbx" value="1" checked> Inactive Closers</label>
                                    </div>
                                </div>
                                <div class="filter-block closer-calls-fblock d-inline-block">
                                    <label class="d-block text-center mb-1 font-weight-bold"><input style="display: inline-block;" type="checkbox" class="booking-type-filter" value="cc" checked/> CLOSER CALLS:</label>
                                    <div class="mb-2 call-types-filter-results text-left">
                                        <div style="display: table-row">
                                            <div style="display: table-cell">
                                                <a href="#" data-class="closing-call-type" data-all="1" class="all-btn badge badge-dark mr-1">ALL</a>
                                            </div>
                                            <div style="display: table-cell">
                                                <label class="mr-1">
                                                    <input type="checkbox" class="closing-call-type" value="future-call" checked> <span class="badge" style="background: <?php echo e(\App\classes\postboombookings\BookingItemBorderColor::futureCall()); ?>">Future Calls</span>
                                                </label>
                                                <label class="mr-1">
                                                    <input type="checkbox" class="closing-call-type" value="no-reason-entered" checked> <span class="badge" style="background: <?php echo e(\App\classes\postboombookings\BookingItemBorderColor::noReasonEntered()); ?>">No Reason Entered</span>
                                                </label>
                                                <label class="mr-1">
                                                    <input type="checkbox" class="closing-call-type" value="no-show" checked> <span class="badge" style="background: <?php echo e(\App\classes\postboombookings\BookingItemBorderColor::noShow()); ?>">No Show</span>
                                                </label>
                                                <label class="mr-1">
                                                    <input type="checkbox" class="closing-call-type" value="follow-up-scheduled" checked> <span class="badge" style="background: <?php echo e(\App\classes\postboombookings\BookingItemBorderColor::followUpScheduled()); ?>">Follow-Up Scheduled</span>
                                                </label>
                                                <label class="mr-1">
                                                    <input type="checkbox" class="closing-call-type" value="other-no-boom-reasons" checked> <span class="badge" style="background: <?php echo e(\App\classes\postboombookings\BookingItemBorderColor::otherReason()); ?>">Other No-Boom Reasons</span>
                                                </label>
                                                <label>
                                                    <input type="checkbox" class="closing-call-type" value="boom" checked> <span class="badge" style="background: <?php echo e(\App\classes\postboombookings\BookingItemBorderColor::boom()); ?>">BOOM</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2 closeable-filter-results text-left">
                                        <div class="d-inline-block f-label"><strong class="mr-1">Closable:</strong></div>
                                        <a href="#" data-class="closeable-filter-chbx" data-all="1" class="all-btn badge badge-dark mr-1">ALL</a>
                                        <label class="mr-1">
                                            <input type="checkbox" class="closeable-filter-chbx" value="1" checked> YES
                                        </label>
                                        <label class="mr-1">
                                            <input type="checkbox" class="closeable-filter-chbx" value="0" checked> MAYBE
                                        </label>
                                        <label>
                                            <input type="checkbox" class="closeable-filter-chbx" value="-1" checked> NO
                                        </label>
                                    </div>
                                    <div class="mb-2 bookings-from-filter-results text-left">
                                        <div class="d-inline-block f-label"><strong class="mr-1">Bookings from:</strong></div>
                                        <label><a href="#" data-class="cc-from-filter-chbx" data-all="1" class="all-btn badge badge-dark mr-1">ALL</a></label>
                                        <label class="mr-1">
                                            <input type="checkbox" class="cc-from-filter-chbx" value="ga" checked> GA
                                        </label>
                                        <label class="mr-1">
                                            <input type="checkbox" class="cc-from-filter-chbx" value="yt" checked> YouTube
                                        </label>
                                        <label class="mr-1">
                                            <input type="checkbox" class="cc-from-filter-chbx" value="fb" checked> FB Ads
                                        </label>
                                        <label>
                                            <input type="checkbox" class="cc-from-filter-chbx" value="other" checked> Other
                                        </label>
                                    </div>
                                    <div class="mb-0 bookings-from-filter-results text-left">
                                        <div class="d-inline-block f-label"><strong class="mr-1">Bookings:</strong></div>
                                        <label><a href="#" data-class="funnel-filter-chbx" data-all="1" class="all-btn badge badge-dark mr-1">ALL</a></label>
                                        <label class="mr-1"><input type="checkbox" class="funnel-filter-chbx" value="direct" checked> DIRECT</label>
                                        <label><input type="checkbox" class="funnel-filter-chbx" value="pq" checked> PQ</label>
                                    </div>
                                </div>
                                <div class="d-inline-block text-left">
                                    <div class="filter-block mb-3 gc-calls-fblock">
                                        <label class="text-left font-weight-bold mb-0"><input style="display: inline-block;" type="checkbox" class="booking-type-filter" value="gc" checked/> SAVING CALLS</label>
                                    </div>
                                    <div class="filter-block mb-3 oe-calls-fblock">
                                        <label class="text-left font-weight-bold mb-0"><input style="display: inline-block;" type="checkbox" class="booking-type-filter" value="oec" checked/> OE CALLS</label>
                                    </div>
                                    <div class="filter-block sou-calls-fblock">
                                        <label class="text-left font-weight-bold mb-0"><input style="display: inline-block;" type="checkbox" class="booking-type-filter" value="souc" checked/> SOU CALLS</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="booking-calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modals'); ?>
    <?php echo $__env->make('payments-calendar.select-month-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('post-boom-bookings-calendar.change-closer-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('post-boom-bookings-calendar.notes-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('post-boom-bookings-calendar.upload-call-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('post-boom-bookings-calendar.email-to-client-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('post-boom-bookings-calendar.booking-info-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    

    <?php echo $__env->make('post-boom-bookings-calendar.report-call-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('post-boom-bookings-calendar.export-to-csv-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('booking-applications.client-file-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div style="position: fixed; top: 15px; right: 15px;z-index:-1000;">
        <!-- Then put toasts within -->
        <div class="toast legend-popup" role="alert" aria-live="assertive" data-autohide="false" aria-atomic="true" style="max-width: 650px;">
            <div class="toast-header">
                <img src="/img/magentatmf.png" style="width: 16px;height: 16px;" class="rounded mr-2">
                <strong class="mr-auto">Legend</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                <div class="mb-3">
                    <span class="text-bold">Borders</span>: <span class="mr-2 p-1" style="border-radius:3px;border: 3px solid <?php echo e(\App\classes\postboombookings\BookingItemBorderColor::noShow()); ?>">No Show</span>
                    <span class="mr-2 p-1" style="border-radius:3px;border: 3px solid <?php echo e(\App\classes\postboombookings\BookingItemBorderColor::followUpScheduled()); ?>">Follow-up scheduled</span>
                    <span class="mr-2 p-1" style="border-radius:3px;border: 3px solid <?php echo e(\App\classes\postboombookings\BookingItemBorderColor::otherReason()); ?>">Other No-BOOM Reason</span>
                    <span class="p-1" style="border-radius:3px;border: 3px solid <?php echo e(\App\classes\postboombookings\BookingItemBorderColor::boom()); ?>">BOOM</span>
                </div>
            </div>
        </div>
        <div class="toast sys-message" role="alert" aria-live="polite" aria-atomic="true" data-delay="3000" data-animation="true" style="width: 350px;">
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('external-jscss'); ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.12.0/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <link href="https://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.0.0/main.css"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://trademarkfactory.com/js/moment-timezone-with-data.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.0.0/main.min.js"></script>
    <script src="https://trademarkfactory.com/js/clipboard-polyfill.promise.js"></script>
    <link rel="stylesheet" href="<?php echo e(asset('plugins/summernote/summernote-bs4.css')); ?>">
    <script src="<?php echo e(asset('plugins/summernote/summernote-bs4.min.js')); ?>"></script>


    

    <?php echo $__env->make('post-boom-bookings-calendar.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('post-boom-bookings-calendar.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/post-boom-bookings-calendar/index.blade.php ENDPATH**/ ?>