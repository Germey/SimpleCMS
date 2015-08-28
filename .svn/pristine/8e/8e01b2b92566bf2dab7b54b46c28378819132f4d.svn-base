<?php

namespace Common\Api;
use Vendor\Mail\Mailer;

class MailApi {
    static function sendEmail($from, $to, $subject, $message, $options=null, $bcc=array()){
 
        if(!$from) {
            $from['host']  = D('Config')->getConfigValue('smtp_host');
            $from['port']  = D('Config')->getConfigValue('smtp_port');
            $from['email'] = D('Config')->getConfigValue('smtp_user');
            $from['pass']  = D('Config')->getConfigValue('smtp_pass');
            $from['ssl']   = D('Config')->getConfigValue('smtp_ssl');
            $from['name']  = D('Config')->getConfigValue('smtp_username');
            $from['from']  = D('Config')->getConfigValue('smtp_user');
            $from['reply'] = D('Config')->getConfigValue('smtp_user');
        }
        $signature = D('Config')->getConfigValue('signature');
        if($signature) {
            $message .= '<br /><br />' . $signature;
        }
        return Mailer::SmtpMail($from, $to, $subject, $message, $options, $bcc);

    }

}