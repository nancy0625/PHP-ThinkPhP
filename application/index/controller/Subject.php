<?php
namespace app\index\controller;
use think\Controller;
class Subject extends \think\Controller
{

     public function index()
    {
        // 获取用户名
        $userName = session('authority')['userName'];
        // 查询学生表
        $subject = new \app\index\model\Subject();
        $result = $subject->select();
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
        $subjectNum = input('subjectNum');
        // 根据用户名和密码去查询帐号表
        $subject = new \app\index\model\Subject();
        $query = array(
            'subjectNum' => $subjectNum
        );
        $row = $subject->get($query);
        $this->assign('row', $row);
        return view();
    }

    public function editdo()
    {
        $data = input('post.');
        $subject = new \app\index\model\Subject();
        $res = $subject->save($data, array(
            'subjectNum' => $data['subjectNum']
        ));
        if ($res > 0) {
            $this->success("修改成功！！！",url('subject/index'));
        } else {
            $this->success("修改失败！！！",url('subject/index'));
        }
    }
    
    public function delete()
    {
        $subjectNum = input('subjectNum');
        $subject = new \app\index\model\Subject();
        $res = $subject->destroy($subjectNum);
        if ($res > 0) {
            $this->success("删除成功！！！",url('subject/index'));
        } else {
            $this->success("删除失败！！！",url('subject/index'));
        }
    }
    
    public function insert(){
        //表单处理
        if(request()->isPost()){
            //取出数据
            $data = input('post.');
            $subject = new \app\index\model\Subject();
            $result = $subject->allowField(true)->save($data);
            if($result){
                $this->success("数据保存成功！",url('subject/index'));
            }else{
               $this->success("数据保存失败！",url('subject/index'));
            }
        }
        // 获取用户名
        $userName = session('authority')['userName'];
        $this->assign('userName', $userName);
        $this->assign('menuName', 'index');
        return view();
        //或者    return $this->fetch();
    }
     public function loginout()
    {
        session(null);
        $this->success('退出成功', url("index/login/login"));
    }
}
