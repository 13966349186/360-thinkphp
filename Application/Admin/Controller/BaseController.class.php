<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller{
	function _initialize(){
		if(!$_SESSION['username']){
		$this->error("没有cookie",U("Index/index"));
		exit();
		}
	}
}