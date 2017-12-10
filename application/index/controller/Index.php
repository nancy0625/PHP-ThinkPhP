<?php
namespace app\index\controller;
use think\Controller;
class Index extends \think\Controller
{

     public function index()
    {
        // 获取用户名
        $userName = session('authority')['userName'];
        // 查询学生表
        $student = new \app\index\model\Student();
        $result = $student->select();
        // 传递模板参数
        $this->assign('userName', $userName);
        /*$this->assign('menuName', 'index');*/
        $this->assign('result', $result);
        return view();
    }

   public function edit()
    {
        // 获取用户名
        $userName = session('authority')['userName'];
        $this->assign('userName', $userName);
        //$this->assign('menuName', 'index');
        // 学生信息
        $studentId = input('studentId');
        // 根据用户名和密码去查询帐号表
        $student = new \app\index\model\Student();
        $query = array(
            'studentId' => $studentId
        );
        $row = $student->get($query);
        $this->assign('row', $row);
        return view();
    }

    public function editdo()
    {
        $data = input('post.');
   
        $student = new \app\index\model\Student();
        $res = $student->save($data, array(
            'studentId' => $data['studentId']
        ));
   
        if ($res > 0) {
            $this->success("修改成功！！！",url('index/index'));
        } else {
            $this->success("修改失败！！！",url('index/index'));
        }
    }
    
    public function delete()
    {
        $studentId = input('studentId');
        $student = new \app\index\model\Student();
        $res = $student->destroy($studentId);
        if ($res > 0) {
            $this->success("删除成功！！！",url('index/index'));
        } else {
            $this->success("删除失败！！！",url('index/index'));
        }
    }
    
    public function insert(){
        //表单处理
        if(request()->isPost()){
            //取出数据
            $data = input('post.');
            $student = new \app\index\model\Student();
            $result = $student->allowField(true)->save($data);
            if($result){
                $this->success("数据保存成功！",url('index/index'));
            }else{
               $this->success("数据保存失败！",url('index/insert'));
            }
        }
        // 获取用户名
        $userName = session('authority')['userName'];
        $this->assign('userName', $userName);
        $this->assign('menuName', 'index');
        return view();
        //或者    return $this->fetch();
    }
    
}
