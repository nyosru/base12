<?php

namespace App\Http\Controllers;

use App\PrequalifyRequest;
use App\TmfSubject;
use Illuminate\Http\Request;

class PqFinderController extends Controller
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
        $left_nav_bar=view('pq-finder.left-nav-bar')->render();
        return view('pq-finder.index',compact('left_nav_bar'));
    }

    public function search(Request $request){
        if($request->name || $request->email || $request->phone){
            $tmf_subject=TmfSubject::select('tmf_subject.id');
            if($request->email || $request->phone) {
                $tmf_subject->join('tmf_subject_contact', 'tmf_subject.id', 'tmf_subject_contact.tmf_subject_id');
                if($request->email) {
                    $tmf_subject->whereRaw(sprintf('tmf_subject_contact.contact like"%%%s%%"',$request->email));
                    if($request->phone)
                        $tmf_subject->orWhereRaw(sprintf('tmf_subject_contact.contact like "%%%s%%"',$request->phone));
                }elseif($request->phone)
                    $tmf_subject->whereRaw(sprintf('tmf_subject_contact.contact like "%%%s%%"',$request->phone));
            }
            if($request->name)
                $tmf_subject->whereRaw("lower(concat(first_name, ' ', last_name)) like '%".strtolower($request->name)."%' ");
            $prequalify_request_objs=PrequalifyRequest::whereIn('tmf_subject_id',$tmf_subject)->get();
            $data=[];
            foreach ($prequalify_request_objs as $prequalify_request_obj){
                $data[]=[
                    'id'=>$prequalify_request_obj->id,
                    'request_date'=>\DateTime::createFromFormat('Y-m-d H:i:s',$prequalify_request_obj->created_at)->format('M j, Y \<\b\r\/\>\@ H:i'),
                    'prospect'=>$prequalify_request_obj->tmfSubject->first_name.' '.$prequalify_request_obj->tmfSubject->last_name,
                    'sdr'=>($prequalify_request_obj->handled_tmfsales_id?$prequalify_request_obj->tmfsales->FirstName.' '.$prequalify_request_obj->tmfsales->LastName:'N/A'),
                    'custom-info'=>($prequalify_request_obj->lead_status_id?$prequalify_request_obj->leadStatus->name:'UNCLAIMED')
                ];
            }

            return view('pq-finder.applications-list',compact('data'));
        }
        return '';
    }

    public function loadDetails(Request $request){

    }

}
