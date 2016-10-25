<?php
/**
 * Created by zhoukai
 * User: Administrator
 * Date: 2016/10/19
 * Time: 14:46
 */
namespace app\index\controller;
use app\index\model\Title;
use think\Controller;
use think\Db;
use think\Request;
use app\index\model\User;
use think\Validate;
class Bbs extends Controller{
    public function bbs(){
      /*  $sql='select t.id,content,status,username, head_img, create_time from api_title as t LEFT JOIN api_user as u ON t.user_id=u.user_id ORDER BY create_time DESC ';
        $res=Db::query($sql);*/
       //
$info=db('title')
    ->alias('t')
    ->join('api_user u','t.user_id = u.user_id')
    ->field('t.id,content,status,username, head_img, create_time')
    ->paginate(4);

        //var_dump($res);exit;
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function publish(){
        return $this->fetch();
    }
    public function savePublish(Request $request){
        $post=$this->request->post();
        //var_dump($post);exit;
        $intro_img= json_decode($post['intro_img']);
        unset($post['intro_img']);
        $post['create_time']=time();
        $user=session('user');
        $user_id=$user['user_id'];
        $post['user_id']=$user_id;
        //var_dump($post);exit;
        $validate=validate('Publish');

      if(!$validate->check($post))
      {
          $error=$validate->getError();
          return error($error);
      }

        $res=db('title')->insert($post);
        if($res){
            return success($post);

        }
    }
    public function discuss(Request $request){
$id=$request->param('id');
       $sql="select t.id,content,status,username, head_img, create_time from api_title as t LEFT JOIN api_user as u ON t.user_id=u.user_id WHERE id={$id}";
        $res=Db::query($sql);

$info=db('discuss')
    ->alias('d')
    ->join('api_user u','d.user_id = u.user_id')
    ->field('content,username, head_img, create_time')
    ->where(['title_id'=>$id])->select();

       //var_dump($info);exit;
        $this->assign('res',$res);
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function saveDiscuss(){
        $post=$this->request->post();
       // var_dump($post);exit;
        //$intro_img=json_encode($post['intro_img']);
        $user=session('user');
        $user_id=$user['user_id'];
        $post['create_time']=time();
        $post['user_id']=$user_id;
        //var_dump($post);exit;
      /* $validate=validate('Discuss');
        if(!$validate->check($post));
        {
            $error=$validate->getError();
            return error($error);
        }*/
         $res=db('discuss')->insert($post);
        //var_dump($res);exit;
        if($res){
            return success($post);
        }

    }

}