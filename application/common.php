<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


//封装ajax成功返回
function success($mes=null){
    $arr=[
        'content'=>$mes,
        'status'=>1,
    ];
    return $arr;
}
//封装ajax失败返回
function error($mes=null){
    $arr=[
        'content'=>$mes,
        'status'=>0,
    ];
    return $arr;
}
