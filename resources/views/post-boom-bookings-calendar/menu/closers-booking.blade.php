<div>
    <div class="d-inline-block float-left">
        @if($booking->sales_confirmed_at=='0000-00-00 00:00:00' && $booking->sales_id==\Illuminate\Support\Facades\Auth::user()->ID)
            <li><a class="dropdown-item confirm-booking-link text-danger" href="#" data-tmoffer-id="{{$tmoffer->ID}}"><i class="fas fa-check-square"></i> Confirm booking call</a></li>
        @endif
        <li><a class="dropdown-item booking-info" href="#" data-booking-id="{{$booking->id}}"><i class="fas fa-info-circle"></i> Booking Info</a></li>
        <li><a class="dropdown-item view-emails" href="#" data-tmoffer-id="{{$tmoffer->ID}}"><i class="fas fa-envelope-open-text"></i> View Emails</a></li>
        <li><a class="dropdown-item" href="https://trademarkfactory.com/shopping-cart/{{$tmoffer->Login}}&donttrack=1" target="_blank"><i class="fas fa-shopping-cart"></i> Shopping cart</a></li>
        @if(\App\TmofferTmfCountryTrademark::where('tmoffer_id',$tmoffer->ID)->count())
            <li><a class="dropdown-item" href="https://trademarkfactory.com/mlcclients/tmfentry/{{$tmoffer->Login}}?show=trademarks" target="_blank"><i class="far fa-list-alt"></i> TMF Entry</a></li>
            <li><a class="dropdown-item" href="https://trademarkfactory.com/searchreport/{{$tmoffer->Login}}&donttrack=donttrack" target="_blank"><i class="fas fa-search"></i> Search Report</a></li>
        @else
            <li><a class="dropdown-item change-closer-link" href="#" data-tmoffer-id="{{$tmoffer->ID}}" data-closer-id="{{$booking->sales_id}}" data-booking-id="{{$booking->id}}"><i class="fas fa-user"></i> Change Closer</a></li>
        @endif
        <li><a class="dropdown-item report-call-link" href="#" data-action="{{$tmoffer->DateConfirmed=='0000-00-00'?'noboom':'boom'}}" data-id="{{$tmoffer->ID}}"><i class="fas fa-file"></i> Call Report</a></li>
    </div>
    <div class="d-inline-block float-left">
        @if(\App\TmofferTmfCountryTrademark::where('tmoffer_id',$tmoffer->ID)->count())
            <li><a class="dropdown-item change-closer-link" href="#" data-tmoffer-id="{{$tmoffer->ID}}" data-closer-id="{{$booking->sales_id}}" data-booking-id="{{$booking->id}}"><i class="fas fa-user"></i> Change Closer</a></li>
        @endif
        <li><a class="dropdown-item manual-rebooking-link" href="https://trademarkfactory.com/mlcclients/manual-rebooking.php?id={{$tmoffer->ID}}" target="_blank"><i class="fas fa-calendar-day"></i> Reshedule</a></li>
        <li><a href="#" class="dropdown-item remove-booking-link" data-booking-id="{{$booking->id}}"><i class="fas fa-times"></i> Remove Booking</a></li>
        <li><a href="#" class="dropdown-item edit-notes-link" data-tmoffer-id="{{$tmoffer->ID}}"><i class="fas fa-sticky-note"></i> Notes</a></li>
        @if(\App\TmofferRecordings::where('tmoffer_id',$tmoffer->ID)->count())
            <li><a href="/closers-recordings-uploader/{{$tmoffer->ID}}" class="dropdown-item" target="_blank"><i class="fas fa-headphones"></i> Show Recordings</a></li>
        @else
            <li><a href="#" class="dropdown-item upload-recordings-link" data-tmoffer-id="{{$tmoffer->ID}}"><i class="fas fa-upload"></i> Upload Recording</a></li>
        @endif
        @if($tmoffer->prequalify_request_id)
            <li><a href="#" class="dropdown-item load-pq-answers" data-tmoffer-id="{{$tmoffer->ID}}"><i class="far fa-list-alt"></i> PQ Answers</a></li>
        @endif
    </div>
</div>