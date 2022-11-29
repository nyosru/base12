<div style='float:right; clear:right; font-family: serif; font-size:10pt;'>
    <b>Trademark Factory International Inc.</b><br/>
    300 - 1055 W. Hastings St.<br/>
    Vancouver, BC, V6E 2E9 Canada<br/><br/>
    <table style='border:0;'>
        <tr style='text-align: left'>
            <td>Vancouver:</td>
            <td style='padding-left:5px;'>778.869.7281</td>
        </tr>
        <tr style='text-align: left'>
            <td>Toronto:</td>
            <td style='padding-left:5px;'>416.305.4142</td>
        </tr>
        <tr style='text-align: left'>
            <td>Toll-Free:</td>
            <td style='padding-left:5px;'>855.MR.TMARK</td>
        </tr>
        <tr style='text-align: left'>
            <td>Fax:</td>
            <td style='padding-left:5px;'>888.767.7078</td>
        </tr>
    </table>
    <br/>
    tm@trademarkfactory.com<br/>
    <span style='font-style: italic'><strong>TrademarkFactory.com</strong></span>
</div>
<img src='https://trademarkfactory.imgix.net/img/TMF_Logo.png'><br/><br/><br/><br/>
<span style='font-size:32pt; font-family:pt sans, arial; font-style:italic; font-weight:bold;'>INVOICE</span><br/>
<span style='font-family: pt sans, arial; font-size:10pt;'>
	{{$invdate1}}<br/>
	Invoice # TMF{{$invnum}}
</span>

<div style='clear:both;'></div><br/><br/>

<table style='width:100%;'>
    <tr>
        <td style='width:50%; vertical-align:top;'><b>Bill To:</b>
            <p class='TOC'>{{$company_info['company']}}<br/>
                {{$company_info['company_address']}}<br/>
                {{$company_info['company_city']}}, {{$company_info['company_state']}}, {{$company_info['company_country']}}<br/>
                {{$company_info['company_zipcode']}}</p>
        </td>
        <td style='width:50%; vertical-align:top;'>
            <b>For:</b><br/>
            <p class='TOC'>Trademark Registration {{$package_name}}{!! ($addif1==''?'':'<br/>'.$addif1) !!}:<br/>{!! $trademarks !!}</p>
        </td>
    </tr>
</table><br/><br/>
<table style='width:100%; border-collapse:collapse; border:2px solid black;'>
    <tr>
        <td style='width:80%; font-family: pt sans, arial; padding:4px;font-size:12pt; vertical-align:top; border:1px solid black;'>
            Retainer fee for trademark registration services
        </td>
        <td style='width:20%; font-family: pt sans, arial; padding:4px; text-align:right; vertical-align:top; border:1px solid black; font-size:12pt;'>
            $ {{number_format($invoices_arr[$installment]['mlcfees']+$invoices_arr[$installment]['admin_fees'], 2)}}
        </td>
    </tr>
    @if($tmoffer->ID<6000)
        {{--later for old tmoffers--}}
    @endif
    <tr>
        <td style='width:80%; font-family: pt sans, arial; padding:4px;font-size:12pt; vertical-align:top; border:1px solid black;'>
            {{$gst}}
        </td>
        <td style='width:20%; font-family: pt sans, arial; padding:4px; text-align:right; vertical-align:top; border:1px solid black; font-size:12pt;'>
            $ {{number_format($gst_val, 2)}}
        </td>
    </tr>
    <tr>
        <td style='width:80%; font-family: pt sans, arial; padding:4px;font-size:12pt; vertical-align:top; border:1px solid black;'>
            {{$pst}}
        </td>
        <td style='width:20%; font-family: pt sans, arial; padding:4px; text-align:right; vertical-align:top; border:1px solid black; font-size:12pt;'>
            $ {{number_format($pst_val, 2)}}
        </td>
    </tr>
    <tr>
        <td style="font-family: pt sans, arial; padding:4px; font-size:14pt; vertical-align:top; font-weight:bold; border:1px solid black;">
            TOTAL {{$addif2}}
        </td>
        <td style="width:20%; font-family: pt sans, arial; padding:4px; text-align:right; vertical-align:top; border:1px solid black; font-weight:bold; font-size:14pt;">$ {{number_format($total,2)}}</td>
    </tr>
</table><br/>
@if(count($arr_paid) && isset($arr_paid[$installment]) && strpos($arr_paid[$installment], "void") !== false)
    <div style='text-align: center;position: relative; top: -100px;'><img src='/img/void.png'/></div>
@endif
@if($invoices_arr[$installment]['govt_fees'])
    <p class='TOC'>You will be responsible for paying all government fees.</p>
@endif
<p class='TOC'>All funds are in {{$selected_currency}} ({{$currency_string}}) Our GST# is <b>85164 8089 RT0001</b>.</p>
<p class='TOC'>Due and payable to Trademark Factory International Inc. {{$duedate}}.</p>
{!! $payment_options !!}
<p class='TOC'>{{$payment_terms}}</p><p class='TOC'><center><b>THANK YOU FOR YOUR BUSINESS</b></center></p>