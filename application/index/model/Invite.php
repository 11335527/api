<?php
/**
 * Created by zhoukai
 * User: Administrator
 * Date: 2016/10/17
 * Time: 15:47
 */
namespace app\index\model;
use think\Model;
class Invite extends Model{


    public function project(){
        return $this->hasOne('Project','id','project_id');
    }

    public function inviteUser(){
        return $this->hasOne('user','user_id','invite_user_id');
    }
}