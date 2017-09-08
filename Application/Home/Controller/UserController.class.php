<?php
namespace Home\Controller;
class UserController extends HomeController{
		function checkusername(){
		$username=$_GET['username'];
		//检查用户名是否存在
		$user=M('user');
		$num=$user->where("username='$username'")->count();
		
		if($num==0){
			echo "true";
		}else{
			echo "false";
		}
	}
	function checkemail(){
		$email=$_GET['email'];
		$user=M('user');
		$num=$user->where("email='$email'")->count();
		if($num==0){
			echo "ok";
		}else{
			echo "false";
		}
	}
	function reg(){
		$this->display();
		
	}
	function save(){
		
		$user=M("User");
		if($_POST['password']==$_POST['confirm_password']){
			$arr=$_POST;
			$arr['qq']=$arr['extend_field2'];
			$arr['phone']=$arr['extend_field5'];
			$arr['question']=$arr['sel_question'];
			$arr['answer']=$arr['passwd_answer'];
			$arr['addtime']=time();
			$re=$user->data($arr)->add();
			if($re){
				$this->success("注册成功",U('Index/index'),2);
			}else{
				$this->error("注册失败",U("User/reg"),3);
			}
		}else{
			$this->error("密码不一致",U("User/reg"),3);
		}
	}
	function check(){
		//检查用户名密码是否正确
		$username=$_POST['username'];
		$password=$_POST['password'];
		$user=M("User");
		$re=$user->where("username='%s' and password='%s'",array($username,$password))->find();
		if($re){
			setcookie('userid',$re['id'],0,'/');
			setcookie('username',$username,0,'/');
			$s=$_POST['s'];
			if($s==1){
				$this->success("登录成功",U("Cart/checkout"));
			}else{
				$this->success("登录成功",U("Index/index"));
			}
		}else{
			$this->error("用户名或密码错误",U("User/login"),3);
		}
	}
	
	function login(){
		if($_COOKIE['userid']){
			setcookie("userid",'',time()-1,'/');
		}
		$this->display();
	}
	function tc(){
		setcookie("userid",'',time()-1,'/');
		$dd=$_SERVER['HTTP_REFERER'];
        $aa=explode("/", $dd);
        unset($aa[0]);
        unset($aa[2]);
        $bb=implode("/", $aa);
$ss=preg_replace("/\.html$/",'',$bb);
		$this->redirect($ss);
		
	}
}