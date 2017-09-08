<?php
namespace Admin\Controller;
class BrandController extends BaseController{
	function add(){
		$type=D("Type");
		$arr=$type->where("fid=0")->select();
		//	$arr=$type->getType();
		$this->assign('arr',$arr);
		$this->display();
	}
	function save(){
		$upload=new \Think\Upload();
		$upload->autoSub=false;
		$upload->mimes=array("image/png","image/gif","image/jpeg");
		$upload->rootPath="./Public/";
		$upload->savePath="Upload/";
		$imageArr=$upload->upload();

		if($imageArr){
			$_POST['imagename']=$imageArr['upload']['savename'];
		}
		$re=M("Brand")->data($_POST)->add();
		if($re){
			$this->success("添加成功",U("Brand/oper"));
		}else{
			$this->success("添加失败",U('Brand/add'));
		}
	}
	function oper(){
		$br=M("Brand");
		$arr=$br->select();
		$this->assign('arr',$arr);
		$this->display();
	}
	function update(){

	}
	function delete(){

	}



}