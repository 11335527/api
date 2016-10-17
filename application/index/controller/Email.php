<?php
/**
 * Created by zhoukai
 * User: YiDian
 * Date: 2016/10/17
 * Time: 13:01
 */
namespace app\index\controller;
use think\Loader;
Loader::import('phpmailer/class',EXTEND_PATH,'.phpmailer.php');
//Loader::import('email/email',EXTEND_PATH,'.php');
class Email{
    /*发送邮件方法
     *@param $to：接收者 $title：标题 $content：邮件内容
     *@return bool true:发送成功 false:发送失败
     */
public function smtp(){
    /**
     * 注：本邮件类都是经过我测试成功了的，如果大家发送邮件的时候遇到了失败的问题，请从以下几点排查：
     * 1. 用户名和密码是否正确；
     * 2. 检查邮箱设置是否启用了smtp服务；
     * 3. 是否是php环境的问题导致；
     * 4. 将26行的$smtp->debug = false改为true，可以显示错误信息，然后可以复制报错信息到网上搜一下错误的原因；
     * 5. 如果还是不能解决，可以访问：http://www.daixiaorui.com/read/16.html#viewpl
     *    下面的评论中，可能有你要找的答案。
     */


//    //******************** 配置信息 ********************************
//    $smtpserver = "smtp.qq.com";//SMTP服务器
//    $smtpserverport =465;//SMTP服务器端口
//    $smtpusermail = "11335527@qq.com";//SMTP服务器的用户邮箱
//    $smtpemailto = '77275355@qq.com';//发送给谁
//    $smtpuser = "11335527@qq.com";//SMTP服务器的用户帐号
//    $smtppass = "hrzobrepkjgecaga";//SMTP服务器的用户密码
//    $mailtitle = '主题';//邮件主题
//    $mailcontent = "<h1>content</h1>";//邮件内容
//    $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
//    //************************ 配置信息 ****************************
//    $smtp = new \smtp2($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
//    $smtp->debug = false;//是否显示发送的调试信息
//    $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
//
//    echo "<div style='width:300px; margin:36px auto;'>";
//    if($state==""){
//        echo "对不起，邮件发送失败！请检查邮箱填写是否有误。";
//        echo "<a href='index.html'>点此返回</a>";
//        exit();
//    }
//    echo "恭喜！邮件发送成功！！";
//    echo "<a href='index.html'>点此返回</a>";
//    echo "</div>";
}


    public function sendMail($to,$title,$content){

        //引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告


        //实例化PHPMailer核心类
        $mail = new \PHPMailer();

        //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        $mail->SMTPDebug = 1;

        //使用smtp鉴权方式发送邮件
        $mail->isSMTP();

        //smtp需要鉴权 这个必须是true
        $mail->SMTPAuth=true;

        //链接qq域名邮箱的服务器地址
        $mail->Host = 'smtp.qq.com';

        //设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = 'ssl';

        //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
        $mail->Port = 465;

        //设置smtp的helo消息头 这个可有可无 内容任意
        // $mail->Helo = 'Hello smtp.qq.com Server';

        //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
        $mail->Hostname = 'localhost';

        //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
        $mail->CharSet = 'UTF-8';

        //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = 'Mama-api开发工具';

        //smtp登录的账号 这里填入字符串格式的qq号即可
        $mail->Username ='11335527@qq.com';

        //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
        $mail->Password = 'hrzobrepkjgecaga';

        //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
        $mail->From = '11335527@qq.com';

        //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
        $mail->isHTML(true);

        //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
        $mail->addAddress($to,'Mama-api注册验证');

        //添加多个收件人 则多次调用方法即可
        // $mail->addAddress('xxx@163.com','lsgo在线通知');

        //添加该邮件的主题
        $mail->Subject = $title;

        //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
        $mail->Body = $content;

        //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
        // $mail->addAttachment('./d.jpg','mm.jpg');
        //同样该方法可以多次调用 上传多个附件
        // $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');


        $status = $mail->send();

        //简单的判断与提示信息
        if($status) {
            return true;
        }else{
            return false;
        }
    }
    public function send(){
        $flag = $this->sendMail('77275355@qq.com','Mama-api注册验证2','<html><h1>我是内容</h1></html>');
        if($flag){
            echo "发送邮件成功！";
        }else{
            echo "发送邮件失败！";
        }
    }
}