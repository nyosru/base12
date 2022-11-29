<?php

namespace App\Http\Controllers;

use App\TmfSubject;
use App\TmfSubjectContact;
use App\Tmoffer;
use App\TmofferCompanySubject;
use Illuminate\Http\Request;

class ShoppingCartFinderController extends Controller
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
        return view('shopping-cart-finder.index');
    }

    public function find(Request $request){
        $tmf_subject_objs=$this->getTmfSubjectObjsByRequest($request);

        if($tmf_subject_objs && $tmf_subject_objs->count()){
            $sc_data=$this->prepareScData($tmf_subject_objs);
        }else
            $sc_data=[];
        return view('shopping-cart-finder.result-table',compact('sc_data'));
    }

    private static function cmp($a, $b)
    {
//        var_dump($a);
        if ($a['created_at']->format('Y-m-d H:i:s') == $b['created_at']->format('Y-m-d H:i:s'))
            return 1;
        return ($a['created_at']->format('Y-m-d H:i:s') > $b['created_at']->format('Y-m-d H:i:s') ? -1 : 1);
    }


        private function prepareScData($tmf_subject_objs){
        $data=[];
        foreach ($tmf_subject_objs as $tmf_subject_obj){
            $tmoffer_company_subject_objs=TmofferCompanySubject::where('tmf_subject_id',$tmf_subject_obj->id)->get();
            if($tmoffer_company_subject_objs && $tmoffer_company_subject_objs->count())
                foreach ($tmoffer_company_subject_objs as $tmoffer_company_subject_obj){
                        $tmoffer=Tmoffer::find($tmoffer_company_subject_obj->tmoffer_id);
                        if($tmoffer && $tmoffer->DateConfirmed=='0000-00-00') {
                            $phone_row=TmfSubjectContact::where('tmf_subject_id', $tmf_subject_obj->id)
                                ->where('contact_data_type_id', 4)
                                ->first();
                            $email_row=TmfSubjectContact::where('tmf_subject_id', $tmf_subject_obj->id)
                                ->where('contact_data_type_id', 1)
                                ->first();
                            $data[] = [
                                'client' => $tmf_subject_obj->first_name . ' ' . $tmf_subject_obj->last_name,
                                'phone' => ($phone_row?$phone_row->contact:''),
                                'email'=> ($email_row?$email_row->contact:''),
                                'tmoffer_login' => $tmoffer->Login,
                                'created_at' => \DateTime::createFromFormat('Y-m-d H:i:s',$tmoffer->created_date),
                            ];
                        }
                }
        }
        if(count($data))
            usort($data,['App\Http\Controllers\ShoppingCartFinderController','cmp']);
        return $data;
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


}
