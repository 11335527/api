<?php
/**
 * Created by zhoukai
 * User: Administrator
 * Date: 2016/10/15
 * Time: 14:06
 */
namespace app\index\model;
use think\Model;
class Project extends Model{

    public function getCreateTimeAttr($value) {
        return date('Y-m-d H:i',$value);
    }

    public function getUpdateTimeAttr($value) {
        if($value==null){
            return null;
        }else{
            return date('Y-m-d H:i',$value);
        }

    }
}