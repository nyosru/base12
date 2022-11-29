<?php

namespace App\classes;


use App\TmfSubjectContact;

class SmsSender
{
    private $tmf_subject;

    public function __construct($tmf_subject)
    {
        $this->tmf_subject=$tmf_subject;
    }

    public static function getModalHtml(){
        return view('sms-sender.modal');
    }

    public function getMessageHtml(){
        $tmf_subject_contact=TmfSubjectContact::where('tmf_subject_id',$this->tmf_subject->id)
            ->where('contact_data_type_id',4)
            ->first();
        $tmf_subject_contact_email=TmfSubjectContact::where('tmf_subject_id',$this->tmf_subject->id)
            ->where('contact_data_type_id',1)
            ->first();
        if($tmf_subject_contact)
            $result=['html'=>view('sms-sender.message',[
                'tmf_subject'=>$this->tmf_subject,
                'tmf_subject_contact_email'=>$tmf_subject_contact_email,
            ])->render(),
                'phone'=>$tmf_subject_contact->contact
            ];
        else
            $result=['html'=>''];
        return json_encode($result);
    }

    public static function getJs($selector){
        return view('sms-sender.js',compact('selector'));
    }

    public function sendStandartNotificationToClient(){
        $tmf_subject_contact_email=TmfSubjectContact::where('tmf_subject_id',$this->tmf_subject->id)
            ->where('contact_data_type_id',1)
            ->first();

        $message=sprintf('%s, we just sent you an email to %s that requires your prompt response. Trademark Factory.',
            $this->tmf_subject->first_name,
            $tmf_subject_contact_email->contact);

        return $this->send($message);
    }

    public function send($message){
        $tmf_subject_contact=TmfSubjectContact::where('tmf_subject_id',$this->tmf_subject->id)
            ->where('contact_data_type_id',4)
            ->first();


        $PhoneNumbers = str_replace(array("+", "-"), "", filter_var($tmf_subject_contact->contact, FILTER_SANITIZE_NUMBER_INT));
//        $PhoneNumbers = '7789297281';
        $username = '61d4696d5dd5';
        $password = 'fb5c90ff65686b22';
//            $wsdl = 'https://validate-ssl.callfire.com/api/1.1/wsdl/callfire-service-http-soap12.wsdl';
        $wsdl = 'https://callfire.com/api/1.1/wsdl/callfire-service-http-soap12.wsdl';
        $client = new \SoapClient($wsdl, [
            'soap_version' => SOAP_1_2,
            'login' => $username,
            'password' => $password
        ]);

        $sendTextRequest = [
            'BroadcastName' => 'SMS broadcast',
            'ToNumber' => $PhoneNumbers,
            'TextBroadcastConfig' => [
                'Message' => $message
            ]
        ];
        $broadcastId = $client->sendText($sendTextRequest);

        $tmf_subject_contact=TmfSubjectContact::where('tmf_subject_id',$this->tmf_subject->id)
            ->where('contact_data_type_id',5)
            ->first();
        if(!$tmf_subject_contact){
            $tmf_subject_contact=new TmfSubjectContact();
            $tmf_subject_contact->tmf_subject_id=$this->tmf_subject->id;
            $tmf_subject_contact->contact_data_type_id=5;
        }
        $tmf_subject_contact->contact=$PhoneNumbers;
        $tmf_subject_contact->save();

        return 'DONE';
    }
}