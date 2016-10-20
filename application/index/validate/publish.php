<?php
/**
 * Created by zhoukai
 * User: Administrator
 * Date: 2016/10/19
 * Time: 16:03
 */
namespace app\index\validate;
use think\Validate;

class Publish extends Validate {
    protected $rule=[
        ['content', 'require', '问题必须填写'],
    ];
}