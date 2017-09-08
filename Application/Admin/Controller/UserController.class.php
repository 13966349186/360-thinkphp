<?php
namespace Admin\Controller;
class UserController extends BaseController{
	function add(){
		$verify=new \Think\Verify();
	
		if(!$verify->check(strtolower($_POST['verify']))){
			
			$this->error("验证码错误",U("User/index"));
			exit();
		}
		$this->error("验证码正确，请退出",U("User/index"));
	}
	function index(){
		$ver=
		$admin=M("admin");
		$admin=$admin->select();
		$user=M("user");
		$arr=$user->select();
		foreach ($arr as $k=>$v){
			$arr[$k]["addtime"]=date("Y-m-d H:m:s",$v["addtime"]);
		}
	$this->assign('admin',$admin);
	$this->assign('arr',$arr);
		$this->display();
	}
	function oper(){
	
			if(isset($_GET['id'])){
			$id=$_GET['id'];
			$user=M("user");
			$arr=$user->where("id=$id")->find();
			$arr["addtime"]=date("Y-m-d H:m:s",$arr["addtime"]);
			$this->assign('v',$arr);
			$this->display();
			}else{
				$this->show("<p align='center'>请通过添加访问</p>");
			}
			
	}
	function update(){
		$id=$_GET['id'];
		$user=D("User");
		
		$arr=$user->where("id=$id")->find();
		$arr["addtime"]=date("Y-m-d H:m:s",$arr["addtime"]);
		$this->assign('v',$arr);
		
		if($user->create()){
			$ss=$user->where("id=$id")->save();
			if($ss){
				$this->success("修改成功",U("User/oper",array('id'=>$id)));
			}else{
				$this->error("修改失败",U("User/oper",array('id'=>$id)));
			}
		}else{
		$cw=$user->getError();
		$this->assign('arr',$cw);
		$this->display("oper");
		exit;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}