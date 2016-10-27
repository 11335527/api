<?php
/**
 * Created by zhoukai
 * User: Administrator
 * Date: 2016/10/19
 * Time: 16:56
 */
namespace app\index\model;
use think\Model;
use app\index\model\Comment;
class Title extends Model {


    public function user(){
        return $this->belongsTo('User','user_id','user_id');
    }

    public function getCommentAttr($value,$data){
        $info=Comment::where(['title_id'=>$data['id']])->order('create_time desc')->find();
        if($info){

            $arr['name']=$info->user->username;

            $arr['ago']=$this->time_tran($info->create_time);
            return $arr;
        }
        return false;

    }
    public function time_tran($the_time) {

        $dur=time()-$the_time;
        if ($dur < 0) {
            return $the_time;
        } else {
            if ($dur < 60) {
                return $dur . '秒前';
            } else {
                if ($dur < 3600) {
                    return floor($dur / 60) . '分钟前';
                } else {
                    if ($dur < 86400) {
                        return floor($dur / 3600) . '小时前';
                    } else {
                        if ($dur < 259200) {//3天内
                            return floor($dur / 86400) . '天前';
                        } else {
                            return date('Y-m-d H:i',$the_time);
                        }
                    }
                }
            }
        }
    }

}