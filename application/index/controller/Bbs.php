<?php
/**
 * Created by zhoukai
 * User: Administrator
 * Date: 2016/10/19
 * Time: 14:46
 */
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use app\index\model\Title;
use think\Validate;
class Bbs extends Controller{
    public function bbs(){

$res=db('title')->select();
        $sql='select content,status,username, head_img  from api_title as t LEFT JOIN api_user as u ON t.user_id=u.user_id ';
        $res=Db::query($sql);
       // var_dump($res);


        $this->assign('info',$res);
        return $this->fetch();
    }
    public function publish(){
        return $this->fetch();
    }
    public function savePublish(Request $request){
        $post=$this->request->post();
        $user=session('user');
        $user_id=$user['user_id'];

        $post['user_id']=$user_id;
        $validate=validate('Publish');

      if(!$validate->check($post))
      {
          $error=$validate->getError();
          return error($error);
      }
        $post['create_time']=time();
        $id=db('title ')->insertGetId($post);
        if($id){
            return success($post);

        }
    }
}