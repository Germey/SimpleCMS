<?php

namespace Manage\Model;
use Think\Model;


class ImportModel extends Model{

    function getTitles($file, $type="Excel"){
        $parser = D($type . "Parser");
        $parser->init($file);
        $titles = array();
        while (($row_one = $parser->getRowIterator()) != null) {
            //就读一行
            foreach ($row_one as $one) {
                $titles[] = $this->prepareStr($one);
            }
            break;
        }
        return $titles ;
    }

    //去除特殊字符
    function prepareStr($str){
        $str = trim(str_replace('"','',$str));
        $str = iconv(get_string_encoding($str),"UTF-8", $str);          //very very important
        $str = trim(str_replace('"','',$str));
        $str = trim(str_replace('/([\r\n])+/','',$str));
        $str = str_replace(array("\r\n", "\r", "\n"), " ", $str);   //去除excel中的回车
        return $str;
    }

    //检查导入数据
    function importCheck($file, $column_matches, $type="Excel"){
        $success = array();
        $notice = array();
        $error = array();

        setlocale(LC_ALL, 'zh_CN');
        $parser = D($type . "Parser");
        $parser->init($file);
        $max_row = $parser->getMaxRow();
        for ($i=0; $i < $max_row; $i++) {
            $row_one = $parser->getRowIterator();
            if($i == 0){ continue; }

            $row = array("data"=> array(), "error" => array());
            $data = array();
            $details = $row_one;
            $index = 0 ;
            foreach ($column_matches as $col_name => $val) {
                if($details[$index] == "-"){ //导出文件会将空格写成-
                    $details[$index] = "";
                }
                $data[$col_name] = $details[$index];
                $index++ ;
            }

            if(array_key_exists('content_title', $column_matches)) {
                if(!$data['content_title']) {
                    $row['error'] = array("column_content_title" => "content_title", "msg" => "第" . ($i+1) . "行无类型详细名称，类型详细名称不能为空，请检查");
                    $notice[] = $row;
                    continue;
                }

                $content = D('Content')->getByTitle($data['content_title']);
                if(!$content) {
                    $row['error'] = array("column_content_title" => "content_title", "msg" => "第" . ($i+1) . "行类型详细名称不存在，请检查");
                    $notice[] = $row;
                    continue;
                }
            }else {
                if(D('Content')->getByTitle($data['title'])) {
                    $row['error'] = array("column_title" => "title", "msg" => "标题'" . $data['title']. "'已经存在了，不能重复，请检查");
                    $notice[] = $row;
                    continue;
                }
            }

            if(!$data['title']) {
                $row['error'] = array("column_title" => "title", "msg" => "第" . ($i+1) . "行无标题信息，标题不能为空，请检查");
                $notice[] = $row;
                $need_break++;
                if($need_break == 50) {
                    break;
                }
                continue;
            } else {
                $need_break = 0;
            }
            $success[] = $row;
        }
        return array("success" => $success, "notice" => $notice);
    }

    //导入数据
    function importContent($file, $column_matches, $map = array(), $type = 'Excel'){
        setlocale(LC_ALL, 'zh_CN');
        $parser = D($type . "Parser");
        $parser->init($file);
        $max_row = $parser->getMaxRow();
        for ($i=0; $i < $max_row; $i++) {
            $row_one = $parser->getRowIterator();
            if($i == 0){continue;};
            $data = array();
            $details = $row_one;
            $index = 0 ;
            foreach ($column_matches as $col_name => $val) {
                if($details[$index] == "-"){ //导出文件会将空格写成-
                    $details[$index] = "";
                }
                $cell = $details[$index];
                $data[$col_name] = $cell;
                $index++ ;
            }
            if(array_key_exists('provice', $data)){
                $data['address'] = str_replace('省', '', $data['provice']) . '///'. $data['city']. '///' .$data['area'] . '///' .$data['detail_address'];
                if(!$data['latlng']){
                    $address_result = file_get_contents("http://api.map.baidu.com/geocoder/v2/?address=".str_replace('/','', str_replace('///', '', $data['address']))."&output=json&ak=NoAbaCexRX7CTt2SulOYHE49");

                    $address = json_decode($address_result);
                    if($address->result->location->lng) {
                        $data['latlng'] = $address->result->location->lng .','.$address->result->location->lat;
                    }
                }
                $data['latlng'] = str_replace('-', ',', $data['latlng']);
                $data['model_id'] = 6;
            } else {
                $data['model_id'] = 1;
            }

            if($data['content_title']) {
                $content = D('Content')->getByTitle($data['content_title']);
                $data['parent_id'] = $content['id'];
            }
            $data = array_merge($data, $map);

            //TODO
            $result = D('Content')->update($data);
            if($result) {
                $success[] = array('data' => $data, 'cid' => $result);
            }else {
                $error[] = array('data' => $data, 'error' => $this->getError());
            }
        }
        return array('success' => $success, 'error' => $error);
    }
}
