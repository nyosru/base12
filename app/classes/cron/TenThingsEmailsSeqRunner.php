<?php
namespace App\classes\cron;


use App\classes\tenthings\TemplateTranslator;
use App\Mail\OutreachEmail1Sent;
use App\TenThingsEmailsSeq;
use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\Tmfsales;
use App\TmfSubjectContact;
use App\Tmoffer;
use App\TmofferCompanySubject;
use Ghattrell\ActiveCampaign\Facades\ActiveCampaign;
use Illuminate\Support\Facades\Mail;

class TenThingsEmailsSeqRunner
{
    public function __invoke()
    {
        $date = new \DateTime();
        $objs=$this->getData($date);
//        dd($objs);
        $andrei = Tmfsales::find(1);
        $signature=sprintf('<br/>%s<br/>%s<br/>%s',
            $andrei->goodbye_text,
            $andrei->FirstName,
            $this->getSignature($andrei));

        foreach ($objs as $obj){
            if($obj->tenThingsEmail->code!='Drip') {
                $data = [
                    'subj' => $obj->tenThingsEmail->subj,
                    'body' => (new TemplateTranslator($obj))->get() . $signature,
                    'firstname' => $obj->tenThingsEbookRequest->firstname,
                    'email' => $obj->tenThingsEbookRequest->email,
                    'from' => $andrei
                ];
                $this->sendEmail($data, $andrei);
            }else{
                $ten_things_ebook_request=$obj->tenThingsEbookRequest;
                $email=$ten_things_ebook_request->email;
                $firstname=$obj->tenThingsEbookRequest->firstname;
                $contact = array(
                    "email" => $email,
                    "first_name" => $firstname,
                    "last_name" => '',
                    "p[2]" => 2,
                    "status[2]" => 1, // "Active" status
                );
                ActiveCampaign::contactSync($contact);
            }
            $obj->sent_at = (new \DateTime())->format('Y-m-d H:i:s');
            $obj->save();
        }
    }

    private function getSignature(Tmfsales $tmfsales)
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $signature_link = 'https://trademarkfactory.com/signatureall_new.php?id=' . $tmfsales->ID;
        return file_get_contents(
            $signature_link,
            false,
            stream_context_create($arrContextOptions)
        );
    }


    private function sendEmail($data,$andrei){
        Mail::to([['email' => $data['email'], 'name' => $data['firstname']]])
//            ->cc($andrei->Email, $andrei->FirstName . ' ' . $andrei->LastName)
            ->send(new OutreachEmail1Sent($data['from']->Email,'Trademark Factory® | '.$data['from']->FirstName.' '.$data['from']->LastName,
                    $data['subj'],
                    $data['body'])
            );
    }

    private function getData($date){
        $result=[];
        $objs=TenThingsEmailsSeq::where('scheduled_at','like','%'.$date->format('Y-m-d H:i').'%')
            ->where('ten_things_email_id','!=',1)
            ->get();
//        dd($objs);
        foreach ($objs as $obj){
            $ten_things_ebook_request=$obj->tenThingsEbookRequest;
            $email=$ten_things_ebook_request->email;
            $tmoffers=$this->getTmoffers($email);
            if($tmoffers && count($tmoffers)) {

                foreach ($tmoffers as $tmoffer) {
//                    echo "id:{$tmoffer->ID}<br/>";
//                    var_dump($this->tmofferHasBooking($tmoffer->ID));
//                    echo '<br/>';
//                    var_dump($this->isTmofferConfirmed($tmoffer));
//                    echo '<hr/><br/>';
                    if (!$this->tmofferHasBooking($tmoffer->ID) && !$this->isTmofferConfirmed($tmoffer))
                        $result[] = $obj;
                }
            }
            else
                $result[]=$obj;
        }
        return $result;
    }

    private function getTmoffers($email){
        return Tmoffer::whereIn('ID',TmofferCompanySubject::select('tmoffer_id')->whereIn('tmf_subject_id',TmfSubjectContact::distinct()
            ->select('tmf_subject_id')
            ->where('contact_data_type_id',1)
            ->where('contact',$email))
        )->get();
    }

    private function tmofferHasBooking($tmoffer_id){
        return TmfBooking::whereIn(
            'tmf_client_tmsr_tmoffer_id',
            TmfClientTmsrTmoffer::select('id')->where('tmoffer_id',$tmoffer_id)
            )
            ->first();
    }

    private function isTmofferConfirmed($tmoffer){
        return $tmoffer->DateConfirmed!='0000-00-00';
    }
}