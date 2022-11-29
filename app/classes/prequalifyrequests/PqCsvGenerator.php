<?php
namespace App\classes\prequalifyrequests;

use App\PrequalifyRequest;
use App\TmfSubject;
use App\Tmoffer;
use Carbon\Carbon;

class PqCsvGenerator
{

    private const BadFit=2;
    public function run(){
        $result=$this->getData();
        $this->downloadFile($result);
    }

    private function getData(){
        $result=[
            [
                'first_name'=>'first_name',
                'last_name'=>'last_name',
                'email'=>'email',
                'raised_hand'=>'raised_hand',
                'client_number_of_pq_requests'=>'client_number_of_pq_requests',
                'client_first_pq_request_date'=>'client_first_pq_request_date',
                'client_last_pq_request_date'=>'client_last_pq_request_date'
            ]
        ];
        $tmf_subject_ids=PrequalifyRequest::select('tmf_subject_id')->distinct()->get()->pluck('tmf_subject_id')->toArray();
        foreach ($tmf_subject_ids as $tmf_subject_id){
            $tmf_subject=TmfSubject::find($tmf_subject_id);
            $prequalify_request_objs=PrequalifyRequest::where('tmf_subject_id',$tmf_subject_id)->get();
            if(
                $this->hasBooking($prequalify_request_objs)==false &&
                $this->hasBoom($prequalify_request_objs)==false &&
                $this->isBadFit($prequalify_request_objs)==false &&
                $tmf_subject->unsubscribed
            )
                $result[]=[
                    'first_name'=>$tmf_subject->first_name,
                    'last_name'=>$tmf_subject->last_name,
                    'email'=>$tmf_subject->tmfSubjectContacts()
                        ->where('contact_data_type_id',1)
                        ->first()
                        ->contact,
                    'raised_hand'=>'yes',
                    'client_number_of_pq_requests'=>PrequalifyRequest::where('tmf_subject_id',$tmf_subject_id)->count(),
                    'client_first_pq_request_date'=>\DateTime::createFromFormat('Y-m-d H:i:s',
                        PrequalifyRequest::where('tmf_subject_id',$tmf_subject_id)
                            ->orderBy('created_at','asc')
                            ->first()
                            ->created_at
                    )->format('m/d/Y'),
                    'client_last_pq_request_date'=>\DateTime::createFromFormat('Y-m-d H:i:s',
                        PrequalifyRequest::where('tmf_subject_id',$tmf_subject_id)
                            ->orderBy('created_at','desc')
                            ->first()
                            ->created_at
                    )->format('m/d/Y')
                ];
        }
        return $result;
    }

    private function hasBooking($prequalify_request_objs){
        $result=0;
        foreach ($prequalify_request_objs as $prequalify_request_obj) {
            $tmoffer=$prequalify_request_obj->tmoffer;
            if ($tmoffer->tmfClientTmsrTmoffer && $tmoffer->tmfClientTmsrTmoffer->tmfBookings)
                $result+=$tmoffer->tmfClientTmsrTmoffer->tmfBookings->count();
            if($result>0)
                return true;
        }
        return false;
    }

    private function hasBoom($prequalify_request_objs){
        foreach ($prequalify_request_objs as $prequalify_request_obj) {
            $tmoffer=$prequalify_request_obj->tmoffer;
            if($tmoffer->tmofferBin && $tmoffer->tmofferBin->need_capture == 0)
                return true;
        }
        return false;
    }

    private function isBadFit($prequalify_request_objs){
        foreach ($prequalify_request_objs as $prequalify_request_obj)
            if($prequalify_request_obj->lead_status_id==self::BadFit)
                return true;
        return false;
    }

    private function downloadFile($data){
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=pq-sendgrid-".Carbon::now()->getTimestamp().".csv");
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
        header("Pragma: no-cache"); // HTTP 1.0
        header("Expires: 0"); // Proxies
        $output = fopen("php://output", "w");
        foreach($data as $el)
            fputcsv($output, [
                'first_name'=>$el['first_name'],
                'last_name'=>$el['last_name'],
                'email'=>$el['email'],
                'raised_hand'=>$el['raised_hand'],
                'client_number_of_pq_requests'=>$el['client_number_of_pq_requests'],
                'client_first_pq_request_date'=>$el['client_first_pq_request_date'],
                'client_last_pq_request_date'=>$el['client_last_pq_request_date']
            ]);

    }

}