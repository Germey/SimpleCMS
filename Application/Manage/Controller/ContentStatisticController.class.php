<?php
namespace Manage\Controller;
use Think\Controller;

class ContentStatisticController extends ManageBaseController {

    public function __construct(){
        parent::__construct();
        if(!C('SHOW_STATISTIC')){
            session('error', '统计功能已经关闭');
            redirect('Index/index');
        }
        $this->statistic_contents = unserialize(D('Config')->getConfigValue('contents'));
    }

    public function index() {

        foreach ($this->statistic_contents as $key => $statistic_content) {
            $filter['category_id'] = $statistic_content['category_id'];
            $method = 'get'.str_replace(' ', '', ucwords(str_replace('_', ' ', $key))).'Statistics';
            $statistics[$key] = D('ContentStatistics')->$method($filter);
        }
        $this->statistics = $statistics;
        $this->display();
    }

    function ajax_get_contact_chart_data() {
        $day_count = I('day_type');
        if(!$day_count) {
            $day_count = 30;
        } 
        $time_type_statistic = D('ContentStatistics')->getContentStatisticsByDayType($day_count);
        echo json_encode($time_type_statistic);
    }

    //序列化统计数据到数据库中
    public function save_field_config(){

        $statistic_config = array(
            'content_sub' => array(
                'category_id' => '189',
                'display_name' => "扭转诊所与爆料信息统计",
                'item' => array(
                    'content_title' => "扭转诊所名称", 
                    'child_content_count' => "爆料数",
                    'export' => "导出excel",
                )
            ),

        );

            /*'content_sub_auhor' => array(
                'category_id' => '189,192',
                'display_name' => "监测点、监测信息与志愿者统计",
                'item' => array(
                    'content_title' =>"监测点名称",
                    'child_content_count' => "监测信息总数", 
                    'author_count' =>"志愿者数"
            )),

            'content_author' => array(
                'category_id' => '189,192',
                'display_name' => "志愿者与监测信息统计",
                'item' => array(
                    'author_name' =>"志愿者昵称",
                    'child_content_count' =>"监测信息数",
            )), 
            
            'time_content' => array(
                'category_id' => '189,192',
                'display_name' => "时间与监测信息统计",
                'item' => array(
                    'create_time' => "时间", 
                    'child_content_count' => "监测信息数",
            )),*/
        $data['value'] = serialize($statistic_config);
        $data['type'] = 'statistic';
        $data['key'] = 'contents';
        $data['title'] = '统计';
        $id = D('Config')->update($data);
    }
}