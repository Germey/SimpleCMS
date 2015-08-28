<?php


namespace Home\Controller;
use User\Api\UserApi;
use Vendor\Wechat;
/*用户中心 用户必须才能使用*/
class DashboardController extends HomeController {

    public function __construct(){
        parent::__construct();

        if(!C('register_is_enable')){
            $this->error('注册已关闭');
        }
        if(!UID) {
            session('error', '您还没有登陆');
            $this->redirect(U('User/login'));
        }

    }

    public function index(){

    }

    public function edit_user(){
        if ( IS_POST ) {
            $data = $_POST;
            empty($data['username']) && $this->error('用户名不能为空');
            empty($data['address']) && $this->error('地址不能为空');

            if($data['address']) {
                $data['address'] = implode('///', $data['address']);
            }

            D('User')->updateFieldsById(UID, $data);

            $this->success('修改成功！');
        }else {
            $this->user = D('User')->where('id =%d', UID)->find();
            $this->display('user/edit');
        }
    }

    /**
     * 修改密码提交
     * @author thomash <thomashtao@163.com>
     */
    public function reset_password(){

        if ( IS_POST ) {
            //获取参数
            $password   =   I('post.old');
            $repassword = I('post.repassword');
            $data['password'] = I('post.password');
            empty($password) && $this->error('请输入原密码');
            empty($data['password']) && $this->error('请输入新密码');
            empty($repassword) && $this->error('请输入确认密码');
            if($data['password'] !== $repassword){
                $this->error('您输入的新密码与确认密码不一致');
            }
            $res = D('User')->updateFieldsById(UID, $data, $password);
            if($res){
                $this->success('修改密码成功');
            }else{
                $this->error(D('User')->getError());
            }
        }else{
            $this->display('user/reset_password');
        }

    }



    /*
     * 修改用户相关信息
     *
     */
    public function update_userinfo(){

        $this->user = D('User')->getById(UID);

        if ( IS_POST ) {
            $data = $_POST;
            $result  = D('User')->updateFieldsById(UID, $data);
            if($result) {
                $this->success("修改成功！");
            }else{
                $this->error("修改失败！");
            }
        }else{
            $this->display();
        }

    }


    public function edit_content(){
        $id = I('id');
        $filter['create_user_id'] = UID;
        if($id) {
            $filter['id'] = $id;
            $filter['status'] = array('gt', 0);
            $filter['parent_id'] = array('gt', 0);
            $contents = D('Content')->getPages($filter);
            $this->content =  $contents[0];
            $this->category_id = $this->content['category_id'];
            $this->current_cate = D('Category')-> where('id=%d', $this->category_id)->find();
        }

        //获取可以发文章的栏目
        $condition['enable_contribute'] = array('gt', 0);
        $this->category =  D('Category')->getTree(0, true, $condition, false);
        $this->display('article/edit');
    }

    public function save_content() {

        $data = I('post.');
        // 存储地址的时候分隔一下
        $data['address'] = implode('///', $data['address']);

        if(!$data['parent_id']) {
            $this->error('请选择监测点');
        }
        //文章类型
        if(!$data['id']) {
            $data['create_user_id'] = UID;
            $data['model_id'] = 1 ;
        }else{
            $old = D('Content')->getById($data['id']);
        }


        
        $File = D('File');
        $file_driver = C('DOWNLOAD_UPLOAD_DRIVER');
        $info = $File->upload(
            $_FILES,
            C('DOWNLOAD_UPLOAD'),
            C('DOWNLOAD_UPLOAD_DRIVER'),
            C("UPLOAD_{$file_driver}_CONFIG")
            );
        $thumb = $info['thumb'];
        if($thumb){
            $base_path = C('DOWNLOAD_UPLOAD.rootPath');
            $base_path = substr($base_path, 1, strlen($base_path)); //去掉前面的点

            $thumb_path = $base_path.$thumb['savepath'].$thumb['savename'];
            $data['thumb'] = $thumb_path;
        }

         // 单独处理一下图片和文件的信息
        if($data['picture_ids']) {
            foreach ($data['picture_ids'] as $img_id) {
                $data['pictures'][$img_id]['link'] = ' ';
                $data['pictures'][$img_id]['title'] = ' ';
                $data['pictures'][$img_id]['summary'] = ' ';
            }
        }

        $data['update_user_id'] = UID;
        $id = D('Content')->updateContent($data);
        if(!$id) {
            $this->error(D('Content')->getError());
        }

        if(Cookie('__forward__')){
            $this->success(intval($_POST['id'])?'更新成功':'新增成功', Cookie('__forward__'));
        } else {
            $this->success(intval($_POST['id'])?'更新成功':'新增成功', U('Dashboard/list_contents'));
        }
    }

    /*
     *  用户投稿列表
     */
    public function list_contents() {
        $filter['create_user_id'] = UID;
        $filter['status'] = intval(I('status'));
        $filter['parent_id'] = array('gt', 0);

        $count = D('Content')->listCount($filter);
        list($pagesize, $page_num, $pagestring) = pagestring($count);
        $this->pagestring = $pagestring;
        $this->articles = D('Content')->getPages($filter, $pagesize, $page_num, 'update_time desc', true, false, true);
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display('article/article_lists');
    }

    /*
     *  删除用户投稿信息
     */
    public function del_content($id) {
        $id = intval(I('id')) ;
        if(!$id){
            session('error', '删除失败');
        }else {

            $filter['id'] = $id;
            $filter['create_user_id'] = UID;

            //判断该用户是否有权限删除
            if(D('Content')->where($filter)->count()) {
                D('Content')->where($filter)->delete();
                session('success', '删除成功');
            }else {
                session('error', '删除出错');
            }
        }
        json(null, "refresh");
    }

    public function wx_bind(){
        $options['appid'] = C('custom_weixin_appid');
        $options['appsecret'] = C('custom_weixin_appsecret');
        $weixin = new Wechat($options);
        $qrc_obj = $weixin->getQRCode($this->login_user['uid']);
        $this->qrc_url = $weixin->getQRUrl($qrc_obj['ticket']);
        $this->display("user/wx_bind");
    }
}