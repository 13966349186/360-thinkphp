<?php
namespace Home\Controller;
use Think\Controller;
class HomeController extends Controller{
	function _initialize(){
		$this->assign('curControllerName',CONTROLLER_NAME);
		//获取一级分类
		$type = new \Admin\Model\TypeModel();
		$typeArrOne=$type->where("fid=0")->select();
		$this->assign('headerTypeArrOne',$typeArrOne);
		
		if($_COOKIE['userid']){
		$head="<scan id=\"userss\"> 欢迎<span>".$_COOKIE['username']."</span><a style=\"color:#ff6600\" href=".U("User/tc").">退出</a></scan>";
		}else{
			$head='<scan id="userss"><a  href='.U("User/login").'>[请登录]</a><span>，新用户？</span><a style="color:#ff6600" href='.U("User/reg").'>[免费注册]</a>
			</scan>';
		}
		$this->assign("head",$head);
		
		if(isset($_GET['id'])){
			$this->assign('headerTypeId',$_GET['id']);
		}else if(isset($_GET['tstr'])){
			preg_match('/^>(\d+)/',$_GET['tstr'],$typeidArr);
			$this->assign('headerTypeId',$typeidArr[1]);
		}
	}
}