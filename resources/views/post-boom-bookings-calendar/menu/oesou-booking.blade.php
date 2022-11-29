@if(strlen($booking->getPageLink()))
    <li><a class="dropdown-item" href="{{$booking->getPageLink()}}" target="_blank"><i class="far fa-file"></i> {{strtoupper($booking->getBookingType())}} page</a></li>
@endif
<li><a class="dropdown-item" href="https://trademarkfactory.com/mlcclients/tmfentry/{{$tmoffer->Login}}?show=trademarks" target="_blank"><i class="far fa-list-alt"></i> TMF Entry</a></li>
<li><a class="dropdown-item" href="https://trademarkfactory.com/searchreport/{{$tmoffer->Login}}&donttrack=donttrack" target="_blank"><i class="fas fa-search"></i> Search Report</a></li>
<li><a href="#" class="dropdown-item cancel-booking-link" data-booking-type="{{$booking->getBookingType()}}" data-booking-id="{{$booking->getBookingObj()->id}}" data-classname="{{get_class($booking->getBookingObj())}}"><i class="fas fa-times"></i> Cancel Booking</a></li>
<li><a href="#" class="dropdown-item resend-oesou-zoom-link" data-booking-id="{{$booking->getBookingObj()->id}}" data-classname="{{get_class($booking->getBookingObj())}}"><i class="fas fa-envelope"></i> Resend Zoom Link</a></li>
<li><a href="#" class="dropdown-item edit-notes-link" data-tmoffer-id="{{$tmoffer->ID}}"><i class="fas fa-sticky-note"></i> Notes</a></li>
