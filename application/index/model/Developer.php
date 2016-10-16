<?php
/**
 * Created by zhoukai
 * User: Administrator
 * Date: 2016/10/15
 * Time: 14:03
 */
namespace app\index\model;
use think\Model;
class Developer extends Model{
    public function project(){
        return $this->hasOne('project','id','project_id');
    }
}