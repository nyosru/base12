@if($tmoffer && \App\TmofferTmfCountryTrademark::where('tmoffer_id',$tmoffer->ID)->count())
    <li><a class="dropdown-item" href="https://trademarkfactory.com/mlcclients/tmfentry/{{$tmoffer->Login}}?show=trademarks" target="_blank"><i class="far fa-list-alt"></i> TMF Entry</a></li>
    <li><a class="dropdown-item" href="https://trademarkfactory.com/searchreport/{{$tmoffer->Login}}&donttrack=donttrack" target="_blank"><i class="fas fa-search"></i> Search Report</a></li>
@endif
<li><a href="#" class="dropdown-item cancel-gc-booking-link" data-booking-id="{{$booking->id}}"><i class="fas fa-times"></i> Cancel Booking</a></li>
@if($booking->zoom_url || $booking->zoom_id)
    <li><a href="#" class="dropdown-item resend-gc-zoom-link" data-booking-class="gm" data-booking-id="{{$booking->id}}"><i class="fas fa-envelope"></i> Resend Zoom Link</a></li>
@endif
@if($tmoffer)
<li><a href="#" class="dropdown-item edit-notes-link" data-tmoffer-id="{{$tmoffer->ID}}"><i class="fas fa-sticky-note"></i> Notes</a></li>
@endif
