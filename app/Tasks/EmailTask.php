<?php
/**
 * Created by PhpStorm.
 * User: hu
 * Date: 18-1-3
 * Time: 下午4:10
 */

namespace App\Tasks;

use App\Services\Email;
use App\Models\Logic\IndexLogic;

class EmailTask
{
    /**
     * 逻辑层
     *
     * @Inject()
     * @var IndexLogic
     */
    private $logic;


    private $smtpserver = "smtp.163.com";

    //SMTP端口号?
    private  $smtpserverport = 25;
    //SMTP发邮件的邮箱
    private  $smtpusermail = "roczhmg@163.com";

    //SMTP用户名，不加@163.com
    private  $smtpuser = "roczhmg";
    //SMTP用户密码
    private $smtppass = "zhmg201718";


    /**
     * @param $smtpemailto  发送给谁(邮件接收者)
     * @param $mailtitle    邮件主题
     * @param $mailcontent  邮件内容
     * @param $mailtype     发送格式
     */
    public function sendEmail($smtpemailto, $mailtitle, $mailcontent, $mailtype ='html'){
        //实例化对象
        $smtp = new Email($this->smtpserver,$this->smtpserverport,true,$this->smtpuser,$this->smtppass);

        $state = $smtp->sendmail($smtpemailto, $this->smtpusermail, $mailtitle, $mailcontent, $mailtype);
        //检查发送状态
        if($state==""){
            return "邮件发送失败，请检查密码或其他设置";
        }else if(strlen($state)!=0){
            //发送成功
            return "邮件发送成功";
        }else{
            return "未知错误";
        }
    }

}