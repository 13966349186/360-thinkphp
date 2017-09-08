<?php
namespace Home\Controller;
class AddrController extends HomeController{
	function index(){
		$this->display();
	}
	function getp(){
		$province=M("country");
		$arr=$province->where("id=$")->select();
		foreach ($arr as $v){
			
		}
		$this->assign("");
		$this->display(); 
	}
}