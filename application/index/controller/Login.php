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

    public function logout(){
        session(null,'api');
        $this->redirect(url('index/login/login'));
    }

    public function register(){
        return $this->fetch();
    }

    public function saveRegister(){
        $post=$this->request->post();
      //  dump($post);
        $validate = validate('User');

        if(!$validate->check($post)) {
            //dump($validate->getError());
            $error=$validate->getError();
            return error($error);
        }else {
            return success('成功');
        }

    }
    public function verifyEmail(){
        $post=$this->request->post();
        $flag =action('Email/sendMail',[$post['email'],'Mama-api注册验证','<html><h1>我是内容</h1></html>'],'controller');
        if($flag){
            return success();
        }else{
            return error();
        }

    }
    public function sendMail(){

        $post=$this->request->post();
        action('Email/sendMail',[$post['email'],'Mama-api注册验证','<h1>李亚利是猪八戒</h1>']);
    }

    public function verifyMail(){
        return $this->fetch();
    }

}