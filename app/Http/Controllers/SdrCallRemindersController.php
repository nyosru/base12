<?php

namespace App\Http\Controllers;

use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\Tmfsales;
use App\TmfSubjectContact;
use App\TmofferCompanySubject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SdrCallRemindersController extends Controller
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

    private static function bcmp($a, $b)
    {
//        var_dump($a);
        if ($a['tmf-booking']->booked_date == $b['tmf-booking']->booked_date)
            return 1;
        return ($a['tmf-booking']->booked_date < $b['tmf-booking']->booked_date ? -1 : 1);
    }


    public function index()
    {
        $data=$this->initData();
        return view('sdr-call-reminders.index',compact('data'));
    }

    private function initData(){
        $tmf_booking_objs=TmfBooking::where('booked_date','>=',Carbon::now()->format('Y-m-d 00:00:00'))
            ->whereRaw('TIMESTAMPDIFF(HOUR, created_at,booked_date)>=36')
//            ->where('sales_id','!=',1)
            ->get();
        $data=[
            'unhandled'=>[],
            'in progress'=>[],
            'finished'=>[],
        ];
        foreach($tmf_booking_objs as $tmf_booking_obj){
            $last_tmf_booking=TmfBooking::where('tmf_client_tmsr_tmoffer_id',$tmf_booking_obj->tmf_client_tmsr_tmoffer_id)
                ->orderBy('id','desc')
                ->first();
            if($last_tmf_booking && $last_tmf_booking->booked_date!='0000-00-00'){
                $tmoffer_company_subject=TmofferCompanySubject::whereIn('tmoffer_id',TmfClientTmsrTmoffer::select('tmoffer_id')
                    ->where('id',$last_tmf_booking->tmf_client_tmsr_tmoffer_id)
                )
                    ->orderBy('id','desc')
                    ->first();
                if($tmoffer_company_subject){
                    $tmf_subject=$tmoffer_company_subject->tmfSubject;
                    $tmf_subject_contact=TmfSubjectContact::where('tmf_subject_id',$tmf_subject->id)->where('contact_data_type_id',4)->first();
                    if($last_tmf_booking->sdr_id){
                        if($last_tmf_booking->sdr_finished_at)
                            $index='finished';
                        else
                            $index='in progress';
                    }else
                        $index='unhandled';
                    $data[$index][]=[
                        'tmf-booking'=>$last_tmf_booking,
                        'fn'=>$tmf_subject->first_name,
                        'ln'=>$tmf_subject->last_name,
                        'phone'=>$tmf_subject_contact->contact,
                        'tmoffer-id'=>$tmoffer_company_subject->tmoffer_id
                    ];
                }
            }
        }
        foreach ($data as $key=>$el)
            usort($data[$key],['App\Http\Controllers\SdrCallRemindersController','bcmp']);

        return $data;
    }

    public function getCurrentProgress(){
        $data=$this->initData();
        return view('sdr-call-reminders.current-progress',compact('data'));
    }

    public function newStatus(Request $request){
        $tmf_booking=TmfBooking::find($request->tmf_booking_id);
        if($tmf_booking) {
            switch ($request->status) {
                case 'unhandled':
                    $tmf_booking->sdr_id=NULL;
                    $tmf_booking->sdr_claimed_at=NULL;
                    $tmf_booking->sdr_finished_at=NULL;
                    $tmf_booking->save();
                    break;
                case 'in progress':
                    $tmf_booking->sdr_id=Auth::user()->ID;
                    $tmf_booking->sdr_claimed_at=Carbon::now()->format('Y-m-d H:i:s');
                    $tmf_booking->sdr_finished_at=NULL;
                    $tmf_booking->save();
                    break;
                case 'finished':
                    $tmf_booking->sdr_id=Auth::user()->ID;
                    if(!$tmf_booking->sdr_claimed_at)
                        $tmf_booking->sdr_claimed_at=Carbon::now()->format('Y-m-d H:i:s');
                    $tmf_booking->sdr_finished_at=Carbon::now()->format('Y-m-d H:i:s');
                    $tmf_booking->save();
                    break;
            }
            return 'DONE';
        }
        return '';
    }

    public function getCallsHistory(Request $request){
        $data=[];
        $tmf_bookings=TmfBooking::whereNotNull('sdr_id')->whereNotNull('sdr_finished_at')->orderBy('id','desc')->get();
        foreach($tmf_bookings as $tmf_booking_obj){
                $tmoffer_company_subject=TmofferCompanySubject::whereIn('tmoffer_id',TmfClientTmsrTmoffer::select('tmoffer_id')
                    ->where('id',$tmf_booking_obj->tmf_client_tmsr_tmoffer_id)
                )
                    ->orderBy('id','desc')
                    ->first();
                if($tmoffer_company_subject){
                    $tmf_subject=$tmoffer_company_subject->tmfSubject;
                    $tmf_subject_contact=TmfSubjectContact::where('tmf_subject_id',$tmf_subject->id)->where('contact_data_type_id',4)->first();
                    $data[]=[
                        'tmf-booking'=>$tmf_booking_obj,
                        'fn'=>$tmf_subject->first_name,
                        'ln'=>$tmf_subject->last_name,
                        'phone'=>$tmf_subject_contact->contact,
                        'tmoffer-id'=>$tmoffer_company_subject->tmoffer_id,
                        'closer'=>($tmf_booking_obj->sales_id?Tmfsales::find($tmf_booking_obj->sales_id):null)
                    ];
                }
        }

        return view('sdr-call-reminders.calls-history-table',compact('data'))->render();

    }
}
