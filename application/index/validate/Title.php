<?php
/**
 * Created by zhoukai
 * User: Administrator
 * Date: 2016/10/19
 * Time: 16:03
 */
namespace app\index\validate;
use think\Validate;

class Title extends Validate {
    protected $rule=[
        ['title', 'require|max:100|min:3', '标题不能为空|标题不能大于100字符|标题不能小于3个字符'],

        ['content', 'require', '内容不能为空'],
        ['type', 'require', '请选择帖子类型'],

    ];
}