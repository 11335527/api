<?php
/**
 * Created by zhoukai
 * User: zhoukai
 * Date: 2016/8/27
 * Time: 17:58
 */
namespace app\index\controller;
use think\Controller;

class Login extends Controller {


    public function login() {
        return $this->fetch();
    }

    public function check() {
        $post = $this->request->post();
        //var_dump($post);exit;
        $info = db('user')->where(['username' => $post['username']])->find();
        if ($info) {
            if ($info['password'] == $post['password']) {
                //登陆成功
                $project = db('developer')->where(['user_id' => $info['user_id']])->order('sort desc')->find();
                if ($project) {
                    $info['project_id'] = $project['project_id'];
                    $info['type'] = $project['type'];
                    $info['role'] = $project['role'];
                    session('user', $info, 'api');
                    return success();
                } else {
                    session('user', $info, 'api');
                    return ['status' => 2];
                }
            } else {
                return error('用户名或密码错误');
            }
        } else {
            return error('用户名或密码错误');
        }
    }

    public function projectList() {
        $user = session('user', '', 'api');
        $this->assign('username', $user['username']);
        $project = db('user_project')->where(['user_id' => $user['user_id']])->select();
        $arr = array();
        foreach ($project as $k => $v) {
            $info = db('project')->where(['id' => $v['project_id']])->find();
            $arr[] = $info;
        }
        $this->assign('list', $arr);
     //  var_dump($arr);
        return $this->fetch();
    }

    public function logout() {
        session(null, 'api');
        $this->redirect(url('index/login/login'));
    }
    public function project(){
        $id=$this->request->param('id');
       // var_dump($id);exit;
        $project=db('cate')->where(['project_id'=>$id])->select();
        $this->assign('project',$project);
        var_dump($project);exit;
        return $this->fetch();
    }
}