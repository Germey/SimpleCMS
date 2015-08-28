<?php
namespace Home\Model;
use Think\Model;

// 字段 + 扩展字段（基于栏目）
class FieldModel extends Model {

    public function getUserColumns(){

        $fields = array(
            'register_code' => array('display_name' => '邀请码', 'required' => 'true', 'type' => 'text', 'class' => "span5"),
            'username'      => array('display_name' => '昵称', 'required' => 'true', 'type' => 'text', 'class' => "span5"),
            'email'         => array('display_name' => "邮箱", 'required' => 'true', 'type' => "text", 'class' => "span5"),
            'desc'         => array('display_name' => "个人简介", 'type' => "textarea", 'class' => "span5"),
            'password'      => array('display_name' => '密码', 'required' => 'true', 'type' => 'password', 'class' => "span5"),
            'repassword'    => array('display_name' => '确认密码', 'required' => 'true', 'type' => 'password', 'class' => "span5"),
            'avatar'    => array('display_name' => "头像", 'type' => "file", 'note' => '图像大小160*160'),
            'address'       => array('display_name' => "详细地址", 'type' => "text", 'class' => "span5"),
            );

        return $fields;
    }

    public function getUserProfileAndMessagesColumns() {

        $fields = array(
            "account"      => array('display_name' => "账户管理", 'type' => "header", 'class' => 'li-header'),
            "profile"      => array('display_name' => "个人资料" , 'link' => "/dashboard/edit_user"),
            // "header_img"   => array('display_name' => "我的图像" , 'link' => "/user/update_userinfo?type=header_url"),
            "update_pwd"   => array('display_name' => "修改密码" , 'link' => "/dashboard/reset_password"),
            // "update_email" => array('display_name' => "修改邮箱" , 'link' => ""),
            "content"      => array('display_name' => "监测记录管理", 'type' =>"header", 'icon' => "", 'class' => 'li-header mar-top-10'),
            "submission"   => array('display_name' => "添加新的监测记录",  'link' => "/dashboard/edit_content", 'class' => "btn btn-success"),
            "published"    => array('display_name' => "已发表", 'status' => 2, 'link' => "/dashboard/list_contents?status=2", 'count' => M('Content')->where(array('create_user_id' => is_login(), "status" => 2, 'parent_id' => array('gt', 0)))->count()),
            "checking"     => array('display_name' => "审核中", 'status' => 1, 'link' => "/dashboard/list_contents?status=1", 'count' => M('Content')->where(array('create_user_id' => is_login(), "status" => 1))->count()),
            "rejection"    => array('display_name' => "已退稿",  'link' => "", 'status' => 10, 'link' => "/dashboard/list_contents?status=10", 'count' => M('Content')->where(array('create_user_id' => is_login(), "status" => 10))->count()),
            );
        return $fields;
}

}