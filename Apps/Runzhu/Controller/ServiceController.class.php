<?php
namespace Runzhu\Controller;
use Think\Controller;
class ServiceController extends Controller {
    public function index(){

        $m=D('product');
        $data=$m->field('web,adress,desc,phone,tel,qq,url,record,path,img')->find(7);
        $_SESSION['Runzhu']=$data;
        $_SESSION['Runzhu']['img']=$data['path'].$data['img'];
        $_SESSION['ip']=get_client_ip();
        $_SESSION['browser']=GetBrowser();
        $_SESSION['os']=GetOs(); 
        
        $m=D('rz_prodservice');
        $arr=$m->find($_GET['id']);
        $this->assign('arr',$arr);      
        
        $this->display();
    }
    
    
    public function _empty(){
    
        $this->display('index');
    }
    
    
    
}