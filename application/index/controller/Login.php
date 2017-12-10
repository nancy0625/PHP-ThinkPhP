<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\User;

class Login extends \think\Controller
{
    //显示注册页面
    public function login(){      
        return $this->fetch();
    }
    public function forget(){
        return $this->fetch();
    }
   public function checkCode(){
         session_start();
 $nums = "";
 for($i=0;$i<4;$i++){
  //产生随机数并转换成十六进制
  $nums.=dechex(mt_rand(0,15));
 }
 //将验证码写入session
 $_SESSION['code']=$nums;

 //设置验证码长和宽
 $_width = 100;
 $_height = 30;
 //创建一张图片
 $_img = imagecreatetruecolor($_width,$_height);
 //创建一个白色
 $_white = imagecolorallocate($_img,220,250,250);
 //填充背景
 imagefill($_img,0,0,$_white);

 //随机画6条线条
 for($i=0;$i<6;$i++){
  $_rnd_color = imagecolorallocate($_img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
  imageline($_img,mt_rand(0,$_width),mt_rand(0,$_width),mt_rand(0,$_width),mt_rand(0,$_width),$_rnd_color);
 }

 //随机画出雪花
 for($i=0;$i<60;$i++){
  imagestring($_img,1,mt_rand(1,$_width),mt_rand(1,$_height),"*",imagecolorallocate($_img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255)));
 }

 //输出验证码
 for($i=0;$i<strlen($_SESSION['code']);$i++){
  imagestring($_img,mt_rand(6,10),$i*$_width/4+mt_rand(1,10),mt_rand(1,$_height/2),$_SESSION['code'][$i],imagecolorallocate($_img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200)));
 }

 //输出和销毁
 header("Content-Type:image/png");
 imagepng($_img);
 imagedestroy($_img);
    }
     public function loginDo()
    {
         session_start();
        if (!request()->isPost()) {
            $this->redirect("index");
        } else {
            if (session('authority')) {
                session(null);
            }
            $username = $_POST['username'];
            $passcode = $_POST['password'];
            // 计算摘要
            $password2 = md5($passcode);
            
            $user = new User();
            // 根据用户名和密码去查询帐号表
            $data = array(
                'username' => $username,
                'password' => $password2
            );
           
            // 返回单记录，或者为空
           $result = $user->get($data);
            if ($result) {
                // 使用 authority 保存用户和权限信息
                $authority = array(
                    'userName' => $username,
                    /*'role' => 'manager'*/
                );
                $yz = $_POST['yzm'];
               
                $code = $_SESSION['code'];
                if($yz == $code){
                    session('authority', $authority);
                $this->success('登录成功', url("index/index"));
            }else{
                 $this->error('登录失败,验证码错误!', url("index/login/login"));
            }

            } else {
                $this->error('登录失败,用户名或密码错误!', url("index/login/login"));
            }
        }
    }
 
      public function update(){
if (!request()->isPost()) {
            $this->redirect("index");
        } else {
            
            $userName = session('authority')['userName'];// 获取某个post变量username
            $password=input('post.password');
            $password1=input('post.repass');

            if(md5($password)!=md5($password1)){
            $this->error('重置失败,密码不一致!', url("index/login/login"));
        
            }
        
            // 计算摘要
            $password2 = md5($password1);
            
            $user = new User();
            // 根据用户名和密码去查询帐号表
            $data = array(
                'username' => $userName,
               
            );
           
            // 返回单记录，或者为空
            $result = $user->get($data);
            if ($result) {
                // 使用 更新密码
              
               $rus = $user->where(" username = '$username' ")->setField('password',"$password2");
               if($rus != false){
                 $this->success('重置成功', url("index/index/index"));
               }else {
                $this->error('重置失败!', url("index/login/login"));
            }
               
            } else{
                $this->error('查无此用户，请核对是否输入正确', url("index/login/forget"));
            }
        }
        
    }

     public function loginout()
    {
        session(null);
        $this->success('退出成功', url("index/login/login"));
    }
   

}