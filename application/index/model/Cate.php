<?php
/**
 * Created by zhoukai
 * User: YiDian
 * Date: 2016/8/8
 * Time: 16:53
 */
namespace app\index\model;
use think\Model;
class Cate extends Model{
    protected $name='cate';
    public function api(){
        return $this->hasMany('Api','cate_id','cate_id');
    }
}