<?php
/**
 * Created by zhoukai
 * User: Administrator
 * Date: 2016/10/19
 * Time: 16:56
 */
namespace app\index\model;
use think\Model;
class Comment extends Model {


    public function user(){
        return $this->belongsTo('User','user_id','user_id');
    }



}