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
//        $developer = Developer::field('project_id,type')->where(['user_id' => $user_id])->select();
//        $this->assign('project', $developer);
  $sql="select d.type,p.name from api_developer as d LEFT JOIN api_project as p ON d.project_id=p.id WHERE d.user_id={$user_id}";
        $res=Db::query($sql);
        dump($res);exit;
        return $this->fetch();
    }

}