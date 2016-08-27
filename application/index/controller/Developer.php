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

    public function saveServerDev(){
        $post=$this->request->post();


        //验证字段
        $result = $this->validate($post, 'Developer');
        if (true !== $result) {
            return error($result);
        }
        $post['project_id']=session('user')['project_id'];

        if(db('developer')->insert($post)){
            return success();
        }else{
            return error('添加失败');
        }

    }
}