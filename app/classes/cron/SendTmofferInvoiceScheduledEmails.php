<?php
namespace App\classes\cron;


use App\classes\common\InvoicePDFGenerator;
use App\classes\tmoffer\CompanySubjectInfo;
use App\classes\tmoffer\ExpeditedPayInFullEmail;
use App\classes\tmoffer\InvoiceGenerator;
use App\Mail\TmofferInvoiceSchedultedEmailSent;
use App\Tmoffer;
use App\TmofferInvoiceScheduledEmail;
use App\Tmfsales;
use App\traits\SaveToSent;
use Illuminate\Support\Facades\Mail;

class SendTmofferInvoiceScheduledEmails
{
    use SaveToSent;

    public function __invoke()
    {
        $tmoffers=$this->get4Sending(new \DateTime());
        $interval_7days=\DateInterval::createFromDateString('7 days');
        if(!is_null($tmoffers)) {
            $arr=[];
            foreach ($tmoffers as $tmoffer) {
                $epfe = new ExpeditedPayInFullEmail($tmoffer);
//                $email_vars = $epfe->getEmailVars();

                $invoices_data=$this->getInvoicesData($tmoffer->Invoices,(new \DateTime())->add($interval_7days));

                $tmoffer_invoice_scheduled_email = TmofferInvoiceScheduledEmail::where([
                    ['tmoffer_id', '=', $tmoffer->ID],
                    ['installment', '=', $invoices_data['current-invoice-index']],
                ])
                    ->first();
//                $andrei = Tmfsales::find(1);
                $andrei = Tmfsales::find(1);
                if ($tmoffer_invoice_scheduled_email)
                    $data = [
                        'subj' => $tmoffer_invoice_scheduled_email->subject,
                        'body' => $tmoffer_invoice_scheduled_email->message,
                        'firstname' => $tmoffer_invoice_scheduled_email->to_fn,
                        'email' => $tmoffer_invoice_scheduled_email->to_email,
//                        'email' => 'vitaly.polukhin@gmail.com',
                        'from' => $tmoffer_invoice_scheduled_email->tmfsales
                    ];
                else {
                    $company_info = CompanySubjectInfo::init($tmoffer)->get();
                    $data = [
                        'subj' => $epfe->getSubject(),
                        'body' => $epfe->getBody(),
                        'firstname' => $company_info['firstname'],
                        'email' => $company_info['email'],
//                        'email' => 'vitaly.polukhin@gmail.com',
                        'from' => $andrei
                    ];
                }
                $invoice = InvoiceGenerator::init(Tmoffer::find($tmoffer->ID))->get($invoices_data['current-invoice-index']+1);
//                $pdf_filename =  public_path()."/../../trademarkfactory.com/clientfiles/invoices/".$invoice->getFilename();
//                $arr[]=$pdf_filename;
//                file_put_contents(storage_path().'/logs/user.log',get_current_user());
//                file_put_contents(public_path().'/../../trademarkfactory.com/clientfiles/invoices/test.log',get_current_user());

                $invoice_file_pdf = (new InvoicePDFGenerator($invoice))->generate();

                $this->sendEmail($data, $andrei, $invoice_file_pdf);
/*
                $invoiced_arr = explode('|', $tmoffer->Invoiced);
                $invoiced_arr[$email_vars->next_installment - 1] = $date->format('Y-m-d');
                $tmoffer->Invoiced = implode('|', $invoiced_arr);
                $tmoffer->save();
                */
            }
//            file_put_contents(storage_path().'/logs/user.log',implode("\r\n",$arr));
        }
    }

    private function sendEmail($data,$andrei,$invoice_file_pdf){
        $signature=$this->getSignature($data['from']);
        $kristine = Tmfsales::find(77);
        if($data['from']->ID!=$andrei->ID)
            Mail::to([['email' => $data['email'], 'name' => $data['firstname']]])
                ->bcc([$andrei->Email, $kristine->Email])
                ->send(new TmofferInvoiceSchedultedEmailSent($data['from']->Email,
                    $data['from']->FirstName . ' ' . $data['from']->LastName,
                    $data['subj'],
                    $data['body'].$signature,
                    $invoice_file_pdf));
        else
            Mail::to([['email' => $data['email'], 'name' => $data['firstname']]])
                ->send(new TmofferInvoiceSchedultedEmailSent($data['from']->Email,
                    $data['from']->FirstName . ' ' . $data['from']->LastName,
                    $data['subj'],
                    $data['body'].$signature,
                    $invoice_file_pdf));

        $this->saveToSentWithAttachment(
            $data['from'],
            $data['email'],
            $data['firstname'],
            $data['subj'],
            $data['body'].$signature,
            $invoice_file_pdf);
    }

    private function getSignature(Tmfsales $tmfsales){
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $signature_link='https://trademarkfactory.com/signatureall_new.php?id='.$tmfsales->ID;
        return file_get_contents(
            $signature_link,
            false,
            stream_context_create($arrContextOptions)
        );
    }

    private function get4Sending(\DateTime $date){
        $interval_7days=\DateInterval::createFromDateString('7 days');
        $tmoffers=Tmoffer::whereRaw('Status not like "%voided%"')
            ->where([
                ['DateConfirmed','!=','0000-00-00'],
                ['Invoices','like','%'.$date->add($interval_7days)->format('Y-m-d').'%'],
            ])
            ->get();
        return $this->filterTmf($tmoffers,$date);
    }

    private function filterTmf($tmoffers,\DateTime $date){
        $result=null;
        if($tmoffers && count($tmoffers))
            foreach ($tmoffers as $tmoffer){
                $invoice_data=$this->getInvoicesData($tmoffer->Invoices,$date);
                $is_invoice_paid=$this->isInvoicePaid($tmoffer->Paid,$invoice_data['current-invoice-index']);
                $paid_count=$this->getPaidCount($tmoffer->Paid);
                if($invoice_data['invoices']>$paid_count && !$is_invoice_paid)
                    $result[]=$tmoffer;
            }
        return $result;
    }

    private function getInvoicesData($invoices_str,\DateTime $date){
        $data=[
            'invoices'=>0,
            'current-invoice-index'=>0
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