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
// $Id$
error_reporting(E_ERROR | E_PARSE );
return [
    'url_route_on' => true,
//    'log'          => [
//        'type' => 'trace', // 支持 socket trace file
//    ],

    //视图输出替换
    'view_replace_str'=>[
        '__S__'=>__SITE__.'public/static/',
        '__API__'=>__SITE__.'api/',
        '__INDEX__'=>__SITE__.'index/',
        '__SITE__' => __SITE__,

    ],
//    'log'     =>  [
//        'type'                  =>  'socket',
//        'host'                  =>  'localhost',
//        'show_included_files'   =>  true,
//        'force_client_ids'      =>  ['slog_api'],
//        'allow_client_ids'      =>  ['slog_api'],
//    ],
    'session'                => [
        'prefix'         => 'api',
        'type'           => '',
        'auto_start'     => true,
    ],
];
