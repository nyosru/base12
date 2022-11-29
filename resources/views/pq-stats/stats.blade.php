@foreach($data as $stat_caption=>$stat_details)
    @php
    $suffix='';
    switch ($stat_caption){
        case 'Total Bookings':
            if($data['Successful calls']['count'])
                $suffix=sprintf(' (%s%%)',round(100*$data[$stat_caption]['count']/$data['Successful calls']['count'],2));
            else
                $suffix='N/A';
        break;
        case 'BOOMS':
        $suffix=sprintf(' (%d TMs)',$data[$stat_caption]['tms-count']);
        break;
    }
    @endphp
    {{$stat_caption}}: {{$stat_details['count']}}{{$suffix}} (<a href="#" class="stat-details" data-action="{{$stat_caption}}" data-ids="{{json_encode($stat_details['ids'])}}">details</a>)<br/>
@endforeach
BOOM Rate: {{($data['Total Bookings']['count']-$data['Future Bookings']['count'])?round(100*$data['BOOMS']['count']/($data['Total Bookings']['count']-$data['Future Bookings']['count']),2):'N/A'}}%<br/>
BOOM Rate Minus No-Shows: {{($data['Total Bookings']['count']-$data['Future Bookings']['count']-$data['No-Shows']['count'])?round(100*$data['BOOMS']['count']/($data['Total Bookings']['count']-$data['Future Bookings']['count']-$data['No-Shows']['count']),2):'N/A'}}%