<?php

namespace App\traits;
use Illuminate\Support\Facades\Auth;


trait SaveToSent
{
    private function saveToSentWithAttachment($from_user,$to_email,$to_fn,$subject,$message,$file_path=''){

        if(strlen($file_path)) {
            $content = file_get_contents($file_path);
            $content = chunk_split(base64_encode($content));
        }

        $imap_message=sprintf("From: %s <%s>\r\n",
            $from_user->FirstName.' '.$from_user->LastName,$from_user->Email);
        $uid = md5(uniqid(time()));

        // Headers for attachment
        $imap_message.="MIME-Version: 1.0\r\n".
            "Content-Type: multipart/mixed;\n boundary=\"$uid\"\r\n".
            "Content-Transfer-Encoding: base64\r\n".

            $imap_message.=sprintf("To: %s <%s>\r\n",$to_fn,$to_email);

        if((Auth::user() && Auth::user()->ID!=$from_user->ID) || !Auth::user())
            $imap_message.=sprintf("Bcc: %s <%s>\r\n",
                $from_user->FirstName.' '.$from_user->LastName,$from_user->Email);

        $imap_message.=sprintf("Subject: %s\r\n",$subject);
        $imap_message.="\r\n";
        $imap_message.="\r\n";
        $imap_message .= "--".$uid."\r\n";
        $imap_message .= "Content-type:text/html; charset=UTF-8\r\n";
        $imap_message .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $imap_message .= chunk_split(base64_encode($message))."\r\n\r\n";
        $imap_message .= "--".$uid."\r\n";
        if(strlen($file_path)){
            $imap_message .= "Content-Type: application/pdf; name=\"".basename($file_path)."\"\r\n";
            $imap_message .= "Content-Transfer-Encoding: base64\r\n";
            $imap_message .= "Content-Disposition: attachment; filename=\"" . basename($file_path) . "\"\r\n\r\n";
            $imap_message .= $content . "\r\n\r\n";
        }
        $imap_message .= "--".$uid."--";

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