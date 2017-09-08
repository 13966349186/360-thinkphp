<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    function Index(){
	$this->display();
    }
    function oper(){
    	$username=$_POST['username'];
    	$password=md5($_POST['password']);
    		$admin=new \Think\Model("admin");
   $arr=$admin->where("username='%s' and password='%s'",array($username,$password))->find();
    	if($arr){
    		$_SESSION['adminid']=$arr['id'];
    		$_SESSION['username']=$username;
    		$this->success("登录成功",U("Default/index"));
    	}else{
    		$this->error("登陆失败",U("Index/index"));
    	}
    }
}