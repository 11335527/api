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


    public function getCreateTimeAttr($value){
        return $this->time_tran($value);
    }

    public function user(){
        return $this->belongsTo('User','user_id','user_id');
    }

    public function comment(){
        return $this->hasMany('Comment','title_id','id');
    }

    public function getCommentLastAttr($value,$data){
        $info=Comment::where(['title_id'=>$data['id']])->order('create_time desc')->find();
        if($info){

            $arr['name']=$info->user->username;

            $arr['ago']=$info->create_time;

            return $arr;
        }
        return false;

    }
    public function getTypeAttr($value){
        $arr=[
            '1'=>'问题反馈',
            '2'=>'技术闲谈',
            '3'=>'使用教程',
        ];
        return $arr[$value];
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