<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Student;
use app\index\model\Grade;
use app\index\model\Subject;

class Stu extends \think\Controller
{

     public function index()
    {
        $userName = session('authority')['userName'];
        // 获取用户名
        if(isset($_POST['xh'])){
            $studentId = $_POST['xh'];
            $km = $_POST['km'];
             // 根据用户名和密码去查询帐号表
        $student = new \app\index\model\Student();
        $query = array(
            'studentId' => $studentId
        );
        $row = $student->get($query);
       
        $grade = new \app\index\model\Grade();

        $subject = new \app\index\model\Subject();
       
        $sub = $subject->where("subjectName = '$km' ")->column("subjectNum");
        
        $grades = $grade->where("subjectNum = '$sub[0]' ","xh = $studentId")->column("cj"); 

        // 传递模板参数
        $this->assign('userName', $userName);
        $this->assign('result', $row);
        $this->assign('grades', $grades);
        $this->assign('km', $km);
        $this->assign('studentId', $studentId);
        return view();
        }else{
             $this->success("请输入学生的学号",url('index/stu/search'));
        }
       
    }
    public function search(){
      
        $student = new \app\index\model\Student();
        $stu = $student->column('studentId');
   
         $this->assign('xh',$stu);
    
         $userName = session('authority')['userName'];
         $subject = new \app\index\model\Subject();
         $km = $subject->column('subjectName');

         $this->assign('km', $km);
         $this->assign('userName', $userName);

         return view();


    }
     public function grade(){
       
        $student = new \app\index\model\Student();
        $stu = $student->column('studentId');
       
         $this->assign('xh',$stu);
         
         $userName = session('authority')['userName'];
                  
         $this->assign('userName', $userName);

         return view();


    }
    public function grades(){
         $userName = session('authority')['userName'];
        if(isset($_POST['xh'])){
            $studentId = $_POST['xh'];

            $student = new \app\index\model\Student();
        $query = array(
            'studentId' => $studentId
        );

        $row = $student->get($query);
       
        $grade = new \app\index\model\Grade();
        
        $grades = $grade->where("xh = $studentId")->select(); 
      
    
        $subject = new \app\index\model\Subject();
      
        $sub = array();
        foreach ($grades as $key => $value) {
          $subjectNum = $value['subjectNum'];
          $su = $subject->where("subjectNum = '$subjectNum' ")->column("subjectName");
          $string=implode("",$su);
          $sub[] = array("0" => $string,"1" => $value['cj']);
       
         }
       


        // 传递模板参数
        $this->assign('userName', $userName);
        $this->assign('result', $row);
        $this->assign('studentId', $studentId);
        $this->assign('subject',$sub);
        $this->assign('grades',$grades);
        return view();

        }else{
             $this->success("请输入学生的学号",url('index/stu/grade'));
        }
    }

    
 
}
