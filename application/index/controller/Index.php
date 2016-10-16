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

}
