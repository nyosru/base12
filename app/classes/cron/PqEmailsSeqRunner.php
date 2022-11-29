<?php
namespace App\classes\cron;


use App\classes\pqfollowup\TemplateTranslator;
use App\Mail\OutreachEmail1Sent;
use App\PqFollowUpEmailsSeq;
use App\Tmfsales;
use App\TmfSubjectContact;
use App\Tmoffer;
use App\TmofferCompanySubject;
use Ghattrell\ActiveCampaign\Facades\ActiveCampaign;
use Illuminate\Support\Facades\Mail;

class PqEmailsSeqRunner
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
            $email=$this->getTmfSubjectEmail($obj->tmf_subject_id);
            $firstname=$obj->tmfSubject->first_name;
            $lastname=$obj->tmfSubject->last_name;
            if($obj->pqFollowUpEmail->code!='Drip') {
                $data = [
                    'subj' => $obj->pqFollowUpEmail->subj,
                    'body' => (new TemplateTranslator($obj))->get() . $signature,
                    'firstname' => $firstname,
                    'email' => $email,
                    'from' => $andrei
                ];
                $this->sendEmail($data, $andrei);
            }else{
                $contact = array(
                    "email" => $email,
                    "first_name" => $firstname,
                    "last_name" => $lastname,
                    "p[2]" => 2,
                    "status[2]" => 1, // "Active" status
                );
                ActiveCampaign::contactSync($contact);
            }
            $obj->sent_at = (new \DateTime())->format('Y-m-d H:i:s');
            $obj->save();
        }
    }

    private function getTmfSubjectEmail($tmf_subject_id){
        $tmf_subject_contact=TmfSubjectContact::where('tmf_subject_id',$tmf_subject_id)
            ->where('contact_data_type_id',1)
            ->first();
        if($tmf_subject_contact)
            return $tmf_subject_contact->contact;
        return '';
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
        $objs=PqFollowUpEmailsSeq::where('scheduled_at','like','%'.$date->format('Y-m-d H:i').'%')
            ->get();
//        dd($objs);
        foreach ($objs as $obj){
            $tmf_subject=$obj->tmfSubject;
            if($tmf_subject->undeliver_flag==0 && $tmf_subject->unsubscribed==0)
            $tmoffers=$this->getTmoffers($tmf_subject->id);
            if($tmoffers && count($tmoffers)) {
                foreach ($tmoffers as $tmoffer) {
//                    echo "id:{$tmoffer->ID}<br/>";
//                    var_dump($this->tmofferHasBooking($tmoffer->ID));
//                    echo '<br/>';
//                    var_dump($this->isTmofferConfirmed($tmoffer));
//                    echo '<hr/><br/>';
                    if ($tmoffer->DateConfirmed=='0000-00-00')
                        $result[] = $obj;
                }
            }
            else
                $result[]=$obj;
        }
        return $result;
    }

    private function getTmoffers($tmf_subject_id){
        return Tmoffer::whereIn('ID',TmofferCompanySubject::select('tmoffer_id')->where('tmf_subject_id',$tmf_subject_id))
            ->get();
    }
}