Total Closer Bookings: {{$data['Total Closer Bookings']['total']}} (incl.
<img src="https://trademarkfactory.imgix.net/img/booking-calendar-adwords-14-7.png"/>={{$data['Total Closer Bookings']['ga']}} [{{($data['Total Closer Bookings']['total']?round(100*$data['Total Closer Bookings']['ga']/$data['Total Closer Bookings']['total'],2).'%':'N/A')}}]
<img src="https://trademarkfactory.imgix.net/img/booking-calendar-fb-14-7.png"/>={{$data['Total Closer Bookings']['fb']}} [{{($data['Total Closer Bookings']['total']?round(100*$data['Total Closer Bookings']['fb']/$data['Total Closer Bookings']['total'],2).'%':'N/A')}}]
<img src="https://trademarkfactory.imgix.net/img/booking-calendar-youtube-14-7.png"/>={{$data['Total Closer Bookings']['yt']}} [{{($data['Total Closer Bookings']['total']?round(100*$data['Total Closer Bookings']['yt']/$data['Total Closer Bookings']['total'],2).'%':'N/A')}}])<br/>
@foreach($data as $key=>$details_data)
    @if($loop->index)
        &mdash;{{$key}}: {{$details_data['total']}} [{{($data['Total Closer Bookings']['total']?round(100*$details_data['total']/$data['Total Closer Bookings']['total'],2).'%':'N/A')}}] (incl.
        <img src="https://trademarkfactory.imgix.net/img/booking-calendar-adwords-14-7.png"/>={{$details_data['ga']}} [{{($data['Total Closer Bookings']['ga']?round(100*$details_data['ga']/$data['Total Closer Bookings']['ga'],2).'%':'N/A')}}]
        <img src="https://trademarkfactory.imgix.net/img/booking-calendar-fb-14-7.png"/>={{$details_data['fb']}} [{{($data['Total Closer Bookings']['fb']?round(100*$details_data['fb']/$data['Total Closer Bookings']['fb'],2).'%':'N/A')}}]
        <img src="https://trademarkfactory.imgix.net/img/booking-calendar-youtube-14-7.png"/>={{$details_data['yt']}} [{{($data['Total Closer Bookings']['yt']?round(100*$details_data['yt']/$data['Total Closer Bookings']['yt'],2).'%':'N/A')}}])
        @if(!$loop->last)<br/>@endif
    @endif
@endforeach