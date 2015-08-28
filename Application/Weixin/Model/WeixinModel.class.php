<?php
namespace Weixin\Model;
use Think\Model;
use Vendor\PLog;
use Think\Log;
use Vendor\Wechat;
//管理微信的各种操作
class WeixinModel{

    private $weixin;
    private $operation_map = array(
        // array("KeywordReply", "weixin_auto_reply"),
        // array("Chats", "add_chat"), //chat应该总是最后一个，因为没有返回
        );

    private $event_map = array('CLICK', 'VIEW', 'LOCATION', 'SCAN', 'UNSUBSCRIBE');

    public function __construct(){
        $options['appid'] = C('custom_weixin_appid');
        $options['appsecret'] = C('custom_weixin_appsecret');
        // PLog::write('Result is :' . $result , Log::INFO);
        $this->weixin = new Wechat($options);
    }

    public function valid(){
        $this->weixin->valid();
    }

    /**
     * 只有高级接口才能获取到
     */
    public function getUserInfo($openid){
        return $this->weixin->getUserInfo($openid);
    }

    public function getOauthRedirect($callback,$state='',$scope='snsapi_userinfo'){
        return $this->weixin->getOauthRedirect($callback, $state, $scope);
    }

    public function getOauthAccessToken(){
        return $this->weixin->getOauthAccessToken();
    }

    public function publish_menu($menu){
        $msg = $this->weixin->createMenu($menu);
        return $msg;
    }

    /**
     * 接受微信非验证信息
     * 首先根据msg type 进行判定，分为Event类型和非event类型
     * Event类型交给WeixinEventModel处理，非event类型循环map
     */
    public function doReceive(){
        $this->weixin->getRev();
        $msg_type = $this->weixin->getRevType();
        $data = $this->weixin->getRevData();
        PLog::write('----Data----:' . print_r($data, true) , Log::INFO);
        if($msg_type == 'event'){//事件操作
            $event = $this->weixin->getRevEvent();
            PLog::write('----Event----:' . print_r($event, true) , Log::INFO);
            $event['event'] = strtolower($event['event']);
            $res = D("WeixinEvent")->getWeixinRes($event, $data);
        }else{//用户输入
            foreach ($this->operation_map as $method_class) {
                $class = $method_class[0];
                $method = $method_class[1];
                PLog::write('----Involve----:' . $class . "->" . $method . "()" , Log::INFO);

                $res = D($class)->$method($data);
                if($res){
                    break;
                }
            }
        }
        if($res){
            if(!$res){
                $res = array("type" => "text", "data" => "");
            }
            $this->set_res($res);
            $this->weixin->reply();
            PLog::write('----Reply----:' . print_r($res, true) , Log::INFO);
            PLog::write('-----------------------------' , Log::INFO);
        }
    }

    public function set_res($res){
        if($res['type'] == "text"){
            $this->weixin->text($res['data']);
        }else if($res['type'] == 'news'){
            $this->weixin->news($res['data']);
        }
    }

    public function uploadFile ($filename) {
        return $this->weixin->uploadfile($filename);
    }
    
    public function uploadNews ($data) {
        return $this->weixin->uploadNews($data);
    }
    

    public function getErrorCode(){
        return $this->weixin->errCode;
    }

    public function getErrorMsg(){
        return $this->weixin->errMsg;
    }

    public function sendCustomMessage($type, $openid, $data){
        if($type == 'text'){
            $content = $data;
            $param = array(
                'touser' => $openid,
                'msgtype' => 'text',
                'text' => array("content" => $content),
                );
            $result = $this->weixin->sendCustomMessage($param);
            return $result;
        }
    }
    /**
     * 获取全部关注者列表
     * 
     */
    public function getUserList($num=0){
        $next_openid = "";
        $data = $this->weixin->getUserList($next_openid);
        $all_fans = array();
        $i = 0;
        while (($fans = $this->weixin->getUserList($next_openid))) {
            $i++;
            if($i > 10){ //做个保险，防止无止境调用，因为超过1w人关注的微信还没测试过.....
                break;
            }
            if($fans['count'] == 0){
                break;
            }else{
                $next_openid = $fans['next_openid'];
                $all_fans = array_merge($all_fans, $fans['data']['openid']);
            }
        }
        return $all_fans;
    }

    public function massSend ($post_data) {
        return $this->weixin->massSend($post_data);
    }
    
    public function getGroup () {
        return $this->weixin->getGroup();
    }
}