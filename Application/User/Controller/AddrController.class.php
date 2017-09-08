<?php
namespace User\Controller;
class AddrController extends UserController{
	function index(){//显示管理页
		//获取所有的地址信息
		$address=M('address');
		$arr=$address->where("userid={$_COOKIE['userid']}")->select();
		$this->assign('arr',$arr);
		$this->display();
	}
	function setaddr(){
		$address=M('address');
		$id=$_GET['id'];
		
		$address->where("userid={$_COOKIE['userid']}")->data(array('ischecked'=>0))->save();
		
		$address->where("id=$id")->data(array('ischecked'=>1))->save();
		if($_GET['s']==1){
			//购物车 checkout
			$this->redirect("Home/Cart/checkout");
		}else{
			$this->redirect("Addr/index");//???
		}
	}
	function clearaddr(){
		$address=M('address');
		$id=$_GET['id'];
		$address->where("id=$id")->data(array('ischecked'=>0))->save();
		$this->redirect("Addr/index");//???
	}
	function getp(){
		$fid=$_GET['fid'];
		$province=M("country");
		$arr=$province->where("fid=$fid")->select();
		foreach($arr as $v){
			echo "<option value='{$v['id']}'>{$v['name']}</option>";
		}
	}
	function save(){
		$country=M("address");
		$_POST['userid']=$_COOKIE['userid'];
		$re=$country->data($_POST)->add();
		//跳转
		if($_POST['s']==1){
			//购物车 checkout
			$this->redirect("Home/Cart/checkout");
		}else{
			$this->redirect("Addr/index");//???
		}
	}
	
	
	
	
	
	
	
	
	
	
}