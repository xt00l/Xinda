<?php
namespace Anshun\Controller;
use Think\Controller;
class ServiceController extends Controller {
    
    public function _empty(){
    
        $this->display('index');
    }
    
    
    public function index(){

        $m=D('product');
        $data=$m->field('web,adress,keywords,desc,phone,tel,qq,qz,url,record,path,img')->find(4);
        $_SESSION['Anshun']=$data;
        $_SESSION['Anshun']['img']=$data['path'].$data['img'];
        $_SESSION['ip']=get_client_ip();
        $_SESSION['browser']=GetBrowser();
        $_SESSION['os']=GetOs();
        
        $m=D('as_prodservice');
        $arr=$m->find($_GET['id']);
        $this->assign('arr',$arr);
        
        $this->display();
    }
       
    
}