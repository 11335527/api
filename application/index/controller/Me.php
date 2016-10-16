<?php
/**
 * Created by zhoukai
 * User: zhoukai
 * Date: 2016/8/27
 * Time: 17:58
 */
namespace app\index\controller;
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
        return $this->fetch();
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

}