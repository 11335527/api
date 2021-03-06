<?php
/**
 * Created by zhoukai
 * User: zhoukai
 * Date: 2016/8/27
 * Time: 17:58
 */
namespace app\index\controller;
use app\index\model\Invite;
use think\Controller;
use  app\index\model\Developer;
use think\Request;
use think\Db;

class Me extends Controller {


    public function __construct(Request $request) {
        parent::__construct($request);
        if (($GLOBALS['params'] === 0)) {
            $this->redirect(url('index/login/login'));
        }
    }

    /**
     *个人中心
     *add by zk 2016/10/14 17:17
     */
    public function me() {
        $user = session('user');
        $user_id = $user['user_id'];
        //个人信息
        $info = db('user')->find($user_id);
        $this->assign('info', $info);
        $developer = Developer::field('project_id,type')->where(['user_id' => $user_id])->select();
        $this->assign('project', $developer);
        //查询邀请消息
        $count = db('invite')->where(['invited_user_id' => $user_id])->count();
        if ($count) {
            $this->assign('invite_count', $count);
        }
        return $this->fetch();
    }

    /**
     *编辑用户
     *add by zk 2016/10/18 13:25
     */
    public function editUser($id) {
        $info = db('user')->find($id);
        $this->assign('info', $info);
        //TODO yali 编辑用户操作
        return $this->fetch('edit');
    }

    public function saveUser() {
        $post = $this->request->post();
        //var_dump($post);exit;
        $user = db('user');
        $post['user_id'] = $post['id'];
        unset($post['id']);
        $res = $user->update($post);
        //var_dump($res);exit;
        if ($res) {
            return success();
        } else {
            return error('没有做任何修改');
        }
    }

    /**
     *通知列表
     *add by zk 2016/10/18 10:51
     */
    public function notifyList() {
        $user = session('user');
        $user_id = $user['user_id'];
        //查询邀请消息
        $list = Invite::where(['invited_user_id' => $user_id])->select();
        $arr = [];
        foreach ($list as $v) {
            $a['project_name'] = $v->project->name;
            $a['invite_name'] = $v->inviteUser->username;
            $a['id'] = $v->id;
            $arr[] = $a;
        }
        return success($arr);
    }

    /**
     *确认邀请操作
     *add by zk 2016/10/18 11:47
     */
    public function sureInvite() {
        $post = $this->request->post();
        $info = db('invite')->find($post['id']);
        $data = [
            'project_id' => $info['project_id'],
            'user_id' => $info['invited_user_id'],
            'type' => 0,
            'role' => $info['role']
        ];
        db('developer')->insert($data);
        db('invite')->delete($post['id']);
    }

    public function createProject() {
        $post = $this->request->post();
        $user = session('user');
        $info = ['name' => $post['name'], 'create_time' => time()];
        $id = db('project')->insertGetId($info);
        $data = [
            'role' => 2,
            'name' => $user['username'],
            'user_id' => $user['user_id'],
            'site' => 'www.maapi.cn',
            'project_id' => $id,
            'sort' => 0,
            'type' => 1,
        ];
        if (db('developer')->insert($data)) {
            $info['id'] = $id;
            $info['create_time'] = date('Y-m-d H:i', $info['create_time']);
            return success($info);
        } else {
            return error('入库失败');
        }
    }

    public function invite($id) {
        return $this->fetch();
    }

    /**
     *搜索用户
     *add by zk 2016/10/21 17:26
     */
    public function searchUser() {
        $post = $this->request->post();
//        dump($post);exit;
        $u_ids = db('developer')->where(['project_id' => $post['project_id']])->column('user_id');
        $where['username'] = ['like', '%' . $post['name'] . '%'];
        if ($u_ids) {
            $where['user_id'] = ['not in', $u_ids];
        }
        $res = db('user')->where($where)->select();
        if ($res) {
            return success($res);
        } else {
            return error('没有搜索到符合调件用户');
        }
    }

    /**
     *邀请别人加入自己项目
     *add by zk 2016/10/18 10:22
     */
    public function addInvite() {
        $post = $this->request->post();
        $post['invite_user_id'] = session('user')['user_id'];
        $post['create_time'] = time();
        db('invite')->insert($post);
        //TODO zk 发送邮件
        return success();
    }

}