<?php

namespace Home\Controller;
use Common\Api\MailApi;
use Common\Api\LingxiApi;

class SubscribeController extends HomeController {

    // 前台订阅
    public function add_subscribe() {
        $name = trim(I('post.name'));
        $email = trim(I('post.email'));
        $set_email_status = C('subscribe_send_subscribe_email');
        $owned_user_email = C('subscribe_owned_email');
        $subscribe_tag = C('subscribe_tag');
        $api_key = C('lingxiapi_lingxi_key');
        $api_secret = C('lingxiapi_lingxi_secret');
        $pattern = "/^([a-zA-Z0-9]{1,20})(([_-.])?([a-zA-Z0-9]{1,20}))*@([a-zA-Z0-9]{1,20})(([-_])?([a-zA-Z0-9]{1,20}))*(.[a-z]{2,4}){1,2}$/";
        if ( preg_match( $pattern, $email ) ) {
            return 0;
        }

        if(!$name || !$email) {
            return 0;
        }

        $user = array(
            "name" => $name,
            "email" => $email,
            "owned_user_email" => $owned_user_email,
            "tag" => $subscribe_tag,
            );

        // $id = D('subscribe')->where("email = '".$email."'")->find();
        // $result = D('subscribe')->add($user);
        $lingxi = new LingxiApi($api_key, $api_secret);
        $user_id = $lingxi->createContact($user);

        if($set_email_status) {
            $subject = C('subscribe_email_title');
            $message = C('subscribe_email_content');
            $message = str_replace('[#name#]', $user['name'], $message);
            MailApi::sendEmail('', $email, $subject, $message);
        }

        echo '1';
    }

}