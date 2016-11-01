<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use app\index\model\Cate;
use app\index\model\Api;
class Index extends Controller

{


public function index(){
    return $this->fetch();
}


    public function test(){
        $user_agent=$_SERVER['HTTP_USER_AGENT'];
        echo $user_agent;
        echo 11111;
    }
}
