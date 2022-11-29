<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 7/24/20
 * Time: 1:30 PM
 */

namespace App\classes\tmoffer;

use App\Tmoffer;

class PaymentOptions
{
    private $tmoffer;

    public function __construct(Tmoffer $tmoffer)
    {
        $this->tmoffer=$tmoffer;
    }

    public function show($installment=0){
        $arr=json_decode($this->tmoffer->Invoices,true);
        if (json_last_error() != JSON_ERROR_NONE) {
            if (strpos($this->tmoffer->Invoices, '+++') !== false)
                throw Exception('Old invoice! Client:',$this->tmoffer->Login);
            else
                $invoices=unserialize($this->tmoffer->Invoices);
        } else
            $invoices=$arr;

        $payment_options_table_text=$this->getPaymentOptionsTableText($invoices,$installment);
        return $this->getPaymentOptionsTable($payment_options_table_text,$this->tmoffer->selected_currency);
    }

    protected function getPaymentOptionsTable($payment_options_table_text,$selected_currency='CAD'){
        $result_html=$payment_options_table_text['prefix'].'<br/>';
        $td_style='font-family: pt sans, arial; padding:4px;font-size:14px; vertical-align:top; border:1px solid black;';
        $result_html.='<table style="width:100%; border-collapse:collapse; border:2px solid black;">';
        $result_html.=sprintf('<tr><td style="%1$s;width:10%%;">%2$s</td><td style="%1$s;width:90%%;">%3$s</td></tr>',$td_style,$payment_options_table_text['cc'],$payment_options_table_text['cc_text']);
        $result_html.=sprintf('<tr><td style="%1$s;width:10%%;">%2$s</td><td style="%1$s;width:90%%;">%3$s</td></tr>',$td_style,$payment_options_table_text['paypal'],$payment_options_table_text['paypal_text']);
        if($selected_currency=='CAD' || $selected_currency=='')
            $result_html.=sprintf('<tr><td style="%1$s;width:10%%;">%2$s</td><td style="%1$s;width:90%%;">%3$s</td></tr>',$td_style,$payment_options_table_text['etransfer'],$payment_options_table_text['etransfer_text']);
        $result_html.=sprintf('<tr><td style="%1$s;width:10%%;">%2$s</td><td style="%1$s;width:90%%;">%3$s</td></tr>',$td_style,$payment_options_table_text['cheque'],$payment_options_table_text['cheque_text']);
        $result_html.=sprintf('<tr><td style="%1$s;width:10%%;">%2$s</td><td style="%1$s;width:90%%;">%3$s</td></tr>',$td_style,$payment_options_table_text['wire'],$payment_options_table_text['wire_text']);
        return $result_html.'</table>';
    }

    private function getPrefixDefaultText($installment){
        if($installment)
            return '
                <p>If you mailed us valid post-dated cheques or set up recurring payments using PayPal or your credit card, then this invoice is for confirmation purposes only and <strong>YOU DON\'T NEED TO DO ANYTHING</strong>.</p>
                <p>If you chose to pay with Interac e-transfers or wire transfers, or if your cheques or recurring payments subscription are no longer valid, please pay by:</p>
            ';

        return '<p>Please pay by:</p>';
    }

    protected function getPaypal6DefaultText(){
        return 'Paypal only allows setting up 3 recurring payments in a single transaction. So please use both links to set up 3 recurring payments:';
    }

    protected function getChequeDefaultText(){
        return 'Trademark Factory International Inc.<br/>300 - 1055 W. Hastings St.<br/>Vancouver, BC, V6E 2E9<br/>Canada';
    }

    protected function getWireDefaultText($selected_currency='CAD'){
        switch($selected_currency) {
            case '':
            case 'CAD':
                return '
                Bank account: 1087626<br/>
                Transit: 00010<br/>
                Bank: Royal Bank of Canada - 1025 W. Georgia St., Vancouver, V6E 3N9 (Bank code: 003)<br/>
                SWIFT code: ROYCCAT2<br/>
                IBAN code: 003108762600010<br/>
                SORT code: 00300010
                ';
            case 'USD':
                return '
                Bank account: 4007746<br/>
                Transit: 01260<br/>
                Bank: Royal Bank of Canada - 1025 W. Georgia St., Vancouver, V6E 3N9<br/>
                (Bank code: 003)<br/>
                SWIFT code: ROYCCAT2<br/>
                IBAN code: 003400774601260<br/>
                SORT code: 00301260<br/>
                ABA Routing Number: 021000021
                ';
        }
        return '';
    }


    private function getPaymentOptionsTableText($invoices,$installment){
        $payment_options_table_text=[];

        $payment_options_table_text['prefix']=$this->getPrefixDefaultText($installment);

        $payment_options_table_text['cc']=sprintf('<img src="https://trademarkfactory.imgix.net/img/visa_curved.png"/><img src="https://trademarkfactory.imgix.net/img/mastercard_curved.png"/><img src="https://trademarkfactory.imgix.net/img/american_express_curved.png"/>');
        $cc_link=sprintf('https://trademarkfactory.com/creditcard?login=%s&confirm=%s&installment=%d',
            $this->tmoffer->Login,
            $this->tmoffer->ConfirmationCode,
            ($installment+1)
        );
        $payment_options_table_text['cc_text']=sprintf('<a href="%1$s" target="_blank">%1$s</a>',$cc_link);

        $payment_options_table_text['paypal']=sprintf('<img src="https://trademarkfactory.imgix.net/img/paypal.png"/>');
        $paypal_href=sprintf('https://trademarkfactory.com/paypal?login=%s&confirm=%s&installment=%d',
            $this->tmoffer->Login,
            $this->tmoffer->ConfirmationCode,
            ($installment+1)
        );
        $payment_options_table_text['paypal_text']=sprintf('<a href="%1$s" target="_blank">%1$s</a>',$paypal_href);

        $payment_options_table_text['etransfer']='Sending Interac e-transfer to:';
        $payment_options_table_text['etransfer_text']='<a href="mailto:tm@trademarkfactory.com">tm@trademarkfactory.com</a>';

        $payment_options_table_text['cheque']='Mailing a cheque to:';
        $payment_options_table_text['cheque_text']=$this->getChequeDefaultText();

        $payment_options_table_text['wire']='Wiring funds to:';
        $payment_options_table_text['wire_text']=$this->getWireDefaultText($this->tmoffer->selected_currency);

        if(isset($invoices['count']))
            switch($invoices['count']){
                case 3:
                    if(!$installment) {//first installment
                        $payment_options_table_text['cc'] = sprintf('Set up 3 recurring payments:<br>%s', $payment_options_table_text['cc']);
                        $payment_options_table_text['paypal'] = sprintf('Set up 3 recurring payments:<br>%s', $payment_options_table_text['paypal']);
                        $payment_options_table_text['etransfer'] = 'Sending 3 monthly Interac e-transfers to:';
                        $payment_options_table_text['cheque'] = 'Mailing one due and payable and 2 post-dated cheques to:';
                        $payment_options_table_text['wire'] = 'Making 3 monthly wire transfers to:';
                    }
                    break;
                case 6:
                    if(!$installment) {//first installment
                        $payment_options_table_text['cc'] = sprintf('Setting up 6 recurring payments:<br>%s', $payment_options_table_text['cc']);

                        $payment_options_table_text['paypal'] = sprintf('%s<br>%s',$this->getPaypal6DefaultText(),$payment_options_table_text['paypal']);
                        $first3payments=sprintf('https://trademarkfactory.com/paypal3?login=%s&confirm=%s',
                            $this->tmoffer->Login,
                            $this->tmoffer->ConfirmationCode
                        );
                        $second3payments=sprintf('https://trademarkfactory.com/paypal6?login=%s&confirm=%s',
                            $this->tmoffer->Login,
                            $this->tmoffer->ConfirmationCode
                        );
                        $payment_options_table_text['paypal_text']=sprintf('First 3 payments: <br/><a href="%1$s" target="_blank">%1$s</a><br/><br/>Second 3 payments:<br/><a href="%2$s">%2$s</a>',$first3payments,$second3payments);

                        $payment_options_table_text['etransfer'] = 'Sending 6 monthly Interac e-transfers to:';
                        $payment_options_table_text['cheque'] = 'Mailing one due and payable and 5 post-dated cheques to:';
                        $payment_options_table_text['wire'] = 'Making 6 monthly wire transfers to:';
                    }else{
                        $second3payments=sprintf('https://trademarkfactory.com/paypal6?login=%s&confirm=%s&installment=%d',
                            $this->tmoffer->Login,
                            $this->tmoffer->ConfirmationCode,
                            ($installment+1)
                        );
                        $first_payment_text=$second_payment_text='';
                        $first_link=$second_link='';
                        if($installment<3) {
                            $first3payments = sprintf('https://trademarkfactory.com/paypal3?login=%s&confirm=%s&installment=%d',
                                $this->tmoffer->Login,
                                $this->tmoffer->ConfirmationCode,
                                ($installment + 1)
                            );
                            $first_payment_text=($installment==3?'First payment: <br/>':sprintf('First %d payment%s: <br/>',3-$installment,(3-$installment>1?'s':'')));
                            $second_payment_text='<br/><br/>Second 3 payments:<br/>';
                            $first_link=sprintf('%2$s<a href="%1$s" target="_blank">%1$s</a>',$first3payments,$first_payment_text);
                            $second_link=sprintf('%2$s<a href="%1$s" target="_blank">%1$s</a>',$second3payments,$second_payment_text);
                        }else {
                            $first3payments = '';
                            $second_payment_text=($installment==6?'':sprintf('Last %d payment%s: <br/>',6-$installment,(6-$installment>1?'s':'')));
                            $second_link=sprintf('%2$s<a href="%1$s" target="_blank">%1$s</a>',$second3payments,$second_payment_text);
                        }
                        $payment_options_table_text['paypal_text']=sprintf('%s%s',$first_link,$second_link);

                    }
                    break;
            }
        return $payment_options_table_text;
    }
}