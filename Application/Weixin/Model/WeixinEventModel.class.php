<?php
namespace Weixin\Model;
use Vendor\PLog;
use Think\Log;
use Think\Model;
class WeixinEventModel{

    /**
     * 文档
     * http://mp.weixin.qq.com/wiki/index.php?title=%E6%8E%A5%E6%94%B6%E4%BA%8B%E4%BB%B6%E6%8E%A8%E9%80%81
     * 
     */
    private $event_map = array(
        "subscribe" => "subscribe", //关注/取消关注事件
        "unsubscribe" => "unsubscribe",
        "scan" => "scan", //扫描带参数二维码事件 1. 用户未关注时，进行关注后的事件推送
        "location" => "location",  //上报地理位置事件
        "click" => "click",  //点击菜单拉取消息时的事件推送
        "view" => "view",   //点击菜单跳转链接时的事件推送
        'masssendjobfinish' => 'msg_send_job_finish', //群发事件推送
    );

    public function getWeixinRes($event, $data){
            
        //这个event竟然还分大小写，有的大写有的小写....
        $event_name = strtolower($event['event']);
        $method = $this->event_map[$event_name];
        if($method){
            return $this->$method($event, $data);
        }
    }

    // <xml>
    // <ToUserName><![CDATA[toUser]]></ToUserName>
    // <FromUserName><![CDATA[FromUser]]></FromUserName>（一个OpenID）
    // <CreateTime>123456789</CreateTime>
    // <MsgType><![CDATA[event]]></MsgType>
    // <Event><![CDATA[subscribe]]></Event>
    // </xml>
    public function subscribe($event, $data){
        $openid = $data['FromUserName'];

        //如果event中带有key，那么用这个key查找一下用户信息,并且吧openid设置上
        if($event['key'] && strpos($event['key'], "qrscene_") === 0){
            $scene_id = str_replace("qrscene_", "", $event['key']);
            $user = D("User")->getById($scene_id);
            if($user){
                if($openid){
                    D("User")->where(array("openid" => $openid))->setField("openid", "");
                }
                $user['openid'] = $openid;
                D("User")->save($user);
            }
            $first_reply =C("custom_weixin_first_bind_reply");
        }
        if(!$first_reply){
            $first_reply =C("custom_weixin_first_reply");
        }
        return array("type" => "text", "data" => $first_reply);
    }

    public function unsubscribe($event, $data){
        // $openid = $data['FromUserName'];
        // if($openid){
        //     D("Users")->delete($openid);
        // }
    }

    public function scan($event, $data){
        if($event['key']){
            $openid = $data['FromUserName'];

            //如果event中带有key，那么用这个key查找一下用户信息,并且吧openid设置上
            $scene_id = $event['key'];
            $user = D("User")->getById($scene_id);
            if($user){
                if($openid){
                    D("User")->where(array("openid" => $openid))->setField("openid", "");
                }
                $user['openid'] = $openid;
                D("User")->save($user);
                $first_reply =C("custom_weixin_first_bind_reply");
            }
            if(!$first_reply){
                $first_reply =C("custom_weixin_first_reply");
            }
            return array("type" => "text", "data" => $first_reply);
        }
    }
    public function location($event, $data){
        
    }

    public function click($event, $data){
        // $this->menu_click($event, $data);
        // $menu_key = D("Menu")->formatMenuKey($event['key']);
        // $action = D("Type")->getActionByType($menu_key['type']);
        // $res = $action->getWeixinRes($menu_key['type_id']);
        // return $res;
    }
    public function view($event, $data){
        // $this->menu_click($event, $data);
    }

    private function menu_click($event, $data){
        // if($event['event'] == 'click'){
        //     $menu_id = D("Menu")->getMenuIdByMenuKey($event['key']);
        // }else{
        //     $menu = D("Menu")->getByLink($event['key']);
        //     $menu_id = $menu['id'];
        // }
        // if($menu_id){
        //     D("MenuStat")->add(array("menu_id" => $menu_id, "time" => $data['CreateTime'], "openid" => $data['FromUserName']));
        // }
    }

    public function msg_send_job_finish ($event, $data) {
        // $param['total_count'] = $data['TotalCount'];
        // $param['sended_count'] = $data['SentCount'];
        // $param['error_count'] = $data['ErrorCount'];
        // $param['filter_count'] = $data['FilterCount'];
        // $param['msg_id'] = $data['MsgID'];
        // if ($data['Status'] == 'send success') {
        //     $param['status'] = 'success';
        // } else if ($data['Status'] == 'send fail') {
        //     $param['status'] = 'fail';
        // } else {
        //     $res = preg_match('/\d+/', $data['Status'], $match);
        //     if ($res) {
        //         $param['err_code'] = $match[0];
        //         $param['status'] = 'fail';
        //     }
        // }
        // D('MassSend')->where(array('msg_id' => $data['MsgID']))->save($param);
        
    }
    
}