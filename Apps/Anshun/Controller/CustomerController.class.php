<?php
namespace Anshun\Controller;
use Think\Controller;
class CustomerController extends Controller {
    
    public function _empty(){
    
        $this->display('index');
    }
    
    public function index(){
        
        $m=D('product');
        $data=$m->field('web,adress,keywords,desc,phone,tel,qz,qq,url,record,path,img')->find(4);
        $_SESSION['Anshun']=$data;
        $_SESSION['Anshun']['img']=$data['path'].$data['img'];
        $_SESSION['ip']=get_client_ip();
        $_SESSION['browser']=GetBrowser();
        $_SESSION['os']=GetOs();       
        
        $this->display();
    }
    
    public function checked(){        
        if($_POST['phone']){
            $m=D('tp_customer');
            $where['phone']=$_POST['phone'];
            $data=$m->where($where)->select();
            if($data){            
                $this->error("这个号码已经注册，无需重复注册");
            }else{
                $this->redirect('/Xiuli/Customer/register/phone/'.$_POST['phone']);
            }
        }else{
            $this->error("您没有填写手机号");
        }
        
        
    }
    
    public function register(){
    
        $m=D('product');
        $data=$m->field('web,adress,desc,phone,tel,qq,url,record,path,img')->find(4);
        $_SESSION['Anshun']=$data;
        $_SESSION['Anshun']['img']=$data['path'].$data['img'];
        $_SESSION['ip']=get_client_ip();
        $_SESSION['browser']=GetBrowser();
        $_SESSION['os']=GetOs(); 
        
        $phone=$_GET['phone'];
        $this->assign('phone',$phone);
    
        $this->display();
    }
    
    
    public function insert(){
        $m=D('tp_customer');
        $_POST['password']=md5(123456);
        $_POST['ctime']=time();
        if(!$m->create()){
            $this->error($m->getError());
        }
        $lastId=$m->add();
        if($lastId){
            $this->success("注册成功",U('Anshun/Index'));
        }else{
            $this->error("注册失败");
        }
    
    }
          
    
    public function setpass(){
        /* 接收参数*/
        $id =  $_SESSION['id'];
        /* 实例化模型*/
        $m=M('tp_customer');
        $user=$m->find($id);
        $this->assign('user',$user);
    
        $this->display();
    }
    
    
    public function setp(){
        /* 接收参数*/
        $id = !empty($_POST['id']) ? $_POST['id'] : $_GET['id'];
        $pass1= $_POST['pass1'];
        $pass2= $_POST['pass2'];
        $pass3= $_POST['pass3'];
        /* 实例化模型*/
        $m=M('tp_customer');
        $user=$m->find($id);
        if (md5($pass1)==$user['password']) {
            if ($pass2==$pass3) {
                $arr['id']=$id;
                $arr['password']=md5($pass2);
                $arr['moder']=$_SESSION['realname'];
                if ($m->save($arr)){
                    $this->success("密码修改成功！");
                }else{
                    $this->error("密码修改失败！");
                }
            }else{
                $this->error('新密码和确认密码不一致');
            }
        }else{
            $this->error('原密码错误');
        }
    }
    
    public function mod(){
        $id=$_GET['id'];
        /* 实例化模型*/
        $m=M('tp_customer');
        $arr=$m->find($id);
        $this->assign('arr',$arr);
        
        $this->display();
    }
    
    public function update(){
        /* 实例化模型*/
        $db=D('tp_customer');
        $_POST['moder']=$_SESSION['realname'];
        if ($db->save($_POST)){
            $this->success("修改成功！");
        }else{
            $this->error("修改失败！");
        }
    }
    
    public function personal(){
        /* 接收参数*/
        if($_SESSION['openid']){
            $where['openid']=$_SESSION['openid'];
        }else {
            $where['id'] =  $_SESSION['userid'];
        }
        /* 实例化模型*/
        $m=M('tp_customer');
        $arr=$m->where($where)->select();
        $this->assign('arr',$arr);

        $this->display();

    } 
    
    
    public function yuyue() {
        /* 接收参数*/
        if($_SESSION['openid']){
            $where['openid']=$_SESSION['openid'];
        }else {
            $where['id'] =  $_SESSION['userid'];
        }
        /* 实例化模型*/
        $m=M('tp_customer');
        $arr=$m->where($where)->select();
        
        /* 实例化模型*/
        $m=D('order_serviccar');
        $map['phone']=$arr[0]['phone'];
        $data=$m->where($map)->select();
        $this->assign('data',$data);
        
        $this->display();
    }

}