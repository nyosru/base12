<p>It looks like we may have a problem with one or more invoice emails scheduled for {{$scheduled_date->format('F j, Y')}}.</p>
@foreach($tmoffers_data as $tmoffer_data)
    <p style="margin-bottom: 10px;">
        <a href="https://trademarkfactory.com/mlcclients/acceptedagreements.php?login={{$tmoffer_data['tmoffer']->Login}}&sbname=&sbphone=&sbtm=&sbemail=&sbnote=&date_from=&date_to=&affiliate_camefrom=&sort_by=new_logins_first&show=ALL&sbmt_btn=SEARCH&page=1" target="_blank">#{{$tmoffer_data['tmoffer']->Login}}'s</a>
        payment of {{$tmoffer_data['invoices_data']['current-invoice-index']+1}} of {{$tmoffer_data['invoices_data']['invoices']}} is
        on {{$payment_date->format('F j, Y')}}. However, according to our system, payment {{$tmoffer_data['invoices_data']['current-invoice-index']}} is still outstanding.
    </p>
@endforeach
<p>Please edit or block the scheduled emails to make sure we have addressed this properly.</p>
<p>If in doubt, discuss with Andrei.</p>


