<?php
/**
 * Created by zhoukai
 * User: Administrator
 * Date: 2016/10/24
 * Time: 18:10
 */
namespace app\index\validate;
use think\Validate;

class Discuss extends Validate {


    protected $rule = [
        ['content', 'require', '讨论必须填写'],
    ];
}