<table class="table table-bordered">
    <thead>
        <tr>
            <th>Client, phone</th>
            <th>Closer</th>
            <th>SDR</th>
            <th>SDR called at</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $el)
            <tr class="calls-history-row" data-sdr-id="{{$el['tmf-booking']->sdr_id}}">
                <td class="text-left"><div class="client-name">{{$el['fn']}} {{$el['ln']}}</div>Phone: {{$el['phone']}}</td>
                <td class="text-left">{{$el['closer']->FirstName}} {{$el['closer']->LastName}}</td>
                <td class="text-left">{{$el['tmf-booking']->sdr->FirstName}} {{$el['tmf-booking']->sdr->LastName}}</td>
                <td class="text-left">{{\DateTime::createFromFormat('Y-m-d H:i:s',$el['tmf-booking']->sdr_finished_at)->format('F j, Y \@ g:iA')}}</td>
            </tr>
        @endforeach
    </tbody>
</table>