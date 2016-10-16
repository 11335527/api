<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use app\index\model\Cate;
use app\index\model\Api;
class Doc extends Controller

{
//    public function __construct(Request $request) {
//        parent::__construct($request);
//
//        if(($GLOBALS['params']===0)){
//            $this->redirect(url('index/login/login'));
//        }
//
//    }


    public function doc($id)
    {



//        $project_id=$GLOBALS['params']['project_id'];
        $project_id=$id;
        session('current_project',$id);
        $user_id=$GLOBALS['params']['user_id'];
        $site=db('developer')->where(['project_id'=>$project_id,'role'=>2])->order('sort',"user_id=$user_id desc")->select();
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

    public function ajaxJson(){
        $post=$this->request->post();
        $param=array_combine($post['param_key'],$post['param_value']);



        switch($post['type']){
            case 'post':
                $res=$this->requestCurlPost($post['site'],$post['api'],$param);
                break;
            case 'get':
                $res=$this->requestCurlGet($post['site'],$post['api'],$param);
                break;
        }
        return $res;
    }

    function requestCurlPost($site,$api,$post_data=''){
        $url='http://'.$site.'/'.$api;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
        $output = curl_exec($ch);
        curl_close($ch);
        //打印获得的数据
        return $output;
    }
    function requestCurlGet($site,$api,$post_data=''){
        $url=$site.'/'.$api;
//        if($post_data){
//            $url.='?';
//            foreach($post_data as $k=>$v){
//                $url.=$k.'='.$v.'&';
//            }
//            $url=rtrim($url,'&');
//        }

        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。

        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        //打印获得的数据
        print_r($output);
        return json_decode($output, true);
    }



//    public function getJsonHtml(){
//
//        $this->assign('data',session('json'));
//        return $this->fetch('json');
//    }

    public function cate(){
        $project_id=$GLOBALS['params']['project_id'];
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
        $post['project_id']=$GLOBALS['params']['project_id'];

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
