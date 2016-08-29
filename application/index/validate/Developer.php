<?php
/**
 * Created by zhoukai
 * User: zhoukai
 * Date: 2016/8/27
 * Time: 21:17
 */
namespace app\index\validate;
use think\Validate;

class Developer extends Validate {


    protected $rule = [
        'name|开发者名称' => 'require',
        'role' => 'CheckSite:',
    ];

    public function CheckSite($value, $rule, $data) {
        if ($value == 2) {
            if (empty($data['site'])) {
                return '服务器接口地址不能为空'.$data['site'];
            }
        }
        return true;
    }
}