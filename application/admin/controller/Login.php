<?php
/**
 * Created by sunny.
 * User: sunny
 * For Darling
 * Date: 2016/9/28
 * Time: 15:30
 */
namespace app\admin\controller;

class Login extends Base
{
    public function index(){
        if(IS_POST){
            $verify=input('post.verify_code');
            //先检测验证码
            if(captcha_check($verify)){
                $username=input('post.user_name');
                $password=input('post.password');
                $remember=input('post.remember');
                //在检测用户名和密码
                $result=model("User")->login($username,$password);
                if($result){
                    if($remember){
                        $encrypted = encrypt(session("user")['user_id']);
                        setCookieRemember(urlencode($encrypted),30);
                    }
                    $ip=getIp();
                    Adminlog( session("user")['user_name'], 'LOGIN', 'User' ,session("user")['user_id'],json_encode(array("IP" => $ip)));
                    $this->redirect("Index/index");
                }else{
                    $this->showError("用户名或密码错误");
                }
            }else{
                $this->showError("验证码错误");
            }
        }
        // 模板输出
        return $this->fetch('index');
    }


    public function logout(){
        //清空session和缓存
        session("user",null);
        cookie("sunny_remember",null);
        //跳转到登录页
        $this->redirect("Login/index");
    }
}
