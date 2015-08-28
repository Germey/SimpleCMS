<?php

namespace Home\Controller;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class ValidatorController extends HomeController {

    public function check_register_code() {
        $v = $_REQUEST['v'];
        if ($v == C('register_code')) {
            $result['error'] = 0;
            $result['data'] = 0;
        }else{
            $result['error'] = 1;

        }
        die(json_encode($result));
    }

    public function check_email(){
        $v = $_REQUEST['v'];
        $user_id = $_REQUEST["n"];
        $user_id = str_replace("id-", "", $user_id);
        $u = M("User")->getByEmail($v);
        if ( empty($u) || $u['id'] == $user_id ) {
            $result['error'] = 0;
            $result['data'] = 0;
        }else{
            $result['error'] = 1;
        }
        die(json_encode($result));
    }

    public function check_register_username(){
        $v = $_REQUEST['v'];
        $user_id = $_REQUEST["n"];
        $user_id = str_replace("id-", "", $user_id);
        $u = M("User")->getByUsername($v);
        if ( empty($u) || $u['id'] == $user_id ) {
            $result['error'] = 0;
            $result['data'] = 0;
        }else{
            $result['error'] = 1;
        }
        die(json_encode($result));
    }
}
?>