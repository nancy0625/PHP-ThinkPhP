<?php
namespace app\index\controller;

class User extends \think\Controller
{
	//显示注册页面
	public function reg(){		
		return $this->fetch();
	}


    public function insert2(){

    	$data['username']=\think\Request::instance()->post('username'); // 获取某个post变量username
		$data['password']=input('post.password');
		$validate = \think\Loader::validate('User');
		if(!$validate->check($data)){
			$this->error($validate->getError());
		}
        

		$u=new \app\index\model\User();
		$u->username=\think\Request::instance()->post('username');
		$u->password=md5(input('post.password'));
		$u->save();
		$this->success("<h1>注册成功</h1>","index/login/login");
    }

     public function edit()
    {
    	// 获取用户名
        $userName = session('authority')['userName'];
        $this->assign('userName', $userName);
        $user =new \app\index\model\User();
        // 学生信息
        $us = $user->where(" username = '$userName' ")->find();
       
        $id = $us['user_id'];

        // 根据用户名和密码去查询帐号表
        
        $query = array(
            'user_id' => $id
        );
        $row = $user->get($query);
        $this->assign('row', $row);
        return view();
       
    }

    public function editdo()
    {
        $data = input('post.');
        $user =new \app\index\model\User();
        $res = $user->save($data,array(
            'user_id' => $data['user_id']));
        if ($res > 0) {
            $this->success("修改成功！！！",url('index/index/in'));
        } else {
            $this->success("修改失败！！！",url('index/user/edit'));
        }
    }


		/*$u=new \app\index\model\User();
		$data['user_pwd']=md5(input('post.password'));
		$u->strict(false)->insert($data); // 插入数据库
		$this->success("<h1>注册成功</h1>","index/index/index");*/	


}