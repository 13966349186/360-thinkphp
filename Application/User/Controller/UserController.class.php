<?php
namespace User\Controller;
use Think\Controller;
class UserController extends Controller{
	//是否登录
	function _initialize(){
		if(!isset($_COOKIE['userid'])){//没有登录
			$this->error("请登录",U("Home/User/login"),2);
			exit();
		}
		$this->assign('curControllerName',CONTROLLER_NAME);
		//获取一级分类
		$type = new \Admin\Model\TypeModel();
		$typeArrOne=$type->where("fid=0")->select();
		//传一级分类的id，get  tstr
		if(isset($_GET['id'])){
			$this->assign('headerTypeId',$_GET['id']);
		}else if(isset($_GET['tstr'])){
			preg_match('/^>(\d+)/',$_GET['tstr'],$typeidArr);
			$this->assign('headerTypeId',$typeidArr[1]);
		}
		$this->assign('headerTypeArrOne',$typeArrOne);
	}
}