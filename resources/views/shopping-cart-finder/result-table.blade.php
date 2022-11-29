<table class="table table-bordered" id="main-table">
    <thead>
        <tr>
            <th>Client</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Creation Date</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        @if(count($sc_data))
            @foreach ($sc_data as $el)
                <tr>
                    <td class="text-left text-nowrap">{{$el['client']}}</td>
                    <td class="text-left text-nowrap"><a href="tel:{{$el['phone']}}">{{$el['phone']}}</a></td>
                    <td class="text-left text-nowrap"><a href="mailto:{{$el['email']}}">{{$el['email']}}</a></td>
                    <td class="text-left text-nowrap">{{$el['created_at']->format('M j, Y \@ g:ia')}}</td>
                    <td class="text-center text-nowrap"><a href="https://trademarkfactory.com/shopping-cart/{{$el['tmoffer_login']}}&donttrack=1" target="_blank">Shopping Cart</a></td>
                </tr>
            @endforeach
        @else
            <tr><td colspan="4" class="text-center">EMPTY</td></tr>
        @endif
    </tbody>
</table>