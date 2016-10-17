<?php
/**
 * Created by zhoukai
 * User: Administrator
 * Date: 2016/10/17
 * Time: 15:29
 */
namespace app\index\validate;
use think\Validate;

class User extends Validate {

    protected $rule = [
        ['username', 'require', '昵称必须填写'],
        ['password', 'require', '密码必须填写'],
        ['re_password','require|confirm:password','密码必须填写|密码不一致'],
    ];
}