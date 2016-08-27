<?php
/**
 * Created by zhoukai
 * User: YiDian
 * Date: 2016/8/26
 * Time: 16:30
 */
//use think\Hook;
//use think\Request;
//Hook::listen('action_init',Request::post());
return [
    'app_init'=> [
        'app\\index\\behavior\\LoginCheck',
    ],

];