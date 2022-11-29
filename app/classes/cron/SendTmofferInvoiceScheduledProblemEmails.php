<?php
namespace App\classes\cron;

use App\Mail\OutreachEmail1Sent;
use App\Tmoffer;
use App\TmofferInvoiceScheduledEmail;
use App\Tmfsales;
use Illuminate\Support\Facades\Mail;

class SendTmofferInvoiceScheduledProblemEmails
{
    public function __invoke()
    {
//        $date=new \DateTime();
        $date=new \DateTime();
        $tmoffers=$this->get4Sending(clone $date);
        $data=[];
        if(!is_null($tmoffers)) {
            $kristine = Tmfsales::find(77);
            $andrei = Tmfsales::find(1);
            $robot = Tmfsales::find(70);
            $data = [
                'subj' => 'Problem with Scheduled Invoice email',
                'body' => $this->getEmailBody($tmoffers, $date),
                'firstname' => $kristine->FirstName,
                        'email' => $kristine->Email,
//                'email' => 'vitaly.polukhin@gmail.com',
                'from' => $robot
            ];
        }
        if(isset($data['subj']))
            $this->sendEmail($data,$andrei);
    }

    private function getEmailBody($tmoffers,\DateTime $date){
        $interval_10days=\DateInterval::createFromDateString('10 days');
        $interval_3days=\DateInterval::createFromDateString('3 days');
        $ddd=clone $date;
        $scheduled_date=$ddd->add($interval_3days);
        $ddd= clone $date;
        $payment_date=$ddd->add($interval_10days);
        $tmoffers_data=[];
        foreach ($tmoffers as $tmoffer) {
            $invoices_data=$this->getInvoicesData($tmoffer->Invoices,$payment_date);
            $tmoffers_data[]=[
                'tmoffer'=>$tmoffer,
                'invoices_data'=>$invoices_data
            ];
        }
        return view('payments-calendar.scheduled-problem-email',
            compact('tmoffers_data','scheduled_date','payment_date')
            )->render();
    }

    private function sendEmail($data,$andrei){
            Mail::to([['email' => $data['email'], 'name' => $data['firstname']]])
                ->cc($andrei->Email, $andrei->FirstName . ' ' . $andrei->LastName)
                ->send(new OutreachEmail1Sent($data['from']->Email,'Trademark Factory® | ROBOT',
                    $data['subj'],
                    $data['body'])
                );
    }

    private function get4Sending(\DateTime $date){
        $interval_10days=\DateInterval::createFromDateString('10 days');
        $tmoffers=Tmoffer::whereRaw('Status not like "%voided%"')
            ->where([
                ['DateConfirmed','!=','0000-00-00'],
                ['Invoices','like','%'.$date->add($interval_10days)->format('Y-m-d').'%'],
            ])
            ->get();
        return $this->filterTmf($tmoffers,$date);
    }

    private function filterTmf($tmoffers,\DateTime $date){
        $result=null;
        if($tmoffers && count($tmoffers))
            foreach ($tmoffers as $tmoffer){
                $invoice_data=$this->getInvoicesData($tmoffer->Invoices,$date);
//                $is_invoice_paid=$this->isInvoicePaid($tmoffer->Paid,$invoice_data['current-invoice-index']);
                $is_previous_invoice_paid=$this->isInvoicePaid($tmoffer->Paid,$invoice_data['current-invoice-index']-1);

                if($invoice_data['current-invoice-index']>-1 && !$is_previous_invoice_paid)
                    $result[]=$tmoffer;
            }
        return $result;
    }

    private function getInvoicesData($invoices_str,\DateTime $date){
        $data=[
            'invoices'=>0,
            'current-invoice-index'=>-1
        ];
        $arr = json_decode($invoices_str, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            $arr = unserialize($invoices_str);
            $data['invoices']=$arr['count'];
        }else {
            $data['invoices'] = count($arr);
            foreach ($arr as $index=>$el)
                if($el['date']==$date->format('Y-m-d')) {
                    $data['current-invoice-index'] = $index;
                    break;
                }
        }
        return $data;
    }

    private function isInvoicePaid($paid_str,$index){
        $paid_arr=explode('|',$paid_str);
        return ($paid_arr[$index]!='+');
    }

    private function getPaidCount($paid_str){
        $result=[];
        $paid_arr=explode('|',$paid_str);
        foreach($paid_arr as $el)
            if(trim($el)!='+')
                $result[]=$el;
        return count($result);
    }

}