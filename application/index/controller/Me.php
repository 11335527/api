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
use app\index\model\Project;
use think\Db;

class Me extends Controller {


    /**
     *个人中心
     *add by zk 2016/10/14 17:17
     */
    public function me() {
        $user = session('user');
        $user_id = $user['user_id'];
        $developer = Developer::field('project_id,type')->where(['user_id' => $user_id])->select();
        $this->assign('project', $developer);

        //查询邀请消息
        $count=db('invite')->where(['invited_user_id'=>$user_id])->count();
        $this->assign('invite_count',$count);
        return $this->fetch();
    }
    /**
    *通知列表
    *add by zk 2016/10/18 10:51
    */
    public function notifyList(){
        $user = session('user');
        $user_id = $user['user_id'];
        //查询邀请消息
        $list=Invite::where(['invited_user_id'=>$user_id])->select();
        $arr=[];
        foreach($list as $v){
            $a['project_name']=$v->project->name;
            $a['invite_name']=$v->inviteUser->username;
            $a['id']=$v->id;
           $arr[]=$a;
        }

        return success($arr);

    }

    /**
    *确认邀请操作
    *add by zk 2016/10/18 11:47
    */
    public function sureInvite(){
        $post=$this->request->post();
        $info=db('invite')->find($post['id']);
        $data=[
            'project_id'=>$info['project_id'],
            'user_id'=>$info['invited_user_id'],
            'type'=>0,
            'role'=>$info['role']
        ];
        db('developer')->insert($data);




        db('invite')->delete($post['id']);



    }

    public function createProject(){
        $post=$this->request->post();
        $user = session('user');
        $info=['name'=>$post['name'],'create_time'=>time()];
        $id=db('project')->insertGetId($info);
        $data=[
          'role'=>2,
            'name'=>$user['username'],
            'user_id'=>$user['user_id'],
            'site'=>'www.maapi.cn',
            'project_id'=>$id,
            'sort'=>0,
            'type'=>1,
        ];
        if(db('developer')->insert($data)){
            $info['id']=$id;
            $info['create_time']=date('Y-m-d H:i',$info['create_time']);
            return success($info);
        }else{
            return error('入库失败');
        }
    }


    public function invite($id){



        return $this->fetch();
    }

    public function searchUser(){
        $post=$this->request->post();

//        dump($post);exit;
        $res=db('user')->where(['username'=>['like','%'.$post['name'].'%']])->select();

        if($res){
            return success($res);
        }else{
            return error();
        }
    }

    /**
    *邀请别人加入自己项目
    *add by zk 2016/10/18 10:22
    */
    public function addInvite(){
        $post=$this->request->post();
        $post['invite_user_id']=session('user')['user_id'];
        $post['create_time']=time();
        db('invite')->insert($post);
        //TODO zk 发送邮件

        return success();
    }

}