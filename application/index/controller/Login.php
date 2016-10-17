<?php
/**
 * Created by zhoukai
 * User: zhoukai
 * Date: 2016/8/27
 * Time: 17:58
 */
namespace app\index\controller;
use think\Validate;
use app\index\model\User;
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

                $project=db('developer')->where(['user_id'=>$info['user_id']])->order('sort desc')->find();


                if($project){
                    $info['project_id']=$project['project_id'];
                    $info['type']=$project['type'];
                    $info['role']=$project['role'];
                    session('user',$info,'api');
                    return success();
                }else{
                    session('user',$info,'api');
                    return ['status'=>2];
                }


            }else{
                return error('用户名或密码错误');
            }
        }else{
            return error('用户名或密码错误');
        }
    }

    public function getCheck(){
        $post=$this->request->param();
        $info=db('user')->where(['email'=>$post['email']])->find();

        if($info){
            if($info['password']==$post['password']){
                //登陆成功

                    session('user',$info,'api');
                $this->redirect(url('index/me/me'));



            }else{
                $this->redirect(url('index/me/me'));
                return error('用户名或密码错误');
            }
        }else{
            $this->redirect(url('index/me/me'));
            return error('用户名或密码错误');
        }
}

    public function logout(){
        session(null,'api');
        $this->redirect(url('index/login/login'));
    }

    public function register(){
        return $this->fetch();
    }

    public function saveRegister(){
        $post=$this->request->post();
        $validate = validate('User');

        if(!$validate->check($post)) {
            $error=$validate->getError();
            return error($error);
        }

        unset($post['re_password']);
        $id=db('user')->insertGetId($post);
        if($id){
            return success($post);
        }


    }

    public function sendMail(){

        $post=$this->request->post();
        action('Email/sendMail',[$post['email'],'Mama-api注册验证','<h1><a href="http://api.com/index/login/getCheck/email/'.$post['email'].'/password/'.$post['password'].'">点击激活</a></h1>']);
    }

    public function verifyMail(){
        return $this->fetch();
    }

}