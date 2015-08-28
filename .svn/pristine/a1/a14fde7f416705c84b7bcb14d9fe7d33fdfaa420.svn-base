<?php
namespace Weixin\Controller;
use Think\Controller;
use Vendor\PLog;
use Think\Log;
use Common\Controller\BaseController;
class ReceiverController extends BaseController {

    //接受微信消息
    function index(){
        $is_active_open = C("custom_weixin_active_open");
        if ($is_active_open){
            PLog::write('Receive Validation Msg :' . print_r($_GET, true) , Log::INFO);
            $result = D("Weixin")->valid();
        }else{
            PLog::write('Result is :' . $result , Log::INFO);
            // var_dump(D("Weixin"));
            D("Weixin")->doReceive();
        }
    }
}