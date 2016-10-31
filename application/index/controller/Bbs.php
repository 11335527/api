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

        $list=Title::order(['top'=>'desc','essence'=>'desc','hot'=>'desc','create_time'=>'desc'])->paginate(15);
        $this->assign('list', $list);
        return $this->fetch();
    }

    public function add() {
        return $this->fetch();
    }

    public function title($id){
        $info=Title::get($id);
        $info['comment']=$info->comment()->order(['create_time'=>'desc'])->select();
        $data['id']=$info['id'];
        $data['visit_count']=$info['visit_count']+1;
        db('title')->update($data);

        $info['visit_count']=$data['visit_count'];
        $this->assign('info',$info);
        return $this->fetch();
    }

    /**
    *添加帖子
    *add by zk 2016/10/30 20:23
    */
    public function saveBbs() {
        $post = $this->request->post();
        $validate = validate('Title');
        if (!$validate->check($post)) {
            $error = $validate->getError();
            return error($error);
        }

        $intro_img = json_decode($post['intro_img']);
        unset($post['intro_img']);
        $post['create_time'] =time();
        $user = session('user');
        $user_id = $user['user_id'];
        $post['user_id'] = $user_id;


        $res = db('title')->insert($post);
        if ($res) {
            return success($post);
        }
    }

    /**
    *添加评论
    *add by zk 2016/10/30 20:23
    */
    public function addComment(){
        $post=$this->request->post();
        $post['user_id']=session('user')['user_id'];
        $post['create_time']=time();
        if($id=db('comment')->insertGetId($post)){


            $sql="update api_title set comment_count=comment_count+1 WHERE id={$post['title_id']}";
            Db::execute($sql);
            $data['id']=$id;
            return success($data);
        }else{
            return error();
        }

    }

    /**
    *添加评论的回复
    *add by zk 2016/10/30 21:26
    */
    public function addReply(){

        $post=$this->request->post();
        $post['user_id']=session('user')['user_id'];
        $post['create_time']=time();
        if($id=db('reply')->insertGetId($post)){


            $data['id']=$id;
            return success($data);
        }else{
            return error();
        }

    }
    /**
     *回复评论的回复
     *add by zk 2016/10/30 21:26
     */
    public function addReplyAgain(){

        $post=$this->request->post();
        $post['user_id']=session('user')['user_id'];
        $post['create_time']=time();

        if($id=db('reply')->insertGetId($post)){


            $data['id']=$id;
            return success($data);
        }else{
            return error();
        }

    }

    /**
    *删除评论
    *add by zk 2016/10/30 21:40
    */
    public function deleteComment(){
        $post=$this->request->post();
        if(db('comment')->delete($post['id'])){
            db('reply')->where(['comment_id'=>$post['id']])->delete();
            return success();
        }else{
            return error();
        }
    }

    /**
    *删除回复
    *add by zk 2016/10/30 22:14
    */
    public function deleteReply(){
        $post=$this->request->post();
        if(db('reply')->delete($post['id'])){
            return success();
        }else{
            return error();
        }
    }





}