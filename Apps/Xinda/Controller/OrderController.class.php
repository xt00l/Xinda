<?php
namespace Xinda\Controller;
use Think\Controller;
class OrderController extends Controller {
    
    public function index(){
        /* 实例化模型*/
        $m=D('xd_order');
    }
    
    public function insert(){
        /* 实例化模型*/
        $m=D('xd_order');
        $_POST['adder']=$_SESSION['realname'];
        $_POST['moder']=$_SESSION['realname'];
        $_POST['createTime']=date("Y-m-d H:i:s",time());
        if(!$m->create()){
            $this->error($m->getError());
        }
        $lastId=$m->add();
        if($lastId){
            $this->success("添加成功");
        }else{
            $this->error("添加失败");
        }
    
    }
    
    public function mod(){
        /* 接收参数*/
        
    
        $id = !empty($_POST['id']) ? $_POST['id'] : $_GET['id'];
        /* 实例化模型*/
        $m=M('xd_order');
        $case=$m->find($id);
        $this->assign("case",$case);
    
        $this -> assign("state", formselect($case['state']));
        
        $this->display();
    }
    

    
    public function update(){
        /* 实例化模型*/
        $db=D('xd_order');
        $_POST['moder']=$_SESSION['realname'];
        
        if ($db->save($_POST)){
            $this->success("修改成功！");
        }else{
            $this->error("修改失败！");
        }
    }
    

    
    public function del(){
        /* 接收参数*/
        $id = !empty($_POST['id']) ? $_POST['id'] : $_GET['id'];
        /* 实例化模型*/
        $m=M('xd_order');
        $count =$m->delete($id);
        if ($count>0) {
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    
    
    public function _empty(){
    
        $this->display('index');
    }
    
}