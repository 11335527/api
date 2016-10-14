<?php
/**
 * Created by zhoukai
 * User: zhoukai
 * Date: 2016/8/27
 * Time: 17:58
 */
namespace app\index\controller;
use think\Controller;

class Me extends Controller {


    /**
    *个人中心
    *add by zk 2016/10/14 17:17
    */
    public function me() {
        return $this->fetch();
    }

}