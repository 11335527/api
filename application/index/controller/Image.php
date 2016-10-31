<?php
namespace app\index\controller;
use think\Controller;
use think\Image as Img;

class Image extends Controller
{

    /**
    *用户头像
    *add by zk 2016/9/8 13:44
    */
    public function userHeadImg(){

        $file = $this->request->file('file');
        $image=Img::open($file);
        $image->thumb(200,200,3);
        $save_name=md5(microtime(true)).'.'.$image->type();
        $path='./static/upload/image/head_img/'.$save_name;
        if($image->save($path)){
            return $save_name;
        }else{
            return '上传失败';
        }

    }

    /**
    *QQ头像
    *add by zk 2016/8/15 16:59
    */
    public function qqImg($url)
    {


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
        return $output;

//dump($url);exit;

//        $file = $this->request->file($url);
        $image=Img::open($url);
        return $image;
        $save_name=md5(microtime(true)).'.gif';
        $path='./static/image/head_img/'.$save_name;

        $fp = fopen($path, 'wb');
        if($image->save($path)){
            return 'head_img/'.$save_name;
        }else{
            return '上传失败';
        }
    }

    /**
    *编辑器上传图片
    *add by zk 2016/8/15 16:59
    */
    public function editorImg(){
        $h5=$this->request->file('wangEditorH5File');
        $paste=$this->request->file('wangEditorPasteFile');
        if($h5){
            $file=$h5;
        }
        if($paste){
            $file=$paste;
        }
        $image = Img::open($file);
        $image->thumb(200,200);
        $save_name=md5(microtime(true)).'.'.$image->type();
        $path='./static/upload/editor/'.$save_name;

        if($image->save($path)){
            $arr=[
                'save_name'=>$save_name,
                'width'=> $image->width(),
                'height'=>$image->height(),
                'src'=>'/static/upload/editor/'.$save_name
            ];
            return json($arr);
        }else{
            return '上传失败';
        }
    }



    /**
    *删除文件
    *add by zk 2016/8/15 16:58
    */
    public function remove(){
        $post=$this->request->post();
        switch($post['cate']){
            case 'head_img':
                //表中删除
                $flag=db('head_img')->where(['save_name'=>$post['name']])->delete();

                //物理删除
               $dir='./static/upload/image/goods/head_img/'.$post['name'];
               if(unlink($dir)||$flag){
                  return success();
               }else{
                   return error();
               }
                break;
            case 'area_img':

                //物理删除
                $dir='./static/upload/image/area/'.$post['name'];
                if(unlink($dir)){
                    return success();
                }else{
                    return error();
                }
                break;
        }
    }
}
