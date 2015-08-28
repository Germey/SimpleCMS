<?php
namespace Manage\Model;
use Think\Model;

class ContentStatisticsModel extends Model {


    public function  getContentSubAuhorStatistics($filter, $status=2){
        $filter['model_id'] = 6;
        
        $cateogry_ids = explode(',', $filter['category_id']);
        foreach ($cateogry_ids  as $category_id) {
            $filter['category_id'] = $category_id;
            $pages = D('Content')->getContentStatistics($filter, null, 'id, title as content_title, child_content_count', '');

            $map['group'] = 'create_user_id';
            $field = 'id, create_user_id , count(id) as count';

            $user_content = D('Content')->getContentStatistics($condition, $map, $field);
            $user_content = ass_column($user_content, 'id');

            foreach ($pages as  $key => $val) {
                $pages[$key]['author_count'] = intval($user_content[$val['id']]['count']);
                $pages[$key]['category_id'] = $category_id;
                $pages[$key]['category_name'] = D('Category')->where('id=%d', $category_id)->getField('title');
            }
            $result[$category_id] = $pages;
        }
        return $result;
    }


    //用户与发布信息统计
    public function  getContentAuthorStatistics($filter, $field='create_user_id , count(id) as child_content_count', $status=2){
        $map['group'] = 'create_user_id';
        $filter['parent_id'] = array('gt', 0);
        $cateogry_ids = explode(',', $filter['category_id']);
        foreach ($cateogry_ids  as $category_id) {
            $filter['category_id'] = $category_id;
            $pages = D('Content')->getContentStatistics($filter, $map, $field);
            foreach ($pages as $key => $p) {
                if(!$p['create_user_id']) {
                    unset($pages[$key]);
                    continue;
                }
                $pages[$key]['author_name'] = D('User')->where('id=%d', intval($p['create_user_id']))->getField('username');
                $pages[$key]['category_id'] = $category_id;
                $pages[$key]['category_name'] = D('Category')->where('id=%d', $category_id)->getField('title');
            }
            $result[$category_id] = $pages;
        }
        return $result;
    }


    public function getTimeContentStatistics($filter, $days_count) {
        $days_count = intval($days_count);
        $days_count = 20;
        if(!$days_count) return ;
        $start_time  = date('Y-m-d', strtotime("-".$days_count."day"));
        $end_time = date('Y-m-d', time());

        $field = 'count(id) as count, date_format(create_time, "%Y-%m-%d") as start_time';

        $filter['parent_id'] = array('gt', 0);
        $filter['create_time'] = array('gt', $start_time);
        $map['group'] = 'start_time';
        $cateogry_ids = explode(',', $filter['category_id']);

        foreach ($cateogry_ids  as $category_id) {
            $filter['category_id'] = $category_id;
            $pages = D('Content')->getContentStatistics($filter, $map, $field);

            //获取文章在统计天数前的总量
            $filter['create_time'] = array('lt', $start_time);
            $content_count_before_start = D('Content')->where($filter)->count();

            $pages = ass_column($pages,"start_time");
            for($i=1; $i<= $days_count; $i++){
                $current_time = date('Y-m-d', strtotime($end_time));
                $times[] = array('create_time' => $current_time, 'child_content_count' => intval($pages[$current_time]['count']));
                $end_time = date('Y-m-d', strtotime("-" . $i . "day"));
            }
            $result[$category_id] = $times;
        }

        return $result;
    }


    /*
     *  父子文章统计
     */
    public function  getContentSubStatistics($filter, $field='id, title as content_title, child_content_count', $status=2){
        $filter['model_id'] = 6;
        $filter['parent_id'] = 0;
        $cateogry_ids = explode(',', $filter['category_id']);

        foreach ($cateogry_ids  as $category_id) {
            $filter['category_id'] = $category_id;
            $pages = D('Content')->getContentStatistics($filter, null, $field, '');
            foreach ($pages as $key => $value) {
                $pages[$key]['category_id'] = $category_id;
                $pages[$key]['category_name'] = D('Category')->where('id=%d', $category_id)->getField('title');
            }
            $result[$category_id] = $pages;
        }
        return $result;
    }
}