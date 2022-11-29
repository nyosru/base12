<?php
namespace App\classes\cron;

use App\classes\common\LinkShortener;
use App\classes\tmoffer\CompanySubjectInfo;
use App\ContactDataType;
use App\GroupMeeting;
use App\Mail\ReminderToClientAboutCallIn1HourEmail;
use App\OeBookingCall;
use App\TmfSubjectContact;
use App\Tmoffer;
use App\TmofferInvoiceScheduledEmail;
use App\Tmfsales;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\classes\SubjectForCallReminder;

class ReminderEmailToClientsAboutBookedCall
{
    public function __invoke()
    {
        $date=new \DateTime();
//        $date=new \DateTime('2020-08-19 07:00:00');
        $interval_1hour=\DateInterval::createFromDateString('1 hour');

        $date->add($interval_1hour);

        $persons=$this->getPersonsFromGroupMeeting(clone $date);

        $persons=array_merge($persons,$this->getPersonsFromOeBookingCall(clone $date));

        if(count($persons))
            foreach ($persons as $person)
                $this->sendEmail($person);


        $another_date=clone $date;
        $interval_15min=\DateInterval::createFromDateString('15 min');

        $another_date->add($interval_15min);

        $persons=$this->getPersonsFromGroupMeeting(clone $another_date);

        $persons=array_merge($persons,$this->getPersonsFromOeBookingCall(clone $another_date));

        if(count($persons))
            foreach ($persons as $person)
                $this->sendSMS($person);

    }

    private function sendSMS(SubjectForCallReminder $obj){

        if(strlen($obj->phone)){
            $PhoneNumbers = str_replace(array("+", "-"), "", filter_var($obj->phone, FILTER_SANITIZE_NUMBER_INT));
            $username = '61d4696d5dd5';
            $password = 'fb5c90ff65686b22';
            $wsdl = 'https://callfire.com/api/1.1/wsdl/callfire-service-http-soap12.wsdl';
            $client = new \SoapClient($wsdl, [
                'soap_version' => SOAP_1_2,
                'login' => $username,
                'password' => $password
            ]);

            $call_with=[];
            foreach ($obj->tmfsales as $tmfsales)
                $call_with[]=$tmfsales->FirstName;
            if($obj->zoom_url)
                $call_method=sprintf('Please join us via zoom at %s',$obj->zoom_url);
            else
                $call_method='We will call you at this number';



            $message=sprintf('%s, this is a reminder about your call with %s of Trademark Factory in 15 minutes. %s. If something changed and you can\'t make it, please go to http://tmf.rocks/%s to let us know.',
                $obj->firstname,
                implode(' and ',$call_with),
                $call_method,
                (new LinkShortener())->addURL($obj->cancel_url,0)->getCurrentHash()
            );

            $sendTextRequest = [
                'BroadcastName' => 'SMS broadcast',
                'ToNumber' => $PhoneNumbers,
                'TextBroadcastConfig' => [
                    'Message' => $message
                ]
            ];
            $broadcastId = $client->sendText($sendTextRequest);
            $obj->table_obj->sms_reminder_sent_at=Carbon::now();
            $obj->table_obj->save();
        }
    }


    private function getPersonsFromGroupMeeting(\DateTime $date){
        $objs=GroupMeeting::where([
                ['meeting_at','=',$date->format('Y-m-d H:i:00')],
                ['reminder_sent_at',NULL],
                ['cancelled_at',NULL],
            ])->get();

        $result=[];
        if($objs->count())
            foreach ($objs as $obj){
                $tmf_subject=$obj->tmfSubject;
                $subject_for_call_reminder=new SubjectForCallReminder();
                $subject_for_call_reminder->firstname=$tmf_subject->first_name;
                $subject_for_call_reminder->lastname=$tmf_subject->last_name;
                $subject_for_call_reminder->email=$this->getTmfSubjectContact($tmf_subject->id,'email');
                $subject_for_call_reminder->phone=$this->getTmfSubjectContact($tmf_subject->id,'phone');
                $subject_for_call_reminder->zoom_url=null;
                if($obj->zoom_url)
                    $subject_for_call_reminder->zoom_url = $obj->zoom_url;
                elseif($obj->zoom_id){
                    $zoom_link = sprintf('https://zoom.us/j/%s', $obj->zoom_id);
                    $subject_for_call_reminder->zoom_url = $zoom_link;
                }
                $subject_for_call_reminder->table_obj=$obj;
                foreach ($obj->groupMeetingTmfsales as $group_meeting_tmfsales_obj)
                    $subject_for_call_reminder->tmfsales[]=$group_meeting_tmfsales_obj->tmfsales;

                $result[]=$subject_for_call_reminder;
            }
        return $result;
    }

    private function getTmfSubjectContact($tmf_subject_id,$contact_type){
        $obj=TmfSubjectContact::where([
            ['tmf_subject_id',$tmf_subject_id],
            ['contact_data_type_id',$this->getContactDataTypeId($contact_type)],
        ])->first();
        if($obj)
            return $obj->contact;
        return '';
    }

    private function getContactDataTypeId($contact_type){
        $obj=ContactDataType::where('contact_data_type',$contact_type)->first();
        if($obj)
            return $obj->id;
        return 0;
    }

    private function getPersonsFromOeBookingCall(\DateTime $date){
        $objs=OeBookingCall::where([
            ['datetime_pst','=',$date->format('Y-m-d H:i:00')],
            ['reminder_sent_at',NULL],
            ['cancelled_at',NULL],
        ])->get();

        $result=[];
        if($objs->count())
            foreach ($objs as $obj){
                $company_info=CompanySubjectInfo::init(Tmoffer::find($obj->tmoffer_id))->get();
                $subject_for_call_reminder=new SubjectForCallReminder();
                $subject_for_call_reminder->firstname=$company_info['firstname'];
                $subject_for_call_reminder->lastname=$company_info['lastname'];
                $subject_for_call_reminder->email=$company_info['email'];
                $subject_for_call_reminder->phone=null;
                $subject_for_call_reminder->zoom_url=$obj->zoom_url;
                $subject_for_call_reminder->table_obj=$obj;
                foreach ($obj->tmfsalesOeBookingCalls as $tmfsales_oe_booking_call_obj)
                    $subject_for_call_reminder->tmfsales[]=$tmfsales_oe_booking_call_obj->tmfsales;

                    $result[]=$subject_for_call_reminder;
            }

        return $result;
    }

    private function getEmailBody(SubjectForCallReminder $obj){
        return view('email-templates.reminder-call-in-one-hour',
            compact('obj')
            )->render();
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


    private function getSubj(SubjectForCallReminder $obj){
        return sprintf('%s call about trademarking is coming up in 1 hour',
            ($obj->zoom_url?'Zoom':'Phone'));
    }

    private function sendEmail(SubjectForCallReminder $obj){
            $tmfsales=Tmfsales::find(76);
            $signature=$this->getSignature($tmfsales);
//            $obj->email='vitaly.polukhin@gmail.com';
            Mail::to([['email' => $obj->email, 'name' => $obj->firstname.' '.$obj->lastname]])
                ->send(new ReminderToClientAboutCallIn1HourEmail($tmfsales->Email,'Trademark Factory® | '.$tmfsales->FirstName.' '.$tmfsales->LastName,
                    $this->getSubj($obj),
                    $this->getEmailBody($obj).$signature)
                );
            $obj->table_obj->reminder_sent_at=Carbon::now();
            $obj->table_obj->save();
    }
}