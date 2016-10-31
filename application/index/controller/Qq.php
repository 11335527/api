<?php
/**
 * Created by zhoukai
 * User: YiDian
 * Date: 2016/10/31
 * Time: 9:19
 */
namespace app\index\controller;
use think\Controller;
use think\Loader;

Loader::import('qq/qqConnectAPI', EXTEND_PATH, '.php');


class Qq extends Controller {


    public function login() {
        $oauth = new \Oauth();
        $oauth->qq_login();
    }

    public function callBack() {
        $oauth = new \Oauth();
        $access_token = $oauth->qq_callback();
        $open_id = $oauth->get_openid();
        $info = db('user')->where(['openid' => $open_id])->find();
        if ($info) {
            session('user', $info);
        } else {
//            cookie('access_token',$access_token);
//            cookie('open_id',$open_id);
            $qc = new \QC($access_token, $open_id);
            $bb = $qc->get_user_info();

//            dump();exit;
            $name = md5(microtime(true)).'.png';
            $arr_img = $this->getImage($bb['figureurl_qq_2'], './static/images/head_img/', $name);
            $user['username'] = $bb['nickname'];
            $user['head_img'] = 'head_img/' . $arr_img['file_name'];
            $user['openid'] = $open_id;
            if ($id = db('user')->insertGetId($user)) {
                $user['user_id'] = $id;
            }
            session('user', $user);
        }
        $this->redirect(__SITE__ . 'me');
    }

    public function test() {
        $name = md5(microtime(true)). '.png';
        $url = 'http://q.qlogo.cn/qqapp/101362222/20E8D90BC4791E4BD27B93850B7A148E/100';
//        $fileName = './static/images/head-img/' . $name;
        $bb = $this->getImage($url, './static/images/head_img/', $name);
        dump($bb);
    }

    /*
    *功能：php完美实现下载远程图片保存到本地
    *参数：文件url,保存文件目录,保存文件名称，使用的下载方式
    *当保存文件名称为空时则使用远程文件原来的名称
    */
    function getImage($url, $save_dir = '', $filename = '', $type = 0) {
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $img = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        //文件大小
        $fp2 = @fopen($save_dir . $filename, 'a');
        fwrite($fp2, $img);
        fclose($fp2);
        unset($img, $url);
        return array('file_name' => $filename, 'save_path' => $save_dir . $filename, 'error' => 0);
    }
}