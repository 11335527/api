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
        if(!session('project')){
            session('project','techan');
        }


    }

    public function index()
    {


        //site
        $project=session('project');
        $site=db('site')->where(['project'=>$project])->find();
        $this->assign('site',$site);

        //cate_list
        $list=Cate::where(['project_id'=>$site['id']])->select();
        foreach ($list as $v) {
            $api = $v->api;
            foreach ($api as $va) {
                $va->param;
            }
        }

        $this->assign('list',$list);
        //cate
        $cate=db('cate')->select();
        $this->assign('cate',$cate);
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

        if(db('cate')->insert($post)){
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
}
