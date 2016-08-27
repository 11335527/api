<?php
/**
 * Created by zhoukai
 * User: zhoukai
 * Date: 2016/8/27
 * Time: 17:58
 */
namespace app\index\controller;
use think\Controller;

class Login extends Controller{
    public function login(){
        return $this->fetch();
    }

    public function check(){
        $post=$this->request->post();
        $info=db('user')->where(['username'=>$post['username']])->find();
        if($info){
            if($info['password']==$post['password']){
                //登陆成功

                $project=db('user_project')->where(['user_id'=>$info['user_id']])->order('sort desc')->find();

                $info['project_id']=$project['project_id'];


                session('user',$info);


               return success();

            }else{
                return error('用户名或密码错误');
            }
        }else{
            return error('用户名或密码错误');
        }
    }

    public function logout(){
        session(null);
        $this->redirect(url('index/login/login'));
    }
}