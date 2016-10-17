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
        action('Email/sendMail',[$post['email'],'Mama-api注册验证','<div><br></div><div><includetail><div><br></div><table border="0" cellpadding="0" cellspacing="0" style="width: 600px; border: 1px solid #ddd; border-radius: 3px; color: #555; font-family: \'Helvetica Neue Regular\',Helvetica,Arial,Tahoma,\'Microsoft YaHei\',\'San Francisco\',\'微软雅黑\',\'Hiragino Sans GB\',STHeitiSC-Light; font-size: 12px; height: auto; margin: auto; overflow: hidden; text-align: left; word-break: break-all; word-wrap: break-word;"> <tbody style="margin: 0; padding: 0;"> <tr style="background-color: #393D49; height: 60px; margin: 0; padding: 0;"> <td style="margin: 0; padding: 0;"> <div style="color: #5EB576; margin: 0; margin-left: 30px; padding: 0;"><a style="font-size: 14px; margin: 0; padding: 0; color: #5EB576; text-decoration: none;" href="http://fly.layui.com/" target="_blank">Mama-api开发工具</a></div> </td> </tr> <tr style="margin: 0; padding: 0;"> <td style="margin: 0; padding: 30px;"> <p style="line-height: 20px; margin: 0; margin-bottom: 10px; padding: 0;"> 伟大的程序员，<em style="font-weight: 700;">'.$post['username'].'</em>： </p> <p style="line-height: 2; margin: 0; margin-bottom: 10px; padding: 0;"> 欢迎你加入<em>Mama</em>，感谢你选择Mama-api开发助手。请点击下面的按钮激活邮箱。 </p> <div style=""> <a href="http://api.com/index/login/getCheck/email/\'.$post[\'email\'].\'/password/\'.$post[\'password\'].\'" style="background-color: #009E94; color: #fff; display: inline-block; height: 32px; line-height: 32px; margin: 0 15px 0 0; padding: 0 15px; text-decoration: none;" target="_blank">立即激活邮箱</a> </div> <p style="line-height: 20px; margin-top: 20px; padding: 10px; background-color: #f2f2f2; font-size: 12px;"> 如果该邮件不是由你本人操作，请勿进行激活！否则你的邮箱将会被他人绑定。 </p> </td> </tr> <tr style="background-color: #fafafa; color: #999; height: 35px; margin: 0; padding: 0; text-align: center;"> <td style="margin: 0; padding: 0;">系统邮件，请勿直接回复。</td> </tr> </tbody> </table></includetail></div>']);
    }

    public function verifyMail(){
        return $this->fetch();
    }

}