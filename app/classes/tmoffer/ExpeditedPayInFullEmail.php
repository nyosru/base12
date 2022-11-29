<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 7/23/20
 * Time: 3:14 PM
 */

namespace App\classes\tmoffer;

use App\classes\tmoffer\ExpeditedPayInFullEmailVars;
use App\classes\tmoffer\CompanySubjectInfo;
use App\TmofferBin;
use App\TmofferTmfCountryTrademark;

class ExpeditedPayInFullEmail
{
    private $tmoffer;
    private $tmoffer_bin;
    private $tmoffer_tmf_country_trademarks;
    private $email_vars;
    private $limit_amount=50;

    public function __construct($tmoffer)
    {
        $this->tmoffer=$tmoffer;
        $this->tmoffer_bin=TmofferBin::where('tmoffer_id',$tmoffer->ID)->first();
        $this->tmoffer_tmf_country_trademarks=TmofferTmfCountryTrademark::where([
                ['tmoffer_id','=',$tmoffer->ID],
                ['search_only','=',0]
            ])->get();
        $this->initEmailVars();
    }

    public function getEmailVars(){
        return $this->email_vars;
    }

    public function getSubject(){
        if($this->email_vars->save_with_pay_in_full>$this->limit_amount &&
            $this->email_vars->next_installment<$this->email_vars->total_installments)
            return sprintf('Trademarking payment due in 7 days. Save $%s if you pay now.',
                $this->email_vars->save_with_pay_in_full);
        else
            return 'Trademarking payment due in 7 days.';
    }

    public function getBody(){
//        $company_data=CompanySubjectInfo::init($this->tmoffer)->get();
        $today_6pm=date('Y-m-d').'18:00:00';
//        dd($this->email_vars);
        if($this->email_vars->save_with_pay_in_full>$this->limit_amount &&
            $this->email_vars->next_installment<$this->email_vars->total_installments)
            return sprintf('
            <p>Your <strong>%d%s</strong> payment of <strong>%s $%s</strong> is due on %s</p>
            <p>However, you can <a href="https://trademarkfactory.com/expedited-payment/%s" target="_blank">save $%s if you make an expedited payment of $%s</a> by 6pm PST on %s. </p>
            <p>If you choose this option, we will cancel your recurring invoices upon receipt of the expedited payment.</p>
            <p>If you prefer to stay on the payment plan, your account will be charged automatically on %s.</p>
            <p>The automatic withdrawal of $%s will only occur if you made your first payment with a credit card or via PayPal and if your payment details have not changed since.</p>
            <p>Otherwise, please use the attached invoice or the link below to make your monthly payment.</p>
            <p><a href="%s" target="_blank">%s</a></p>
            <p>Once paid, the link above will serve as your payment receipt.</p>
            <p>Either way, we appreciate you taking care of the upcoming payment in due time.</p>
            ',
    //            $company_data['firstname'],
                $this->email_vars->next_installment,
                $this->getNumSuffix($this->email_vars->next_installment),
                $this->email_vars->selected_currency,
                round((1+$this->email_vars->tax)*$this->email_vars->installment_with_interest,2),
                date('F j, Y',strtotime($this->email_vars->payment_date)),
                $this->tmoffer->Login,
                $this->email_vars->save_with_pay_in_full,
                $this->email_vars->expedited_pay_in_full,
                date('F j, Y',strtotime($this->email_vars->payment_date.' - 1 day')),
                date('F j, Y',strtotime($this->email_vars->payment_date)),
                round((1+$this->email_vars->tax)*$this->email_vars->installment_with_interest,2),
                $this->email_vars->payment_link,
                $this->email_vars->payment_link);
        else
            return sprintf('
            <p>Your account will be charged automatically on %s.</p>
            <p>The automatic withdrawal of $%d will only occur if you made your first payment with a credit card or via PayPal and if your payment details have not changed since.</p>
            <p>Otherwise, please use the attached invoice or the link below to make your monthly payment.</p>
            <p><a href="%s" target="_blank">%s</a></p>
            <p>Once paid, the link above will serve as your payment receipt.</p>
            <p>Either way, we appreciate you taking care of the upcoming payment in due time.</p>
            ',
                date('F j, Y',strtotime($this->email_vars->payment_date)),
                round((1+$this->email_vars->tax)*$this->email_vars->installment_with_interest,2),
                $this->email_vars->payment_link,
                $this->email_vars->payment_link);
    }

    private function getNumSuffix($num){
        switch ($num){
            case 2: return 'nd';
            case 3: return 'rd';
            default: return 'th';
        }
    }

    private function initEmailVars(){
        $this->email_vars=new ExpeditedPayInFullEmailVars();
//        dd($this->tmoffer_bin->toArray());
        $this->email_vars->selected_currency=$this->tmoffer_bin->selected_currency;
//        echo $this->tmoffer_tmf_country_trademarks->count();exit;
//        dd($this->tmoffer_tmf_country_trademarks);
        foreach ($this->tmoffer_tmf_country_trademarks as $tmoffer_tmf_country_trademark) {
//            var_dump($tmoffer_tmf_country_trademark->toArray());exit;
            if ($this->email_vars->selected_currency == 'USD')
                $this->email_vars->pay_in_full+=$tmoffer_tmf_country_trademark->cost;
            else
                $this->email_vars->pay_in_full+=$tmoffer_tmf_country_trademark->cost_cad;
        }

//        dd($this->email_vars);

        $amounts=json_decode($this->tmoffer_bin->amount,true);
        $tax=$this->tmoffer_bin->gst+$this->tmoffer_bin->pst;
        $this->email_vars->tax=$tax;
        $this->email_vars->installment_with_interest=$amounts[0];
        $this->email_vars->total_installments=count($amounts);
        $this->email_vars->installment_without_interest=round($this->email_vars->pay_in_full/$this->email_vars->total_installments,2);
        $this->email_vars->next_installment=$this->paid($this->tmoffer->Paid)+1;
        $this->email_vars->payments_remaining=$this->email_vars->total_installments-$this->email_vars->next_installment+1;


        $this->email_vars=$this->recalculateVarPayments($this->email_vars,$tax);

        $invoices=json_decode($this->tmoffer->Invoices,true);
        $this->email_vars->payment_date=$invoices[$this->email_vars->next_installment-1]['date'];
        $this->email_vars->payment_link=sprintf('https://trademarkfactory.com/package-view-invoice?login=%s&code=%s&installment=%d',
            $this->tmoffer->Login,
            $this->tmoffer->ConfirmationCode,
            $this->email_vars->next_installment);
    }

    public function recalculateVarPayments($email_vars,$tax){
        $email_vars->remaining_pay=round((1+$tax)*$email_vars->installment_with_interest*$email_vars->payments_remaining,2);
        $email_vars->expedited_pay_in_full=0;
        if($email_vars->payments_remaining &&
            $email_vars->payments_remaining<=($email_vars->total_installments-1)) {
            if($email_vars->payments_remaining==($email_vars->total_installments-1))
                $email_vars->expedited_pay_in_full=round((1+$tax)*($email_vars->pay_in_full-$email_vars->installment_with_interest),2);
            else
                $email_vars->expedited_pay_in_full=round((1+$tax)*$email_vars->installment_without_interest*$email_vars->payments_remaining,2);
        }else{
            if(!$email_vars->payments_remaining)
                $email_vars->expedited_pay_in_full=round((1+$tax)*$email_vars->pay_in_full,2);
        }
        $email_vars->save_with_pay_in_full=round($email_vars->remaining_pay-$email_vars->expedited_pay_in_full,2);
//        dd($email_vars);
        return $email_vars;
    }

    private function paid($paid_str){
        $arr=explode('|',$paid_str);
        $paid=0;
        foreach ($arr as $el){
            if($el=='+')
                break;
            else
                $paid++;
        }
        return $paid;
    }

}