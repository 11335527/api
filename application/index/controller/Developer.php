<?php
/**
 * Created by zhoukai
 * User: zhoukai
 * Date: 2016/8/27
 * Time: 19:10
 */
namespace app\index\controller;
use think\Controller;

class Developer extends Controller{


    //添加服务器端开发人员
    public function addServerDev(){

        return $this->fetch();
    }
}