<?php


namespace Home\Controller;

class PaController extends HomeController {
    private $_category_extend = "";

    public function index() {
        $this->display();
    }

    public function go() {

        require_once('simple_html_dom.php');
        ini_set("max_execution_time", 60000);
        $post = $_REQUEST;
        $mode = 'list';
        $url = strtolower($post['list_url']);
        // $url = 'http://fordgreen.v2012.anttroop.com/cegc/currentProjects.aspx?award=1043';
        if(!$url) {
            $url = $post['single_url'];
            $mode = 'single';
        }

        $page_num = $post['page_num'];
        if(!$page_num){
            $page_num = 1;
        }
        $category_id = intval($post['category_id']);
        // $category_id = 3;
        if(!$url || !$category_id) {
            redirect('/pa?error=missing param');
        }
        $category = D('Category')->where('id=%d', $category_id)->find();
        $this->_category_extend = unserialize($category['extend']['extends']);

        $data['category_id'] = $category_id;
        $data['model_id'] = 1;
        $data['status'] = 2;

        if($mode=='single') {
            $data = array_merge($data, $this->single_page($url));
            $last_id = D("Content")->add($data);
            $result_string .= '<p>YES:' . $url . ' : <a style="color:blue" target="_blank" href="/content/'.$last_id.'">go to check</a></p>';
        } else {
            $result_string = $this->list_pages($url, $category_id);
        }
        session('result_string', $result_string);
        redirect('/pa/index');
    }

    function list_pages($url, $category_id){

        $html = file_get_html($url);
        if(!$html->save()) {
            var_dump('Fail to open:' . $url);
            die();
        }
        $subdmoin = 'http://fordgreen.v2012.anttroop.com/';
        header("Content-Type: text/html;charset=utf-8");

        $result_string = '';
        foreach ($html->find('div[class=list] div[class=item]') as $k => $v) {

            foreach($v->find('h3[class=notitle]') as $sk => $sv){
                $awards_name = $sv->plaintext;
            }
            if(!$awards_name){
                foreach($v->find('div[class=desc] p > strong') as $sk => $sv){
                    $awards_name = $sv->plaintext;
                }
            }

            foreach($v->find('div[class=desc] a') as $ak => $av){
                $link = $av->href;
            }
            if(!$link) continue;
            $link = str_replace($subdmoin, '', trim($link));

            if(strpos($link, 'http://')===0) {
                $data['model_id'] = 3;
                $data['external_url'] = $link;
                $result_string .= '<p class="text-error">注意外链：' . $link . '</p>';
                $slink = $link;
            } else {
                $slink = $subdmoin . 'cegc/'. $link;
            }

            $data = array();
            $data['category_id'] = $category_id;
            $data['crawler_source_link'] = $slink;
            $data['model_id'] = 1;
            $data['status'] = 2;
            $data['awards_name'] = $awards_name;
            $result_string .= $this->single_page($subdmoin, $slink, $data);
        }

        $html->clear();
        return $result_string;
    }

    function single_page($subdmoin, $url, $data) {
        $awards_name = $data['awards_name'];
        unset($data['awards_name']);
        if(strpos($url, $subdmoin)===false) {
            return array();
        }

        $data['source_id'] = 0;
        $data['publish_time'] = $data['create_time'] = $data['update_time'] = date('Y-m-d');;

        $html = file_get_html($url);
        if(!$html->save()) {
            var_dump('Fail to open:' . $url);
        }

        foreach ($html->find('div[class=images] div[class=left] p') as $k => $v) {
            if($k == 0 ){
                $data['title'] = $v->plaintext;
            }else if($k == 1){
                $data['address'] = $v->plaintext;
            }else if($k == 2){
                $extend_val = $v->plaintext;
            }
        }

        $f['title'] = $data['title'];
        $f['category_id'] = $data['category_id'];
        $content = M("Content")->where($f)->find();
        $last_id = $content['id'];

        if($content) {
            $c_data['content_id'] = $last_id;
            $c_data['name'] = 'awards_name';
            $c_data['value'] = $awards_name;
            D('ContentExtend')->add($c_data);
            return '<p>重复了：' . $slink . '---' . $data['title'] . '， 更新获得的奖项</p>';
        }

        foreach ($html->find('div[class=context]') as $k => $v) {
            $data['content'] = trim(preg_replace('/\<br\/\>/',"", $this->trim_content($v->innertext),1));
        }

        //get project pictures
        foreach ($html->find('div[class=images] div[class=showpics] img') as $k => $v) {
            $path = $this->save_image($subdmoin . 'cegc/' . $v->src);
            if(file_exists(C('WWW_ROOT') . $path)){
                $imgs[] = $path;
            }
        }
        $data['thumb'] = $imgs[0];
        $last_id = D("Content")->add($data);
        if(count($imgs)){
            $this->updateMapping($last_id, 'content', $imgs);
        }
        if($awards_name){
            $c_e_data[] = array('content_id' => $last_id, 'name' =>'awards_name', 'value' => $awards_name) ;
        }

        if($extend_val){
            $c_e_data[] = array('content_id' => $last_id, 'name' =>'project_own_user_name', 'value' => $extend_val) ;
        }
        if($c_e_data){
            D('ContentExtend')->addAll($c_e_data);
        }
        $html->clear();
        return  '<p>YES:' . $slink . ' : <a style="color:blue" target="_blank" href="/content/'.$last_id.'">go to check</a></p>';
    }

    public function trim_content($str) {
        $str = preg_replace('/<style.*?<\/style>/is', '', $str);
        $str = preg_replace('/<div.*?<\/div>/is', '', $str);
        $str = preg_replace("/\sstyle=.+?['|\"]/i",'',$str);
        $str = preg_replace("/\sdata-mce-style=.+?['|\"]/i",'',$str);
        $str = preg_replace("/<img([^>]*)\ssrc=\"([^\s>]+)\"([^>]*)\>/", '', $str);
        $str = trim(str_replace(array('/keditor/attached','&nbsp;&nbsp;&nbsp;&nbsp;', "<span宋体'; COLOR: rgb(0,0,0); mso-spacerun: 'yes'\">", '</span>'), array('/Uploads/old_data',''), $str));
        return $str;
    }

    public function save_image($image_url) {

        $IMG_ROOT = '/home/wwwroot/fordcms/';
        //注意修改图片路径
        // $IMG_ROOT = 'E:/workplace/simplecms/';

        $year = date('Y'); $day = date('md'); $n = time().rand(1000,9999).'.jpg';
        $full_path = $IMG_ROOT . "/Uploads/old_data/image/$year/$day";
        RecursiveMkdir($full_path);

        $image = "/Uploads/old_data/image/$year/$day/$n";
        $path = $IMG_ROOT . $image;

        // 中文标题的内容
        $image_url = str_replace(array('%3A','%2F'), array(':','/'), urlencode($image_url));
        $image_content = file_get_contents($image_url);
        $fimage = fopen($path,'w');
        fwrite($fimage,$image_content);
        fclose($fimage);

        return $image;
    }

    //从html中获取所有的img地址
    function get_imgs_from_html($str, $rich=false){
        preg_match_all("/<img([^>]*)\ssrc=\"([^\s>]+)\"/", $str, $results);
        $imgs = $results[2];
        $result_imgs = array();

        foreach ($imgs as $key => $result) {
            if(!$result || !file_exists(WWW_ROOT . $result)) unset($imgs[$key]);
            $result_imgs[$key]['path'] = $result;
            if($rich) {
               $result_imgs[$key]['size'] = getimagesize(WWW_ROOT . $result);
            }
        }
        return $result_imgs;
    }


    //上传gallery图片
    public function updateMapping($object_id, $object_type='content', $picture_info) {
        if(!$object_id) return;

        $pm['object_id'] = $object_id;
        $pm['object_type'] = $object_type;

        M("PictureMapping")->where($filter)->delete();
        $seq = 0;
        foreach($picture_info as $pic){
            if(!$pic) continue ;
            $pic_data['path'] = $pic;
            $pic_data['ext'] = substr($pic, strpos($pic, '.'));
            $pic_data['create_time'] = time();
            $id = D('Picture')->add($pic_data);

            $pm['sequence'] = ++$seq;
            $pm['picture_id'] = $id;
            M("PictureMapping")->add($pm);
        }
        return true;
    }

 }