<div style="max-height: 450px;overflow-x: hidden;overflow-y: auto">
    <ul class="list-group list-group-flush">
        @foreach($data as $el)
            <li class="list-group-item">{{$el['booking_datetime']}} {{$el['company_info']['firstname']}} {{$el['company_info']['lastname']}}   <a href="https://trademarkfactory.com/shopping-cart/{{$el['tmoffer_login']}}&donttrack=1" class="float-end"><i class="fas fa-shopping-cart"></i></a></li>
        @endforeach
    </ul>
</div>