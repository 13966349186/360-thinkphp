<?php
namespace Admin\Controller;
use Think\Controller;
class VerifyController extends Controller{
	function show(){
		$ob=new \Think\Verify();
		$ob->length=3;
		$ob->entry();
	}
}