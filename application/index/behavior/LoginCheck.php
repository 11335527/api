<?php
/**
 * Created by zhoukai
 * User: zhoukai
 * Date: 2016/8/27
 * Time: 19:39
 */

namespace app\index\behavior;

class LoginCheck
{
    public function app_init(&$params)
    {
        $params=1;
        if(!session('user')){
            $params=0;
        }else{
            $params=1;
        }
    }

    public function app_end(&$params)
    {

    }
}
