<?php
namespace App\classes\tmoffer;

use App\Tmoffer;
use App\TmofferCompanySubject;
use App\TmfCompany;
use App\TmfSubject;

class CompanySubjectInfo
{
    private $tmoffer;
    private $client_info;

    public function __construct(Tmoffer $tmoffer)
    {
        $this->tmoffer=$tmoffer;
        $this->client_info=$this->initClientInfo();
    }

    public static function init(Tmoffer $tmoffer){
        return new self($tmoffer);
    }

    private function initClientInfo(){
        return [
            'tmf-subject-id'=>0,
            'firstname'=>'',
            'lastname'=>'',
            'gender'=>'',
            'company'=>'',
            'phone'=>'',
            'email'=>'',
            'skype'=>'',
            'whatsapp'=>'',
            'company_country'=>'',
            'company_state'=>'',
            'company_city'=>'',
            'company_address'=>'',
            'company_zipcode'=>'',
            'company_biztype'=>'',
            'company_incorp'=>'',
        ];
    }

    public function get(){
//        dd($this->tmoffer->toArray());
        $tmoffer_company_subject=TmofferCompanySubject::where('tmoffer_id',$this->tmoffer->ID)->first();
//        $tmoffer_company_subject=$this->tmoffer->tmofferCompanySubjectRows->first();
        if($tmoffer_company_subject){
//            dd($tmoffer_company_subject);
            $tmf_company=$tmoffer_company_subject->tmfCompany;
            if($tmf_company) {
                $this->client_info['company'] = $tmf_company->name;
                $this->client_info['company_country'] = $tmf_company->country->Name;
                if ($tmf_company->tmfState)
                    $this->client_info['company_state'] = $tmf_company->tmfState->tmf_state_name;
                $this->client_info['company_city'] = $tmf_company->city;
                $this->client_info['company_address'] = $tmf_company->address;
                $this->client_info['company_zipcode'] = $tmf_company->zip_code;
                $this->client_info['company_biztype'] = $tmf_company->tmfPersonType->client_type_name;
                $this->client_info['company_incorp'] = $tmf_company->incorp;
            }
            if($tmoffer_company_subject->tmf_subject_id)
                $tmf_subject=$tmoffer_company_subject->tmfSubject;
            else
                $tmf_subject=$tmf_company->tmfSubjects[0];
//            dd($tmf_subject->toArray());
            $this->client_info['firstname']=$tmf_subject->first_name;
            $this->client_info['lastname']=$tmf_subject->last_name;
            $this->client_info['gender']=$tmf_subject->gender;
            $tmf_subject_contacts=$tmf_subject->tmfSubjectContacts;
            $this->client_info['tmf-subject-id']=$tmf_subject->id;
//            dd($tmf_subject_contacts->toArray());
            foreach ($tmf_subject_contacts as $tmf_subject_contact)
                $this->client_info[$tmf_subject_contact->contactDataType->contact_data_type]=$tmf_subject_contact->contact;

        }
        return $this->client_info;
    }
}