<?php
namespace app\index\controller;
use think\Controller;
class Grade extends \think\Controller
{

     public function index()
    {
        // 获取用户名
        $userName = session('authority')['userName'];
        // 查询学生表
        $grade = new \app\index\model\Grade();
        $result = $grade->select();
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
        $id = input('id');
        // 根据用户名和密码去查询帐号表
        $grade = new \app\index\model\Grade();
        $query = array(
            'id' => $id
        );
        $row = $grade->get($query);
        $this->assign('row', $row);
        return view();
    }

    public function editdo()
    {
        $data = input('post.');
        $grade = new \app\index\model\Grade();
        $res = $grade->save($data, array(
            'id' => $data['id']
        ));
        if ($res > 0) {
            $this->success("修改成功！！！",url('grade/index'));
        } else {
            $this->success("修改失败！！！",url('grade/index'));
        }
    }
    
    public function delete()
    {
        $id = input('id');
        $grade = new \app\index\model\Grade();
        $res = $grade->destroy($id);
        if ($res > 0) {
            $this->success("删除成功！！！",url('grade/index'));
        } else {
            $this->success("删除失败！！！",url('grade/index'));
        }
    }
    
    public function insert(){
        $subject = new \app\index\model\Subject();
        $student = new \app\index\model\Student();
        $stu = $student->column('studentId');
        $km = $subject->column('subjectName');
         $this->assign('xh',$stu);
         $this->assign('km', $km);
       



        
        //表单处理
        if(request()->isPost()){
            $grade = new \app\index\model\Grade();
            $sub = new \app\index\model\Subject();
            $km = input('post.subjectName');
            $subjectNum = $sub->where("subjectName = '$km' ")->column('subjectNum');
            
            $grade->xh=\think\Request::instance()->post('xh');
            $grade->subjectNum=$subjectNum[0];
            $grade->cj=input('post.cj');
           $result =  $grade->save();
            
            if($result){
                $this->success("数据保存成功！",url('grade/index'));
            }else{
               $this->success("数据保存失败！",url('grade/index'));
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
