<?php

namespace Home\Controller;

class SearchController extends HomeController {

    public function index() {
        $this->skey = $skey = I('skey');
        $stag_id = I('stag_id');
        if(!$skey && !$stag_id) {
            redirect('/');
        }
        $pages = array();

        if($skey) {
            $pages =  D('Search')->searchContent($skey, 'page');
            
            $search_result = $pages;
            // $search_result = array_sort($search_result, 'create_time', 'desc');
            $count = count($search_result);

            list($pagesize, $page_num, $pagestring) = pagestring($count, 10);
            $search_result = array_slice($search_result, ($page_num-1) * $pagesize, $pagesize);

            $data['replace'] = "<font color='red'>$skey</font>";
            $data['pagestring'] = $pagestring;

        } elseif ($stag_id) {
            $ids = M('TagMapping')->where(array('tag_id'=>$stag_id))->getField('object_id',true);
            $filter['id'] = array('in',$ids);
            $pages = D('Content')->getPages($filter,0,0);
            $count = count($pages);
            $search_result = $pages;
        }


        $data['skey']     = $skey;
        $data['stag_id']  = $stag_id;
        $data['search_result'] = $search_result;
        $data['all_count'] = intval($count);
        $this->assign($data);
        $this->display('search/index');

    }


    function ajax_search_content() {
        $q = I("q"); 
        $category_id = I("category_id"); 

        $condition['category_id'] = intval($category_id);
        $condition['title'] = array("like", "%$q%");
        $condition['parent_id'] = 0;

        $result = D('Content')->where($condition)
                ->order('convert(title USING gbk) COLLATE gbk_chinese_ci')
                ->field('id, title as text')
                ->limit(30)
                ->select();

        if($result){
            echo json_encode($result);
        }else{
            echo "";
        }
    }
}