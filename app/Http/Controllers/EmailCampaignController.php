<?php

namespace App\Http\Controllers;

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
use App\TmofferCompanySubject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Http\Request;

class EmailCampaignController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
//        $tmoffer_id=56662;
//        dd($this->getTmfBookingCloser($tmoffer_id));
        $tmoffers=$this->getTmoffers();
//        exit;
//        $tmoffers=Tmoffer::whereIn('ID',[385864,390488,390489])->get();
        $tmoffers=Tmoffer::whereIn('ID',[390489])->get();
        $ec_id=2;
        foreach ($tmoffers as $tmoffer){
//            $cancelled_or_marked_as_noshow=($this->isBookedCancelled($tmoffer->ID) || $this->isMarkedAsNoShow($tmoffer->ID));
//            $closer=$this->getTmfBookingCloser($tmoffer->ID);
            $company_info = CompanySubjectInfo::init($tmoffer)->get();
            $ec_subj_id = $this->getEmailCampaignTmfSubjectId($ec_id, $this->getTmfSubjectId($tmoffer->ID));
            $hash = Hashids::encode($ec_subj_id);
            $pixel = sprintf('<img src="https://trademarkfactory.com/p/ecph/%s"/>', $hash);
            $client_affiliate_link=sprintf('https://trademarkfactory.com/tmf-ref%d',$company_info['tmf-subject-id']);
            $email = view('email-campaign.refer-a-friend',
                compact(
                    'tmoffer',
                    'closer',
                    'company_info', 'pixel', 'hash','client_affiliate_link'
                )
            );
            echo $email;
            exit;
            $andrei = Tmfsales::find(1);
            $signature=sprintf('<br/>%s<br/>%s<br/>%s',
                $andrei->goodbye_text,
                $andrei->FirstName,
                $this->getSignature($andrei));

            $data = [
                'subj' => '🤝 Refer a friend, get a free TM',
                'body' => $email.$signature,
                'client_fn' => $company_info['firstname'].' '.$company_info['lastname'],
                'email' => $company_info['email'],
                'from' => $andrei
            ];
//            $this->sendEmail($data,$andrei);
            sleep(rand(5,20));

        }
        return 'here';
    }

    public function brandCheckUp(){
//        $tmoffer_id=56662;
//        dd($this->getTmfBookingCloser($tmoffer_id));
        $tmoffers=$this->getTmoffers();
//        exit;
//        $tmoffers=Tmoffer::whereIn('ID',[385864,390488,390489])->get();
        $tmoffers=Tmoffer::whereIn('ID',[390489])->get();
        $ec_id=3;
        foreach ($tmoffers as $tmoffer){
//            $cancelled_or_marked_as_noshow=($this->isBookedCancelled($tmoffer->ID) || $this->isMarkedAsNoShow($tmoffer->ID));
//            $closer=$this->getTmfBookingCloser($tmoffer->ID);
            $company_info = CompanySubjectInfo::init($tmoffer)->get();
            $ec_subj_id = $this->getEmailCampaignTmfSubjectId($ec_id, $this->getTmfSubjectId($tmoffer->ID));
            $hash = Hashids::encode($ec_subj_id);
            $pixel = sprintf('<img src="https://trademarkfactory.com/p/ecph/%s"/>', $hash);
            $client_affiliate_link=sprintf('https://trademarkfactory.com/tmf-ref%d',$company_info['tmf-subject-id']);
            $email = view('email-campaign.brand-checkup',
                compact(
                    'tmoffer',
                    'closer',
                    'company_info', 'pixel', 'hash','client_affiliate_link'
                )
            );
            echo $email;
            exit;
            $andrei = Tmfsales::find(1);
            $signature=sprintf('<br/>%s<br/>%s<br/>%s',
                $andrei->goodbye_text,
                $andrei->FirstName,
                $this->getSignature($andrei));

            $data = [
                'subj' => strtoupper($company_info['firstname']).', get your free annual brand audit 📅',
                'body' => $email.$signature,
                'client_fn' => $company_info['firstname'].' '.$company_info['lastname'],
                'email' => $company_info['email'],
                'from' => $andrei
            ];
//            $this->sendEmail($data,$andrei);
            sleep(rand(5,20));

        }
        return 'here';
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
        Mail::to([['email' => $data['email'], 'name' => $data['client_fn']]])
//            ->bcc($andrei->Email, $andrei->FirstName . ' ' . $andrei->LastName)
            ->send(new OutreachEmail1Sent($data['from']->Email,'Trademark Factory® | '.$andrei->FirstName . ' ' . $andrei->LastName,
                    $data['subj'],
                    $data['body'])
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
        $tmoffers=Tmoffer::whereIn('ID',
            TmfClientTmsrTmoffer::select('tmoffer_id')
                ->distinct()
                ->whereIn('id',
                    TmfBooking::select('tmf_client_tmsr_tmoffer_id')
                        ->distinct()
                        ->where([
                            ['booked_date','>=','2020-01-01 00:00:00'],
                            ['booked_date','<','2020-10-01 00:00:00'],
                        ])
                )
        )
            ->where(function ($query){
                $query->where('tmoffer.DateConfirmed','=','0000-00-00')
                    ->orWhere('tmoffer.Status','like','%void%');
            })
            ->whereNotIn('ID',TmfsalesTmofferNotBoomReason::select('tmoffer_id')->where('not_boom_reason_id',87))
            ->get();

        $result=[];
        foreach ($tmoffers as $tmoffer){
            if($this->isTmofferValid($tmoffer->ID))
                $result[]=$tmoffer;
        }
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

    private function isTmofferValid($tmoffer_id){
        $tmf_subjects=TmfSubject::whereIn('id',
            TmofferCompanySubject::select('tmf_subject_id')
                ->where('tmoffer_id',$tmoffer_id)
        )->get();

        $emails=[];
        foreach ($tmf_subjects as $tmf_subject){
            $emails[]=$this->getTmfSubjectEmail($tmf_subject->id);
        }

        $emails=array_unique($emails);
        foreach ($emails as $email){
            $tmoffers=Tmoffer::whereIn('ID',TmofferCompanySubject::select('tmoffer_id')
                ->distinct()
                ->whereIn('tmf_subject_id',TmfSubjectContact::select('tmf_subject_id')
                    ->distinct()
                    ->where('contact_data_type_id',1)
                    ->where('contact','like',"%$email%")
                )
            )->get();
            foreach ($tmoffers as $tmoffer)
                if($tmoffer->DateConfirmed!='0000-00-00' && strpos($tmoffer->Status,'void')===false)
                    return false;
        }
        return true;
//        echo "tmoffer_id:$tmoffer_id emails:".implode(',',$emails).'<br/><hr><br/>';
    }

}
