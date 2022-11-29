<?php

namespace App\Http\Controllers;

use App\TmfBooking;
use App\TmfClientTmsrTmoffer;
use App\Tmfsales;
use App\TmfSubject;
use App\TmfSubjectContact;
use App\Tmoffer;
use App\TmofferCompanySubject;
use App\Workflow;
use App\Workflowclass;
use App\WorkflowHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingsSearcherController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $request=new Request();
//        $request->name='Ruth Zh';
//        $request->name='';
//        $request->phone='';
//        $request->email='Trademark Attorney';
//        dd($this->find($request));
        return view('bookings-searcher.index');
    }

    private function getTmfSubjectObjsByRequest(Request $request){
        $tmf_subject_contact_objs0=null;
        if($request->email && strlen($request->email))
            $tmf_subject_contact_objs0=TmfSubjectContact::select('tmf_subject_id')
                ->where('contact_data_type_id',1)
                ->where('contact','like','%'.$request->email.'%');
        $tmf_subject_contact_objs1=null;
        if($request->phone && strlen($request->phone))
            $tmf_subject_contact_objs1=TmfSubjectContact::select('tmf_subject_id')
                ->where('contact_data_type_id',4)
                ->where('contact','like','%'.$request->phone.'%');
        $tmf_subject_objs=null;
        if($request->name && strlen($request->name)) {
            $tmf_subject_objs = TmfSubject::where(function($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->name . '%')
                    ->orWhere('last_name', 'like', '%' . $request->name . '%')
                    ->orWhereRaw('concat(first_name," ",last_name) like "%' . $request->name . '%"');
            });
            if($tmf_subject_contact_objs0)
                $tmf_subject_objs->whereIn('id',$tmf_subject_contact_objs0);
            if($tmf_subject_contact_objs1)
                $tmf_subject_objs->whereIn('id',$tmf_subject_contact_objs1);
        }else{
            if($tmf_subject_contact_objs0 && $tmf_subject_contact_objs1)
                $tmf_subject_objs=TmfSubject::whereIn('id',$tmf_subject_contact_objs0)
                    ->whereIn('id',$tmf_subject_contact_objs1);
            elseif ($tmf_subject_contact_objs0)
                $tmf_subject_objs=TmfSubject::whereIn('id',$tmf_subject_contact_objs0);
            elseif ($tmf_subject_contact_objs1)
                $tmf_subject_objs=TmfSubject::whereIn('id',$tmf_subject_contact_objs1);
        }
        if($tmf_subject_objs)
            return $tmf_subject_objs->get();
        return null;
    }

    private function getTmfBookingByTmofferId($tmoffer_id){
        return TmfBooking::whereIn('tmf_client_tmsr_tmoffer_id',
            TmfClientTmsrTmoffer::select('id')
                ->where('tmoffer_id',$tmoffer_id)
        )
            ->where('booked_date','!=','0000-00-00 00:00:00')
            ->where('sales_id','!=',0)
            ->orderBy('id','desc')
            ->first();
    }

    private function prepareBookingsData($tmf_subject_objs){
        $data=[];
        foreach ($tmf_subject_objs as $tmf_subject_obj){
            $tmoffer_company_subject_objs=TmofferCompanySubject::where('tmf_subject_id',$tmf_subject_obj->id)->get();
            if($tmoffer_company_subject_objs && $tmoffer_company_subject_objs->count())
                foreach ($tmoffer_company_subject_objs as $tmoffer_company_subject_obj){
                    $tmf_booking=$this->getTmfBookingByTmofferId($tmoffer_company_subject_obj->tmoffer_id);
                    if($tmf_booking){
                        $tmoffer=Tmoffer::find($tmoffer_company_subject_obj->tmoffer_id);
                        $tmfsales=Tmfsales::find($tmf_booking->sales_id);
                        if($tmoffer && $tmfsales) {
                            $phone_row=TmfSubjectContact::where('tmf_subject_id', $tmf_subject_obj->id)
                                ->where('contact_data_type_id', 4)
                                ->first();
                            $email_row=TmfSubjectContact::where('tmf_subject_id', $tmf_subject_obj->id)
                                ->where('contact_data_type_id', 1)
                                ->first();

                            $personal_flowchart_link='';
                            if(in_array(Auth::user()->ID,[1,53])){
                                $workflow_history_last_block=WorkflowHistory::whereIn('tmf_client_tmsr_tmoffer_id',
                                        TmfClientTmsrTmoffer::select('id')->where('tmoffer_id',$tmoffer->ID)
                                    )
                                    ->orderBy('id','desc')
                                    ->first();
                                if($workflow_history_last_block){
                                    $workflowclass=Workflowclass::whereIn('id',
                                        Workflow::select('workflowclass_id')
                                            ->where('id',$workflow_history_last_block->workflow_id)
                                    )
                                        ->first();
                                    if($workflowclass)
                                        $personal_flowchart_link=sprintf('https://trademarkfactory.com/mlcclients/flowchart.php?tmoffer_id=%d&last_action_id=%s&wf_root=%d',
                                            $tmoffer->ID,
                                            $workflow_history_last_block->last_action_id,
                                            $workflowclass->workflow_root_id);
                                }
                            }

                            $data[] = [
                                'booking_datetime' => $tmf_booking->booked_date,
                                'client' => $tmf_subject_obj->first_name . ' ' . $tmf_subject_obj->last_name,
                                'phone' => ($phone_row?$phone_row->contact:''),
                                'email'=> ($email_row?$email_row->contact:''),
                                'closer' => $tmfsales->FirstName . ' ' . $tmfsales->LastName,
                                'tmoffer_login' => $tmoffer->Login,
                                'personal_flowchart_link'=>$personal_flowchart_link
                            ];
                        }
                    }
                }
        }
        return $data;
    }

    public function find(Request $request){
//        return $request->toArray();
        $tmf_subject_objs=$this->getTmfSubjectObjsByRequest($request);
//        return $tmf_subject_objs->toArray();
        if($tmf_subject_objs && $tmf_subject_objs->count()){
            $bookings_data=$this->prepareBookingsData($tmf_subject_objs);
        }else
            $bookings_data=[];
        return view('bookings-searcher.result-table',compact('bookings_data'));
    }

}
