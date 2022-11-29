<?php
namespace App\classes\tmoffer;

use App\TmfPackages;
use App\classes\tmoffer\CompanySubjectInfo;
use App\classes\tmoffer\PaymentOptions;
use App\TmofferBin;


class InvoiceGeneratorFromJSON extends InvoiceGenerator
{

    public function get($installment)
    {
        $invoices_arr=json_decode($this->tmoffer->Invoices,true);
//        dd($invoices_arr);
        $company_info=CompanySubjectInfo::init($this->tmoffer)->get();
        $installment--;
        $invdate = new \DateTime($invoices_arr[$installment]['date']);
        if (($installment - 1) > 0)
            $invdate->modify("- 7 days");

        $ddd = $invdate;
        $ddd1 = $ddd->format("F j, Y");
        $duedate = "on or before " . $ddd1;

        $invdate1 = $invdate->format("F j, Y");
        $invdate0 = $invdate->format("Y-m-d H:i:s");
        $invdate2 = $invdate->format("Y-m-d");

        $invnum = $invdate->format("ymd") . $this->addZeros($this->tmoffer->ID, 6) . $installment;
        $package_name = $this->getPackageName();

        $pnum = count($invoices_arr);
        if ($pnum > 1) {
            $addif1 = " [Payment  " . ($installment + 1) . " of $pnum]";
            $addif2 = " (this installment)";
        } else {
            $addif1 = "";
            $addif2='';
        }

        $payment_options = '';
        if ($this->tmoffer->DateConfirmed >= '2016-05-11') {
            //$payment_options.='<p class="TOC">Please pay by:</p>';
            $payment_options .= (new PaymentOptions($this->tmoffer))->show($installment);
        }
        $payment_terms='';

        $trademarks=$this->getListOfTMs();
        $tmoffer=$this->tmoffer;

        $gst=sprintf('GST (%s%%)',$tmoffer->gst*100);
        $pst=sprintf('PST (%s%%)',$tmoffer->pst*100);
        $total=($invoices_arr[$installment]['mlcfees']+
                $invoices_arr[$installment]['admin_fees']+
                $invoices_arr[$installment]['govt_fees']+
                $invoices_arr[$installment]['upsells'])*(1+$tmoffer->gst+$tmoffer->pst);
        $gst_val=($invoices_arr[$installment]['mlcfees']+
                $invoices_arr[$installment]['admin_fees']+
                $invoices_arr[$installment]['govt_fees']+
                $invoices_arr[$installment]['upsells'])*$tmoffer->gst;
        $pst_val=($invoices_arr[$installment]['mlcfees']+
                $invoices_arr[$installment]['admin_fees']+
                $invoices_arr[$installment]['govt_fees']+
                $invoices_arr[$installment]['upsells'])*$tmoffer->pst;

        $currency_string='';
        $tmoffer_bin=TmofferBin::where('tmoffer_id',$tmoffer->ID)->first();
        if($tmoffer_bin)
            $selected_currency=$tmoffer_bin->selected_currency;
        else
            $selected_currency=$tmoffer->selected_currency;
        switch($selected_currency){
            case 'CAD':
                $currency_string='Canadian Dollars';
                break;
            case 'USD':
                $currency_string='U.S. Dollars';
                break;
        }

        $exploded_paid=explode('|',$tmoffer->Paid);
        $arr_paid=[];
        foreach($exploded_paid as $el)
            if($el!='' && trim($el)!='+')
                $arr_paid[]=$el;

        $invoice_html=view('invoices.tmoffer-invoice',
            compact(
                'addif1',
                'addif2',
                'package_name',
                'payment_options',
                'invnum',
                'invdate1',
                'company_info',
                'trademarks',
                'payment_terms',
                'invoices_arr',
                'installment',
                'tmoffer',
                'gst','pst',
                'gst_val','pst_val','total','duedate',
                'selected_currency','currency_string',
                'arr_paid'
            )
        )->render();
        $invoice_html = $this->paintPaid($installment, $pnum, $invdate0, $invoice_html);
        $filename = $this->getFileName($company_info,$package_name, $addif1, $invnum, $invdate2, $installment);

        return new Invoice($tmoffer,$installment,$invoice_html,$filename);
    }

    private function getFileName($company_info,$package_name, $addif1, $invnum, $invdate2, $installment)
    {
        $allpaid=explode('|',$this->tmoffer->Paid);
        $addif1 = " $package_name $addif1";
        $company_modif = str_replace(" ", "_", str_replace("'", "", $this->sanitize($company_info['company'])));
        $addif3 = '';
        if ($addif1)
            $addif3 = " " . trim(str_replace("Payment ", "", $addif1));

        $void_text = '';
        if (strpos($allpaid[$installment], 'void') !== false) {
            $filename = str_replace(" ", "_", "Invoice TMF$invnum - $invdate2 - {$company_modif}$addif3.pdf");
            $filename = str_replace("__", "_", $filename);
            $filename = str_replace("\'", "", $filename);
            $void_text = "VOID";
        }

        $filename = str_replace(" ", "_", "Invoice TMF$invnum" . "$void_text - $invdate2 - {$company_modif}$addif3.pdf");
        $filename = str_replace("__", "_", $filename);
        $filename = str_replace("\'", "", $filename);
        return str_replace("/", "", $filename);
    }

}