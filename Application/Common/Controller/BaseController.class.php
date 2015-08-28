<?php
namespace Common\Controller;
use Think\Controller;

class BaseController extends Controller {

    protected function _initialize() {
        // 读取配置
        $config = api('Config/lists');
        C($config);
    }
}