<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use app\index\model\Cate;
use app\index\model\Api;
class Index extends Controller

{
    public function __construct(Request $request) {
        parent::__construct($request);

        if(($GLOBALS['params']===0)){
            $this->redirect(url('index/login/login'));
        }

    }

    public function index()
    {



        $project_id=session('user')['project_id'];
        $user_id=session('user')['user_id'];
        $site=db('developer')->where(['project_id'=>$project_id,'role'=>2])->order("user_id=$user_id desc",'sort')->select();
        $this->assign('site',$site);


        //cate_list
        $list=Cate::order('sort')->where(['project_id'=>$project_id])->select();


        foreach ($list as $v) {
            $api = $v->api;
            foreach ($api as $va) {
                $va->param;
            }
        }

        $this->assign('list',$list);

        //cate
        $cate=db('cate')->order('sort')->select();
        $this->assign('cate',$cate);
        return $this->fetch();
    }
    public function apiList(){



    }

    public function cate(){
        $project_id=session('user')['project_id'];
        $list=db('cate')->where(['project_id'=>$project_id])->order('sort')->select();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function editCate($id){
        $info=db('cate')->find($id);
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function addApi(Request $request){
        $post=$request->post();
        $param=$post['param'];
        unset($post['param']);

        if($post['id']){
            db('list')->update($post);
            $list_id=$post['id'];
        }else{
            $list_id=db('list')->insertGetId($post);
        }

        $data=[];
        db('request')->where(['list_id'=>$list_id])->delete();
        foreach($param as $k=>$v){
            $data[$k]['name']=$v[0];
            $data[$k]['value']=$v[1];
            $data[$k]['comment']=$v[2];
            $data[$k]['list_id']=$list_id;
        }
        db('request')->insertAll($data);
        return success();

    }
    public function getApi(Request $request){
        $post=$request->post('id');
        $api=Api::get($post);
        $api->param;
        return $api;
    }
    public function deleteApi(Request $request){

        $post=$request->post('id');
        db('list')->delete($post);
        db('request')->where(['list_id'=>$post])->delete();
        return success();
    }
    public function updateStatus(Request $request){
        $post=$request->post();
        $status=db('list')->where(['id'=>$post['id']])->value('status');
        switch($status){
            case 1:
                $post['status']=2;
                break;
            case 2;
                $post['status']=3;
                break;
            case 3:
                $post['status']=2;
                break;
        }

        db('list')->update($post);
        return success($post['status']);
    }

    public function addCate(Request $request){
        $post=$request->post();
        $post['project_id']=session('user')['project_id'];

        if($post['cate_id']){

            if(db('cate')->update($post)){
                return success();
            }else{
                return error('修改失败');
            }
        }else{
            if(db('cate')->insert($post)){
                return success();
            }else{
                return error('添加失败');
            }
        }

    }
    public function delCate(){

        $post=$this->request->post('cate_id');
        if(db('cate')->where(['cate_id'=>$post])->delete()){
            return success();
        }else{
            return error();
        }

    }

    public function saveSite(Request $request){
        $post=$request->post();
        db('site')->where(['project'=>$post['project']])->update($post);
            return success();

    }
    public function updateDirOrder(){
        $ids=$this->request->post('id');
        $ids=json_decode($ids);
        foreach($ids as $k=>$v){
            db('cate')->where(['cate_id'=>$v])->update(['sort'=>$k]);
        }
        return $ids;
    }
}
