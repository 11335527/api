<?php
namespace app\index\controller;
use think\Controller;

class Debug extends Controller

{


public function debug(){
    return $this->fetch();
}

}
