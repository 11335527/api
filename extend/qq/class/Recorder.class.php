<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */

require_once(QQ_CONTENT_CLASS_PATH."ErrorCase.class.php");
class Recorder{
    private static $data;
    private $inc;
    private $error;

    public function __construct(){
        $this->error = new ErrorCase();

        //-------读取配置文件
//        $incFileContents = file(QQ_CONTENT_ROOT."comm/inc.php");
//        $incFileContents = $incFileContents[1];
//        $this->inc = json_decode($incFileContents);

        $this->inc->appid='101362222';
        $this->inc->appkey='d8441a841e3e4a255a0f09f6ac7d4baf';
        $this->inc->callback='http://www.maapi.cn/index/qq/callback';
        $this->inc->scope='get_user_info';
        $this->inc->errorReport=true;
        $this->inc->storageType='file';
        if(empty($this->inc)){
            $this->error->showError("20001");
        }

        if(empty($_SESSION['QC_userData'])){
            self::$data = array();
        }else{
            self::$data = $_SESSION['QC_userData'];
        }
    }

    public function write($name,$value){
        self::$data[$name] = $value;
    }

    public function read($name){
        if(empty(self::$data[$name])){
            return null;
        }else{
            return self::$data[$name];
        }
    }

    public function readInc($name){
        if(empty($this->inc->$name)){
            return null;
        }else{
            return $this->inc->$name;
        }
    }

    public function delete($name){
        unset(self::$data[$name]);
    }

    function __destruct(){
        $_SESSION['QC_userData'] = self::$data;
    }
}
