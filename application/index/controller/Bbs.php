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

class Bbs extends Controller {


    public function bbs() {
        $list=Title::order(['top'=>'desc','essence'=>'desc','hot'=>'desc'])->paginate(15);
        $this->assign('list', $list);
        return $this->fetch();
    }

    public function publish() {
        return $this->fetch();
    }

    public function title($id){
        $info=Title::get($id);
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function savePublish(Request $request) {
        $post = $this->request->post();
        /// var_dump($post);exit;
        $intro_img = json_decode($post['intro_img']);
        unset($post['intro_img']);
        $post['create_time'] = time();
        $user = session('user');
        $user_id = $user['user_id'];
        $post['user_id'] = $user_id;
        $validate = validate('Publish');
        if (!$validate->check($post)) {
            $error = $validate->getError();
            return error($error);
        }
        $res = db('title')->insert($post);
        if ($res) {
            return success($post);
        }
    }

    public function discuss(Request $request) {
        $id = $request->param('id');
        // var_dump($id);
        /* $res=db('title')->where(['id'=>$id])->find();
           $userid=$res['user_id'];
           $headimg=db('user')->field('head_img')->where(['user_id'=>$userid])->find();
           $res['head_img']=$headimg;
   var_dump($res);exit;*/
        $sql = "select t.id,content,status,username, head_img, create_time from api_title as t LEFT JOIN api_user as u ON t.user_id=u.user_id WHERE id={$id}";
        $res = Db::query($sql);
        //var_dump($res);exit;
        $this->assign('info', $res);
        return $this->fetch();
    }

    public function bb() {
//        return json(success());
        return success();
    }
}