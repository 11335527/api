<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

    'login'=>'index/login/login',
    'register'=>'index/login/register',
    'doc/:id'=>['index/doc/doc', ['method' => 'get'], ['id' => '\d+']],
    'invite/:id'=>['index/me/invite', ['method' => 'get'], ['id' => '\d+']],
    'editUser/:id'=>['index/me/editUser', ['method' => 'get'], ['id' => '\d+']],
    'bbs'=>'index/bbs/bbs',
    'me'=>'index/me/me',
    'addDev'=>'index/developer/addDev',
    'editDev/:id'=>['index/developer/editDev', ['method' => 'get'], ['id' => '\d+']],
    'devList'=>'index/developer/devList',
    'cate'=>'index/doc/cate',
    'editCate/:id'=>['index/doc/editCate', ['method' => 'get'], ['id' => '\d+']],
    'debug'=>'index/debug/debug',
    'addBbs'=>'index/bbs/add',
    'title/:id'=>['index/bbs/title',['method' => 'get'], ['id' => '\d+']],
];
