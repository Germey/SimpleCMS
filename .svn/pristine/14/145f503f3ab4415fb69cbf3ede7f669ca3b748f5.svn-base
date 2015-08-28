<?php

namespace Common\Api;

class LingxiApi{

    private $gateway = 'http://api.lingxi360.com/';

    public function __construct($api_key=null, $api_secret=null){
        if(!$api_key){
            $api_key = C('lingxiapi_lingxi_key');
            $api_secret = C('lingxiapi_lingxi_secret');
        }
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
    }

    public function __call($funName,$argu){
        return $this->__callStatic($funName,$argu);
    }

    private $post_operation_map = array("create", "save");
    /**
     * 接受方法getsContact, createContact, totalDonate等等
     */
    public function __callStatic($funName,$argu) {
        if(preg_match('#^([a-zA-Z0-9_]*)([A-Z])([a-zA-Z0-9]*)$#', $funName, $m)) {
            $operation = $m[1];

            $method = "get";
            //这些操作默认为用post提交，其他的默认用get获取
            if(in_array($operation, $this->post_operation_map)){
                $method = "post";
            }
            if($argu){
                $argu = $argu[0];
            }
            //如果最后一个参数是get或者post，认为是指定提交方式
            if($argu && ($argu[count($argu) - 1] == 'post' || $argu[count($argu)-1] == 'get')){
                $method = $argu[count($argu) - 1] == 'post';
                unset($argu[count($argu) - 1]);
            }
            if(in_array($operation, $this->post_operation_map)){
            }
            $type = strtolower($m[2]) . $m[3];
            if($method == "post"){
                $res = $this->doPost($type, $operation, $argu);
            }else{
                $res = $this->doGet($type, $operation, $argu);
            }
            return $res;
        } else {
                echo 'Error Function:' . $funName . ', the format should be like getsContact(args) or createContact(args)';
        }
    }

    public function obj2Array($obj, $root_name){
        if($obj){
            $array = objectToArray($obj);
            if($array != ""){
                if($root_name){ //如果填写了root_name，表示内容应该是个数组，但是返回来如果不是数组（有可能只有一项，simplexml_load_string就解析成不是数组了），这样，外面套一个数组的壳，保证外层使用的一致性
                    if(is_list($array[$root_name])){
                        return $array[$root_name];
                    }else{
                        return array($array[$root_name]);
                    }
                }else{
                    return $array;
                }
            }else{
                return null;
            }
        }else{
            return null;
        }
    }

    public function getStatus(){
        return $this->status;
    }

    public function getStatusMsg(){
        return $this->status_message;
    }

    private function doGet($type, $operation, $params){
        $auth_param = $this->generateAuthParam(true);
        $extra_param =  http_build_query($params);
        $url = $this->gateway . $type . "/$operation" . $auth_param . $extra_param;
        $res = $this->doAction($url, "get");
        return $res;
    }

    private function doPost($type, $operation, $params){
        $auth_param = $this->generateAuthParam(false);
        if($params){
            $post_data = array_merge($auth_param, $params);
        }else{
            $post_data = $auth_param;
        }
        $url = $this->gateway . $type . "/$operation";
        $res = $this->doAction($url, "post", $post_data);
        return $res;
    }

    private function doAction($url, $action_type, $data){
        if($action_type == 'get'){
            $res = json_decode(DoGet($url));
        }else{
            $res = json_decode(DoPost($url, $data));
        }
        $res = $this->obj2Array($res);
        $this->status = $res['status'];
        $this->status_message = $res['status_message'];
        return $res['data'];
    }

    private function getSignature($stamp, $token) {
        $sha = hash_hmac("sha256", $stamp . $token, $this->api_secret);
        return $sha;
    }

    private function generateAuthParam($is_get=true){
        $stamp = time();
        $token = GenSecret(30);
        $signature = $this->getSignature($stamp, $token);
        if($is_get){
            $auth_param = '?accesskey='.$this->api_key.'&stamp='.$stamp.'&token='.$token.'&signature='.$signature . '&';
        }else{
            $auth_param['accesskey'] = $this->api_key;
            $auth_param['stamp'] = $stamp;
            $auth_param['token'] = $token;
            $auth_param['signature'] = $signature;
        }
        return $auth_param;
    }
}