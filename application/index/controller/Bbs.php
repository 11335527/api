<?php
/**
 * Created by zhoukai
 * User: zhoukai
 * Date: 2016/8/27
 * Time: 17:58
 */
namespace app\index\controller;
use think\Controller;

class Bbs extends Controller{
    public function bbs(){
        return $this->fetch();
    }
   public function publish(){
       return $this->fetch();
   }
}