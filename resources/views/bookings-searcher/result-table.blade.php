<table class="table table-bordered" id="main-table">
    <thead>
        <tr>
            <th class="text-center">Date and Time, PST</th>
            <th>Client</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Closer</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        @if(count($bookings_data))
            @foreach ($bookings_data as $el)
                <tr>
                    <td class="text-center text-nowrap">{{$el['booking_datetime']}}</td>
                    <td class="text-left text-nowrap">{{$el['client']}}</td>
                    <td class="text-left text-nowrap"><a href="tel:{{$el['phone']}}">{{$el['phone']}}</a></td>
                    <td class="text-left text-nowrap"><a href="mailto:{{$el['email']}}">{{$el['email']}}</a></td>
                    <td class="text-left text-nowrap">{{$el['closer']}}</td>
                    <td class="text-center text-nowrap"><a href="https://trademarkfactory.com/shopping-cart/{{$el['tmoffer_login']}}&donttrack=1" target="_blank">Shopping Cart</a>{!!(strlen($el['personal_flowchart_link'])?'<br/>'.sprintf('<a href="%s" target="_blank">Flowchart</a>',$el['personal_flowchart_link']):'')!!}</td>
                </tr>
            @endforeach
        @else
            <tr><td colspan="4" class="text-center">EMPTY</td></tr>
        @endif
    </tbody>
</table>