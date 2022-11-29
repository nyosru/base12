<?php

namespace App\Http\Controllers;

use App\TmfSubject;
use App\TmfSubjectContact;
use Illuminate\Http\Request;

class ClientCabinetInitializer extends Controller
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
        $tmf_subject_objs=TmfSubject::whereNull('active_at')->get();

        echo "total:{$tmf_subject_objs->count()}<br/>";
        foreach ($tmf_subject_objs as $index=>$tmf_subject_obj){
            $tmf_subject_contact=TmfSubjectContact::where('tmf_subject_id',$tmf_subject_obj->id)
                ->where('contact_data_type_id',1)
                ->first();
            if($tmf_subject_contact) {
                $new_pswd = $this->generatePassword($tmf_subject_contact->contact);
                $salt = $this->getSalt();
                $hashed_password = crypt($new_pswd, $salt);
                echo "$index - client:{$tmf_subject_obj->first_name} {$tmf_subject_obj->last_name} email:{$tmf_subject_contact->contact} password:{$new_pswd} hash:{$hashed_password}<br/>";

/*                $new_rep->setUserPassword($hashed_password);
                $new_rep->setSalt($salt);
                $new_rep->setActiveAt(date('Y-m-d H:i:s'));
                $new_rep->save();*/
            }else{
                echo "$index - <span style='color:red'>client_id:{$tmf_subject_obj->id} does not have email!</span><br/>";
            }

        }
    }

    private function getSalt(){
        return '$2a$10$'.substr(str_replace('+', '.', base64_encode(pack('N4', mt_rand(), mt_rand(), mt_rand(),mt_rand()))), 0, 22) . '$';
    }

    private function generatePassword($email){
        $pswd = md5($email . time());
        $pswd=str_split($pswd);
        $new_pswd = "";
        for ($i = 0; $i < 5; $i++)
            if (rand(0, 1))
                $new_pswd .= strtoupper($pswd[rand(0, count($pswd)-1)]);
            else
                $new_pswd .= $pswd[rand(0, count($pswd)-1)];
        return $new_pswd;

    }

}
