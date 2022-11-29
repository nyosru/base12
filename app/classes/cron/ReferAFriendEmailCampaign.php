<?php
namespace App\classes\cron;

use App\classes\tmoffer\CompanySubjectInfo;
use App\EmailCampaignTmfSubject;
use App\Mail\OutreachEmail1Sent;
use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\Tmfsales;
use App\TmfsalesTmofferNotBoomReason;
use App\TmfSubject;
use App\TmfSubjectContact;
use App\Tmoffer;
use App\TmofferBin;
use App\TmofferCompanySubject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Http\Request;

class ReferAFriendEmailCampaign
{
    public function __invoke()
    {
//        $tmoffer_id=56662;
//        dd($this->getTmfBookingCloser($tmoffer_id));

        $tmoffers=$this->getTmoffers();

//        dd($tmoffers);
//        exit;
//        $tmoffers=Tmoffer::whereIn('ID',[393534])->get();
        $ec_id=2;
        $remove_from_send=[131,1553];
        $andrei = Tmfsales::find(1);
        $signature=sprintf('<br/>%s<br/>%s<br/>%s',
            $andrei->goodbye_text,
            $andrei->FirstName,
            $this->getSignature($andrei));
        foreach ($tmoffers as $tmoffer){
//            $cancelled_or_marked_as_noshow=($this->isBookedCancelled($tmoffer->ID) || $this->isMarkedAsNoShow($tmoffer->ID));
//            $closer=$this->getTmfBookingCloser($tmoffer->ID);
            $company_info = CompanySubjectInfo::init($tmoffer)->get();
            if(strlen($company_info['firstname']) && strlen($company_info['email']) &&
                !in_array($company_info['tmf-subject-id'],$remove_from_send)) {
//                echo "fn:{$company_info['firstname']} ln:{$company_info['lastname']} email:{$company_info['email']}<br/>";
                            $ec_subj_id = $this->getEmailCampaignTmfSubjectId($ec_id, $this->getTmfSubjectId($tmoffer->ID));
                            $hash = Hashids::encode($ec_subj_id);
                            $pixel = sprintf('<img src="https://trademarkfactory.com/p/ecph/%s"/>', $hash);
                            $client_affiliate_link=sprintf('https://trademarkfactory.com/tmf-ref%d',$company_info['tmf-subject-id']);
                            $email = view('email-campaign.refer-a-friend',
                                compact(
                                    'tmoffer',
                                    'company_info', 'pixel', 'hash','client_affiliate_link'
                                )
                            );

                            $data = [
                                'subj' => '🤝 Refer a friend, get a free TM',
                                'body' => $email.$signature,
                                'client_fn' => $company_info['firstname'].' '.$company_info['lastname'],
                                'email' => $company_info['email'],
                                'from' => $andrei
                            ];
//                            dd($data);

                try {
                    $this->sendEmail($data, $andrei);
                }catch (\Exception $e){
                    $this->sendEmailError($data,$andrei);
                }

            sleep(rand(5,20));
            }
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
        $vitaly=Tmfsales::find(53);
        Mail::to([['email' => $data['email'], 'name' => $data['client_fn']]])
            ->bcc($vitaly->Email, $vitaly->FirstName . ' ' . $vitaly->LastName)
            ->send(new OutreachEmail1Sent($data['from']->Email,'Trademark Factory® | '.$andrei->FirstName . ' ' . $andrei->LastName,
                    $data['subj'],
                    $data['body'])
            );
    }

    private function sendEmailError($data,$andrei){
        $vitaly=Tmfsales::find(53);
        Mail::to([['email' => $vitaly->Email, 'name' => $vitaly->FirstName . ' ' . $vitaly->LastName]])
//            ->bcc($vitaly->Email, $vitaly->FirstName . ' ' . $vitaly->LastName)
            ->send(new OutreachEmail1Sent($data['from']->Email,'Trademark Factory® | '.$andrei->FirstName . ' ' . $andrei->LastName,
                    'ERROR NOBOOM CAMPAIGN',
                    print_r($data,true))
            );
    }



    private function getEmailCampaignTmfSubjectId($ec_id,$tmf_subject_id){
        $obj=EmailCampaignTmfSubject::where('email_campaign_id',$ec_id)
            ->where('tmf_subject_id',$tmf_subject_id)
            ->first();
        if(!$obj){
            $obj=new EmailCampaignTmfSubject();
            $obj->email_campaign_id=$ec_id;
            $obj->tmf_subject_id=$tmf_subject_id;
            $obj->save();
        }
        return $obj->id;
    }

    private function getTmfSubjectId($tmoffer_id){
        $tmoffer_company_subject=TmofferCompanySubject::where('tmoffer_id',$tmoffer_id)->first();
        return $tmoffer_company_subject->tmf_subject_id;
    }

    private function getTmfBookingCloser($tmoffer_id){
        $tmf_booking=TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',TmfClientTmsrTmoffer::select('id')->where('tmoffer_id',$tmoffer_id))
            ->where('booked_date','!=','0000-00-00 00:00:00')
            ->orderBy('id','desc')
            ->first();
        if($tmf_booking && $tmf_booking->booked_date!='0000-00-00 00:00:00')
            return Tmfsales::find($tmf_booking->sales_id);

        return null;
    }

    private function isBookedCancelled($tmoffer_id){
        $tmf_booking=TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',TmfClientTmsrTmoffer::select('id')->where('tmoffer_id',$tmoffer_id))
            ->orderBy('id','desc')
            ->first();
        if($tmf_booking && $tmf_booking->booked_date=='0000-00-00 00:00:00')
            return true;
        return false;
    }

    private function isMarkedAsNoShow($tmoffer_id){
        $obj=TmfsalesTmofferNotBoomReason::where('tmoffer_id',$tmoffer_id)
            ->where('not_boom_reason_id',79)
            ->first();

        return ($obj?true:false);
    }

    private function getTmoffers(){
        $tmoffers=[];
        $inc=0;
        $result=[];
        $used_tmf_subject_ids=[];
        do{
            $tmoffer=Tmoffer::where('DateConfirmed','!=','0000-00-00')
                ->where('Status','not like','%void%')
                ->offset($inc++)
                ->first();
            if($tmoffer){
                $next=1;
                if($tmoffer->DateConfirmed>='2017-04-28'){
                    $tmoffer_bin=TmofferBin::where('tmoffer_id',$tmoffer->ID)
                        ->where('need_capture',0)
                        ->first();
                    if($tmoffer_bin)
                        $next=1;
                    else
                        $next=0;
                }
                if($next) {
                    $company_info = CompanySubjectInfo::init($tmoffer)->get();
                    if (!in_array($company_info['tmf-subject-id'], $used_tmf_subject_ids)) {
                        $used_tmf_subject_ids[] = $company_info['tmf-subject-id'];
                        $result[] = $tmoffer;
                    }
                }
            }
        }while($tmoffer);
        return $result;
    }

    private function getTmfSubjectEmail($tmf_subject_id){
        $tmf_subject_contact=TmfSubjectContact::where('tmf_subject_id',$tmf_subject_id)
            ->where('contact_data_type_id',1)
            ->first();
        if($tmf_subject_contact)
            return $tmf_subject_contact->contact;
        return '';
    }

}