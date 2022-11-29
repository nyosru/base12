<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tmfsales;
use App\OutreachEmailLog;
use App\OutreachEmailTemplate;
use Illuminate\Support\Facades\Auth;
use App\Mail\OutreachEmail1Sent;
use Illuminate\Support\Facades\Mail;

class OutreachEmail1Controller extends Controller
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
//        echo date('Y-m-d H:i:s').'<br/>';
/*        $from_user=Tmfsales::find(53);
        $m=new OutreachEmail1Sent($from_user->Email,
            $from_user->FirstName.' '.$from_user->LastName,
            'test subject',
            'first laravel message');
        Mail::to([['email'=>'vitaly.polukhin@gmail.com','name'=>'VP']])
            ->send($m);
        $this->saveToSent($from_user,'vitaly.polukhin@gmail.com','VP','test subj','test message');
        exit;*/

        $users=Tmfsales::where([
            ['Visible','=',1],
            ['ID','!=',70]
        ])
            ->orderBy('Level','desc')
            ->get();
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $email_templates=OutreachEmailTemplate::all();

        $images=$this->getDirContents('/var/www/html/trademarkfactory.com/img/bronson');
//        sort($images);
//        dd($images);
        return view('outreach-email-1.index',
            compact('users',
                'arrContextOptions',
                'images','email_templates')
        );
    }

    private function getDirContents($dir) {
        $results=[];
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = basename($path);
            } /*else if ($value != "." && $value != "..") {
                getDirContents($path, $results);
                $results[] = $path;
            }*/
        }

        return $results;
    }

    public function sendEmail(Request $request)
    {
        if($request->firstname &&
            $request->email &&
            $request->subject &&
            $request->message &&
            $request->from){

            $from_user=Tmfsales::find($request->from);
//            dd($from_user->toArray());
            $emails=explode(',',$request->email);

            $original_message=$request->message;
            if(Auth::user()->ID==$from_user->ID){
                foreach ($emails as $email) {
                    $log_id=$this->saveLog($request,$email);
                    $message=str_replace($request->img,'https://trademarkfactory.com/img/video-'.$log_id.'.jpg',$original_message);
                    Mail::to([['email' => trim($email), 'name' => $request->firstname]])
                        ->send(new OutreachEmail1Sent($from_user->Email,
                                $from_user->FirstName . ' ' . $from_user->LastName,
                                $request->subject,
                                $message)
                        );
                    $this->saveToSent($from_user,trim($email),$request->firstname,$request->subject,$request->message);
                }
            }else
                foreach ($emails as $email) {
                    $log_id=$this->saveLog($request,$email);
                    $message=str_replace($request->img,'https://trademarkfactory.com/img/video-'.$log_id.'.jpg',$original_message);
                    Mail::to([['email' => trim($email), 'name' => $request->firstname]])
                        ->bcc($from_user->Email, $from_user->FirstName . ' ' . $from_user->LastName)
                        ->send(new OutreachEmail1Sent($from_user->Email,
                                $from_user->FirstName . ' ' . $from_user->LastName,
                                $request->subject,
                                $message)
                        );
                    $this->saveToSent($from_user,trim($email),$request->firstname,$request->subject,$request->message);
                }

            return 'Sent';
        }
        return '';
    }

    private function saveLog(Request $request,$email){
        $obj=new OutreachEmailLog();
        $obj->firstname=$request->firstname;
        $obj->image=basename($request->img);
        $obj->email=$email;
        $obj->from_tmfsales_id=$request->from;
        $obj->outreach_email_template_id=$request->email_template;
        $obj->who_sent=Auth::user()->ID;
        $obj->created_at=date('Y-m-d H:i:s');
        $obj->save();
        return $obj->id;
    }

    private function saveToSent($from_user,$to_email,$to_fn,$subject,$message){
        $imap_message=sprintf("From: %s <%s>\r\n",
            $from_user->FirstName.' '.$from_user->LastName,$from_user->Email);
        $imap_message.="MIME-Version: 1.0\r\n".
                "Content-Type: text/html; charset=UTF-8\r\n".
                "Content-Transfer-Encoding: base64\r\n";
        $imap_message.=sprintf("To: %s <%s>\r\n",$to_fn,$to_email);
        if(Auth::user()->ID!=$from_user->ID)
            $imap_message.=sprintf("Bcc: %s <%s>\r\n",
                $from_user->FirstName.' '.$from_user->LastName,$from_user->Email);
        $imap_message.=sprintf("Subject: %s\r\n",$subject);
        $imap_message.="\r\n";
        $imap_message.=base64_encode($message)."\r\n";

        $host="mail.trademarkfactory.com/novalidate-cert";
        $mailbox='{'.$host.'}Sent';
        $stream = imap_open($mailbox, $from_user->Email, $from_user->passw);
        imap_append($stream, $mailbox, $imap_message);

        $str = imap_last_error();
        $result='';
        if ($str)
            $result.=print_r($str,true);
        else
            $result.='Message sent';
        imap_close($stream);

    }


}
