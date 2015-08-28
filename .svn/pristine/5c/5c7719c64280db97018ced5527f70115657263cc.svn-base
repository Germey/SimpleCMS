<?php
namespace Home\Controller;

class FormController extends HomeController {

    public function save_info() {
        $data = I('post.','htmlspecialchars');
        $data['create_time'] = time();
        $id = M('FormInfo')->data($data)->add();
        // $referer = I('server.HTTP_REFERER');
        // $this->success('提交成功',$referer,true);
        // redirect($referer);
        if($id) {
            echo 1;
        }
    }
}