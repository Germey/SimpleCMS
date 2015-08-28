<?php


namespace Home\Controller;

class FileController extends HomeController {

	/* 文件上传 */
	public function upload(){
		$return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
		/* 调用文件上传组件上传文件 */
		$File = D('File');
		$file_driver = C('DOWNLOAD_UPLOAD_DRIVER');
		$info = $File->upload(
			$_FILES,
			C('DOWNLOAD_UPLOAD'),
			C('DOWNLOAD_UPLOAD_DRIVER'),
			C("UPLOAD_{$file_driver}_CONFIG")
		);

		/* 记录附件信息 */
		if($info){
			$return['data'] = think_encrypt(json_encode($info['download']));
		} else {
			$return['status'] = 0;
			$return['info']   = $File->getError();
		}

		/* 返回JSON数据 */
		$this->ajaxReturn($return);
	}

	// 
	public function download($id = null){
		$md5 = $id;
		if(!$md5) {
			$this->error('参数错误！');
		}

		$File = D('File');
		$root = C('DOWNLOAD_UPLOAD.rootPath');

		if(false === $File->download($root, $md5)) {
			$this->error = $File->getError();
		}		
	}


	/**
     * 上传图片
     * @author huajie <banhuajie@163.com>
     */
	public function uploadPicture(){
        //TODO: 用户登录检测

		/* 返回标准数据 */
		$return  = array('status' => 1, 'info' => '上传成功', 'data' => '', 'field_key'=>I("field_key"));
		/* 调用文件上传组件上传文件 */
		$Picture = D('Picture');
		$pic_driver = C('PICTURE_UPLOAD_DRIVER');
		$info = $Picture->upload(
			$_FILES,
			C('PICTURE_UPLOAD'),
			C('PICTURE_UPLOAD_DRIVER'),
			C("UPLOAD_{$pic_driver}_CONFIG")
        ); //TODO:上传到远程服务器
		/* 记录图片信息 */
		if($info){
			$return['status'] = 1;
            // $return['preview_path']
            if($info['download']) {
				$return = array_merge($info['download'], $return);
            }else {
				$return = array_merge($info['Filedata'], $return);
            }

		} else {
			$return['status'] = 0;
			$return['info']   = $Picture->getError();
		}
		/* 返回JSON数据 */
		$this->ajaxReturn($return);
	}
}
