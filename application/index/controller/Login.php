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
        //TODO yali 此处写验证逻辑


        return error('用户名错误');
        unset($post['re_password']);

        $id=db('user')->insertGetId($post);
        $flag =action('Email/sendMail',[$post['email'],'Mama-api注册验证','<html><h1>我是内容</h1></html>'],'controller');
        if($flag){
            return success();
        }else{
            return error('验证邮件发送失败');
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
}