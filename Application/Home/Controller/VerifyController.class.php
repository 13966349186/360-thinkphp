<?php
namespace Home\Controller;
use Think\Controller;
class VerifyController extends Controller{
	function showimage(){
		$verify=new \Think\Verify();
		$verify->entry();//输出验证码图片
	}
}