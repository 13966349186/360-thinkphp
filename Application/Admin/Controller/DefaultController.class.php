<?php
namespace Admin\Controller;
class DefaultController extends BaseController{
	function index(){
		$this->display();
	}
	function welcome(){
		$this->show("欢迎".$_SESSION["username"]."登陆");
	}
}