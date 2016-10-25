<?php
/**
 * Created by zhoukai
 * User: Administrator
 * Date: 2016/10/17
 * Time: 15:47
 */
namespace app\index\model;
use think\Model;
class User extends Model{
    public function Title(){
        return $this->hasOne('Title','user_id','user_id');
    }

}