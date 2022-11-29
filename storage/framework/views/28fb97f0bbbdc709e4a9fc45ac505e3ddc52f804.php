<?php if(strlen($booking->getPageLink())): ?>
    <li><a class="dropdown-item" href="<?php echo e($booking->getPageLink()); ?>" target="_blank"><i class="far fa-file"></i> <?php echo e(strtoupper($booking->getBookingType())); ?> page</a></li>
<?php endif; ?>
<li><a class="dropdown-item" href="https://trademarkfactory.com/mlcclients/tmfentry/<?php echo e($tmoffer->Login); ?>?show=trademarks" target="_blank"><i class="far fa-list-alt"></i> TMF Entry</a></li>
<li><a class="dropdown-item" href="https://trademarkfactory.com/searchreport/<?php echo e($tmoffer->Login); ?>&donttrack=donttrack" target="_blank"><i class="fas fa-search"></i> Search Report</a></li>
<li><a href="#" class="dropdown-item cancel-booking-link" data-booking-type="<?php echo e($booking->getBookingType()); ?>" data-booking-id="<?php echo e($booking->getBookingObj()->id); ?>" data-classname="<?php echo e(get_class($booking->getBookingObj())); ?>"><i class="fas fa-times"></i> Cancel Booking</a></li>
<li><a href="#" class="dropdown-item resend-oesou-zoom-link" data-booking-id="<?php echo e($booking->getBookingObj()->id); ?>" data-classname="<?php echo e(get_class($booking->getBookingObj())); ?>"><i class="fas fa-envelope"></i> Resend Zoom Link</a></li>
<li><a href="#" class="dropdown-item edit-notes-link" data-tmoffer-id="<?php echo e($tmoffer->ID); ?>"><i class="fas fa-sticky-note"></i> Notes</a></li>
<?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/post-boom-bookings-calendar/menu/oesou-booking.blade.php ENDPATH**/ ?>