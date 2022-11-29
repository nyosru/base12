<div style="max-height: 450px;overflow-x: hidden;overflow-y: auto">
    <ul class="list-group list-group-flush">
        @foreach($data as $el)
            <li class="list-group-item">{{$el['date']}} {{$el['company_info']['firstname']}} {{$el['company_info']['lastname']}}  - {{$el['selected_currency']}} ${{number_format($el['amount'],2)}} <a href="https://trademarkfactory.com/mlcclients/acceptedagreements.php?login={{$el['tmoffer_login']}}&amp;sbname=&amp;sbphone=&amp;sbtm=&amp;sbemail=&amp;sbnote=&amp;date_from=&amp;date_to=&amp;affiliate_camefrom=&amp;sort_by=new_logins_first&amp;show=ALL&amp;sbmt_btn=SEARCH&amp;page=1" class="float-end">view</a></li>
        @endforeach
    </ul>
</div>