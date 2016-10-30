<?php
/**
 * Created by zhoukai
 * User: Administrator
 * Date: 2016/10/19
 * Time: 16:56
 */
namespace app\index\model;
use think\Model;
class Reply extends Model {


    public function user(){
        return $this->belongsTo('User','user_id','user_id');
    }
    public function getCreateTimeAttr($value){
        return $this->time_tran($value);
    }

    public function replyUser(){
        return $this->belongsTo('User','reply_user_id','user_id');
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