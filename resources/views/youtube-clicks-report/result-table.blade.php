<table class="table table-bordered" id="main-table">
    <thead>
        <tr>
            <th>Video</th>
            <th>Clicks in Period</th>
            <th>Clicks Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $el)
            <tr>
                <td class="text-left"><a href="https://youtu.be/{{$el['video-id']}}" target="_blank">{!! $el['title'] !!}</a></td>
                <td>{{$el['clicks-in-period']}}</td>
                <td>{{$el['total-clicks']}}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-left">TOTAL:</th>
            <th>{{$total_in_period}}</th>
            <th>{{$total_clicks}}</th>
        </tr>
    </tfoot>
</table>