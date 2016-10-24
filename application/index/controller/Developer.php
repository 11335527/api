<?php
/**
 * Created by zhoukai
 * User: zhoukai
 * Date: 2016/8/27
 * Time: 19:10
 */
namespace app\index\controller;
use think\Controller;
use think\Request;
class Developer extends Controller{
    public function __construct(Request $request) {
        parent::__construct($request);
        if (($GLOBALS['params'] === 0)) {
            $this->redirect(url('index/login/login'));
        }
    }
    public function devList(){

        $project_id=session('current_project');
        $list=db('developer')->where(['project_id'=>$project_id])->order('sort')->select();

        $this->assign('list',$list);
        $this->view->engine->layout('layout_doc');
        return $this->fetch();
    }

    //添加服务器端开发人员
    public function addDev(){
        $this->view->engine->layout('layout_doc');
        return $this->fetch();
    }

    //编辑服务器端开发人员
    public function editDev($id){

        $info=db('developer')->find($id);
$this->assign('info',$info);
        $this->view->engine->layout('layout_doc');
        return $this->fetch();
    }


    public function saveDev(){
        $post=$this->request->post();

//        dump($post);exit;

        //验证字段
        $result = $this->validate($post, 'Developer');
        if (true !== $result) {
            return error($result);
        }
        $post['project_id']=session('current_project');

        if(isset($post['id'])){
            if(db('developer')->update($post)){
                return success();
            }else{
                return error('修改失败');
            }
        }else{
            if(db('developer')->insert($post)){
                return success();
            }else{
                return error('添加失败');
            }

        }


    }


    public function setSort(){
        $post=$this->request->post();
        $ids=json_decode($post['id']);
        foreach($ids as $k=>$v){
            db('developer')->where(['id'=>$v])->update(['sort'=>$k]);
        }
        return $ids;
    }
}