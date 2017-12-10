<?php
namespace app\index\controller;


use think\Controller;
use app\index\model\User;

class Register extends \think\Controller
{
	
	public function edit(){

        if(request()->isPost()){
            $password = md5(input('password'));
            $user = new User();
            $userName = session('authority')['userName'];
            $result = $user->save(['password'=>$password],['username'=>$userName]);
            if($result){
                $this->success("密码修改成功！",url('login/loginout'));
            }else{
                $this->success("密码修改失败！",url('index/index'));
            }
        }else{
            // 获取用户名
            $userName = session('authority')['userName'];
            $this->assign('userName', $userName);
            $this->assign('menuName', 'register');
            return view();
        }
    }
}
?>